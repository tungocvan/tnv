<?php

namespace Modules\Ntd\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guardian extends Model
{
    protected $fillable = [
        'application_id',
        'type',
        'full_name',
        'birth_year',
        'job',
        'position',
        'phone',
        'personal_id',
    ];

    public function application()
    {
        return $this->belongsTo(Application::class);
    }
}