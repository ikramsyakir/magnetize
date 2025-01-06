<?php

namespace App\Models\Roles;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Role as BaseRole;

/**
 * @property string $display_name
 * @property string $description
 */
class Role extends BaseRole
{
    use HasFactory;
}
