-Documentation d'installation et de déploiement local

-=— KFM Collection

-1. Présentation du projet

KFM Collection est une mini-application web développée en PHP orienté objet (POO), avec une base de données MySQL.

L'application permet de présenter et de gérer un catalogue de produits à l'aide des fonctionnalités CRUD :

\- CREATE : Ajouter un produit.
\- READ : Afficher les produits et consulter leurs détails.
\- UPDATE : Modifier les détails d'un produit.
\- DELETE : Supprimer un produit.

Pour organiser le code, j'ai utilisé l'architecture MVC.


-2. Environnement technique

L'application est exécutée en local. Pour faire fonctionner mon projet en local, j'utilise :

\- WampServer :
- - Apache
- - MySQL
- - PHP

\- Un navigateur web.

\- phpMyAdmin pour créer et gérer la base de données.


-3. Installation du projet

1\. Installer et démarrer WampServer sur l'ordinateur. WampServer permet de disposer des services Apache et MySQL.

2\. Contrôler le bon fonctionnement d'Apache et de MySQL.

3\. Placer le dossier de l'application dans le répertoire `C:\\wamp64\\www\\`.

4\. Vérifier que les fichiers du projet sont bien présents dans ce dossier.


-4. Configuration de la base de données

1\. Lancer phpMyAdmin depuis WampServer : `http://localhost/phpmyadmin/`.

2\. Créer une base de données nommée `base\_test`.

3\. Créer les tables nécessaires, notamment la table `produits`, qui contient les champs suivants :

\- `id\_produit`
\- `nom\_produit`
\- `description\_produit`
\- `prix\_produit`
\- `produit\_image`


-5. Connexion à la base de données

Le fichier `models/Database.php` contient la configuration de connexion à la base de données MySQL.

Pour connecter l'application PHP à la base de données, nous avons besoin des éléments suivants :

\- Le nom de la base de données.
\- Le serveur MySQL.
\- Le nom d'utilisateur.
\- Le mot de passe.

PDO est utilisé pour établir la connexion avec la base de données.


-6. Démarrage de l'application

1\. Vérifier que WampServer fonctionne.

2\. Ouvrir un navigateur web, ici Google Chrome, et saisir l'adresse locale du projet : `http://localhost/KFM-Collection/` (si le dossier s'appelle `KFM-Collection`).

3\. S'assurer que la page d'accueil s'affiche correctement.


-7. Tests de fonctionnement

près l'installation, je vérifie que les fonctionnalités marchent correctement : 

\- Affichage des produits : le test est réussi si les produits apparaissent correctement.

\- Ajout d'un produit : le test est réussi si le produit est enregistré dans la base de données.

\- Modification d'un produit : le test est réussi si les changements sont pris en compte.

\- Suppression d'un produit : le test est réussi si le produit est supprimé et si l'utilisateur est redirigé vers la page d'accueil.

\- Affichage de l'image : le test est réussi si l'image du produit apparaît correctement.


-8. Sécurité et précautions

\- Contrôler les données envoyées par les formulaires afin de limiter les risques de failles XSS.

\- Utiliser des requêtes SQL préparées pour limiter les risques d'injection SQL.

\- Vérifier les fichiers envoyés par les utilisateurs.

\- Sécuriser et protéger les identifiants de connexion à la base de données.

\- Effectuer une sauvegarde de la base de données avant chaque mise à jour importante.


-9. Limites du déploiement

Dans le cadre de ce projet, l'application fonctionne dans un environnement local avec WampServer.

Elle n'a pas été déployée sur un serveur de production accessible sur Internet.

Pour mettre mon application en ligne, je devrais utiliser un hébergement PHP et MySQL, configurer correctement les accès et renforcer la sécurité de l'application.


-10. Conclusion

Ce document présente les démarches nécessaires pour installer et configurer le projet PHP2, ainsi que les vérifications essentielles permettant de s'assurer du bon fonctionnement de l'application.

Ce document explique comment installer mon projet et vérifier son fonctionnement en local.

