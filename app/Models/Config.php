<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Config extends Model
{
    use HasFactory;

    protected $table = 'config';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'magnitude_threshold',
    ];

    public function getGlobal(): ?Config
    {
        return $this->whereNull('user_id')->first();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
