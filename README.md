# Application Web d'Emploi du Temps

## Description

Cette application web d'emploi du temps permet aux utilisateurs de s'inscrire, de se connecter, de gérer leurs événements hebdomadaires, et de naviguer entre différentes semaines. Le design de l'application est basé sur un style rétro pour offrir une expérience utilisateur agréable.

## Technologies Utilisées

- **Slim Framework** : Backend PHP léger et performant.
- **Twig** : Moteur de templates pour la création des vues.
- **Retro.css** : Framework CSS pour un style rétro.
- **SQLite** : Base de données pour stocker les utilisateurs et les événements.

---

## Fonctionnalités Principales

- **Gestion des utilisateurs** :
  - Inscription
  - Connexion
  - Déconnexion
- **Gestion des événements** :
  - Ajout d'événements
  - Affichage hebdomadaire des événements
  - Navigation entre les semaines
- **Interface utilisateur rétro** :
  - Design esthétique avec un style rétro utilisant des couleurs pastel

---

## Structure du Projet

```
Root Directory
├── public
│   └── index.php             # Point d'entrée principal de l'application
├── src
│   ├── routes.php            # Fichier de définition des routes
│   ├── EventController.php   # Contrôleur pour les événements
│   └── UserController.php    # Contrôleur pour les utilisateurs
├── templates
│   ├── layout.twig           # Modèle principal pour le layout
│   ├── home.twig             # Page d'accueil
│   ├── events.twig           # Page des événements
│   ├── login.twig            # Page de connexion
│   └── register.twig         # Page d'inscription
├── database
│   └── database.sqlite       # Base de données SQLite
├── styles
│   └── styles.css            # Feuille de styles personnalisée
├── setup.php                 # Script pour initialiser la base de données
├── README.md                 # Documentation du projet
└── composer.json             # Fichier de configuration Composer
```

---

## Installation

1. Clonez le dépôt :
   ```bash
   git clone https://github.com/your-username/your-repo-name.git
   ```

2. Accédez au répertoire du projet :
   ```bash
   cd your-repo-name
   ```

3. Installez les dépendances via Composer :
   ```bash
   composer install
   ```

4. Configurez la base de données (Si vous voulez une nouvelle base) :
   ```bash
   php setup.php  
   ```

5. Lancez le serveur de développement :
   ```bash
   php -S localhost:8080 -t public
   ```

6. Accédez à l'application via [http://localhost:8080](http://localhost:8080).

---

## Prérequis

- PHP >= 8.1
- Composer
- Extension PHP SQLite activée
- Extension PHP intl activée

---

## Contributions

Les contributions sont les bienvenues ! Veuillez suivre les étapes ci-dessous :

1. Forkez le dépôt.
2. Créez une branche pour votre fonctionnalité :
   ```bash
   git checkout -b feature/nom-de-la-fonctionnalite
   ```
3. Effectuez vos modifications et validez-les :
   ```bash
   git commit -m "Ajout de ma fonctionnalité"
   ```
4. Poussez vos modifications :
   ```bash
   git push origin feature/nom-de-la-fonctionnalite
   ```
5. Créez une Pull Request.

---

## Auteur

Nicolas Robles

---

## Licence

Ce projet est sous licence MIT.
