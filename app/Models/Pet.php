<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner_id',
        'name',
        'registration_code',
        'species',
        'age',
        'weight'
    ];

    protected $casts = [
        'age' => 'integer',
        'weight' => 'decimal:2',
    ];

    public function owner()
    {
        return $this->belongsTo(Owner::class);
    }

    public function checkups()
    {
        return $this->hasMany(Checkup::class);
    }
}
