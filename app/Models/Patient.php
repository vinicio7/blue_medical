<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Patient extends Model
{
    use HasFactory;
    protected $table = 'patients';
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'ocupation',
        'name_tax',
        'tax_id',
        'weight',
        'height',
        'marital_status',
        'insurance',
        'birthdate'
    ];
    protected $hidden = ['password'];

}
