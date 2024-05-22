<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CandidatureHistory extends Model
{
    use HasFactory;

    protected $table = 'candidatures_history';
    public $timestamps = false;

    protected $fillable = [
        'candidature_id',
        'recruiter_id',
        'origin_status_id',
        'destiny_status_id',
        'created_at'
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function candidature()
    {
        return $this->belongsTo(Candidature::class, 'candidature_id');
    }

    public function recruiter()
    {
        return $this->belongsTo(User::class, 'recruiter_id');
    }

    public function statusOrigin()
    {
        return $this->belongsTo(CandidatureStatus::class, 'origin_status_id');
    }

    public function statusDestiny()
    {
        return $this->belongsTo(CandidatureStatus::class, 'destiny_status_id');
    }

    public static function register($candidatureId,$recruiterId = null){

        if ($recruiterId == null) {
            $recruiterId = \Auth::id();
        }

        $statusRegister = CandidatureStatus::where('name','Registered')->first();

       return  self::create([
           'candidature_id' => $candidatureId,
           'recruiter_id' => $recruiterId,
           'origin_status_id' => $statusRegister->id,
           'destiny_status_id' => $statusRegister->id,
           'created_at' =>Carbon::now()
        ]);
    }

    public static function updateStatus($candidatureId,$originStatusId,$destinyStatusId,$recruiterId = null){

        if ($recruiterId == null) {
            $recruiterId = \Auth::id();
        }

        return  self::create([
            'candidature_id' => $candidatureId,
            'recruiter_id' => $recruiterId,
            'origin_status_id' => $originStatusId,
            'destiny_status_id' => $destinyStatusId,
        ]);


    }

}
