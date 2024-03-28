<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Forms extends Model
{
    use HasFactory;

    protected $table = 'forms'; 

    protected $fillable = ['title', 'idStyle', 'idUser'];

    public function questions()
    {
        return $this->hasMany(Questions::class, 'idForm');
    }

}
