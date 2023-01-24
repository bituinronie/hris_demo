<?php
namespace App\Traits;

use App\Models\Employee;
use Illuminate\Support\Str;

/**
 * Employee Traits
 */
trait EmployeeTrait
{
    public function returnResponseAllEmployees()
    {
        //* INIT ALL EMPLOYEE RECORDS
        $query = Employee::select('id','employee_number','last_name','first_name','middle_name','name_extension','birth_date')
                        ->orderBy('created_at','DESC');

        if($this->userCan(auth()->user(), 'restore employee'))
            $query = $query->withTrashed();
        $entities = $query->get();

        $employees = $entities->map(function ($item) {
            // $sr = $item->serviceRecords()->orderBy('date_from','DESC')->first();
            return [
                'id' => $item->id,
                'employee_number' => $item->employee_number,
                'name' => $item->name,
                'birth_date' => $item->birth_date,
                // 'group' => $sr?->group?->code,
                // 'date_hired' => $item->date_hired,
                // 'division' => $sr?->assignedTo?->name ?? $sr?->divisionOnPrint,
                // 'is_new' => $item->is_new,
                // 'is_deleted' => $item->is_deleted,
            ];
        });

        // Filters
        $filters = $this->REQUEST->validate([
            'searchValue' => 'nullable', // search by employee_number, name, group
            'page' => 'nullable|integer',
            'perPage' => 'nullable|integer',
            'field' => 'nullable|in:employee_number,name',
            'order' => 'required_unless:field,!=,null|in:ASC,DESC'
        ]);

        // filter for search value
        if(isset($filters['searchValue'])) {
            $search = $filters['searchValue'];
            $employees = $employees->filter(function ($item) use ($search) {
                return $this->isMatch($item['employee_number'], $search) ||
                    $this->isMatch($item['name'], $search);
            });
        }

        // filter for order by
        if (isset($filters['field'])) {
            $employees = match($filters['order']) {
                 'ASC' => $employees->sortBy($filters['field']),
                 'DESC' => $employees->sortByDesc($filters['field'])
            };
        }

        // return response
        $count = $employees ==[]? 0:count($employees);

        // paginate
        $perPage = $filters['perPage'] ?? 10;
        $page = $filters['page'] ?? 1;

        $entities = $this->paginate($employees, $perPage, $page);

        return response($entities)->withHeaders([
            'Access-Control-Expose-Headers' => 'Content-Range',
            'Content-Range' => 'bytes : */'.$count
        ]);
    }

    public function returnResponseAllEmployeesWithSR()
    {
        //* INIT ALL EMPLOYEE RECORDS
        $query = Employee::select('id','employee_number','last_name','first_name','middle_name','name_extension','birth_date')->orderBy('created_at','DESC');
        if($this->userCan(auth()->user(), 'restore employee'))
            $query = $query->withTrashed();
        $entities = $query->get();

        $employees = $entities->map(function ($item) {
            $sr = $item->serviceRecords()->orderBy('date_from','DESC')->first();

            return [
                'id' => $item->id,
                'employee_number' => $item->employee_number,
                'name' => $item->name,
                'birth_date' => $item->birth_date,
                'salary_grade' => $sr?->designation?->sgOnPrint,
                'division' => $sr?->assignedTo?->name ?? $sr?->divisionOnPrint,
            ];
        });

        // Filters
        $filters = $this->REQUEST->validate([
            'searchValue' => 'nullable', // search by employee_number, name, group
            'page' => 'nullable|integer',
            'perPage' => 'nullable|integer',
            'field' => 'nullable|in:employee_number,name',
            'order' => 'required_unless:field,!=,null|in:ASC,DESC'
        ]);

        // filter for search value
        if(isset($filters['searchValue'])) {
            $search = $filters['searchValue'];
            $employees = $employees->filter(function ($item) use ($search) {
                return $this->isMatch($item['employee_number'], $search) ||
                    $this->isMatch($item['name'], $search) ||
                    $this->isMatch($item['salary_grade'], $search) ||
                    $this->isMatch($item['division'], $search);
            });
        }

        // filter for order by
        if (isset($filters['field'])) {
            $employees = match($filters['order']) {
                 'ASC' => $employees->sortBy($filters['field']),
                 'DESC' => $employees->sortByDesc($filters['field'])
            };
        }

        // return response
        $count = $employees ==[]? 0:count($employees);

        // paginate
        $perPage = $filters['perPage'] ?? 10;
        $page = $filters['page'] ?? 1;

        $entities = $this->paginate($employees, $perPage, $page);

        return response($entities)->withHeaders([
            'Access-Control-Expose-Headers' => 'Content-Range',
            'Content-Range' => 'bytes : */'.$count
        ]);
    }


    public function returnResponseEmployeesParameter()
    {
         //* INIT ALL EMPLOYEE RECORDS
        $query = Employee::select('id','employee_number','last_name','first_name','middle_name','name_extension','birth_date')
                        ->orderBy('employee_number','ASC');

        $entities = $query->get();

        $employees = $entities->map(function ($item) {
            return [
                'id' => $item->id,
                'employee_number' => $item->employee_number,
                'first_name' => Str::upper($item->first_name),
                'middle_name' => Str::upper($item->middle_name),
                'last_name' => Str::upper($item->last_name),
                'name_extension' => $item->name_extension?Str::upper($item->name_extension):null,
                'birth_date' => $item->birth_date
            ];
        });

        // Filters
        $filters = $this->REQUEST->validate([
            'searchValue' => 'nullable',
            'page' => 'nullable|integer',
            'perPage' => 'nullable|integer',
            'field' => 'nullable|in:employee_number,first_name,middle_name,last_name,name_extenstion',
            'order' => 'required_unless:field,!=,null|in:ASC,DESC'
        ]);

        // filter for search value
        if(isset($filters['searchValue'])) {
            $search = $filters['searchValue'];
            $employees = $employees->filter(function ($item) use ($search) {
                return $this->isMatch($item['employee_number'], $search) ||
                        $this->isMatch($item['first_name'], $search) ||
                        $this->isMatch($item['middle_name'], $search) ||
                        $this->isMatch($item['last_name'], $search) ||
                        $this->isMatch($item['name_extension'], $search);

            });
        }

        // filter for order by
        if (isset($filters['field'])) {
            $employees = match($filters['order']) {
                 'ASC' => $employees->sortBy($filters['field']),
                 'DESC' => $employees->sortByDesc($filters['field'])
            };
        }

        // return response
        $count = $employees ==[]? 0:count($employees);

        // paginate
        $perPage = $filters['perPage'] ?? 10;
        $page = $filters['page'] ?? 1;

        $entities = $this->paginate($employees, $perPage, $page);

        return response($entities)->withHeaders([
            'Access-Control-Expose-Headers' => 'Content-Range',
            'Content-Range' => 'bytes : */'.$count
        ]);
    }
}
