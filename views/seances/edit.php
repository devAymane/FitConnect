<?php require __DIR__ . '/../layouts/header.php'; ?>

<div class="page-header">
    <h1>Modifier la séance #<?= $seance['id_seance'] ?></h1>
    <a href="?page=seances" class="btn btn-secondary">← Retour</a>
</div>

<?php if (!empty($errors)): ?>
    <div class="alert alert-error">
        <?php foreach ($errors as $e): ?><p><?= htmlspecialchars($e) ?></p><?php endforeach; ?>
    </div>
<?php endif; ?>

<div class="card form-card">
    <form method="POST" action="?page=seances&action=update&id=<?= $seance['id_seance'] ?>">
        <div class="form-grid">
            <div class="form-group">
                <label>Salle *</label>
                <select name="id_salle" required>
                    <?php foreach ($salles as $salle): ?>
                        <option value="<?= $salle['id_salle'] ?>"
                            <?= $salle['id_salle'] == $seance['id_salle'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($salle['nom_salle']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Date de séance *</label>
                <input type="date" name="date_seance" value="<?= $seance['date_seance'] ?>" required>
            </div>
            <div class="form-group">
                <label>Type d'activité *</label>
                <input type="text" name="type_activite" value="<?= htmlspecialchars($seance['type_activite']) ?>" required>
            </div>
            <div class="form-group">
                <label>Durée *</label>
                <input type="time" name="duree" value="<?= substr($seance['duree'], 0, 5) ?>" required>
            </div>
            <div class="form-group">
                <label>Équipement</label>
                <input type="text" name="equipement" value="<?= htmlspecialchars($seance['equipement'] ?? '') ?>">
            </div>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Enregistrer</button>
            <a href="?page=seances" class="btn btn-ghost">Annuler</a>
        </div>
    </form>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
