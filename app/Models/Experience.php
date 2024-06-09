<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'business',
        'description',
        'start_date',
        'finish_date'
    ];

    public function cv(){
        return $this->belongsTo(Cv::class);
    }
}
