<?php


class AdherentController
{
    private AdherentService  $service;
    private SalleRepository  $salleRepo;

    public function __construct()
    {
        $this->service   = new AdherentService(new AdherentRepository());
        $this->salleRepo = new SalleRepository();
    }

    public function index(): void
    {
        $adherents = $this->service->listerTous();
        require __DIR__ . '/../../views/adherents/index.php';
    }

    public function show(int $id): void
    {
        $adherent = $this->service->trouverParId($id);
        if (!$adherent) {
            $this->redirect('?page=adherents', 'Adhérent introuvable.', 'error');
        }
        require __DIR__ . '/../../views/adherents/show.php';
    }

    public function create(): void
    {
        $salles = $this->salleRepo->findAll();
        $errors = [];
        require __DIR__ . '/../../views/adherents/create.php';
    }

    public function store(): void
    {
        $salles = $this->salleRepo->findAll();
        $errors = [];
        try {
            $id = $this->service->creer($_POST);
            $this->redirect('?page=adherents', "Adhérent créé avec succès (ID: $id).", 'success');
        } catch (RuntimeException $e) {
            $errors[] = $e->getMessage();
            require __DIR__ . '/../../views/adherents/create.php';
        }
    }

    public function edit(int $id): void
    {
        $adherent = $this->service->trouverParId($id);
        $salles   = $this->salleRepo->findAll();
        $errors   = [];
        if (!$adherent) {
            $this->redirect('?page=adherents', 'Adhérent introuvable.', 'error');
        }
        require __DIR__ . '/../../views/adherents/edit.php';
    }

    public function update(int $id): void
    {
        $adherent = $this->service->trouverParId($id);
        $salles   = $this->salleRepo->findAll();
        $errors   = [];
        try {
            $this->service->modifier($id, $_POST);
            $this->redirect('?page=adherents', "Adhérent modifié avec succès.", 'success');
        } catch (RuntimeException $e) {
            $errors[] = $e->getMessage();
            require __DIR__ . '/../../views/adherents/edit.php';
        }
    }

    public function destroy(int $id): void
    {
        try {
            $this->service->supprimer($id);
            $this->redirect('?page=adherents', "Adhérent supprimé.", 'success');
        } catch (RuntimeException $e) {
            $this->redirect('?page=adherents', $e->getMessage(), 'error');
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
