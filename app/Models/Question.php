<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    public function matches()
    {
        return $this->belongsTo(Matches::class);
    }

    public function options()
    {
        return $this->hasMany(Option::class);
    }

    public function bets()
    {
        return $this->hasMany(Bet::class);
    }
}
