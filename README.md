Dimitry Blog Back
À propos du projet
Dimitry Blog Back est une application backend basée sur Laravel, conçue pour gérer une plateforme de blogging. Elle fournit une API robuste pour l'authentification des utilisateurs, la gestion des posts, la gestion des commentaires et le contrôle d'accès basé sur les rôles. Le projet est structuré pour être facilement maintenable et extensible, garantissant que d'autres développeurs peuvent rapidement comprendre et contribuer à la base de code.

Table des matières
À propos du projet
Installation
Structure du projet
Modules et packages principaux
Routes API
Seeding de la base de données
Tests
Contribution
Licence
Installation
Pour commencer avec le projet, suivez ces étapes :

Cloner le dépôt :

Installer les dépendances :

Copier le fichier d'environnement exemple et le configurer :

Générer la clé de l'application :

Exécuter les migrations et les seeders de la base de données :

Démarrer le serveur de développement :

Structure du projet
Le projet suit la structure standard de Laravel avec quelques répertoires supplémentaires pour des fonctionnalités spécifiques :

app/ : Contient le code principal de l'application, y compris les modèles, les contrôleurs et les middlewares.
bootstrap/ : Contient les fichiers de bootstrap de l'application.
config/ : Contient les fichiers de configuration pour divers services et packages.
database/ : Contient les migrations de base de données, les seeders et les factories.
public/ : Contient les fichiers accessibles au public, y compris le point d'entrée de l'application.
resources/ : Contient les vues, les fichiers de langue et les assets frontend.
routes/ : Contient les définitions de routes pour l'application.
storage/ : Contient les fichiers générés par l'application, y compris les logs et les fichiers de cache.
tests/ : Contient les tests unitaires et fonctionnels.
vendor/ : Contient les dépendances installées via Composer.
Modules et packages principaux
Le projet utilise plusieurs modules et packages pour fournir des fonctionnalités clés :

Laravel Sanctum : Pour l'authentification des API.
Spatie Laravel Permission : Pour la gestion des rôles et des permissions.
Laravel Tinker : Pour une REPL puissante.
PHPUnit : Pour les tests unitaires.
GuzzleHTTP : Pour les requêtes HTTP.
Laravel Mix : Pour la gestion des assets frontend.
Routes API
Les routes API sont définies dans le fichier api.php. Voici un aperçu des principales routes :

Routes d'authentification :

POST /register : Inscription d'un nouvel utilisateur.
POST /login : Connexion d'un utilisateur.
POST /logout : Déconnexion d'un utilisateur (nécessite une authentification).
Routes publiques :

GET /posts : Récupérer tous les posts.
GET /posts/{post} : Récupérer un post spécifique.
GET /comments : Récupérer tous les commentaires.
GET /comments/{comment} : Récupérer un commentaire spécifique.
Routes pour les utilisateurs authentifiés :

GET /user/profile : Récupérer le profil de l'utilisateur authentifié.
PUT /user/profile : Mettre à jour le profil de l'utilisateur authentifié.
DELETE /user/profile : Supprimer le profil de l'utilisateur authentifié.
POST /posts/{post}/comments : Ajouter un commentaire à un post.
DELETE /comments/{comment} : Supprimer un commentaire.
Routes pour les auteurs :

POST /posts : Créer un nouveau post.
PUT /posts/{post} : Mettre à jour un post.
DELETE /posts/{post} : Supprimer un post.
Routes pour les modérateurs :

PUT /posts/{post} : Mettre à jour un post.
DELETE /posts/{post} : Supprimer un post.
PUT /posts/{post}/state : Changer l'état d'un post.
DELETE /comments/{comment} : Supprimer un commentaire.
Routes pour les administrateurs :

PUT /admin/role/{user_id} : Assigner un rôle à un utilisateur.
DELETE /admin/{user_id} : Supprimer un utilisateur.
PUT /admin/{user_id} : Mettre à jour un utilisateur.
Seeding de la base de données
Le projet utilise des seeders pour peupler la base de données avec des données initiales. Les seeders sont définis dans le répertoire seeders. Voici quelques seeders importants :

RolePermissionSeeder : Définit les rôles et les permissions.
AdminSeeder : Crée des utilisateurs administrateurs et leur assigne des rôles.
Pour exécuter les seeders, utilisez la commande suivante :

Tests
Les tests unitaires et fonctionnels sont définis dans le répertoire tests. Le projet utilise PHPUnit pour les tests. Pour exécuter les tests, utilisez la commande suivante :

Contribution
Merci de considérer contribuer à ce projet ! Les contributions sont les bienvenues. Veuillez suivre les étapes suivantes pour contribuer :

Forker le dépôt.
Créer une branche pour votre fonctionnalité (git checkout -b feature/ma-fonctionnalité).
Commiter vos modifications (git commit -m 'Ajouter ma fonctionnalité').
Pousser votre branche (git push origin feature/ma-fonctionnalité).
Ouvrir une Pull Request.
Licence
Ce projet est sous licence MIT. Voir le fichier LICENSE pour plus de détails.
