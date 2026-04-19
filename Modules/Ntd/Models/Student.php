<?php

namespace Modules\Ntd\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'application_id',
        'full_name',
        'gender',
        'date_of_birth',
        'ethnicity',
        'nationality',
        'religion',
        'personal_id',
        'place_of_birth',
        'birth_certificate_place',
        'hometown',
        'phone',
    ];

    public function application()
    {
         return $this->belongsTo(Application::class, 'application_id', 'id');
    }
}