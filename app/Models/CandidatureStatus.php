<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CandidatureStatus extends Model
{
    use HasFactory;

    protected $table = 'candidature_statuses';
    protected $fillable = ['name'];

    /**
     * Relations
     */

    public function candidatures(){
        return $this->hasMany(Candidature::class,'status_id');
    }
}
