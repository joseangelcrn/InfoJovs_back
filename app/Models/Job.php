<?php

namespace App\Models;

use App\Libs\ChartHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use function Termwind\breakLine;

/**
 *
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property int $recruiter_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $active
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Candidature> $candidatures
 * @property-read int|null $candidatures_count
 * @property-read \App\Models\User|null $recruiter
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Tag> $tags
 * @property-read int|null $tags_count
 * @method static \Illuminate\Database\Eloquent\Builder|Job newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Job newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Job query()
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereRecruiterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Job whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Job extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description'
    ];

    public function recruiter()
    {
        return $this->belongsTo(User::class);
    }

    public function candidatures()
    {
        return $this->hasMany(Candidature::class, 'job_id');
    }

    public function tags()
    {
        return $this->morphMany(Tag::class, 'taggable');
    }

    /**
     * @param string $scope
     * @return array
     *
     * Generate stats, additional information , etc.. about a job
     */
    public function generateAdditionalInfo($scope = 'main_info')
    {

        switch ($scope){
            case 'main_info':
                return $this->displayMainInfoStats();
                break;
            case 'candidatures':
                return $this->displayCandidatures();
                break;
            default:break;
        }
    }

    /**
     * @return array
     *
     * Display data charts about Job Information
     *
     */
    public function displayMainInfoStats()
    {

        /** QueryBuilder **/
//        $status = Candidature::selectRaw('status.id,status.name,count(*) as amount')
//             ->where('job_id',$id)
//            ->leftJoin('candidature_statuses as status','status.id','candidatures.status_id')
//            ->groupBy('status.id')
//            ->get();

        /** Eloquent Query **/
        $status = CandidatureStatus::
        whereHas('candidatures')
            ->withCount(['candidatures as amount' => function ($q) {
                $q->where('job_id', $this->id);
            }])
            ->get();

        /** QueryBuilder **/
//        $profiles = Candidature::
//        selectRaw('jobs.id as jobId,profile.id,profile.title,count(*) as amount')
//            ->where('jobs.id',$id)
//            ->leftJoin('jobs','candidatures.job_id','jobs.id')
//            ->leftJoin('users as employee','employee.id','candidatures.employee_id')
//            ->leftJoin('professional_profiles as profile','profile.id','employee.professional_profile_id')
//            ->groupBy(['jobs.id','profile.id'])
//        ->get();

        /** Eloquent Query **/
        $profiles = ProfessionalProfile::
        whereRelation('employee.candidatures.job', 'id', '=', $this->id)
            ->withCount(['employee as amount' => function ($q)  {
                $q->whereRelation('candidatures', 'job_id', $this->id);
            }])->get();

        $status = ChartHelper::generateStatus($status);
        $profiles = ChartHelper::generateProfile($profiles);

        return [
            'status'=>$status,
            'profiles'=>$profiles
        ];
    }

    /**
     * @return array
     * Display needed information to see and manage candidatures about job
     */
    public function displayCandidatures(){

        $this->loadMissing(['candidatures.status','candidatures.employee.professionalProfile']);
        $items = [];

        foreach ($this->candidatures as $cand){
            $employee = $cand->employee;
            $professionalProfile = $cand->employee->professionalProfile;
            $status = $cand->status;
            $items[] = [
                'employee'=>$employee,
                'professional_profile'=>$professionalProfile,
                'status'=>$status
            ];
        }


        return [
            'items' => $items
        ];
    }
}
