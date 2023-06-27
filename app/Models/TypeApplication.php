<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeApplication extends Model
{
    use HasFactory;

    public function nameapplication()
    {
        return $this->belongsTo(NameApplication::class, 'nameapplications_id');
    }

    public function priority()
    {
        return $this->belongsTo(Priority::class, 'priorities_id');
    }

}
