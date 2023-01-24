<?php
namespace App\Traits;

use App\Models\Employee;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Pre Applied Traits
 */
trait ControllerTrait
{
    private $MODEL_URI = 'App\\Models\\';

    //*************************
    //* Permissions
    /**
     * checking user permission
     * 
     * @param User $user
     * @param string $permission
     * 
     * @return void
     */
    public function checkUserAccess($user, $permission)
    {
        if (!$user->hasPermissionTo($permission))
            abort(401, 'Unauthorized.');
    }

    /**
     * can user do the permission
     * 
     * @param User $user
     * @param string $permission
     * 
     * @return boolean
     */
    public function userCan($user, string $permission)
    {
        return $user->hasPermissionTo($permission);
    }

    /**
     * checking kiosk access
     * 
     * @param User $user
     */
    public function checkKioskAccess($user)
    {
        $this->checkUserAccess($user, 'access kiosk');

        if ($user->role != 'Kiosk')
            abort(401, 'Unauthorized');
    }

    //*************************
    //* CRUD
    /**
     * record validation id
     * 
     * @return bolean
     */
    private function isRecordExist(string $modelName, $id)
    {
        $model = $this->MODEL_URI . $modelName;

        $record = $model::find($id);
        if ($record == null)
            return false;

        return true;
    }

    /**
     * create Record
     * 
     * @return Model
     */
    public function createRecord(string $modelName, array $body)
    {
        $model = $this->MODEL_URI . $modelName;
        $entity = $model::create($body);

        return $entity;
    }

    /**
     * update Record
     * 
     * @return Model
     */
    public function updateRecord(string $modelName, $id, array $body)
    {
        $model = $this->MODEL_URI . $modelName;

        // validation
        if (!$this->isRecordExist($modelName, $id))
            abort(400, "$modelName record not found.");

        $entity = $model::where('id', $id)->first();
        foreach ($body as $key => $value) {
            $entity[$key] = $value;
        }

        $entity->save();

        return $entity;
    }

    /**
     * delete Record
     * 
     * @return void
     */
    public function deleteRecord(string $modelName, $id)
    {
        $model = $this->MODEL_URI . $modelName;

        // validation
        if (!$this->isRecordExist($modelName, $id))
            abort(400, "$modelName record not found.");

        // TODO: isOkToDelete


        $model::where('id', $id)->delete();
    }

    /**
     * restore Record
     * 
     * @return void
     */
    public function restoreRecord(string $modelName, $id)
    {
        $model = $this->MODEL_URI . $modelName;

        // validation
        $record = $model::withTrashed()->where('id', $id)->first();
        if ($record == null)
            abort(400, "$modelName record not found.");

        $model::where('id', $id)->restore();
    }

    /**
     * validation employee id
     * 
     * @return void
     */
    public function checkEmployeeId($employeeId)
    {
        if (Employee::find($employeeId) == null)
            abort(400, "Employee not found.");
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function paginate($items, $perPage = 10, $page = null)
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items->values() : Collection::make($items)->values();
        return new LengthAwarePaginator($items->forPage($page, $perPage)->values(), $items->count(), $perPage, $page, ['path' => Paginator::resolveCurrentPath()]);
    }

    /**
     * user has employee
     * 
     * @return integer employeeId
     */
    public function checkUserHasEmployee($user)
    {
        $employeeId = $user->employee->id ?? null;
        if ($employeeId == null)
            abort(400, "No employee record");

        return $employeeId;
    }

    /**
     * matching two strings
     * 
     * @return boolean
     */
    public function isMatch($first, $second)
    {
        return str_contains(Str::lower($first), Str::lower($second));
    }

    public function isBetweenDates($date, $dateFrom, $dateTo)
    {
        return Carbon::parse($date)->between($dateFrom, $dateTo);
    }

    /**
     * sorting by dates
     * 
     * @return object {from : {from}, to : {to}]
     * @return null
     * 
     * Note: this uses $this->REQUEST
     */
    public function getDateFilters()
    {
        $body = $this->REQUEST->validate([
            'month' => 'nullable|date_format:m',
            'year' => 'nullable|date_format:Y',
            'dateFrom' => 'nullable|date_format:Y-m-d',
            'dateTo' => 'nullable|date_format:Y-m-d'
        ]);

        if (isset($body['month'])) {
            $year = $body['year'] ?? date('Y');
            $month = $body['month'];

            $dateToParse = "$year-$month-01";

            $dateFrom = date('Y-m-01', strtotime($dateToParse));
            $dateTo = date('Y-m-t', strtotime($dateToParse));
        }

        if (isset($body['dateFrom']) && isset($body['dateTo'])) {
            $dateFrom = $body['dateFrom'];
            $dateTo = $body['dateTo'];
        }

        if (isset($dateFrom) && isset($dateTo))
            return (object)[
                'from' => $dateFrom,
                'to' => $dateTo
            ];
    }
}
