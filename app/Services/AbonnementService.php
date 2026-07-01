<?php


class AbonnementService
{
    private AbonnementRepository $repo;

    public function __construct(AbonnementRepository $repo)
    {
        $this->repo = $repo;
    }

    public function listerTous(): array
    {
        return $this->repo->findAll();
    }

    public function trouverParId(int $id): ?array
    {
        return $this->repo->findById($id);
    }

    public function trouverActifParAdherent(int $idAdherent): ?array
    {
        return $this->repo->findActifByAdherent($idAdherent);
    }

    public function adherentAAbonnementValide(int $idAdherent): bool
    {
        return $this->repo->findActifByAdherent($idAdherent) !== null;
    }

    public function creer(array $data): int
    {
        $this->validerDonnees($data);

        // Règle métier : un seul abonnement actif à la fois
        $actif = $this->repo->findActifByAdherent((int)$data['id_adherent']);
        if ($actif) {
            throw new RuntimeException("Cet adhérent a déjà un abonnement actif jusqu'au {$actif['date_fin']}.");
        }

        $dateFin = $this->calculerDateFin($data['date_debut'], $data['type_abonnement']);

        $abonnement = new Abonnement(
            $data['type_abonnement'],
            $data['date_debut'],
            $dateFin,
            'Actif',
            (int) $data['id_adherent']
        );

        return $this->repo->save($abonnement);
    }

    public function modifier(int $id, array $data): bool
    {
        $row = $this->repo->findById($id);
        if (!$row) {
            throw new RuntimeException("Abonnement introuvable.");
        }

        $abonnement = new Abonnement(
            $data['type_abonnement'],
            $data['date_debut'],
            $data['date_fin'],
            $data['statut'],
            (int) $row['id_adherent'],
            $id
        );

        return $this->repo->update($abonnement);
    }

    public function supprimer(int $id): bool
    {
        $row = $this->repo->findById($id);
        if (!$row) {
            throw new RuntimeException("Abonnement introuvable.");
        }
        return $this->repo->delete($id);
    }

    private function calculerDateFin(string $dateDebut, string $type): string
    {
        $dt = new DateTime($dateDebut);
        match ($type) {
            'Mensuel'      => $dt->modify('+1 month'),
            'Trimestriel'  => $dt->modify('+3 months'),
            'Annuel'       => $dt->modify('+1 year'),
            default        => throw new RuntimeException("Type d'abonnement invalide."),
        };
        return $dt->format('Y-m-d');
    }

    private function validerDonnees(array $data): void
    {
        if (empty($data['type_abonnement']) || !in_array($data['type_abonnement'], ['Mensuel','Trimestriel','Annuel'])) {
            throw new RuntimeException("Type d'abonnement invalide.");
        }
        if (empty($data['date_debut'])) {
            throw new RuntimeException("Date de début obligatoire.");
        }
        if (empty($data['id_adherent'])) {
            throw new RuntimeException("Adhérent obligatoire.");
        }
    }
}
