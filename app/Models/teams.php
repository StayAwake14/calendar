<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class teams extends Model
{
    use HasFactory;

    protected $table = 'teams';

    protected $primaryKey = 'id';

    protected $fillable = ['team_name'];

    public function leader()
    {
        return $this->hasMany('App\Models\leaders', 'id');
    }

    public function user()
    {
        return $this->hasOne('App\Models\users', 'team_id');
    }
}
