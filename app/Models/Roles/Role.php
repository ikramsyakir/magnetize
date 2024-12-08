<?php

namespace App\Models\Roles;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Role as BaseRole;

class Role extends BaseRole
{
    use HasFactory;
}
