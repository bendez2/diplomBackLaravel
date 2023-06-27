<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Applications extends Model
{
    use HasFactory;

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function type()
    {
        return $this->belongsTo(TypeApplication::class);
    }
    public function employee()
    {
        return $this->belongsTo(User::class);
    }

    public function initiator()
    {
        return $this->belongsTo(User::class);
    }

}
