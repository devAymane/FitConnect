# FitConnect — Application de gestion de salles de sport

Application backend PHP en architecture en couches (MVC) pour le réseau FitConnect (4 salles).

## Structure du projet

```
fitconnect/
├── app/
│   ├── Controllers/     # Orchestration requête → service → vue
│   ├── Entities/        # Classes métier (Adherent, Abonnement, Seance, Salle)
│   ├── Repositories/    # Accès BDD via PDO paramétré
│   └── Services/        # Règles de gestion (validation, contraintes métier)
├── config/
│   └── Database.php     # Singleton PDO
├── views/               # Templates PHP (adherents, abonnements, seances, dashboard)
├── public/
│   ├── index.php        # Point d'entrée unique — routeur
│   ├── test.php         # Tests par couche
│   ├── css/style.css
│   └── js/script.js
└── database/
    └── fitconnect.sql   # Schéma + données de test
```

## Installation

1. Importer `database/fitconnect.sql` dans MySQL (base nommée `ffit`)
2. Configurer `config/Database.php` (host, dbname, user, password)
3. Placer le projet dans `htdocs/fitconnect/`
4. Ouvrir `http://localhost/fitconnect/public/index.php`
5. Tests : `http://localhost/fitconnect/public/test.php`

## Règles métier implémentées

- Un adhérent ne peut être supprimé s'il a des séances ou un abonnement en cours
- Une séance ne peut être enregistrée que si l'abonnement est valide à la date du jour
- Un seul abonnement actif par adhérent à la fois
- La date de fin est calculée automatiquement selon le type (Mensuel / Trimestriel / Annuel)

## Architecture en couches

```
HTTP Request
    ↓
public/index.php  (routeur)
    ↓
Controller        (dispatch, gère la réponse)
    ↓
Service           (règles métier, validations)
    ↓
Repository        (requêtes SQL paramétrées)
    ↓
Database (PDO)    (connexion centralisée)
```
