<?php require __DIR__ . '/../layouts/header.php';
$abonnRepo  = new AbonnementRepository();
$seanceRepo = new SeanceRepository();
$abonnements = $abonnRepo->findByAdherent($adherent['id_adherent']);
$seances     = $seanceRepo->findByAdherent($adherent['id_adherent']);
$abonnActif  = $abonnRepo->findActifByAdherent($adherent['id_adherent']);
?>

<div class="page-header">
    <h1><?= htmlspecialchars($adherent['prenom'] . ' ' . $adherent['nom']) ?></h1>
    <div>
        <a href="?page=adherents&action=edit&id=<?= $adherent['id_adherent'] ?>" class="btn btn-warning">Modifier</a>
        <a href="?page=adherents" class="btn btn-secondary">← Retour</a>
    </div>
</div>

<div class="profile-grid">
    <div class="card">
        <div class="card-header"><h2>Informations</h2></div>
        <div class="card-body info-list">
            <div><span>Email</span><span><?= htmlspecialchars($adherent['email']) ?></span></div>
            <div><span>Téléphone</span><span><?= htmlspecialchars($adherent['telephone']) ?></span></div>
            <div><span>Salle</span><span><?= htmlspecialchars($adherent['nom_salle']) ?></span></div>
            <div><span>Inscrit le</span><span><?= date('d/m/Y', strtotime($adherent['date_inscription'])) ?></span></div>
        </div>
    </div>

    <div class="card">
        <div class="card-header"><h2>Statut abonnement</h2></div>
        <div class="card-body">
            <?php if ($abonnActif): ?>
                <div class="status-badge status-active">✓ Abonnement valide</div>
                <p>Type : <?= $abonnActif['type_abonnement'] ?></p>
                <p>Expire le : <strong><?= date('d/m/Y', strtotime($abonnActif['date_fin'])) ?></strong></p>
            <?php else: ?>
                <div class="status-badge status-expired">✗ Pas d'abonnement actif</div>
                <a href="?page=abonnements&action=create&id_adherent=<?= $adherent['id_adherent'] ?>" class="btn btn-primary" style="margin-top:1rem">+ Créer un abonnement</a>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="card" style="margin-top:1.5rem">
    <div class="card-header">
        <h2>Séances (<?= count($seances) ?>)</h2>
    </div>
    <table class="table">
        <thead><tr><th>Date</th><th>Activité</th><th>Durée</th><th>Équipement</th><th>Salle</th></tr></thead>
        <tbody>
            <?php foreach ($seances as $s): ?>
            <tr>
                <td><?= date('d/m/Y', strtotime($s['date_seance'])) ?></td>
                <td><?= htmlspecialchars($s['type_activite']) ?></td>
                <td><?= $s['duree'] ?></td>
                <td><?= $s['equipement'] ? htmlspecialchars($s['equipement']) : '—' ?></td>
                <td><?= htmlspecialchars($s['nom_salle']) ?></td>
            </tr>
            <?php endforeach; ?>
            <?php if (empty($seances)): ?>
            <tr><td colspan="5" class="text-center">Aucune séance.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
