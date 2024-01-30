<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vin extends Model
{
    use HasFactory;

    public $fillable = [
        'name',
        'price',
        'type',
        'country',
        'size',
        'photo',
        'code_saq',
        'created_at',
        'updated_at'
    ];
}
