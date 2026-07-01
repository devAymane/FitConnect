<?php require __DIR__ . '/../layouts/header.php'; ?>

<div class="page-header">
    <div>
        <h1>Abonnements</h1>
        <p class="page-subtitle"><?= count($abonnements) ?> abonnement(s)</p>
    </div>
    <a href="?page=abonnements&action=create" class="btn btn-primary">+ Nouvel abonnement</a>
</div>

<div class="card">
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Adhérent</th>
                <th>Type</th>
                <th>Début</th>
                <th>Fin</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($abonnements as $a): ?>
            <?php $expire = $a['date_fin'] < date('Y-m-d'); ?>
            <tr>
                <td>#<?= $a['id_abonnement'] ?></td>
                <td><strong><?= htmlspecialchars($a['prenom'] . ' ' . $a['nom']) ?></strong></td>
                <td><?= $a['type_abonnement'] ?></td>
                <td><?= date('d/m/Y', strtotime($a['date_debut'])) ?></td>
                <td><?= date('d/m/Y', strtotime($a['date_fin'])) ?></td>
                <td><span class="badge <?= $expire ? 'badge-danger' : 'badge-success' ?>"><?= $expire ? 'Expiré' : 'Actif' ?></span></td>
                <td class="actions">
                    <a href="?page=abonnements&action=show&id=<?= $a['id_abonnement'] ?>" class="btn-sm btn-info">Voir</a>
                    <a href="?page=abonnements&action=edit&id=<?= $a['id_abonnement'] ?>" class="btn-sm btn-warning">Modifier</a>
                    <form method="POST" action="?page=abonnements&action=destroy&id=<?= $a['id_abonnement'] ?>" style="display:inline" onsubmit="return confirm('Supprimer cet abonnement ?')">
                        <button class="btn-sm btn-danger">Supprimer</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php if (empty($abonnements)): ?>
            <tr><td colspan="7" class="text-center">Aucun abonnement trouvé.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
