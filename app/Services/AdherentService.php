<?php


class AdherentService
{
    private AdherentRepository $repo;

    public function __construct(AdherentRepository $repo)
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

    public function creer(array $data): int
    {
        $this->validerDonnees($data);

        if ($this->repo->findByEmail($data['email'])) {
            throw new RuntimeException("Un adhérent avec cet email existe déjà.");
        }

        $adherent = new Adherent(
            trim($data['nom']),
            trim($data['prenom']),
            trim($data['email']),
            trim($data['telephone']),
            date('Y-m-d'),
            (int) $data['id_salle']
        );

        return $this->repo->save($adherent);
    }

    public function modifier(int $id, array $data): bool
    {
        $this->validerDonnees($data);

        $existing = $this->repo->findByEmail($data['email']);
        if ($existing && (int)$existing['id_adherent'] !== $id) {
            throw new RuntimeException("Cet email est déjà utilisé par un autre adhérent.");
        }

        $row = $this->repo->findById($id);
        if (!$row) {
            throw new RuntimeException("Adhérent introuvable.");
        }

        $adherent = new Adherent(
            trim($data['nom']),
            trim($data['prenom']),
            trim($data['email']),
            trim($data['telephone']),
            $row['date_inscription'],
            (int) $data['id_salle'],
            $id
        );

        return $this->repo->update($adherent);
    }

    public function supprimer(int $id): bool
    {
        if ($this->repo->hasSeances($id)) {
            throw new RuntimeException("Impossible de supprimer : cet adhérent a des séances enregistrées.");
        }
        if ($this->repo->hasAbonnementActif($id)) {
            throw new RuntimeException("Impossible de supprimer : cet adhérent a un abonnement en cours.");
        }
        return $this->repo->delete($id);
    }

    private function validerDonnees(array $data): void
    {
        if (empty($data['nom']) || empty($data['prenom'])) {
            throw new RuntimeException("Nom et prénom sont obligatoires.");
        }
        if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            throw new RuntimeException("Email invalide.");
        }
        if (empty($data['telephone'])) {
            throw new RuntimeException("Téléphone obligatoire.");
        }
        if (empty($data['id_salle'])) {
            throw new RuntimeException("Salle obligatoire.");
        }
    }
}
