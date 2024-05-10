<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property string $title
 * @property string|null $description
 * @property int $role_id
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $employee
 * @property-read int|null $employee_count
 * @method static \Illuminate\Database\Eloquent\Builder|ProfessionalProfile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProfessionalProfile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProfessionalProfile query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProfessionalProfile whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProfessionalProfile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProfessionalProfile whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProfessionalProfile whereTitle($value)
 * @mixin \Eloquent
 */
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
