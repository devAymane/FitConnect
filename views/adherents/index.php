<?php require __DIR__ . '/../layouts/header.php'; ?>

<div class="page-header">
    <div>
        <h1>Adhérents</h1>
        <p class="page-subtitle"><?= count($adherents) ?> adhérent(s) inscrit(s)</p>
    </div>
    <a href="?page=adherents&action=create" class="btn btn-primary">+ Nouvel adhérent</a>
</div>

<div class="card">
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Email</th>
                <th>Téléphone</th>
                <th>Salle</th>
                <th>Inscription</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($adherents as $a): ?>
            <tr>
                <td>#<?= $a['id_adherent'] ?></td>
                <td><strong><?= htmlspecialchars($a['prenom'] . ' ' . $a['nom']) ?></strong></td>
                <td><?= htmlspecialchars($a['email']) ?></td>
                <td><?= htmlspecialchars($a['telephone']) ?></td>
                <td><span class="badge"><?= htmlspecialchars($a['nom_salle']) ?></span></td>
                <td><?= date('d/m/Y', strtotime($a['date_inscription'])) ?></td>
                <td class="actions">
                    <a href="?page=adherents&action=show&id=<?= $a['id_adherent'] ?>" class="btn-sm btn-info">Voir</a>
                    <a href="?page=adherents&action=edit&id=<?= $a['id_adherent'] ?>" class="btn-sm btn-warning">Modifier</a>
                    <form method="POST" action="?page=adherents&action=destroy&id=<?= $a['id_adherent'] ?>" style="display:inline" onsubmit="return confirm('Supprimer cet adhérent ?')">
                        <button class="btn-sm btn-danger">Supprimer</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php if (empty($adherents)): ?>
            <tr><td colspan="7" class="text-center">Aucun adhérent trouvé.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
