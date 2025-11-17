<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'phone_verified',
        'email',
        'address'
    ];

    protected $casts = [
        'phone_verified' => 'boolean',
    ];

    public function pets()
    {
        return $this->hasMany(Pet::class);
    }

    public function scopeVerified($query)
    {
        return $query->where('phone_verified', true);
    }

    public function hasPet($name, $species)
    {
        return $this->pets()
            ->where('name', strtoupper($name))
            ->where('species', strtoupper($species))
            ->exists();
    }
}
