<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class reasons extends Model
{
    use HasFactory;

    protected $table = 'reasons';

    protected $primaryKey = 'id';

    protected $fillable = ['reason_name', 'reason_color'];

    public function absence()
    {
        return $this->hasMany('App\Models\absences');
    }
}
