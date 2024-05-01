<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'first_surname',
        'second_surname',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Relations
     */

    public function jobsAsRecruiter(){
       return $this->hasMany(Job::class,'recruiter_id');
    }

    public function candidatures(){
        return $this->hasMany(Candidature::class,'employee_id');
    }

    public function jobsAsEmployee(){
        return $this->hasManyThrough(Job::class,Candidature::class,'employee_id','id','id','job_id');
    }



    //Tests functions
    public static function getEmployee(){
        return self::where('name','employee')->first();
    }

    public static function getRecruiter(){
        return self::where('name','recruiter')->first();
    }
}
