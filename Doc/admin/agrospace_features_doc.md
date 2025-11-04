# 🌿 AGROSPACE - Document des Fonctionnalités par Rôle

## 📌 Vue d'ensemble du projet

**Agrospace** est une plateforme de mise en relation des acteurs du secteur agropastoral au Cameroun. Elle connecte les **producteurs** avec les **consommateurs** tout en offrant aux **administrateurs** des outils puissants de gestion et de supervision.

---

## 🎯 Les 3 Rôles Principaux

1. **👨‍🌾 Producteur** - Propose des offres (produits/services agricoles)
2. **🛒 Consommateur** - Crée des demandes et recherche des produits
3. **👨‍💼 Administrateur** - Supervise et gère toute la plateforme

---

## 🔐 1. FONCTIONNALITÉS COMMUNES (Tous les rôles)

### 📝 Authentification & Compte
- ✅ **Inscription** (avec choix du rôle : Producteur/Consommateur)
- ✅ **Connexion / Déconnexion**
- ✅ **Réinitialisation du mot de passe** (via email)
- ✅ **Vérification d'email** (sécurité)
- ✅ **Gestion du profil** :
  - Modifier photo de profil
  - Modifier informations (nom, email, téléphone)
  - Modifier localisation (ville, région)
  - Modifier description/bio
  - Changer le mot de passe

### 📱 Navigation & Interface
- ✅ **Header responsive** avec menu adaptatif
- ✅ **Notifications en temps réel**
- ✅ **Barre de recherche globale** (offres, demandes, utilisateurs)
- ✅ **Page d'accueil publique** (landing page)
- ✅ **Blog** (lecture d'articles)
- ✅ **Carte interactive** (Leaflet/Mapbox) - voir les acteurs par région

### 💬 Messagerie
- ✅ **Système de chat privé** (Producteur ↔ Consommateur)
- ✅ **Liste des conversations**
- ✅ **Notifications de nouveaux messages**
- ✅ **Statut de lecture** (lu/non lu)
- ✅ **Envoi de fichiers** (images, documents)

---

## 👨‍🌾 2. FONCTIONNALITÉS PRODUCTEUR

### 📊 Tableau de Bord Producteur
- ✅ **Statistiques personnelles** :
  - Nombre d'offres actives
  - Vues totales de mes offres
  - Messages reçus cette semaine
  - Demandes correspondant à mes produits
- ✅ **Graphiques** :
  - Évolution des vues de mes offres
  - Offres par catégorie
- ✅ **Activités récentes** (nouveaux messages, nouvelles demandes)

### 🌾 Gestion des Offres
- ✅ **Créer une offre** :
  - Titre
  - Description détaillée
  - Catégorie (Céréales, Légumes, Élevage, etc.)
  - Prix indicatif
  - Quantité disponible
  - Unité de mesure (kg, tonne, sac, pièce)
  - Photos (upload multiple)
  - Localisation (région, ville)
  - Date de disponibilité
  - Informations de contact
- ✅ **Modifier mes offres**
- ✅ **Supprimer mes offres**
- ✅ **Marquer une offre comme "Vendue"**
- ✅ **Dupliquer une offre** (gain de temps)
- ✅ **Liste de mes offres** avec filtres :
  - Par statut (active, vendue, expirée)
  - Par catégorie
  - Par date
  - Recherche par mot-clé

### 🔍 Consultation
- ✅ **Explorer les demandes** des consommateurs
- ✅ **Filtrer les demandes** par :
  - Catégorie
  - Région
  - Date
  - Quantité
- ✅ **Répondre aux demandes** (via messagerie)
- ✅ **Sauvegarder des demandes** (favoris)

### 📈 Visibilité & Promotion
- ✅ **Badge "Producteur Vérifié"** (après validation admin)
- ✅ **Statistiques détaillées par offre** :
  - Nombre de vues
  - Nombre de contacts reçus
  - Taux de conversion
- ✅ **Partage social** (lien de l'offre)

---

## 🛒 3. FONCTIONNALITÉS CONSOMMATEUR

### 📊 Tableau de Bord Consommateur
- ✅ **Statistiques personnelles** :
  - Nombre de demandes actives
  - Offres consultées
  - Messages envoyés
  - Demandes satisfaites
- ✅ **Recommandations** (offres correspondant à mes demandes)
- ✅ **Producteurs favoris**

### 📢 Gestion des Demandes
- ✅ **Créer une demande** :
  - Titre
  - Description de ce que je cherche
  - Catégorie
  - Quantité souhaitée
  - Prix maximum (budget)
  - Localisation souhaitée
  - Date limite
  - Contact
- ✅ **Modifier mes demandes**
- ✅ **Supprimer mes demandes**
- ✅ **Marquer une demande comme "Satisfaite"**
- ✅ **Liste de mes demandes** avec filtres

### 🔍 Exploration & Recherche
- ✅ **Explorer les offres** disponibles
- ✅ **Filtres avancés** :
  - Par catégorie
  - Par région
  - Par fourchette de prix
  - Par producteur
  - Par date de publication
- ✅ **Carte des producteurs** (géolocalisation)
- ✅ **Voir le profil des producteurs**
- ✅ **Sauvegarder des offres** (favoris)

### 💬 Interaction
- ✅ **Contacter les producteurs** (messagerie)
- ✅ **Laisser un avis** sur un producteur (optionnel)
- ✅ **Signaler une offre** (contenu inapproprié)

---

## 👨‍💼 4. FONCTIONNALITÉS ADMINISTRATEUR

### 📊 Dashboard Administrateur (Page principale)

#### **Statistiques Globales**
- ✅ **KPIs principaux** :
  - Nombre total d'utilisateurs (avec évolution)
  - Nombre d'offres publiées (avec évolution)
  - Nombre de demandes actives (avec évolution)
  - Taux de conversion (demandes satisfaites)
  - Nouveaux inscrits (ce mois)
  - Messages échangés (ce mois)

#### **Graphiques & Visualisations**
- ✅ **Graphique d'activité** :
  - Offres vs Demandes par mois (6-12 derniers mois)
  - Évolution des inscriptions
- ✅ **Distribution par catégorie** :
  - Offres par catégorie (barres de progression)
  - Catégories les plus populaires
- ✅ **Répartition géographique** :
  - Carte interactive avec nombre d'utilisateurs par région
  - Top 5 des régions actives

#### **Activités Récentes**
- ✅ **Timeline en temps réel** :
  - Nouvelles inscriptions
  - Offres publiées
  - Demandes créées
  - Messages importants
  - Signalements
  - Articles de blog publiés

#### **Top Utilisateurs**
- ✅ **Top Producteurs** du mois (par nombre d'offres)
- ✅ **Top Consommateurs** actifs
- ✅ **Utilisateurs les plus engagés**

#### **Actions Rapides**
- ✅ Boutons d'accès rapide :
  - ➕ Créer une offre
  - 📝 Publier un article
  - 👥 Inviter des utilisateurs
  - 📧 Envoyer une newsletter
  - ⚠️ Voir les signalements

---

### 👥 Gestion des Utilisateurs

#### **Liste des Utilisateurs**
- ✅ **Tableau complet** avec :
  - Photo, Nom, Email, Rôle
  - Date d'inscription
  - Statut (actif, suspendu, banni)
  - Nombre d'offres/demandes
  - Dernière connexion
- ✅ **Filtres** :
  - Par rôle (Producteur/Consommateur)
  - Par statut
  - Par région
  - Par date d'inscription
  - Recherche par nom/email

#### **Actions sur les Utilisateurs**
- ✅ **Voir le profil complet** (mode lecture seule)
- ✅ **Modifier les informations** d'un utilisateur
- ✅ **Suspendre temporairement** un compte
- ✅ **Bannir définitivement** un utilisateur
- ✅ **Réactiver** un compte suspendu
- ✅ **Supprimer** un compte (avec confirmation)
- ✅ **Envoyer un email** à un utilisateur
- ✅ **Attribuer un badge** "Vérifié" aux producteurs
- ✅ **Voir l'historique d'activité** d'un utilisateur :
  - Offres publiées
  - Demandes créées
  - Messages envoyés
  - Signalements reçus

#### **Statistiques Utilisateur**
- ✅ **Taux de croissance** des inscriptions
- ✅ **Répartition Producteurs/Consommateurs**
- ✅ **Taux d'activation** (email vérifié)
- ✅ **Utilisateurs actifs** (derniers 30 jours)

---

### 🌾 Gestion des Offres

#### **Liste des Offres**
- ✅ **Tableau complet** avec :
  - Image, Titre, Producteur
  - Catégorie, Prix, Région
  - Date de publication
  - Statut (active, vendue, expirée)
  - Nombre de vues
  - Nombre de contacts reçus
- ✅ **Filtres** :
  - Par catégorie
  - Par région
  - Par statut
  - Par producteur
  - Par date
  - Par fourchette de prix

#### **Actions sur les Offres**
- ✅ **Voir le détail** complet d'une offre
- ✅ **Modifier** une offre (si nécessaire)
- ✅ **Supprimer** une offre (avec motif)
- ✅ **Mettre en avant** (featured) une offre
- ✅ **Masquer temporairement** une offre
- ✅ **Approuver/Rejeter** (si modération activée)
- ✅ **Contacter le producteur** via messagerie admin

#### **Modération**
- ✅ **Signalements reçus** sur les offres
- ✅ **Validation des images** (contenu approprié)
- ✅ **Vérification des prix** (détection d'anomalies)

---

### 📢 Gestion des Demandes

#### **Liste des Demandes**
- ✅ **Tableau complet** similaire aux offres
- ✅ **Filtres** identiques
- ✅ **Statistiques** :
  - Demandes actives vs satisfaites
  - Temps moyen de résolution
  - Taux de satisfaction

#### **Actions sur les Demandes**
- ✅ Mêmes actions que pour les offres
- ✅ **Suggérer des offres** correspondantes
- ✅ **Mettre en relation** manuellement

---

### 💬 Gestion des Messages

#### **Vue d'ensemble**
- ✅ **Statistiques** :
  - Messages échangés (total)
  - Conversations actives
  - Temps de réponse moyen
- ✅ **Messages signalés** (spam, contenu inapproprié)

#### **Modération**
- ✅ **Voir toutes les conversations** (mode supervision)
- ✅ **Supprimer des messages** inappropriés
- ✅ **Bannir un utilisateur** pour spam
- ✅ **Filtres anti-spam** (mots-clés interdits)

---

### 📰 Gestion du Blog

#### **Liste des Articles**
- ✅ **Tableau** avec :
  - Image, Titre, Auteur (admin)
  - Catégorie, Date de publication
  - Statut (brouillon, publié, archivé)
  - Nombre de vues
  - Nombre de commentaires (si activé)

#### **Création d'Article**
- ✅ **Éditeur WYSIWYG** (TinyMCE/Trix)
- ✅ **Champs** :
  - Titre
  - Slug SEO (auto-généré)
  - Image de couverture
  - Catégorie
  - Contenu (rich text)
  - Extrait (meta description)
  - Tags
  - Statut (brouillon/publié)
  - Date de publication programmée
- ✅ **Prévisualisation** avant publication

#### **Actions**
- ✅ **Modifier** un article
- ✅ **Supprimer** un article
- ✅ **Archiver** un ancien article
- ✅ **Dupliquer** un article
- ✅ **Programmer** une publication
- ✅ **Partage social** automatique (si intégré)

#### **Catégories du Blog**
- ✅ Innovations agricoles
- ✅ Techniques de culture
- ✅ Subventions et financements
- ✅ Formations disponibles
- ✅ Success stories
- ✅ Actualités du secteur

---

### 🗺️ Gestion de la Carte Interactive

#### **Configuration**
- ✅ **Choix de la plateforme** (Leaflet.js/Mapbox)
- ✅ **Géolocalisation** des utilisateurs
- ✅ **Marqueurs personnalisés** :
  - Icône Producteur (vert)
  - Icône Consommateur (bleu)
  - Icône Admin (rouge)

#### **Fonctionnalités**
- ✅ **Affichage sur la carte** :
  - Tous les producteurs
  - Toutes les offres géolocalisées
  - Toutes les demandes
- ✅ **Filtres de la carte** :
  - Par catégorie
  - Par type (offre/demande)
  - Par région
- ✅ **Popup d'information** au clic sur un marqueur
- ✅ **Clustering** (regroupement si trop de marqueurs)

---

### 📊 Statistiques Avancées

#### **Page Statistiques Dédiée**
- ✅ **Période personnalisable** :
  - Aujourd'hui
  - 7 derniers jours
  - 30 derniers jours
  - 6 derniers mois
  - 12 derniers mois
  - Année en cours
  - Période personnalisée

#### **Graphiques Détaillés**
- ✅ **Évolution temporelle** :
  - Inscriptions par jour/semaine/mois
  - Offres publiées
  - Demandes créées
  - Messages échangés
- ✅ **Répartition** :
  - Utilisateurs par région (carte de chaleur)
  - Offres par catégorie (camembert)
  - Taux de conversion (entonnoir)
- ✅ **Performances** :
  - Temps moyen de réponse aux demandes
  - Taux d'engagement (utilisateurs actifs/total)
  - Taux de rétention (utilisateurs revenant)

#### **Export de Données**
- ✅ **Télécharger les statistiques** :
  - Format CSV
  - Format Excel
  - Format PDF (rapport complet)

---

### ⚙️ Paramètres Système

#### **Configuration Générale**
- ✅ **Informations du site** :
  - Nom de la plateforme
  - Logo
  - Favicon
  - Description
  - Email de contact
  - Réseaux sociaux
- ✅ **Paramètres régionaux** :
  - Fuseau horaire
  - Langue par défaut
  - Devise (FCFA)

#### **Gestion des Catégories**
- ✅ **Catégories d'offres/demandes** :
  - Céréales & Grains
  - Légumes & Fruits
  - Élevage & Volaille
  - Produits Transformés
  - Services Agricoles
- ✅ **Ajouter** une nouvelle catégorie
- ✅ **Modifier** une catégorie
- ✅ **Supprimer** une catégorie
- ✅ **Icône personnalisée** par catégorie

#### **Gestion des Régions**
- ✅ **Liste des régions du Cameroun** :
  - Adamaoua, Centre, Est, Extrême-Nord
  - Littoral, Nord, Nord-Ouest, Ouest
  - Sud, Sud-Ouest
- ✅ **Ajouter/Modifier** des régions
- ✅ **Géocoordonnées** (latitude, longitude)

#### **Modération**
- ✅ **Activation de la modération** :
  - Offres (approbation avant publication)
  - Demandes (idem)
  - Commentaires de blog
- ✅ **Filtres de contenu** :
  - Liste de mots interdits
  - Validation des images (IA anti-nudité)
- ✅ **Signalements** :
  - Seuil de signalements avant action auto
  - Notification admin immédiate

#### **Email & Notifications**
- ✅ **Configuration SMTP** :
  - Serveur mail
  - Port, Encryption
  - From Name, From Email
- ✅ **Templates d'emails** :
  - Email de bienvenue
  - Email de réinitialisation
  - Notification de nouveau message
  - Newsletter
- ✅ **Notifications Push** (optionnel)

#### **SEO**
- ✅ **Métadonnées** :
  - Title
  - Description
  - Keywords
- ✅ **Google Analytics** (ID de suivi)
- ✅ **Google Search Console**
- ✅ **Sitemap XML** (auto-généré)
- ✅ **Robots.txt**

#### **Sécurité**
- ✅ **Activation 2FA** (Two-Factor Authentication)
- ✅ **Limitation du taux de requêtes** (rate limiting)
- ✅ **Blocage d'IP** (liste noire)
- ✅ **Logs de sécurité** :
  - Tentatives de connexion échouées
  - Changements de mot de passe
  - Modifications par admin
- ✅ **Sauvegarde automatique** :
  - Fréquence (quotidienne, hebdomadaire)
  - Rétention (nombre de backups conservés)

---

### 🔔 Système de Notifications Admin

#### **Centre de Notifications**
- ✅ **Alertes en temps réel** :
  - Nouveau signalement
  - Nouveau compte créé
  - Offre en attente de validation
  - Activité suspecte détectée
  - Erreur système
- ✅ **Tableau de bord des notifications** :
  - Non lues / Lues
  - Par type
  - Par priorité (élevée, moyenne, faible)

---

### 📧 Système de Communication Admin

#### **Newsletter**
- ✅ **Créer une newsletter** :
  - Titre
  - Contenu (HTML)
  - Destinataires (tous, producteurs, consommateurs, segment)
  - Programmation d'envoi
- ✅ **Historique des newsletters**
- ✅ **Statistiques** :
  - Taux d'ouverture
  - Taux de clic
  - Désabonnements

#### **Emails de masse**
- ✅ **Envoyer un email** à :
  - Tous les utilisateurs
  - Tous les producteurs
  - Tous les consommateurs
  - Utilisateurs d'une région spécifique
  - Utilisateurs inactifs
- ✅ **Templates personnalisables**

---

### 🛡️ Gestion des Signalements

#### **Page Signalements**
- ✅ **Liste des signalements** :
  - Offre signalée
  - Utilisateur signalé
  - Raison (spam, contenu inapproprié, arnaque, autre)
  - Nombre de signalements
  - Date du premier signalement
  - Statut (en attente, traité, rejeté)

#### **Actions**
- ✅ **Voir le contenu signalé**
- ✅ **Contacter le signaleur**
- ✅ **Contacter le signalé**
- ✅ **Supprimer le contenu**
- ✅ **Avertir l'utilisateur**
- ✅ **Suspendre le compte**
- ✅ **Bannir définitivement**
- ✅ **Rejeter le signalement** (non fondé)

---

### 📱 API REST (Admin)

#### **Endpoints Admin**
- ✅ **Documentation Swagger/Postman**
- ✅ **Authentification par token** (Sanctum)
- ✅ **Rate Limiting** (limitation des requêtes)
- ✅ **Versioning** (v1, v2)

#### **Routes Admin API**
- ✅ `GET /api/admin/stats` - Statistiques globales
- ✅ `GET /api/admin/users` - Liste des utilisateurs
- ✅ `POST /api/admin/users/{id}/suspend` - Suspendre
- ✅ `GET /api/admin/offers` - Liste des offres
- ✅ `DELETE /api/admin/offers/{id}` - Supprimer
- ✅ `GET /api/admin/reports` - Signalements
- ✅ `POST /api/admin/newsletter` - Envoyer newsletter

---

## 🚀 Technologies & Stack Technique

### Backend
- ✅ **Laravel 11** (PHP 8.2+)
- ✅ **PostgreSQL** (base de données)
- ✅ **Redis** (cache & sessions)
- ✅ **Laravel Sanctum** (authentification API)
- ✅ **Laravel Queue** (jobs asynchrones)
- ✅ **Laravel Broadcasting** (temps réel)
- ✅ **Spatie Media Library** (gestion fichiers)
- ✅ **Spatie Permission** (rôles & permissions)

### Frontend
- ✅ **Livewire 3** (composants dynamiques)
- ✅ **Alpine.js** (interactions JS légères)
- ✅ **Tailwind CSS** (styling)
- ✅ **Leaflet.js / Mapbox** (cartes)
- ✅ **ApexCharts / Chart.js** (graphiques)

### DevOps
- ✅ **Docker & Docker Compose**
- ✅ **GitHub Actions** (CI/CD)
- ✅ **Nginx** (serveur web)
- ✅ **Let's Encrypt** (SSL/TLS)

---

## 📦 Livrables du Projet

### Phase 1 : Authentification & Base
- ✅ Système d'authentification complet
- ✅ Gestion des profils
- ✅ Dashboard basique pour chaque rôle

### Phase 2 : Fonctionnalités Métier
- ✅ CRUD Offres (Producteur)
- ✅ CRUD Demandes (Consommateur)
- ✅ Système de recherche & filtres
- ✅ Carte interactive

### Phase 3 : Communication
- ✅ Système de messagerie temps réel
- ✅ Notifications push/email
- ✅ Blog & actualités

### Phase 4 : Administration
- ✅ Dashboard admin complet
- ✅ Gestion des utilisateurs
- ✅ Modération
- ✅ Statistiques avancées

### Phase 5 : API & Optimisation
- ✅ API RESTful documentée
- ✅ Tests unitaires & fonctionnels
- ✅ Optimisation performances
- ✅ SEO

### Phase 6 : Déploiement
- ✅ Dockerisation
- ✅ CI/CD
- ✅ Déploiement production
- ✅ Monitoring & logs

---

## 🎓 Objectifs Pédagogiques

À la fin de ce projet, vous maîtriserez :

1. **Architecture Laravel avancée** (Services, Repositories, Actions)
2. **TallStack complet** (Tailwind, Alpine, Livewire, Laravel)
3. **Gestion des rôles & permissions** (Spatie Permission)
4. **API RESTful professionnelle** (Sanctum, Versioning)
5. **Temps réel** (WebSockets, Broadcasting)
6. **DevOps** (Docker, CI/CD, déploiement)
7. **Tests** (PHPUnit, Pest)
8. **Sécurité** (CSRF, XSS, SQL Injection, Rate Limiting)
9. **Performance** (Cache, Queue, Lazy Loading)
10. **Bonnes pratiques** (Clean Code, SOLID, Design Patterns)

---

## 📅 Planning Suggéré

| Semaine | Fonctionnalités |
|---------|----------------|
| 1-2 | Authentification, Profils, Base de données |
| 3-4 | CRUD Offres & Demandes, Recherche |
| 5-6 | Messagerie, Notifications |
| 7-8 | Dashboard Admin, Gestion Utilisateurs |
| 9-10 | Blog, Carte Interactive, Statistiques |
| 11-12 | API, Tests, Optimisation |
| 13-14 | Docker, CI/CD, Déploiement |

---

## 🎯 Prochaine Étape

**Quelle fonctionnalité souhaitez-vous développer en premier ?**

Je vous suggère de commencer par :
1. ✅ **Dashboard Admin** (déjà créé !)
2. 🔨 **Page de gestion des utilisateurs** (tableau + actions)
3. 🔨 **Page de gestion des offres** (modération)
4. 🔨 **Formulaire de création d'offre** (Producteur)
5. 🔨 **Système de messagerie** (Chat temps réel)

**Dites-moi par laquelle on commence ! 🚀**