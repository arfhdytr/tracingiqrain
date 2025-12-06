<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $primaryKey = 'user_id';

    protected $fillable = [
        'username',
        'password',
        'avatar_path',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Relationships
    public function admin()
    {
        return $this->hasOne(Admin::class, 'user_id', 'user_id');
    }

    public function mentor()
    {
        return $this->hasOne(Mentor::class, 'user_id', 'user_id');
    }

    public function murid()
    {
        return $this->hasOne(Murid::class, 'user_id', 'user_id');
    }

    // Helper methods
    public function isAdmin()
    {
        return $this->hasRole('admin');
    }

    public function isMentor()
    {
        return $this->hasRole('mentor');
    }

    public function isMurid()
    {
        return $this->hasRole('murid');
    }

    public function getAvatarUrlAttribute()
    {
        return $this->avatar_path ? asset('storage/' . $this->avatar_path) : asset('images/avatar/cowo.webp');
    }

    public function routeNotificationForMail()
    {
        if ($this->hasRole('mentor') && $this->mentor) {
            return $this->mentor->email;
        }
        
        return $this->email; 
    }

    /**
     * Get the email address for password reset.
     * Method ini digunakan oleh Fortify password reset.
     *
     * @return string
     */
    public function getEmailForPasswordReset()
    {
        if ($this->hasRole('mentor') && $this->mentor) {
            return $this->mentor->email;
        }
        
        return $this->email; 
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    /**
     * Update the user's profile photo.
     *
     * @param  \Illuminate\Http\UploadedFile  $photo
     * @return void
     */
    public function updateProfilePhoto(UploadedFile $photo)
    {
        // Hapus foto lama jika ada
        if ($this->avatar_path) {
            Storage::disk('public')->delete($this->avatar_path);
        }

        // Simpan foto baru
        $path = $photo->store('avatars', 'public');

        // Update avatar_path di database
        $this->forceFill([
            'avatar_path' => $path,
        ])->save();
    }

    /**
     * Delete the user's profile photo.
     *
     * @return void
     */
    public function deleteProfilePhoto()
    {
        if ($this->avatar_path) {
            Storage::disk('public')->delete($this->avatar_path);

            $this->forceFill([
                'avatar_path' => null,
            ])->save();
        }
    }
}
