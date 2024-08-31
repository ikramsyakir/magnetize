<?php

namespace Database\Seeders;

use App\Models\Users\User;
use App\Utilities\Theme;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Laravolt\Avatar\Facade as Avatar;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        File::ensureDirectoryExists(storage_path(User::STORAGE_AVATAR_PATH));

        $fileName = Str::random(30).'.png';
        Avatar::create('Admin')->save(storage_path(User::STORAGE_AVATAR_PATH.$fileName), 100);

        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'avatar' => $fileName,
            'is_initial_avatar' => true,
            'theme' => Theme::LIGHT,
            'remember_token' => Str::random(10),
        ]);

        $admin->assignRole('admin');
    }
}
