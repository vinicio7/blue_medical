<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use JamesDordoy\LaravelVueDatatable\Traits\LaravelVueDatatableTrait;

class Patient extends Model
{
    use HasFactory,LaravelVueDatatableTrait;
     
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
    
    protected $dataTableColumns = [
        'id' => [
            'searchable' => false,
        ],
        'name' => [
            'searchable' => true,
        ],
        'email' => [
            'searchable' => true,
        ],
        'phone' => [
            'searchable' => true,
        ],
        'name_tax' => [
            'searchable' => true,
        ],
        'tax_id' => [
            'searchable' => true,
        ],
        'ocupation' => [
            'searchable' => false,
        ],
        'weight' => [
            'searchable' => false,
        ],
        'height' => [
            'searchable' => false,
        ],
        'marital_status' => [
            'searchable' => false,
        ],
        'insurance' => [
            'searchable' => false,
        ],
        'birthdate' => [
            'searchable' => false,
        ],
    ];

}
