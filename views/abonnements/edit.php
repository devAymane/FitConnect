<?php require __DIR__ . '/../layouts/header.php'; ?>

<div class="page-header">
    <h1>Modifier l'abonnement #<?= $abonnement['id_abonnement'] ?></h1>
    <a href="?page=abonnements" class="btn btn-secondary">← Retour</a>
</div>

<?php if (!empty($errors)): ?>
    <div class="alert alert-error">
        <?php foreach ($errors as $e): ?><p><?= htmlspecialchars($e) ?></p><?php endforeach; ?>
    </div>
<?php endif; ?>

<div class="card form-card">
    <form method="POST" action="?page=abonnements&action=update&id=<?= $abonnement['id_abonnement'] ?>">
        <div class="form-grid">
            <div class="form-group">
                <label>Type d'abonnement *</label>
                <select name="type_abonnement" required>
                    <?php foreach (['Mensuel','Trimestriel','Annuel'] as $type): ?>
                        <option value="<?= $type ?>" <?= $abonnement['type_abonnement'] === $type ? 'selected' : '' ?>><?= $type ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Date de début *</label>
                <input type="date" name="date_debut" value="<?= $abonnement['date_debut'] ?>" required>
            </div>
            <div class="form-group">
                <label>Date de fin *</label>
                <input type="date" name="date_fin" value="<?= $abonnement['date_fin'] ?>" required>
            </div>
            <div class="form-group">
                <label>Statut</label>
                <select name="statut">
                    <option value="Actif"   <?= $abonnement['statut'] === 'Actif'   ? 'selected' : '' ?>>Actif</option>
                    <option value="Expire"  <?= $abonnement['statut'] === 'Expire'  ? 'selected' : '' ?>>Expiré</option>
                    <option value="Suspendu" <?= $abonnement['statut'] === 'Suspendu' ? 'selected' : '' ?>>Suspendu</option>
                </select>
            </div>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Enregistrer</button>
            <a href="?page=abonnements" class="btn btn-ghost">Annuler</a>
        </div>
    </form>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
