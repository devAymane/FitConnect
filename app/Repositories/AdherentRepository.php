<?php


class AdherentRepository
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::getInstance();
    }

    public function findAll(): array
    {
        $stmt = $this->pdo->query(
            'SELECT a.*, s.nom_salle FROM adherent a
             JOIN salle s ON a.id_salle = s.id_salle
             ORDER BY a.id_adherent DESC'
        );
        return $stmt->fetchAll();
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->pdo->prepare(
            'SELECT a.*, s.nom_salle FROM adherent a
             JOIN salle s ON a.id_salle = s.id_salle
             WHERE a.id_adherent = ?'
        );
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function findByEmail(string $email): ?array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM adherent WHERE email = ?');
        $stmt->execute([$email]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function save(Adherent $adherent): int
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO adherent (nom, prenom, email, telephone, date_inscription, id_salle)
             VALUES (?, ?, ?, ?, ?, ?)'
        );
        $stmt->execute([
            $adherent->getNom(),
            $adherent->getPrenom(),
            $adherent->getEmail(),
            $adherent->getTelephone(),
            $adherent->getDateInscription(),
            $adherent->getIdSalle(),
        ]);
        return (int) $this->pdo->lastInsertId();
    }

    public function update(Adherent $adherent): bool
    {
        $stmt = $this->pdo->prepare(
            'UPDATE adherent SET nom=?, prenom=?, email=?, telephone=?, id_salle=?
             WHERE id_adherent=?'
        );
        return $stmt->execute([
            $adherent->getNom(),
            $adherent->getPrenom(),
            $adherent->getEmail(),
            $adherent->getTelephone(),
            $adherent->getIdSalle(),
            $adherent->getId(),
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare('DELETE FROM adherent WHERE id_adherent = ?');
        return $stmt->execute([$id]);
    }

    public function hasSeances(int $id): bool
    {
        $stmt = $this->pdo->prepare('SELECT COUNT(*) FROM seance WHERE id_adherent = ?');
        $stmt->execute([$id]);
        return (int) $stmt->fetchColumn() > 0;
    }

    public function hasAbonnementActif(int $id): bool
    {
        $stmt = $this->pdo->prepare(
            "SELECT COUNT(*) FROM abonnement
             WHERE id_adherent = ? AND date_fin >= CURDATE()"
        );
        $stmt->execute([$id]);
        return (int) $stmt->fetchColumn() > 0;
    }
}
