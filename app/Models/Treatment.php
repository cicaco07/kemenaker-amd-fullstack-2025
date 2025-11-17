<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Treatment extends Model
{
    protected $fillable = [
        'name',
        'type',
        'price',
        'description'
    ];

    public function checkups()
    {
        return $this->hasOne(Checkup::class);
    }
}
