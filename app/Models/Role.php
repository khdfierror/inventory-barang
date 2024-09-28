<?php

namespace App\Models;

use App\Concerns\HasUlids;

class Role extends \Spatie\Permission\Models\Role
{
    use HasUlids;
}
