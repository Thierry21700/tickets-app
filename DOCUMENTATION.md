# Système de Gestion de Tickets - Documentation

## Informations du Projet

**Nom du projet :** Système de Gestion de Tickets  
**Développé par :** Thierry Goutier  
**Framework :** Symfony 7.3  
**Base de données :** SQLite  
**Interface :** Bootstrap 5.3 + Font Awesome 6.0  

## Accès à l'Application

### Comptes Utilisateurs

#### Administrateur
- **E-mail :** admin@agence.com
- **Mot de passe :** admin123
- **Rôle :** ROLE_ADMIN
- **Permissions :** Accès complet à l'administration, gestion des tickets, catégories, statuts et responsables

#### Personnel
- **E-mail :** staff@agence.com
- **Mot de passe :** staff123
- **Rôle :** ROLE_STAFF
- **Permissions :** Consultation et modification des tickets, changement de statut

### Fonctionnalités

#### Pour les Visiteurs (Non connectés)
- Page d'accueil avec formulaire de création de ticket
- Création de tickets avec :
  - Adresse e-mail du client
  - Description (20-250 caractères)
  - Catégorie (Incident, Panne, Évolution, Anomalie, Information)

#### Pour le Personnel (ROLE_STAFF)
- Consultation de la liste des tickets
- Visualisation détaillée des tickets
- Modification du statut des tickets
- Interface de filtrage par statut

#### Pour l'Administrateur (ROLE_ADMIN)
- Toutes les fonctionnalités du personnel
- Gestion complète des tickets (création, modification, suppression)
- Administration des catégories
- Administration des statuts
- Administration des responsables
- Tableau de bord d'administration

## Structure de la Base de Données

### Entités Principales

#### Ticket
- **id** : Identifiant unique
- **author** : Adresse e-mail du client
- **openingDate** : Date d'ouverture (automatique)
- **closingDate** : Date de clôture (optionnelle)
- **description** : Description du ticket (20-250 caractères)
- **category** : Catégorie du ticket
- **status** : Statut du ticket
- **responsible** : Responsable assigné

#### Category
- **id** : Identifiant unique
- **name** : Nom de la catégorie

#### Status
- **id** : Identifiant unique
- **name** : Nom du statut

#### Responsible
- **id** : Identifiant unique
- **name** : Nom du responsable
- **email** : E-mail du responsable

#### User
- **id** : Identifiant unique
- **email** : E-mail de connexion
- **name** : Nom d'affichage
- **password** : Mot de passe hashé
- **roles** : Rôles de l'utilisateur

## Technologies Utilisées

### Backend
- **Symfony 7.3** : Framework PHP
- **Doctrine ORM** : Mapping objet-relationnel
- **Doctrine Migrations** : Gestion des versions de base de données
- **Doctrine Fixtures** : Données de test
- **Symfony Security** : Authentification et autorisation
- **Symfony Forms** : Gestion des formulaires
- **Symfony Validator** : Validation des données

### Frontend
- **Bootstrap 5.3** : Framework CSS
- **Font Awesome 6.0** : Icônes
- **Twig** : Moteur de templates
- **JavaScript** : Interactions côté client

## Installation et Configuration

### Prérequis
- PHP 8.1 ou supérieur
- Composer
- SQLite (inclus avec PHP)

### Installation
1. Cloner le projet
2. Installer les dépendances : `composer install`
3. Configurer la base de données dans `.env`
4. Exécuter les migrations : `php bin/console doctrine:migrations:migrate`
5. Charger les fixtures : `php bin/console doctrine:fixtures:load`
6. Démarrer le serveur : `php bin/console server:start`

### Configuration
- Base de données SQLite : `var/data.db`
- Environnement de développement activé
- Cache et logs dans le répertoire `var/`

## Fonctionnalités Techniques

### Sécurité
- Authentification par formulaire
- Hachage des mots de passe avec l'algorithme auto
- Protection CSRF sur tous les formulaires
- Contrôle d'accès basé sur les rôles

### Validation
- Validation côté serveur avec Symfony Validator
- Contraintes sur les champs obligatoires
- Validation de format e-mail
- Contraintes de longueur sur les descriptions

### Interface Utilisateur
- Design responsive avec Bootstrap
- Navigation intuitive avec menu contextuel
- Messages de confirmation et d'erreur
- Filtrage dynamique des tickets
- Interface d'administration complète

## Déploiement

L'application est prête pour le déploiement en production avec :
- Configuration d'environnement séparée
- Gestion des erreurs
- Logs de sécurité
- Optimisations de cache

---

**Développé par Thierry Goutier**  
**Framework :** Symfony 7.3  
**Date de création :** 2025
**Développeur :** Thierry Goutier
