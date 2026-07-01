<?php require __DIR__ . '/../layouts/header.php'; ?>

<div class="page-header">
    <h1>Nouvelle séance</h1>
    <a href="?page=seances" class="btn btn-secondary">← Retour</a>
</div>

<?php if (!empty($errors)): ?>
    <div class="alert alert-error">
        <?php foreach ($errors as $e): ?><p><?= htmlspecialchars($e) ?></p><?php endforeach; ?>
    </div>
<?php endif; ?>

<div class="card form-card">
    <form method="POST" action="?page=seances&action=store">
        <div class="form-grid">
            <div class="form-group">
                <label>Adhérent *</label>
                <select name="id_adherent" required>
                    <option value="">-- Choisir un adhérent --</option>
                    <?php foreach ($adherents as $ad): ?>
                        <option value="<?= $ad['id_adherent'] ?>"
                            <?= (($_POST['id_adherent'] ?? '') == $ad['id_adherent']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($ad['prenom'] . ' ' . $ad['nom']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Salle *</label>
                <select name="id_salle" required>
                    <option value="">-- Choisir une salle --</option>
                    <?php foreach ($salles as $salle): ?>
                        <option value="<?= $salle['id_salle'] ?>"
                            <?= (($_POST['id_salle'] ?? '') == $salle['id_salle']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($salle['nom_salle']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Date de séance *</label>
                <input type="date" name="date_seance" value="<?= htmlspecialchars($_POST['date_seance'] ?? date('Y-m-d')) ?>" required>
            </div>
            <div class="form-group">
                <label>Type d'activité *</label>
                <input type="text" name="type_activite" placeholder="Ex : Musculation, Yoga, Cardio…"
                       value="<?= htmlspecialchars($_POST['type_activite'] ?? '') ?>" required>
            </div>
            <div class="form-group">
                <label>Durée * (HH:MM)</label>
                <input type="time" name="duree" value="<?= htmlspecialchars($_POST['duree'] ?? '01:00') ?>" required>
            </div>
            <div class="form-group">
                <label>Équipement utilisé</label>
                <input type="text" name="equipement" placeholder="Ex : Haltères, Tapis Yoga…"
                       value="<?= htmlspecialchars($_POST['equipement'] ?? '') ?>">
            </div>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Enregistrer la séance</button>
            <a href="?page=seances" class="btn btn-ghost">Annuler</a>
        </div>
    </form>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
