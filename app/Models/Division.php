<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Division extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'divisions';

    protected $fillable = [
        'id',
        'name'
    ];

    public function employe() {
        return $this->hasMany(Employee::class, 'division_id');
    }
}
