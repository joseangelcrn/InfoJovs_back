<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property int $employee_id
 * @property int $job_id
 * @property int|null $status_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $employee
 * @property-read \App\Models\Job|null $job
 * @property-read \App\Models\User|null $recruiter
 * @property-read \App\Models\CandidatureStatus|null $status
 * @method static \Illuminate\Database\Eloquent\Builder|Candidature newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Candidature newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Candidature query()
 * @method static \Illuminate\Database\Eloquent\Builder|Candidature whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Candidature whereEmployeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Candidature whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Candidature whereJobId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Candidature whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Candidature whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
