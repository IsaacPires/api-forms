<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Limiters extends Model
{
    use HasFactory;

    protected $table = 'limiters'; 

    protected $fillable = ['idUser', 'idForm', 'consumption'];

}
