<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class leaders extends Model
{
    use HasFactory;

    protected $table = 'leaders';

    protected $primaryKey ='id';

    public function user()
    {
        return $this->belongsTo('App\Models\users');
    }

    public function team()
    {
        return $this->belongsTo('App\Models\teams');
    }

}
