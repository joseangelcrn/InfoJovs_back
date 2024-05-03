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

    public function tags()
    {
        return $this->morphMany(Tag::class, 'taggable');
    }
}
