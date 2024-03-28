<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class type_answer extends Model
{
    use HasFactory;

    protected $table = 'type_answer'; 

    protected $fillable = ['type'];
}
