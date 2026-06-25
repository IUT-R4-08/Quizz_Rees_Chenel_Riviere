<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Question extends Model
{
    use HasFactory;
    protected $fillable = ['theme_id', 'question'];

    public function theme()
    {
        return $this->belongsTo(Theme::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
}
