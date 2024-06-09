<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CV extends Model
{
    use HasFactory;
    protected $table = 'cv';
    public $timestamps = false;

    protected $fillable = [
        'summary'
    ];

    public function skills()
    {
        return $this->hasMany(Skill::class,'cv_id');
    }

    public function experiences()
    {
        return $this->hasMany(Experience::class,'cv_id');
    }
}
