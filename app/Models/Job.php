<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description'
    ];

    public function recruiter(){
        return $this->belongsTo(User::class);
    }

    public function candidatures(){
        return $this->hasMany(Candidature::class,'job_id');
    }

    public function tags()
    {
        return $this->morphMany(Tag::class, 'taggable');
    }
}
