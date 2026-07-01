<?php


class SeanceRepository
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::getInstance();
    }

    public function findAll(): array
    {
        $stmt = $this->pdo->query(
            'SELECT s.*, ad.nom, ad.prenom, sa.nom_salle
             FROM seance s
             JOIN adherent ad ON s.id_adherent = ad.id_adherent
             JOIN salle sa ON s.id_salle = sa.id_salle
             ORDER BY s.date_seance DESC'
        );
        return $stmt->fetchAll();
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->pdo->prepare(
            'SELECT s.*, ad.nom, ad.prenom, sa.nom_salle
             FROM seance s
             JOIN adherent ad ON s.id_adherent = ad.id_adherent
             JOIN salle sa ON s.id_salle = sa.id_salle
             WHERE s.id_seance = ?'
        );
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function findByAdherent(int $idAdherent): array
    {
        $stmt = $this->pdo->prepare(
            'SELECT s.*, sa.nom_salle FROM seance s
             JOIN salle sa ON s.id_salle = sa.id_salle
             WHERE s.id_adherent = ? ORDER BY s.date_seance DESC'
        );
        $stmt->execute([$idAdherent]);
        return $stmt->fetchAll();
    }

    public function save(Seance $seance): int
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO seance (date_seance, type_activite, equipement, duree, id_salle, id_adherent)
             VALUES (?, ?, ?, ?, ?, ?)'
        );
        $stmt->execute([
            $seance->getDateSeance(),
            $seance->getTypeActivite(),
            $seance->getEquipement(),
            $seance->getDuree(),
            $seance->getIdSalle(),
            $seance->getIdAdherent(),
        ]);
        return (int) $this->pdo->lastInsertId();
    }

    public function update(Seance $seance): bool
    {
        $stmt = $this->pdo->prepare(
            'UPDATE seance SET date_seance=?, type_activite=?, equipement=?, duree=?, id_salle=?
             WHERE id_seance=?'
        );
        return $stmt->execute([
            $seance->getDateSeance(),
            $seance->getTypeActivite(),
            $seance->getEquipement(),
            $seance->getDuree(),
            $seance->getIdSalle(),
            $seance->getId(),
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare('DELETE FROM seance WHERE id_seance = ?');
        return $stmt->execute([$id]);
    }

    public function countTotal(): int
    {
        return (int) $this->pdo->query('SELECT COUNT(*) FROM seance')->fetchColumn();
    }

    public function countThisMonth(): int
    {
        return (int) $this->pdo->query(
            "SELECT COUNT(*) FROM seance
             WHERE MONTH(date_seance)=MONTH(CURDATE()) AND YEAR(date_seance)=YEAR(CURDATE())"
        )->fetchColumn();
    }

    public function statsByActivite(): array
    {
        $stmt = $this->pdo->query(
            'SELECT type_activite, COUNT(*) as total FROM seance GROUP BY type_activite ORDER BY total DESC'
        );
        return $stmt->fetchAll();
    }
}
