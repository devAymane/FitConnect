<?php


class AbonnementRepository
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::getInstance();
    }

    public function findAll(): array
    {
        $stmt = $this->pdo->query(
            'SELECT ab.*, ad.nom, ad.prenom FROM abonnement ab
             JOIN adherent ad ON ab.id_adherent = ad.id_adherent
             ORDER BY ab.id_abonnement DESC'
        );
        return $stmt->fetchAll();
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->pdo->prepare(
            'SELECT ab.*, ad.nom, ad.prenom FROM abonnement ab
             JOIN adherent ad ON ab.id_adherent = ad.id_adherent
             WHERE ab.id_abonnement = ?'
        );
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function findActifByAdherent(int $idAdherent): ?array
    {
        $stmt = $this->pdo->prepare(
            "SELECT * FROM abonnement
             WHERE id_adherent = ? AND date_debut <= CURDATE() AND date_fin >= CURDATE()
             LIMIT 1"
        );
        $stmt->execute([$idAdherent]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function findByAdherent(int $idAdherent): array
    {
        $stmt = $this->pdo->prepare(
            'SELECT * FROM abonnement WHERE id_adherent = ? ORDER BY date_debut DESC'
        );
        $stmt->execute([$idAdherent]);
        return $stmt->fetchAll();
    }

    public function save(Abonnement $abonnement): int
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO abonnement (type_abonnement, date_debut, date_fin, statut, id_adherent)
             VALUES (?, ?, ?, ?, ?)'
        );
        $stmt->execute([
            $abonnement->getType(),
            $abonnement->getDateDebut(),
            $abonnement->getDateFin(),
            $abonnement->getStatut(),
            $abonnement->getIdAdherent(),
        ]);
        return (int) $this->pdo->lastInsertId();
    }

    public function update(Abonnement $abonnement): bool
    {
        $stmt = $this->pdo->prepare(
            'UPDATE abonnement SET type_abonnement=?, date_debut=?, date_fin=?, statut=?
             WHERE id_abonnement=?'
        );
        return $stmt->execute([
            $abonnement->getType(),
            $abonnement->getDateDebut(),
            $abonnement->getDateFin(),
            $abonnement->getStatut(),
            $abonnement->getId(),
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare('DELETE FROM abonnement WHERE id_abonnement = ?');
        return $stmt->execute([$id]);
    }

    public function countActifs(): int
    {
        return (int) $this->pdo->query(
            "SELECT COUNT(*) FROM abonnement WHERE date_fin >= CURDATE()"
        )->fetchColumn();
    }
}
