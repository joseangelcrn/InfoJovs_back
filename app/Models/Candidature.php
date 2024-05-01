<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidature extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'job_id',
        'status_id'
    ];

    public function  employee(){
        return $this->belongsTo(User::class,'employee_id');
    }

    public function job(){
        return $this->belongsTo(Job::class,'job_id');
    }

    public function recruiter(){
        return $this->hasOneThrough(User::class,Job::class);
    }

    public function status(){
        return $this->belongsTo(CandidatureStatus::class,'status_id');
    }
}
