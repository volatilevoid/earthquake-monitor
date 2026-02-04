<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Earthquake extends Model
{
    use HasFactory;

    public const PUBLIC_THRESHOLD_MAX = 1.9;

    public $timestamps = false;
}
