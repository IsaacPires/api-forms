<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Questions extends Model
{
    protected $table = 'questions'; 

    protected $fillable = ['question', 'idType_answer', 'idForm'];

    public function forms()
    {
        return $this->belongsTo(Forms::class, 'id');

    }

    public function answers()
    {
        return $this->hasMany(Answers::class, 'idQuestion');
    }
}
