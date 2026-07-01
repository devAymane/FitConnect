<?php


class AbonnementController
{
    private AbonnementService    $service;
    private AdherentRepository   $adherentRepo;

    public function __construct()
    {
        $this->service      = new AbonnementService(new AbonnementRepository());
        $this->adherentRepo = new AdherentRepository();
    }

    public function index(): void
    {
        $abonnements = $this->service->listerTous();
        require __DIR__ . '/../../views/abonnements/index.php';
    }

    public function show(int $id): void
    {
        $abonnement = $this->service->trouverParId($id);
        if (!$abonnement) {
            $this->redirect('?page=abonnements', 'Abonnement introuvable.', 'error');
        }
        require __DIR__ . '/../../views/abonnements/show.php';
    }

    public function create(): void
    {
        $adherents = $this->adherentRepo->findAll();
        $errors    = [];
        require __DIR__ . '/../../views/abonnements/create.php';
    }

    public function store(): void
    {
        $adherents = $this->adherentRepo->findAll();
        $errors    = [];
        try {
            $id = $this->service->creer($_POST);
            $this->redirect('?page=abonnements', "Abonnement créé (ID: $id).", 'success');
        } catch (RuntimeException $e) {
            $errors[] = $e->getMessage();
            require __DIR__ . '/../../views/abonnements/create.php';
        }
    }

    public function edit(int $id): void
    {
        $abonnement = $this->service->trouverParId($id);
        $errors     = [];
        if (!$abonnement) {
            $this->redirect('?page=abonnements', 'Abonnement introuvable.', 'error');
        }
        require __DIR__ . '/../../views/abonnements/edit.php';
    }

    public function update(int $id): void
    {
        $abonnement = $this->service->trouverParId($id);
        $errors     = [];
        try {
            $this->service->modifier($id, $_POST);
            $this->redirect('?page=abonnements', "Abonnement modifié.", 'success');
        } catch (RuntimeException $e) {
            $errors[] = $e->getMessage();
            require __DIR__ . '/../../views/abonnements/edit.php';
        }
    }

    public function destroy(int $id): void
    {
        try {
            $this->service->supprimer($id);
            $this->redirect('?page=abonnements', "Abonnement supprimé.", 'success');
        } catch (RuntimeException $e) {
            $this->redirect('?page=abonnements', $e->getMessage(), 'error');
        }
    }

    private function redirect(string $url, string $msg = '', string $type = 'success'): never
    {
        if ($msg) {
            $_SESSION['flash'] = ['msg' => $msg, 'type' => $type];
        }
        header("Location: $url");
        exit;
    }
}
