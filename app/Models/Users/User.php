<?php

namespace App\Models\Users;

use App\Notifications\ResetPassword as ResetPasswordNotification;
use App\Notifications\VerifyEmail as VerifyEmailNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, HasRoles, Notifiable;

    const string STORAGE_AVATAR_PATH = 'app/public/uploads/avatars/';

    const string PUBLIC_AVATAR_PATH = 'uploads/avatars/';

    const string AVATAR_TYPE_INITIAL = 'initial';

    const string AVATAR_TYPE_UPLOADED = 'uploaded';

    protected $guarded = [];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::deleted(function (User $user) {
            $avatarPath = User::PUBLIC_AVATAR_PATH.$user->avatar;

            // Avatar exists
            if (Storage::disk('public')->exists($avatarPath)) {
                Storage::disk('public')->delete($avatarPath);
            }
        });
    }

    public function sendEmailVerificationNotification(): void
    {
        $this->notify(new VerifyEmailNotification);
    }

    public function sendPasswordResetNotification($token): void
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    public function getRoleDisplayNames(): Collection
    {
        return $this->roles->pluck('display_name');
    }

    public function getAvatarPath(): string
    {
        return Storage::url(self::PUBLIC_AVATAR_PATH.$this->avatar);
    }

    public static function avatarTypes(): array
    {
        $types = [
            self::AVATAR_TYPE_INITIAL,
            self::AVATAR_TYPE_UPLOADED,
        ];

        return array_combine($types, $types);
    }
}
