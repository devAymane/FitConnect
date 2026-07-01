<?php require __DIR__ . '/../layouts/header.php'; ?>

<div class="page-header">
    <h1>Abonnement #<?= $abonnement['id_abonnement'] ?></h1>
    <div>
        <a href="?page=abonnements&action=edit&id=<?= $abonnement['id_abonnement'] ?>" class="btn btn-warning">Modifier</a>
        <a href="?page=abonnements" class="btn btn-secondary">← Retour</a>
    </div>
</div>

<?php $expire = $abonnement['date_fin'] < date('Y-m-d'); ?>

<div class="card form-card">
    <div class="card-body info-list">
        <div><span>Adhérent</span><span><?= htmlspecialchars($abonnement['prenom'] . ' ' . $abonnement['nom']) ?></span></div>
        <div><span>Type</span><span><?= $abonnement['type_abonnement'] ?></span></div>
        <div><span>Début</span><span><?= date('d/m/Y', strtotime($abonnement['date_debut'])) ?></span></div>
        <div><span>Fin</span><span><?= date('d/m/Y', strtotime($abonnement['date_fin'])) ?></span></div>
        <div><span>Statut</span><span><span class="badge <?= $expire ? 'badge-danger' : 'badge-success' ?>"><?= $expire ? 'Expiré' : 'Actif' ?></span></span></div>
    </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
