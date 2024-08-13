<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Employee extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'employees';

    protected $fillable = [
        'id',
        'image',
        'name',
        'phone',
        'division_id',
        'position'
    ];

    public function division() {
        return $this->belongsTo(Division::class, 'division_id');
    }
}
