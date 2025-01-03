<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Lawyer extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\LawyerFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phoneNumber',
        'gender',
        'dob',
        'password',
        'education',
        'address',
        'experience',
        'rate',
        'profileLink',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function expertises()
    {
        return $this->belongsToMany(Expertise::class, 'lawyers_expertises', 'lawyer_id', 'expertise_id');
    }

    public function articles()
    {
        return $this->hasMany(Article::class);
    }
}
