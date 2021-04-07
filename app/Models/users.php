<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class users extends Model
{
    use HasFactory;

    protected $table = 'users';

    protected $primaryKey = 'id';

    protected $fillable = ['login', 'password', 'email', 'fname', 'lname', 'team_id'];

    public function absence()
    {
        return $this->hasMany('App\Models\absences', 'user_id');
    }

    public function team()
    {
        return $this->hasOne('App\Models\teams', 'id');
    }
}
