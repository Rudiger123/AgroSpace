# 🌿 AgroSpace - Plateforme de Connexion Agropastorale

<div align="center">

![AgroSpace](Docs/logo.png)

**Connecter • Valoriser • Collaborer dans le monde agropastoral**

[![Laravel](https://img.shields.io/badge/Laravel-11.x-FF2D20?style=flat&logo=laravel&logoColor=white)](https://laravel.com)
[![Livewire](https://img.shields.io/badge/Livewire-3.x-4E56A6?style=flat&logo=livewire&logoColor=white)](https://livewire.laravel.com)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind-3.x-38B2AC?style=flat&logo=tailwind-css&logoColor=white)](https://tailwindcss.com)
[![PostgreSQL](https://img.shields.io/badge/PostgreSQL-Latest-336791?style=flat&logo=postgresql&logoColor=white)](https://www.postgresql.org)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)

</div>

---

## 📑 Table des matières

- [À propos](#-à-propos)
- [Fonctionnalités](#-fonctionnalités)
- [Architecture](#-architecture)
- [Stack Technique](#-stack-technique)
- [Installation](#-installation)
- [Configuration](#-configuration)
- [Utilisation](#-utilisation)
- [API & Routes](#-api--routes)
- [Tests](#-tests)
- [Déploiement](#-déploiement)
- [Documentation](#-documentation)
- [Contribution](#-contribution)
- [Sécurité](#-sécurité)
- [Roadmap](#-roadmap)
- [Licence](#-licence)

---

## 🎯 À propos

**AgroSpace** est une plateforme web moderne qui met en relation les acteurs du secteur agropastoral au Cameroun. Elle connecte les **producteurs** (fermiers, éleveurs, coopératives) avec les **consommateurs** (particuliers, restaurateurs, distributeurs) tout en offrant aux **administrateurs** des outils puissants de gestion.

### 🌟 Vision & Mission

**Vision :** Devenir la référence digitale pour les échanges agropastoraux locaux en Afrique francophone.

**Mission :** Faciliter la digitalisation des filières agricoles locales, réduire les intermédiaires et promouvoir des échanges directs, transparents et durables entre producteurs et acheteurs.

### 🎪 Contexte du Projet

Ce projet s'inscrit dans un **Bootcamp Laravel & DevOps** en tant que projet de mentoring complet couvrant :
- Architecture Clean (Services, Repositories, Actions)
- Développement Full-Stack (TallStack)
- API RESTful professionnelle
- DevOps & CI/CD moderne

**Apprenant :** Feutsop Kenne Rüdiger Dietrich  
**Mentor :** ChatGPT

---

## ✨ Fonctionnalités

### 👥 Gestion des Utilisateurs

#### 🔐 Authentification & Profils
- ✅ Inscription avec choix de rôle (Producteur / Consommateur)
- ✅ Connexion / Déconnexion sécurisée
- ✅ Réinitialisation de mot de passe par email
- ✅ Vérification d'email obligatoire
- ✅ Gestion complète du profil (photo, bio, localisation, activités)

#### 🎭 Rôles Utilisateurs
| Rôle | Description | Accès Principal |
|------|-------------|----------------|
| 👨‍🌾 **Producteur** | Crée des offres de produits/services agricoles | Gestion d'offres, Messagerie, Statistiques |
| 🛒 **Consommateur** | Crée des demandes et recherche des produits | Navigation offres, Demandes, Contact producteurs |
| 👨‍💼 **Administrateur** | Supervise l'ensemble de la plateforme | Dashboard, Modération, Gestion utilisateurs, Blog |

---

### 🌾 Fonctionnalités Producteur

#### 📊 Tableau de Bord Producteur
- Statistiques personnelles (offres actives, vues, messages)
- Graphiques d'évolution
- Demandes correspondant aux produits
- Accès rapide aux actions

#### 📦 Gestion des Offres
**Créer une offre complète :**
- Titre, description détaillée
- Catégorie (Céréales, Légumes, Élevage, Produits Transformés, Services)
- Prix indicatif et quantité disponible
- Photos multiples (upload drag & drop)
- Localisation (région, ville)
- Date de disponibilité
- Informations de contact

**Actions sur les offres :**
- ✏️ Modifier / Supprimer
- ✓ Marquer comme "Vendue"
- 📋 Dupliquer (gain de temps)
- 📈 Statistiques détaillées (vues, contacts, taux de conversion)
- 🔍 Filtres avancés (statut, catégorie, date)

#### 🔍 Exploration
- Parcourir les demandes des consommateurs
- Filtres par catégorie, région, quantité
- Répondre via messagerie intégrée
- Sauvegarder des demandes en favoris

---

### 🛒 Fonctionnalités Consommateur

#### 📊 Tableau de Bord Consommateur
- Suivi des demandes actives
- Recommandations personnalisées
- Historique de consultations
- Producteurs favoris

#### 📢 Gestion des Demandes
**Créer une demande :**
- Description du produit recherché
- Quantité souhaitée et budget
- Localisation et date limite
- Catégorie et spécifications

**Actions :**
- Modifier / Supprimer ses demandes
- Marquer comme "Satisfaite"
- Statistiques de performance

#### 🔎 Recherche & Exploration
- **Filtres avancés :**
  - Par catégorie et région
  - Fourchette de prix
  - Par producteur
  - Date de publication
- **Carte interactive** des producteurs
- **Profils détaillés** des producteurs
- **Système de favoris**

---

### 👨‍💼 Fonctionnalités Administrateur

#### 📊 Dashboard Administrateur Complet

**Statistiques Globales (KPIs) :**
- 👥 Utilisateurs actifs (avec évolution)
- 🌾 Offres publiées
- 📢 Demandes actives
- 📈 Taux de conversion
- 📧 Messages échangés
- 📅 Nouveaux inscrits du mois

**Visualisations Avancées :**
- Graphique activité (Offres vs Demandes sur 6-12 mois)
- Distribution par catégorie (barres de progression)
- Carte géographique interactive (utilisateurs par région)
- Top 5 régions actives
- Timeline des activités récentes

**Top Utilisateurs :**
- 🏆 Top Producteurs du mois
- ⭐ Consommateurs les plus actifs
- 💬 Utilisateurs engagés

---

#### 👥 Gestion des Utilisateurs

**Tableau complet avec :**
- Photo, Nom, Email, Rôle
- Date d'inscription et dernière connexion
- Statut (actif / suspendu / banni)
- Nombre d'offres/demandes

**Actions disponibles :**
- 👁️ Voir le profil complet
- ✏️ Modifier les informations
- ⏸️ Suspendre temporairement
- 🚫 Bannir définitivement
- ✅ Réactiver un compte
- 🗑️ Supprimer (avec confirmation)
- ✉️ Envoyer un email
- ✓ Attribuer badge "Vérifié"
- 📜 Historique d'activité

**Filtres :**
- Par rôle, statut, région
- Par date d'inscription
- Recherche par nom/email

---

#### 🌾 Gestion des Offres & Demandes

**Liste complète avec :**
- Image, Titre, Producteur/Consommateur
- Catégorie, Prix, Région
- Date de publication et statut
- Nombre de vues et contacts

**Modération :**
- ✅ Approuver / Rejeter
- ⭐ Mettre en avant (featured)
- 👁️ Masquer temporairement
- 🗑️ Supprimer avec motif
- ⚠️ Gérer les signalements
- 🔍 Validation des images
- 💰 Vérification des prix

---

#### 📰 Gestion du Blog

**Création d'Articles :**
- Éditeur WYSIWYG (TinyMCE)
- Champs : Titre, Slug SEO, Image de couverture
- Catégorie et tags
- Contenu riche (rich text)
- Extrait (meta description)
- Programmation de publication

**Actions :**
- ✏️ Modifier / 🗑️ Supprimer
- 📦 Archiver les anciens articles
- 📋 Dupliquer un article
- ⏰ Programmer une publication
- 📱 Partage social automatique

**Catégories disponibles :**
- Innovations agricoles
- Techniques de culture
- Subventions et financements
- Formations disponibles
- Success stories
- Actualités du secteur

---

#### 💬 Gestion des Messages

**Supervision :**
- Statistiques globales (messages échangés, conversations actives)
- Temps de réponse moyen
- Messages signalés (spam, contenu inapproprié)

**Modération :**
- Voir toutes les conversations
- Supprimer messages inappropriés
- Bannir utilisateurs spammeurs
- Filtres anti-spam (mots-clés interdits)

---

#### 🗺️ Carte Interactive

**Configuration :**
- Plateforme : Leaflet.js / Mapbox
- Géolocalisation des utilisateurs
- Marqueurs personnalisés par rôle

**Fonctionnalités :**
- Affichage producteurs/offres/demandes
- Filtres (catégorie, type, région)
- Popup d'information au clic
- Clustering automatique

---

#### 📊 Statistiques Avancées

**Périodes personnalisables :**
- Aujourd'hui / 7 jours / 30 jours
- 6 mois / 12 mois / Année
- Période personnalisée

**Graphiques détaillés :**
- Évolution temporelle (inscriptions, offres, demandes, messages)
- Répartition géographique (carte de chaleur)
- Distribution par catégorie (camembert)
- Performances (taux d'engagement, rétention)

**Export de données :**
- Format CSV
- Format Excel
- Rapport PDF complet

---

#### ⚙️ Paramètres Système

**Configuration Générale :**
- Informations du site (nom, logo, favicon)
- Paramètres régionaux (fuseau, langue, devise)
- Gestion des catégories et régions
- SEO (métadonnées, Analytics)

**Sécurité :**
- Activation 2FA
- Rate limiting
- Blocage d'IP
- Logs de sécurité
- Sauvegarde automatique

**Email & Notifications :**
- Configuration SMTP
- Templates personnalisables
- Notifications push (optionnel)

---

### 💬 Système de Messagerie

**Communication temps réel entre utilisateurs :**
- Discussion privée (Producteur ↔ Consommateur)
- Liste des conversations récentes
- Statut de lecture (lu/non lu)
- Envoi de fichiers (images, documents)
- Interface type WhatsApp
- WebSocket ou Livewire polling

---

### 🌐 Fonctionnalités Globales

#### 🔍 Recherche & Filtres
- Barre de recherche globale
- Filtres avancés multiples
- Recherche par mot-clé
- Tri personnalisé

#### 🌍 Localisation
- Chaque offre/demande géolocalisée
- Carte interactive (Leaflet.js)
- Géocodage (latitude, longitude)

#### 🔔 Notifications
- Notifications temps réel (Livewire toasts)
- Emails automatiques
- Centre de notifications

#### 🌐 SEO & i18n
- **SEO côté serveur** (Helper `App\Helpers\SEO`)
- Meta tags (Primary, Open Graph, Twitter, Geo)
- Microdata / Schema.org
- **Multilingue** (FR/EN via `__('producer.*')`)
- Slugs SEO friendly

---

## 🏗️ Architecture

### Structure du Projet

```
AgroSpace/
├── app/
│   ├── Http/
│   │   ├── Controllers/       # Contrôleurs HTTP
│   │   ├── Middleware/        # Middlewares personnalisés
│   │   └── Requests/          # Form Requests
│   ├── Livewire/              # Composants Livewire
│   ├── Models/                # Modèles Eloquent
│   │   ├── User.php           # Utilisateur (base)
│   │   ├── Producer.php       # Profil producteur
│   │   └── Offer.php          # Offre
│   ├── Services/              # Couche métier
│   ├── Helpers/
│   │   └── SEO.php            # Helper SEO
│   ├── Policies/              # Policies d'autorisation
│   ├── Notifications/         # Notifications
│   └── Mail/                  # Templates email
├── resources/
│   ├── views/
│   │   ├── livewire/          # Vues Livewire/Volt
│   │   │   └── producer-page.blade.php
│   │   ├── components/        # Composants Blade
│   │   │   └── layouts/
│   │   │       ├── header.blade.php
│   │   │       └── footer.blade.php
│   │   └── layouts/           # Layouts principaux
│   ├── lang/                  # Traductions i18n
│   │   ├── en/
│   │   │   └── producer.php
│   │   └── fr/
│   │       └── producer.php
│   └── js/                    # JavaScript
├── routes/
│   ├── web.php                # Routes web
│   └── api.php                # Routes API
├── config/                    # Configurations
├── database/
│   ├── migrations/            # Migrations
│   └── seeders/               # Seeders
├── tests/
│   ├── Feature/               # Tests fonctionnels
│   └── Unit/                  # Tests unitaires
├── public/
│   ├── images/                # Assets images
│   └── build/                 # Assets compilés (Vite)
├── docker/                    # Configuration Docker
├── .github/
│   └── workflows/             # CI/CD GitHub Actions
├── composer.json              # Dépendances PHP
├── package.json               # Dépendances Node
├── tailwind.config.js         # Config Tailwind
├── vite.config.js             # Config Vite
└── README.md
```

### Modèles & Relations Eloquent

**Relations principales :**
- `User` 1:1 `Producer` (un producteur est un utilisateur avec profil producteur)
- `Producer` 1:N `Offer` (un producteur peut publier plusieurs offres)
- `User` 1:N `Demand` (un consommateur crée plusieurs demandes)
- `User` 1:N `Message` (communications)
- `Admin` 1:N `BlogPost` (articles de blog)

---

## 🛠️ Stack Technique

### Backend
| Technologie | Version | Rôle |
|-------------|---------|------|
| **Laravel** | 11.x | Framework PHP principal |
| **PHP** | 8.2+ | Langage backend |
| **PostgreSQL** | Latest | Base de données |
| **Redis** | Latest | Cache & Sessions |
| **Laravel Sanctum** | - | Authentification API |
| **Laravel Queue** | - | Jobs asynchrones |
| **Laravel Broadcasting** | - | Temps réel (WebSockets) |
| **Spatie Media Library** | - | Gestion de fichiers |
| **Spatie Permission** | - | Rôles & Permissions |

### Frontend
| Technologie | Version | Rôle |
|-------------|---------|------|
| **Livewire** | 3.x | Composants dynamiques |
| **Alpine.js** | 3.x | Interactions JS légères |
| **Tailwind CSS** | 3.x | Framework CSS |
| **Vite** | Latest | Bundler d'assets |
| **Leaflet.js / Mapbox** | - | Cartes interactives |
| **ApexCharts / Chart.js** | - | Graphiques |

### DevOps & Outils
| Technologie | Rôle |
|-------------|------|
| **Docker & Docker Compose** | Conteneurisation |
| **GitHub Actions** | CI/CD |
| **Nginx** | Serveur web |
| **Let's Encrypt** | Certificats SSL/TLS |
| **PHPUnit / Pest** | Tests unitaires |

---

## 🚀 Installation

### Prérequis

- **PHP** >= 8.2 avec extensions : `pdo`, `mbstring`, `openssl`, `tokenizer`, `xml`, `ctype`, `json`, `bcmath`, `fileinfo`, `gd`
- **Composer** >= 2.5
- **Node.js** >= 18 LTS et **npm** / **yarn**
- **PostgreSQL** >= 14 (ou MySQL >= 8.0)
- **Redis** (optionnel mais recommandé)
- **Git**

### Étapes d'Installation

#### 1. Cloner le Dépôt

```bash
git clone https://github.com/votre-username/agrospace.git
cd agrospace
```

#### 2. Installer les Dépendances PHP

```bash
composer install
```

#### 3. Installer les Dépendances Frontend

```bash
npm install
# ou
yarn install
```

#### 4. Configuration de l'Environnement

```bash
cp .env.example .env
php artisan key:generate
```

**Éditez `.env` avec vos paramètres :**

```env
APP_NAME=AgroSpace
APP_ENV=local
APP_KEY=base64:VOTRE_CLE_GENEREE
APP_URL=http://localhost:8000

DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=agrospace
DB_USERNAME=votre_user
DB_PASSWORD=votre_password

CACHE_DRIVER=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=mailhog
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="noreply@agrospace.cm"
MAIL_FROM_NAME="${APP_NAME}"

FILESYSTEM_DRIVER=local
```

#### 5. Base de Données

```bash
# Créer la base de données PostgreSQL
createdb agrospace

# Exécuter les migrations
php artisan migrate

# (Optionnel) Remplir avec des données de test
php artisan db:seed
```

#### 6. Builder les Assets

```bash
# Développement (avec hot reload)
npm run dev

# Production (optimisé)
npm run build
```

#### 7. Lancer l'Application

```bash
php artisan serve
```

**Accédez à :** `http://127.0.0.1:8000`

---

## ⚙️ Configuration

### Variables d'Environnement Essentielles

```env
# Application
APP_NAME=AgroSpace
APP_ENV=production
APP_DEBUG=false
APP_URL=https://agrospace.cm

# Base de données
DB_CONNECTION=pgsql
DB_DATABASE=agrospace_prod
DB_USERNAME=prod_user
DB_PASSWORD=VOTRE_MOT_DE_PASSE_SECURISE

# Cache & Sessions
CACHE_DRIVER=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis

# Email (Production - exemple avec Mailgun)
MAIL_MAILER=mailgun
MAILGUN_DOMAIN=mg.agrospace.cm
MAILGUN_SECRET=VOTRE_CLE_API

# Stockage (avec S3)
FILESYSTEM_DRIVER=s3
AWS_ACCESS_KEY_ID=VOTRE_ACCESS_KEY
AWS_SECRET_ACCESS_KEY=VOTRE_SECRET_KEY
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=agrospace-assets

# SEO & Analytics
GOOGLE_ANALYTICS_ID=UA-XXXXXXXXX-X
```

### Commandes Artisan Utiles

```bash
# Cache des configs
php artisan config:cache

# Cache des routes
php artisan route:cache

# Cache des vues
php artisan view:cache

# Optimisation complète
php artisan optimize

# Nettoyer les caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

---

## 📘 Utilisation

### Lancer l'Application Localement

```bash
# Terminal 1 : Serveur Laravel
php artisan serve

# Terminal 2 : Builder assets (hot reload)
npm run dev

# Terminal 3 : Queue worker (optionnel)
php artisan queue:work

# Terminal 4 : Laravel Reverb (WebSockets, optionnel)
php artisan reverb:start
```

### Routes Principales

| Route | Description | Rôle |
|-------|-------------|------|
| `/` | Page d'accueil | Public |
| `/producteur` | Espace producteurs | Public (marketing) |
| `/register` | Inscription | Public |
| `/login` | Connexion | Public |
| `/dashboard` | Tableau de bord | Authentifié |
| `/offres` | Liste des offres | Public |
| `/demandes` | Liste des demandes | Authentifié |
| `/messages` | Messagerie | Authentifié |
| `/blog` | Articles de blog | Public |
| `/admin` | Dashboard admin | Admin |

### Accès Rapide

**Créer un compte administrateur :**

```bash
php artisan make:admin-user
# Suivre les instructions
```

**Créer un producteur de test :**

```bash
php artisan db:seed --class=ProducerSeeder
```

---

## 🔌 API & Routes

### Endpoints API Principaux

**Base URL :** `https://agrospace.cm/api/v1`

**Authentification :** Bearer Token (Laravel Sanctum)

#### Authentification

```http
POST /api/v1/auth/register
POST /api/v1/auth/login
POST /api/v1/auth/logout
POST /api/v1/auth/refresh
```

#### Offres

```http
GET    /api/v1/offres           # Liste des offres
GET    /api/v1/offres/{id}      # Détails d'une offre
POST   /api/v1/offres           # Créer une offre (Producteur)
PUT    /api/v1/offres/{id}      # Modifier une offre
DELETE /api/v1/offres/{id}      # Supprimer une offre
```

#### Demandes

```http
GET    /api/v1/demandes         # Liste des demandes
GET    /api/v1/demandes/{id}    # Détails d'une demande
POST   /api/v1/demandes         # Créer une demande (Consommateur)
PUT    /api/v1/demandes/{id}    # Modifier une demande
DELETE /api/v1/demandes/{id}    # Supprimer une demande
```

#### Utilisateurs

```http
GET    /api/v1/users/{id}       # Profil utilisateur
PUT    /api/v1/users/{id}       # Modifier profil
```

#### Admin

```http
GET    /api/v1/admin/stats              # Statistiques globales
GET    /api/v1/admin/users              # Liste utilisateurs
POST   /api/v1/admin/users/{id}/suspend # Suspendre
GET    /api/v1/admin/reports            # Signalements
```

### Documentation API

**Swagger/Postman :** [Documentation complète disponible ici](#) *(à venir)*

---

## 🧪 Tests

### Structure des Tests

```
tests/
├── Feature/              # Tests fonctionnels
│   ├── Auth/
│   ├── Offer/
│   ├── Demand/
│   └── Admin/
└── Unit/                 # Tests unitaires
    ├── Models/
    ├── Services/
    └── Helpers/
```

### Exécuter les Tests

```bash
# Tous les tests
php artisan test

# Avec PHPUnit
./vendor/bin/phpunit

# Avec Pest (si installé)
./vendor/bin/pest

# Tests spécifiques
php artisan test --filter=OfferTest

# Avec couverture
php artisan test --coverage
```

### Exemple de Test

```php
<?php

use App\Models\User;
use App\Models\Offer;

test('un producteur peut créer une offre', function () {
    $producer = User::factory()->create(['role' => 'producer']);
    
    $this->actingAs($producer);
    
    $response = $this->post('/offres', [
        'title' => 'Maïs Bio 100kg',
        'description' => 'Maïs biologique de qualité',
        'price' => 50000,
        'category' => 'cereales',
    ]);
    
    $response->assertStatus(201);
    $this->assertDatabaseHas('offers', ['title' => 'Maïs Bio 100kg']);
});
```

---

## 🚢 Déploiement

### Déploiement avec Docker

#### 1. Configuration Docker

```yaml
# docker-compose.yml
version: '3.8'

services:
  app:
    build:
      context: .
      dockerfile: docker/Dockerfile
    ports:
      - "8000:8000"
    environment:
      - APP_ENV=production
    volumes:
      - ./storage:/var/www/html/storage
    depends_on:
      - db
      - redis

  db:
    image: postgres:15-alpine
    environment:
      POSTGRES_DB: agrospace
      POSTGRES_USER: agrospace
      POSTGRES_PASSWORD: ${DB_PASSWORD}
    volumes:
      - postgres_data:/var/lib/postgresql/data

  redis:
    image: redis:7-alpine
    volumes:
      - redis_data:/data

  nginx:
    image: nginx:alpine
    ports:
      - "80:80"
      - "443:443"
    volumes:
      - ./docker/nginx:/etc/nginx/conf.d
      - ./public:/var/www/html/public
    depends_on:
      - app

volumes:
  postgres_data:
  redis_data:
```

#### 2. Lancer avec Docker

```bash
# Build les images
docker-compose build

# Démarrer les services
docker-compose up -d

# Exécuter les migrations
docker-compose exec app php artisan migrate --force

# Optimiser
docker-compose exec app php artisan optimize
```

### Déploiement Production (VPS)

#### Étapes

```bash
# 1. Récupérer le code
git clone https://github.com/votre-username/agrospace.git
cd agrospace

# 2. Installer dépendances
composer install --no-dev --optimize-autoloader
npm ci
npm run build

# 3. Configurer l'environnement
cp .env.example .env
php artisan key:generate
# Éditer .env avec les variables de production

# 4. Migrations
php artisan migrate --force

# 5. Optimisation
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize

# 6. Permissions
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

# 7. Configurer Nginx (voir docker/nginx/agrospace.conf)

# 8. SSL avec Certbot
sudo certbot --nginx -d agrospace.cm -d www.agrospace.cm
```

### CI/CD avec GitHub Actions

```yaml
# .github/workflows/deploy.yml
name: Deploy to Production

on:
  push:
    branches: [ main ]

jobs:
  deploy:
    runs-on: ubuntu-latest
    
    steps:
    - uses: actions/checkout@v3
    
    - name: Setup PHP
      uses: shivammathur/setup-php@v2
      with:
        php-version: '8.2'
    
    - name: Install Dependencies
      run: composer install --no-dev --optimize-autoloader
    
    - name: Run Tests
      run: php artisan test
    
    - name: Deploy to Server
      uses: appleboy/ssh-action@master
      with:
        host: ${{ secrets.SERVER_HOST }}
        username: ${{ secrets.SERVER_USER }}
        key: ${{ secrets.SSH_PRIVATE_KEY }}
        script: |
          cd /var/www/agrospace
          git pull origin main
          composer install --no-dev
          php artisan migrate --force
          php artisan optimize
          sudo systemctl reload nginx
```

---

## 📚 Documentation

### Documentation Additionnelle

- [Guide d'Architecture](Docs/ARCHITECTURE.md)
- [Guide de Contribution](CONTRIBUTING.md)
- [Cahier des Charges](🌿%20Cahier%20de%20Charges%20-%20Agrospace.md)
- [Document des Fonctionnalités](📋%20Agrospace%20-%20Document%20des%20Fonctionnalités%20par%20Rôle.md)
- [API Documentation](Docs/API.md) *(à venir)*
- [Changelog](CHANGELOG.md)

### Ressources Utiles

- [Laravel Documentation](https://laravel.com/docs/11.x)
- [Livewire Documentation](https://livewire.laravel.com)
- [Tailwind CSS Documentation](https://tailwindcss.com/docs)

---