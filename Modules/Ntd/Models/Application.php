<?php

namespace Modules\Ntd\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $fillable = [
        'code',
        'school_year',
        'status',
        'submitted_at',
        'addresses',
        'siblings',
        'abilities',
        'health_info',
        'family_info',
        'registration',
        'commitment',
    ];

    protected $casts = [
        'addresses' => 'array',
        'siblings' => 'array',
        'abilities' => 'array',
        'health_info' => 'array',
        'family_info' => 'array',
        'registration' => 'array',
        'commitment' => 'array',
        'submitted_at' => 'datetime',
    ];

    public function student()
    {
        return $this->hasOne(Student::class, 'application_id', 'id');
    }

    public function guardians()
    {
        return $this->hasMany(Guardian::class);
    }
}