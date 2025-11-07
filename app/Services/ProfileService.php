<?php
// app/Services/ProfileService.php

namespace App\Services;

use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProfileService
{
    public function updateProfile(User $user, array $data): bool
    {
        $oldData = $user->only(['name', 'phone', 'bio', 'location']);

        $user->update($data);

        ActivityLog::log(
            'profile_update',
            'Profil mis à jour',
            ['old' => $oldData, 'new' => $data]
        );

        // Émettre un événement pour mettre à jour l'UI globalement
        event('profile.updated', $user);

        return true;
    }

    public function updateAvatar(User $user, UploadedFile $file): string
    {
        // Supprimer l'ancien avatar si existe
        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        // Stocker le nouveau
        $path = $file->store('avatars', 'public');

        $user->update(['avatar' => $path]);

        ActivityLog::log('avatar_update', 'Photo de profil mise à jour');

        return Storage::url($path);
    }

    public function updatePassword(User $user, string $currentPassword, string $newPassword): bool
    {
        if (!Hash::check($currentPassword, $user->password)) {
            throw new \Exception('Le mot de passe actuel est incorrect.');
        }

        $user->update(['password' => Hash::make($newPassword)]);

        ActivityLog::log('password_change', 'Mot de passe modifié');

        return true;
    }

    public function updateEmail(User $user, string $newEmail, string $password): bool
    {
        if (!Hash::check($password, $user->password)) {
            throw new \Exception('Le mot de passe est incorrect.');
        }

        $user->update([
            'email' => $newEmail,
            'email_verified_at' => null,
        ]);

        ActivityLog::log('email_change', 'Email modifié', [
            'old_email' => $user->getOriginal('email'),
            'new_email' => $newEmail,
        ]);

        // Envoyer l'email de vérification
        $user->sendEmailVerificationNotification();

        return true;
    }

    public function deleteAccount(User $user, string $password): bool
    {

        if (!Hash::check($password, $user->password)) {
            throw new \Exception('Le mot de passe est incorrect.');
        }

        // Supprimer l'avatar
        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        ActivityLog::log('account_deletion', 'Compte supprimé');

        DB::transaction(function () {
            $user = Auth::user();

            if ($user) {
                if (method_exists($user, 'offers')) {
                    $user->offers()->delete();
                }
                if (method_exists($user, 'demands')) {
                    $user->demands()->delete();
                }

                if (method_exists($user, 'activityLogs')) {
                    $user->activityLogs()->delete();
                }

                $user->delete();

                session()->flash('toast', [
                    'type' => 'success',
                    'message' => "Votre compte a été supprimé avec succès."
                ]);
            }
        });

        return true;
    }
}
