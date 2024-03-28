<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class multiple_choices extends Model
{
    use HasFactory;

    protected $table = 'multiple_choices'; 

    protected $fillable = ['choices', 'idQuestion'];
}
