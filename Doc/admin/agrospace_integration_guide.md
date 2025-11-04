# 🚀 Guide d'Intégration - Modals Utilisateurs Agrospace

## 📦 Fichiers créés

### 1. **Vues Livewire** (`resources/views/livewire/admin/modals/`)
- ✅ `create-edit-user-modal.blade.php` - Modal de création/édition
- ✅ `user-details-modal.blade.php` - Modal de détails utilisateur
- ✅ `send-email-modal.blade.php` - Modal d'envoi d'emails

### 2. **Composants Livewire** (`app/Livewire/Admin/Modals/`)
- ✅ `CreateEditUserModal.php`
- ✅ `UserDetailsModal.php`
- ✅ `SendEmailModal.php`

### 3. **Template Email** (`resources/views/emails/`)
- ✅ `admin-email.blade.php`

---

## 🔧 Étape 1 : Créer les composants Livewire

```bash
php artisan make:livewire Admin/Modals/CreateEditUserModal
php artisan make:livewire Admin/Modals/UserDetailsModal
php artisan make:livewire Admin/Modals/SendEmailModal
```

---

## 📝 Étape 2 : Créer la classe Mail

```bash
php artisan make:mail AdminEmail
```

**Fichier : `app/Mail/AdminEmail.php`**
```php
<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $emailSubject;
    public $emailMessage;

    public function __construct($subject, $message)
    {
        $this->emailSubject = $subject;
        $this->emailMessage = $message;
    }

    public function build()
    {
        return $this->subject($this->emailSubject)
                    ->view('emails.admin-email')
                    ->with([
                        'subject' => $this->emailSubject,
                        'message' => $this->emailMessage,
                    ]);
    }
}
```

---

## 🎨 Étape 3 : Intégrer dans la page de gestion des utilisateurs

**Modifier : `resources/views/livewire/admin/users-management.blade.php`**

Ajouter avant la fermeture du `</div>` principal :

```blade
{{-- Modals --}}
@livewire('admin.modals.create-edit-user-modal')
@livewire('admin.modals.user-details-modal')
@livewire('admin.modals.send-email-modal')
```

---

## ⚡ Étape 4 : Déclencher les modals

### Dans le composant `UsersManagement.php`, mettre à jour les méthodes :

```php
public function viewUser($userId)
{
    $this->dispatch('openUserDetailsModal', userId: $userId);
}

public function editUser($userId)
{
    $this->dispatch('openEditUserModal', userId: $userId);
}

public function sendEmail($userId)
{
    $this->dispatch('openSendEmailModal', userIds: [$userId]);
}

// Pour le bouton "Nouvel utilisateur" dans le header
<button wire:click="$dispatch('openCreateUserModal')" ...>
```

---

## 🔄 Étape 5 : Écouter les événements

### Dans `UsersManagement.php`, ajouter :

```php
use Livewire\Attributes\On;

#[On('refresh-users')]
public function refreshUsers()
{
    $this->loadStats();
    $this->resetPage();
}
```

---

## 📧 Étape 6 : Configuration Email

**Fichier : `.env`**
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io  # ou votre serveur SMTP
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@agrospace.cm
MAIL_FROM_NAME="Agrospace"
```

---

## 🎯 Fonctionnalités des Modals

### 1. **Modal Création/Édition Utilisateur**
- ✅ Upload d'avatar avec prévisualisation
- ✅ Validation en temps réel
- ✅ Tous les champs du profil
- ✅ Sélection du statut (Active, radio buttons)
- ✅ Vérification email (checkbox)
- ✅ Mot de passe (création uniquement)
- ✅ Design moderne avec gradient vert

### 2. **Modal Détails Utilisateur**
- ✅ Header avec cover image gradient
- ✅ 3 onglets : Informations, Activité, Historique
- ✅ Badges de rôle et statut
- ✅ Statistiques (offres, demandes, messages)
- ✅ Cartes d'informations colorées
- ✅ Boutons d'action (Envoyer email, Modifier)

### 3. **Modal Envoi d'Email**
- ✅ Support multi-destinataires
- ✅ 7 templates pré-définis :
  - 🎉 Bienvenue
  - ✅ Vérification
  - 📦 Offre approuvée
  - ❌ Offre rejetée
  - ⏸ Compte suspendu
  - 📰 Newsletter
  - 🎁 Promotion
- ✅ Variables dynamiques : {nom}, {email}, {role}
- ✅ Options : Copie, Programmation
- ✅ Sauvegarde brouillon
- ✅ Prévisualisation

### 4. **Template Email Agrospace**
- ✅ Design responsive
- ✅ Header avec gradient vert
- ✅ Logo Agrospace
- ✅ Bouton CTA vert
- ✅ Section fonctionnalités avec icônes
- ✅ Footer avec réseaux sociaux
- ✅ Compatible tous clients email

---

## 🎨 Palette de Couleurs Utilisée

```css
/* Vert Primary (Agrospace) */
--green-50: #f0fdf4
--green-100: #dcfce7
--green-500: #22c55e
--green-600: #16a34a
--green-700: #15803d

/* Terre (Earth) */
--earth-50: #fef3e2
--earth-400: #f7a01b
--earth-600: #b06d11

/* Autres */
--blue-600: #2563eb (pour les emails)
--purple-600: #9333ea (pour le admin)
--gray: différentes nuances
```

---

## 📱 Responsive Design

Tous les modals sont **100% responsive** :
- ✅ Mobile first (affichage optimal sur téléphone)
- ✅ Tablette (layout adapté)
- ✅ Desktop (pleine largeur avec max-width)

---

## ⚠️ Points d'attention

### 1. **Permissions**
Assurez-vous que les dossiers ont les bonnes permissions :
```bash
chmod -R 775 storage/app/public
php artisan storage:link
```

### 2. **Queue pour les emails**
Pour l'envoi en masse, utilisez les queues :
```php
Mail::to($recipient->email)->queue(new AdminEmail(...));
```

Configuration :
```bash
php artisan queue:table
php artisan migrate
php artisan queue:work
```

### 3. **Rate Limiting**
Ajoutez un rate limiting pour l'envoi d'emails :
```php
use Illuminate\Support\Facades\RateLimiter;

RateLimiter::attempt('send-email:'.auth()->id(), 10, function() {
    // Envoi email
});
```

---

## 🧪 Tests

### Tester l'upload d'avatar :
```bash
php artisan test --filter=UserAvatarUploadTest
```

### Tester l'envoi d'email :
```bash
php artisan test --filter=SendEmailTest
```

---

## 🚀 Prochaines améliorations possibles

1. **Éditeur WYSIWYG** pour les emails (TinyMCE/Quill)
2. **Historique des emails** envoyés
3. **Statistiques d'emails** (taux d'ouverture, clics)
4. **Templates d'email** personnalisables depuis l'admin
5. **Attachements** de fichiers aux emails
6. **Signature** email personnalisée

---

## 📞 Support

Besoin d'aide ? Contactez l'équipe technique Agrospace !

---

## ✅ Checklist d'intégration

- [ ] Créer les composants Livewire
- [ ] Copier les vues Blade
- [ ] Créer la classe Mail
- [ ] Configurer le .env (SMTP)
- [ ] Tester la création d'utilisateur
- [ ] Tester l'édition d'utilisateur
- [ ] Tester l'envoi d'email
- [ ] Vérifier le responsive
- [ ] Tester les uploads d'avatar
- [ ] Configurer les queues
- [ ] Déployer en production

**Tout est prêt ! Vous pouvez maintenant gérer vos utilisateurs comme un pro ! 🎉**