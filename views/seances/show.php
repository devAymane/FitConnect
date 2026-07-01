<?php require __DIR__ . '/../layouts/header.php'; ?>

<div class="page-header">
    <h1>Séance #<?= $seance['id_seance'] ?></h1>
    <div>
        <a href="?page=seances&action=edit&id=<?= $seance['id_seance'] ?>" class="btn btn-warning">Modifier</a>
        <a href="?page=seances" class="btn btn-secondary">← Retour</a>
    </div>
</div>

<div class="card form-card">
    <div class="card-body info-list">
        <div><span>Adhérent</span><span><?= htmlspecialchars($seance['prenom'] . ' ' . $seance['nom']) ?></span></div>
        <div><span>Date</span><span><?= date('d/m/Y', strtotime($seance['date_seance'])) ?></span></div>
        <div><span>Activité</span><span><?= htmlspecialchars($seance['type_activite']) ?></span></div>
        <div><span>Durée</span><span><?= $seance['duree'] ?></span></div>
        <div><span>Équipement</span><span><?= $seance['equipement'] ? htmlspecialchars($seance['equipement']) : '—' ?></span></div>
        <div><span>Salle</span><span><?= htmlspecialchars($seance['nom_salle']) ?></span></div>
    </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
