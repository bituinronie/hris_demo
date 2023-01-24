<?php
namespace App\Models;

use App\Models\TimeLog;
use App\Traits\ModelTrait;

use App\Classes\DtrStatistic;
use App\Traits\Scopes\ModelScope;

use App\Traits\Attributes\DtrAttribute;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Attributes\ModelAttribute;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Dtr extends Model
{
    use HasFactory, ModelScope, ModelAttribute, LogsActivity, ModelTrait, DtrAttribute;

    public $showStats = false;

    protected $fillable = [
        'employee_id',
        'ref_date',
        'time_in',
        'lunch_out',
        'lunch_in',
        'time_out',
        'reason',
    ];

    protected $hidden = [
        'employee_id'
    ];

    protected $casts = [
        'ref_date' => 'datetime:Y-m-d',
        'time_in' => 'datetime:Y-m-d H:i:s',
        'lunch_out' => 'datetime:Y-m-d H:i:s',
        'lunch_in' => 'datetime:Y-m-d H:i:s',
        'time_out' => 'datetime:Y-m-d H:i:s',
    ];

    protected static $logName = 'Dtr';

    public function getDescriptionForEvent(string $eventName): string
    {
        if ($eventName=='created')
            return 'A Dtr has been initialized to an employees.';
        if ($eventName=='updated')
            return 'A Dtr of an employees has been updated.';
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function scopeMiniSelect($query){
        return $query->select('id','ref_date','time_in', 'lunch_out', 'lunch_in', 'time_out');
    }

    public function getTimeLogsAttribute(){
        $timeLogs = TimeLog::where('employee_id', $this->employee_id)->where('ref_date', $this->ref_date)->orderBy('created_at','DESC')->get();

        if(!$timeLogs->count())
            return [];
        return $timeLogs->map(function($item) {
            return [
                'id' => $item->id,
                'post_date' => $item->post_date->format('F d, Y'),
                'post_time' => $item->post_date->format('h:i a'),
                'type' => $item->type,
                'cause' => $item->name,
                'created_at' => $item->created_at,
                'isNew' => $item->is_new,
            ];
        })->toArray();
    }

    public function getHasTimeLogAttribute(){
        $timeLog = TimeLog::where('employee_id', $this->employee_id)->where('ref_date', $this->ref_date)->first();

        return $timeLog != null ? true : false;
    }

    public static function getStats($employeeId, $dateFrom = null, $dateTo = null){
        // initialize datefrom and dateto
        $dateFrom = $dateFrom ?? date('Y-m-01');
        $dateTo = $dateTo ?? date('Y-m-t');

        $entities = self::select('*')->where('employee_id', $employeeId)->whereBetween('ref_date',[$dateFrom, $dateTo])->get();

        // get stats per dtr
        $statsPerDtr = $entities->map(function($item) {
            $item->showStats = true;
            $data = $item->parseDtr;

            return $data->get('stats');
        });

        $newStats = new DtrStatistic;

        foreach ($statsPerDtr as $stats) {
            $newStats->addWorkMinutes($stats->workMinutes);
            $newStats->addDiff($stats->diff);
            $newStats->addOt($stats->ot);
            $newStats->addLateCount($stats->lateCount);
            $newStats->addUtCount($stats->utCount);
            if($stats->isAbsent)
                $newStats->addAbsentCount();
        }

        return [
            'total' => [
                'diff' => $newStats->diffToReadable(),
                'ot' => $newStats->otToReadable(),
                'workHours' => $newStats->workHours()
            ],
            'summary' => [
                'unfilledLeave' => $newStats->absentCount,
                'late' => $newStats->lateCount,
                'ut' => $newStats->utCount,
                'diff_in_days' => $newStats->diffToDays()
            ]
        ];
    }

    public static function getReportStats($employeeId, $dateFrom = null, $dateTo = null){
        // initialize datefrom and dateto
        $dateFrom = $dateFrom ?? date('Y-m-01');
        $dateTo = $dateTo ?? date('Y-m-t');

        $entities = self::select('*')->where('employee_id', $employeeId)->whereBetween('ref_date',[$dateFrom, $dateTo])->get();

        // get stats per dtr
        $statsPerDtr = $entities->map(function($item) {
            $item->showStats = true;
            $data = $item->parseDtr;

            return $data->get('stats');
        });

        $returnStats = (object) [
            'leaves' => 0,
            'absences' => 0,
            'present' => 0,
            'status' => (object) [
                'S' => 0,
                'V' => 0,
                'ML' => 0,
                'PL' => 0,
                'SPL' => 0,
                'M' => 0,
                'P' => 0,
                'O' => 0,
                'A' => 0,
                'OB' => 0
            ],
            'absencesStats' => (object) [
                'vl' => 0,
                'sl' => 0,
                'ml' => 0,
                'pl' => 0,
                'spl' => 0,
                'mandatory' => 0,
                'cto' => 0,
                'training' => 0,
                'meeting' => 0,
                'calamity' => 0,
                'holiday' => 0,
                'lwop' => 0,
                'awol' => 0
            ]
        ];

        foreach ($statsPerDtr as $stats) {
            // status
            $status = $stats->status();
            if($status)
                $returnStats->status->{$status} += 1;

            // other stats
            // TODO: add Leaves
            // TODO: add Absent Code
            if($stats->isAbsent) {
                $returnStats->absences+=1;
                $returnStats->absencesStats->lwop+=1;
            }else if($stats->workMinutes) {
                $returnStats->present+=1;
            }
        }

        return $returnStats;
    }



    public static function getByRefDate($employeeId, $refDate){
        return Dtr::where('employee_id', $employeeId)->where('ref_date', $refDate)->first();
    }

}