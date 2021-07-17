<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function instructors()
    : \Illuminate\Database\Eloquent\Relations\BelongsTo

    {
        return $this->belongsTo(Instructor::class);
    }
}
