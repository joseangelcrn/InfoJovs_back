<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Candidature> $candidatures
 * @property-read int|null $candidatures_count
 * @method static \Illuminate\Database\Eloquent\Builder|CandidatureStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CandidatureStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CandidatureStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder|CandidatureStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CandidatureStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CandidatureStatus whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CandidatureStatus whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
