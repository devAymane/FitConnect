<?php require __DIR__ . '/../layouts/header.php'; ?>

<div class="page-header">
    <h1>Nouvel abonnement</h1>
    <a href="?page=abonnements" class="btn btn-secondary">← Retour</a>
</div>

<?php if (!empty($errors)): ?>
    <div class="alert alert-error">
        <?php foreach ($errors as $e): ?><p><?= htmlspecialchars($e) ?></p><?php endforeach; ?>
    </div>
<?php endif; ?>

<div class="card form-card">
    <form method="POST" action="?page=abonnements&action=store">
        <div class="form-grid">
            <div class="form-group">
                <label>Adhérent *</label>
                <select name="id_adherent" required>
                    <option value="">-- Choisir un adhérent --</option>
                    <?php foreach ($adherents as $ad): ?>
                        <option value="<?= $ad['id_adherent'] ?>"
                            <?= (($_POST['id_adherent'] ?? $_GET['id_adherent'] ?? '') == $ad['id_adherent']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($ad['prenom'] . ' ' . $ad['nom']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Type d'abonnement *</label>
                <select name="type_abonnement" required>
                    <option value="">-- Choisir un type --</option>
                    <?php foreach (['Mensuel','Trimestriel','Annuel'] as $type): ?>
                        <option value="<?= $type ?>" <?= (($_POST['type_abonnement'] ?? '') === $type) ? 'selected' : '' ?>><?= $type ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Date de début *</label>
                <input type="date" name="date_debut" value="<?= htmlspecialchars($_POST['date_debut'] ?? date('Y-m-d')) ?>" required>
            </div>
            <div class="form-group info-box">
                <p>💡 La date de fin est calculée automatiquement selon le type choisi.</p>
            </div>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Créer l'abonnement</button>
            <a href="?page=abonnements" class="btn btn-ghost">Annuler</a>
        </div>
    </form>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
