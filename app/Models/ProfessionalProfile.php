<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfessionalProfile extends Model
{
    use HasFactory;
    protected $table = 'professional_profiles';

    protected $fillable = [
        'title',
        'description'
    ];

    public function employee(){
        return $this->hasMany(User::class,'professional_profile_id');
    }
}
