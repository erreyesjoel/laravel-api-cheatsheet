<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{   
    // Una tarea pertenece a un usuario
    public function user()
    {
    return $this->belongsTo(User::class);    
    }

    // fillable para que laravel sepa que campos se pueden insertar
    protected $fillable = [
        'title',
        'description',
        'status',
        'priority',
        'due_date',
        'user_id',
    ];
}
