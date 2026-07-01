<?php


class SeanceService
{
    private SeanceRepository  $seanceRepo;
    private AbonnementService $abonnementService;

    public function __construct(SeanceRepository $seanceRepo, AbonnementService $abonnementService)
    {
        $this->seanceRepo        = $seanceRepo;
        $this->abonnementService = $abonnementService;
    }

    public function listerToutes(): array
    {
        return $this->seanceRepo->findAll();
    }

    public function trouverParId(int $id): ?array
    {
        return $this->seanceRepo->findById($id);
    }

    public function listerParAdherent(int $idAdherent): array
    {
        return $this->seanceRepo->findByAdherent($idAdherent);
    }

    public function enregistrer(array $data): int
    {
        $this->validerDonnees($data);

        // Règle métier : abonnement valide obligatoire
        if (!$this->abonnementService->adherentAAbonnementValide((int)$data['id_adherent'])) {
            throw new RuntimeException("Impossible d'enregistrer la séance : l'adhérent n'a pas d'abonnement valide.");
        }

        $seance = new Seance(
            $data['date_seance'],
            trim($data['type_activite']),
            $data['duree'],
            (int) $data['id_salle'],
            (int) $data['id_adherent'],
            !empty($data['equipement']) ? trim($data['equipement']) : null
        );

        return $this->seanceRepo->save($seance);
    }

    public function modifier(int $id, array $data): bool
    {
        $this->validerDonnees($data);

        $row = $this->seanceRepo->findById($id);
        if (!$row) {
            throw new RuntimeException("Séance introuvable.");
        }

        $seance = new Seance(
            $data['date_seance'],
            trim($data['type_activite']),
            $data['duree'],
            (int) $data['id_salle'],
            (int) $row['id_adherent'],
            !empty($data['equipement']) ? trim($data['equipement']) : null,
            $id
        );

        return $this->seanceRepo->update($seance);
    }

    public function supprimer(int $id): bool
    {
        $row = $this->seanceRepo->findById($id);
        if (!$row) {
            throw new RuntimeException("Séance introuvable.");
        }
        return $this->seanceRepo->delete($id);
    }

    public function statsByActivite(): array
    {
        return $this->seanceRepo->statsByActivite();
    }

    private function validerDonnees(array $data): void
    {
        if (empty($data['date_seance'])) {
            throw new RuntimeException("Date de séance obligatoire.");
        }
        if (empty($data['type_activite'])) {
            throw new RuntimeException("Type d'activité obligatoire.");
        }
        if (empty($data['duree'])) {
            throw new RuntimeException("Durée obligatoire.");
        }
        if (empty($data['id_salle'])) {
            throw new RuntimeException("Salle obligatoire.");
        }
        if (empty($data['id_adherent'])) {
            throw new RuntimeException("Adhérent obligatoire.");
        }
    }
}
