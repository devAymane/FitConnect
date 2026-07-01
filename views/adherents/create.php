<?php require __DIR__ . '/../layouts/header.php'; ?>

<div class="page-header">
    <h1>Nouvel adhérent</h1>
    <a href="?page=adherents" class="btn btn-secondary">← Retour</a>
</div>

<?php if (!empty($errors)): ?>
    <div class="alert alert-error">
        <?php foreach ($errors as $e): ?><p><?= htmlspecialchars($e) ?></p><?php endforeach; ?>
    </div>
<?php endif; ?>

<div class="card form-card">
    <form method="POST" action="?page=adherents&action=store">
        <div class="form-grid">
            <div class="form-group">
                <label>Nom *</label>
                <input type="text" name="nom" value="<?= htmlspecialchars($_POST['nom'] ?? '') ?>" required>
            </div>
            <div class="form-group">
                <label>Prénom *</label>
                <input type="text" name="prenom" value="<?= htmlspecialchars($_POST['prenom'] ?? '') ?>" required>
            </div>
            <div class="form-group">
                <label>Email *</label>
                <input type="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
            </div>
            <div class="form-group">
                <label>Téléphone *</label>
                <input type="text" name="telephone" value="<?= htmlspecialchars($_POST['telephone'] ?? '') ?>" required>
            </div>
            <div class="form-group">
                <label>Salle d'inscription *</label>
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
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Créer l'adhérent</button>
            <a href="?page=adherents" class="btn btn-ghost">Annuler</a>
        </div>
    </form>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
