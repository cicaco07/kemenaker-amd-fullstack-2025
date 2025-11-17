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
        'species',
        'age',
        'weight'
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
