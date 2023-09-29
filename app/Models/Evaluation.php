<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    use HasFactory;

    public function evaluations()
    {
        return $this->belongsTo(Evaluate::class);
    }

    public function question()
    {
        return $this->hasMany(Question::class);
    }
}
