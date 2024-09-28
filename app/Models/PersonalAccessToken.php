<?php
namespace App\Models;

use App\Concerns\HasUlids;
use Laravel\Sanctum\PersonalAccessToken as Model;

class PersonalAccessToken extends Model
{
    use HasUlids;
}