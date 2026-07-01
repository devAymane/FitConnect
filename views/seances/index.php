<?php require __DIR__ . '/../layouts/header.php'; ?>

<div class="page-header">
    <div>
        <h1>Séances</h1>
        <p class="page-subtitle"><?= count($seances) ?> séance(s)</p>
    </div>
    <a href="?page=seances&action=create" class="btn btn-primary">+ Nouvelle séance</a>
</div>

<div class="card">
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Date</th>
                <th>Adhérent</th>
                <th>Activité</th>
                <th>Durée</th>
                <th>Équipement</th>
                <th>Salle</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($seances as $s): ?>
            <tr>
                <td>#<?= $s['id_seance'] ?></td>
                <td><?= date('d/m/Y', strtotime($s['date_seance'])) ?></td>
                <td><strong><?= htmlspecialchars($s['prenom'] . ' ' . $s['nom']) ?></strong></td>
                <td><span class="badge"><?= htmlspecialchars($s['type_activite']) ?></span></td>
                <td><?= $s['duree'] ?></td>
                <td><?= $s['equipement'] ? htmlspecialchars($s['equipement']) : '—' ?></td>
                <td><?= htmlspecialchars($s['nom_salle']) ?></td>
                <td class="actions">
                    <a href="?page=seances&action=show&id=<?= $s['id_seance'] ?>" class="btn-sm btn-info">Voir</a>
                    <a href="?page=seances&action=edit&id=<?= $s['id_seance'] ?>" class="btn-sm btn-warning">Modifier</a>
                    <form method="POST" action="?page=seances&action=destroy&id=<?= $s['id_seance'] ?>" style="display:inline" onsubmit="return confirm('Supprimer cette séance ?')">
                        <button class="btn-sm btn-danger">Supprimer</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php if (empty($seances)): ?>
            <tr><td colspan="8" class="text-center">Aucune séance enregistrée.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
