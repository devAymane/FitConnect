<?php

session_start();

$base = dirname(__DIR__);

require_once $base . '/config/Database.php';

// Entities
require_once $base . '/app/Entities/Adherent.php';
require_once $base . '/app/Entities/Abonnement.php';
require_once $base . '/app/Entities/Seance.php';
require_once $base . '/app/Entities/Salle.php';

// Repositories
require_once $base . '/app/Repositories/SalleRepository.php';
require_once $base . '/app/Repositories/AdherentRepository.php';
require_once $base . '/app/Repositories/AbonnementRepository.php';
require_once $base . '/app/Repositories/SeanceRepository.php';

// Services
require_once $base . '/app/Services/AbonnementService.php';
require_once $base . '/app/Services/AdherentService.php';
require_once $base . '/app/Services/SeanceService.php';

// Controllers
require_once $base . '/app/Controllers/AdherentController.php';
require_once $base . '/app/Controllers/AbonnementController.php';
require_once $base . '/app/Controllers/SeanceController.php';

// Routeur
$page   = $_GET['page']   ?? 'dashboard';
$action = $_GET['action'] ?? 'index';
$id     = isset($_GET['id']) ? (int)$_GET['id'] : null;

try {
    match ($page) {

        'dashboard' => require $base . '/views/dashboard/index.php',

        'adherents' => (function () use ($action, $id) {
            $ctrl = new AdherentController();
            match ($action) {
                'index'   => $ctrl->index(),
                'show'    => $ctrl->show($id),
                'create'  => $ctrl->create(),
                'store'   => $ctrl->store(),
                'edit'    => $ctrl->edit($id),
                'update'  => $ctrl->update($id),
                'destroy' => $ctrl->destroy($id),
                default   => $ctrl->index(),
            };
        })(),

        'abonnements' => (function () use ($action, $id) {
            $ctrl = new AbonnementController();
            match ($action) {
                'index'   => $ctrl->index(),
                'show'    => $ctrl->show($id),
                'create'  => $ctrl->create(),
                'store'   => $ctrl->store(),
                'edit'    => $ctrl->edit($id),
                'update'  => $ctrl->update($id),
                'destroy' => $ctrl->destroy($id),
                default   => $ctrl->index(),
            };
        })(),

        'seances' => (function () use ($action, $id) {
            $ctrl = new SeanceController();
            match ($action) {
                'index'   => $ctrl->index(),
                'show'    => $ctrl->show($id),
                'create'  => $ctrl->create(),
                'store'   => $ctrl->store(),
                'edit'    => $ctrl->edit($id),
                'update'  => $ctrl->update($id),
                'destroy' => $ctrl->destroy($id),
                default   => $ctrl->index(),
            };
        })(),

        default => require $base . '/views/dashboard/index.php',
    };

} catch (Throwable $e) {
    echo '<div style="font-family:sans-serif;padding:2rem;color:#c0392b">';
    echo '<h2>Erreur</h2><p>' . htmlspecialchars($e->getMessage()) . '</p>';
    echo '</div>';
}
