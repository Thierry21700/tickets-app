# 🎫 Système de Gestion de Tickets

Application web de gestion de tickets développée avec Symfony 7.3 pour une agence web.

**Développé par Thierry Goutier**

## 🚀 Démarrage Rapide

### Prérequis
- PHP 8.1+
- Composer
- SQLite (inclus avec PHP)

### Installation
```bash
# Aller sur le repertoire du projet
cd tickets-app

# Installer les dépendances
composer install

# Configurer la base de données
echo 'DATABASE_URL="sqlite:///%kernel.project_dir%/var/data.db"' >> .env

# Exécuter les migrations
php bin/console doctrine:migrations:migrate

# Charger les données de test
php bin/console doctrine:fixtures:load

# Démarrer le serveur
php bin/console server:start

# Accèder a l'app ici
http://localhost:8000/ 
```


## 🔐 Comptes d'Accès

### Administrateur
- **E-mail :** admin@agence.com
- **Mot de passe :** admin123
- **Accès :** Administration complète

### Personnel
- **E-mail :** staff@agence.com
- **Mot de passe :** staff123
- **Accès :** Gestion des tickets

## 📋 Fonctionnalités

### Visiteurs
- Création de tickets avec formulaire
- Sélection de catégorie
- Description du problème

### Personnel
- Consultation des tickets
- Modification des statuts
- Filtrage par statut

### Administrateur
- Gestion complète des tickets
- Administration des catégories
- Administration des statuts
- Administration des responsables
- Tableau de bord

## 🏗️ Architecture

- **Framework :** Symfony 7.3
- **Base de données :** SQLite
- **Frontend :** Bootstrap 5.3 + Font Awesome
- **Sécurité :** Symfony Security
- **Validation :** Symfony Validator
- **Templates :** Twig

## 📁 Structure du Projet

```
src/
├── Controller/          # Contrôleurs
├── Entity/             # Entités Doctrine
├── Form/               # Formulaires Symfony
├── Repository/         # Repositories Doctrine
└── DataFixtures/       # Données de test

templates/
├── admin/              # Templates d'administration
├── home/               # Page d'accueil
├── security/           # Authentification
└── ticket/             # Gestion des tickets
```

## 👨‍💻 Développeur

**Thierry Goutier** - Développeur Symfony

## 📝 Licence

Projet interne de l'agence web - 2025
