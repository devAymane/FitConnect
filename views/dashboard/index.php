<?php require __DIR__ . '/../layouts/header.php'; ?>

<?php
// Stats
$seanceRepo    = new SeanceRepository();
$abonnRepo     = new AbonnementRepository();
$adherentRepo  = new AdherentRepository();

$totalAdherents   = count($adherentRepo->findAll());
$totalSeances     = $seanceRepo->countTotal();
$seancesMois      = $seanceRepo->countThisMonth();
$abonnementsActifs = $abonnRepo->countActifs();
$statsActivite    = $seanceRepo->statsByActivite();
?>

<div class="page-header">
    <h1>Dashboard</h1>
    <p class="page-subtitle">Vue d'ensemble du réseau FitConnect</p>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon">👥</div>
        <div class="stat-value"><?= $totalAdherents ?></div>
        <div class="stat-label">Adhérents inscrits</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">📋</div>
        <div class="stat-value"><?= $abonnementsActifs ?></div>
        <div class="stat-label">Abonnements actifs</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">🏋️</div>
        <div class="stat-value"><?= $totalSeances ?></div>
        <div class="stat-label">Séances totales</div>
    </div>
    <div class="stat-card highlight">
        <div class="stat-icon">📅</div>
        <div class="stat-value"><?= $seancesMois ?></div>
        <div class="stat-label">Séances ce mois</div>
    </div>
</div>

<div class="dashboard-grid">
    <div class="card">
        <div class="card-header">
            <h2>Activités populaires</h2>
        </div>
        <div class="card-body">
            <?php foreach ($statsActivite as $stat): ?>
                <div class="activite-row">
                    <span class="activite-nom"><?= htmlspecialchars($stat['type_activite']) ?></span>
                    <div class="activite-bar-wrap">
                        <div class="activite-bar" style="width: <?= min(100, ($stat['total'] / max(1, $totalSeances)) * 100) ?>%"></div>
                    </div>
                    <span class="activite-count"><?= $stat['total'] ?></span>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h2>Accès rapide</h2>
        </div>
        <div class="card-body quick-links">
            <a href="?page=adherents&action=create" class="btn btn-primary">+ Nouvel adhérent</a>
            <a href="?page=abonnements&action=create" class="btn btn-secondary">+ Nouvel abonnement</a>
            <a href="?page=seances&action=create" class="btn btn-accent">+ Nouvelle séance</a>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
