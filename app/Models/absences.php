<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class absences extends Model
{
    use HasFactory;

    protected $table = 'absences';

    protected $primaryKey ='id';

    protected $fillable = ['datefrom', 'dateto', 'description', 'user_id', 'reason_id'];

    public function user()
    {
        return $this->belongsTo('App\Models\users');
    }

    public function reason()
    {
        return $this->belongsTo('App\Models\reasons');
    }

}
