<?php


class SeanceController
{
    private SeanceService      $service;
    private AdherentRepository $adherentRepo;
    private SalleRepository    $salleRepo;

    public function __construct()
    {
        $abonnementService  = new AbonnementService(new AbonnementRepository());
        $this->service      = new SeanceService(new SeanceRepository(), $abonnementService);
        $this->adherentRepo = new AdherentRepository();
        $this->salleRepo    = new SalleRepository();
    }

    public function index(): void
    {
        $seances = $this->service->listerToutes();
        require __DIR__ . '/../../views/seances/index.php';
    }

    public function show(int $id): void
    {
        $seance = $this->service->trouverParId($id);
        if (!$seance) {
            $this->redirect('?page=seances', 'Séance introuvable.', 'error');
        }
        require __DIR__ . '/../../views/seances/show.php';
    }

    public function create(): void
    {
        $adherents = $this->adherentRepo->findAll();
        $salles    = $this->salleRepo->findAll();
        $errors    = [];
        require __DIR__ . '/../../views/seances/create.php';
    }

    public function store(): void
    {
        $adherents = $this->adherentRepo->findAll();
        $salles    = $this->salleRepo->findAll();
        $errors    = [];
        try {
            $id = $this->service->enregistrer($_POST);
            $this->redirect('?page=seances', "Séance enregistrée (ID: $id).", 'success');
        } catch (RuntimeException $e) {
            $errors[] = $e->getMessage();
            require __DIR__ . '/../../views/seances/create.php';
        }
    }

    public function edit(int $id): void
    {
        $seance = $this->service->trouverParId($id);
        $salles = $this->salleRepo->findAll();
        $errors = [];
        if (!$seance) {
            $this->redirect('?page=seances', 'Séance introuvable.', 'error');
        }
        require __DIR__ . '/../../views/seances/edit.php';
    }

    public function update(int $id): void
    {
        $seance = $this->service->trouverParId($id);
        $salles = $this->salleRepo->findAll();
        $errors = [];
        try {
            $this->service->modifier($id, $_POST);
            $this->redirect('?page=seances', "Séance modifiée.", 'success');
        } catch (RuntimeException $e) {
            $errors[] = $e->getMessage();
            require __DIR__ . '/../../views/seances/edit.php';
        }
    }

    public function destroy(int $id): void
    {
        try {
            $this->service->supprimer($id);
            $this->redirect('?page=seances', "Séance supprimée.", 'success');
        } catch (RuntimeException $e) {
            $this->redirect('?page=seances', $e->getMessage(), 'error');
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
