<?php

namespace App\Http\Controllers\Api\History;

use App\Models\Remark;
use App\Models\Division;

use App\Models\Employee;
use App\Models\Position;
use Illuminate\Http\Request;
use App\Models\EmployeeGroup;
use App\Models\ServiceRecord;
use App\Traits\EmployeeTrait;
use App\Models\EmploymentStatus;
use App\Http\Controllers\Controller;

class ServiceRecordController extends Controller
{
    use EmployeeTrait;

    public function __construct(
        public Request $REQUEST
    ){}

    private function validation(){
        $body = $this->REQUEST->validate([
           'date_from' => 'required|date_format:Y-m-d',
           'date_to' => 'nullable|date_format:Y-m-d',
           'employee_group_id' => 'required|exists:employee_groups,id',
           'funding_source_id' => 'nullable|exists:funding_sources,id',
           'position_id' => 'nullable|exists:positions,id',
           'positionOnPrint' => 'nullable',
           'salary' => 'required|numeric',
           'assigned_to' => 'nullable|exists:divisions,id',
           'divisionOnPrint' => 'nullable',
           'assigned_supervisor' => 'nullable|exists:employees,id',
           'supervisorOnPrint' => 'nullable',
           'date_seperation' => 'nullable|date_format:Y-m-d',
           'cause' => 'nullable',
           'employment_status_id' => 'required|exists:employment_statuses,id',
           'remark_id' => 'nullable|exists:remarks,id',
           'awol_at' => 'nullable|array',
           'awol_at.from' => 'nullable|date_format:Y-m-d',
           'awol_at.to' => 'nullable|date_format:Y-m-d',
           'show_in_reports' => 'required|boolean',
           'is_uniformed' => 'nullable|boolean',
           'cancellation_reason' => 'nullable',
           'is_exempted' => 'required|boolean',
           'date_hired' => 'required|boolean',
           'place_of_work' => 'nullable',
           'is_wfh' => 'required|boolean',
           'classification' => 'required|in:KEY,TECHNICAL,SUPPORT TO THE TECHNICAL,ADMINISTRATIVE',
           'level' => 'required|in:1ST,2ND,3RD',
        ]);

        return $body;
    }

    private function renderData($column){
        return [
            'id' => $column->id,
            'date_from' => $column->date_from,
            'date_to' => $column->date_to ?? 'present',
            'position' => $column->positionName,
            'division' => $column->divisionName,
            'supervisor' => $column->supervisorName,
            'employee_group' => $column->employeeGroupName,
            'status' => $column->employmentStatusName,
            'remark' => $column->remarkName,
            'salary' => $column->salary,
            'date_seperation' => $column->date_seperation,
            'cause' => $column->cause,
            'attachment' => $column->attachmentUrl,
            'awol_at' => $column->awol_at,
            'show_in_reports' => $column->show_in_reports,
            'isNew' => $column->is_new,
            'isDeleted' => $column->is_deleted,
        ];
    }

    public function parameter(){
        $this->checkUserAccess(auth()->user(), 'search service record');

        if(!Employee::all()->isEmpty())
            $supervisorOnPrint = Employee::all()->map(function($item, $key) {
                return $item->name; // get name of all employee
            })->merge( // merge to service record
                ServiceRecord::groupBy('supervisorOnPrint')
                                ->pluck('supervisorOnPrint')
                                ->toArray()
            )->unique() // remove redundant value
            ->filter() // remove null
            ->flatten();
        else
            $supervisorOnPrint = ServiceRecord::groupBy('supervisorOnPrint')
            ->pluck('supervisorOnPrint')
            ->unique() // remove redundant value
            ->filter() // remove null
            ->flatten();

        if(!Position::all()->isEmpty())
            $positionOnPrint = Position::all()->map(function($item, $key) {
                return $item->positionName; // position name from position table
            })->merge( // merge to service record
                ServiceRecord::groupBy('positionOnPrint')
                                ->pluck('positionOnPrint')
                                ->toArray()
            )->unique() // remove redundant value
            ->filter()
            ->flatten(); // remove null
        else
            $positionOnPrint = ServiceRecord::groupBy('positionOnPrint')
            ->pluck('positionOnPrint')
            ->unique() // remove redundant value
            ->filter()
            ->flatten(); // remove null

        if(!Division::all()->isEmpty())
            $divisionOnPrint = Division::all()->map(function($item, $key) {
                return $item->name; // division name from division table
            })->merge( // merge to service record
                ServiceRecord::groupBy('divisionOnPrint')
                                ->pluck('divisionOnPrint')
                                ->toArray()
            )->unique() // remove redundant value
            ->filter() // remove null
            ->flatten();
        else
            $divisionOnPrint = ServiceRecord::groupBy('divisionOnPrint')
            ->pluck('divisionOnPrint')
            ->unique() // remove redundant value
            ->filter() // remove null
            ->flatten();

        return response([
            'employee_group' => EmployeeGroup::select('id','description AS name')->get()->makeHidden('is_new'),
            'employment_status' => EmploymentStatus::select('id','description AS name')->get()->makeHidden('is_new'),
            'remark' => Remark::select('id','description AS name')->get()->makeHidden('is_new'),
            'positionOnPrint' => $positionOnPrint,
            'supervisorOnPrint' => $supervisorOnPrint,
            'divisionOnPrint' => $divisionOnPrint,
            'place_of_work' => ServiceRecord::where('place_of_work', '!=', null)->groupBy('place_of_work')->pluck('place_of_work'),
            'classification' =>  ['KEY','TECHNICAL','SUPPORT TO THE TECHNICAL','ADMINISTRATIVE'],
            'level' => ['1ST','2ND','3RD'],
        ], 200);
    }

    public function parameterPosition(){
        $this->checkUserAccess(auth()->user(), 'search service record');
        
        // init position parameter
        $returnEntities = Position::serviceRecordParams();

         // Filters
         $filters = $this->REQUEST->validate([
            'searchValue' => 'nullable',
            'page' => 'nullable|integer',
            'perPage' => 'nullable|integer',
            'field' => 'nullable|in:positionName,item_number,salary',
            'order' => 'required_unless:field,!=,null|in:ASC,DESC'
        ]);

        // filter for search value
        if(isset($filters['searchValue'])) {
            $search = $filters['searchValue'];
            $returnEntities = $returnEntities->filter(function ($item) use ($search) {
                return $this->isMatch($item['positionName'], $search) ||
                        $this->isMatch($item['item_number'], $search) ||
                        $this->isMatch($item['salary'], $search);
            });
        }

        // filter for asc and desc fields
        if (isset($filters['field'])) {
            $returnEntities = match($filters['order']) {
                    'ASC' => $returnEntities->sortBy($filters['field']),
                    'DESC' => $returnEntities->sortByDesc($filters['field'])
            };
        }

        // count
        $count = $returnEntities == [] ? 0 : count($returnEntities);

        // paginate
        $perPage = $filters['perPage'] ?? 10;
        $page = $filters['page'] ?? 1;
        $postRenderData = $this->paginate($returnEntities, $perPage, $page);

        return response($postRenderData)->withHeaders([
            'Access-Control-Expose-Headers' => 'Content-Range',
            'Content-Range' => 'bytes : */'.$count
        ]);
    }

    public function parameterStep($positionId){
        $position = Position::find($positionId);
        if (!$position)
            return response([
                'message' => 'No position found.'
            ], 400);

        return response($position->steps, 200);
    }

    public function create($employeeId){
        $this->checkUserAccess(auth()->user(), 'write service record');
        $this->checkEmployeeId($employeeId);

        $body = $this->validation();
        $body['employee_id'] = $employeeId;

        // check date hired if true (false all date hired)
        if($body['date_hired']) {
            activity()->disableLogging(); // for date hired revoking
            ServiceRecord::where('employee_id', $employeeId)->where('date_hired',true)->update(['date_hired' => false]);
            activity()->enableLogging(); // resume logging
        }

        $sr = $this->createRecord('ServiceRecord', $body);

        return response([
            'message' => 'servicerecord successfully created.',
            'data' => $sr->id
        ], 201);
    }

    public function latest($employeeId){
        $this->checkUserAccess(auth()->user(), 'search service record');
        $this->checkEmployeeId($employeeId);

        $entity = ServiceRecord::getRecord($employeeId);

        return response([
            'date_hired' => ServiceRecord::getDateHired($employeeId),
            'record' => $entity
        ],200);
    }

    public function search($employeeId = null, $id = null){
        $this->checkUserAccess(auth()->user(), 'search service record');

        if($employeeId == null)
            return $this->returnResponseAllEmployees();

        if($id != null) {
            $entity = ServiceRecord::find($id);

            if($entity == null)
                return response(['message' => 'no service record record found.'], 400);

            return response($entity, 200);
        }

        $query = ServiceRecord::select('*')->where('employee_id', $employeeId)->orderBy('created_at', 'DESC');
        if($this->userCan(auth()->user(), 'restore service record'))
            $query = $query->withTrashed();

        $entities = $query->get();
        $returnEntities = $entities->map(function($item, $key) {
            return $this->renderData($item);
        });

        // Filters
        $filters = $this->REQUEST->validate([
            'searchValue' => 'nullable',
            'page' => 'nullable|integer',
            'perPage' => 'nullable|integer',
            'field' => 'nullable|in:date_from,date_to,division,position,supervisor,employee_group,status,salary',
            'order' => 'required_unless:field,!=,null|in:ASC,DESC'
        ]);

        // filter for search value
        if(isset($filters['searchValue'])) {
            $search = $filters['searchValue'];
            $returnEntities = $returnEntities->filter(function ($item) use ($search) {
                return $this->isMatch($item['position'], $search) ||
                        $this->isMatch($item['division'], $search) ||
                        $this->isMatch($item['supervisor'], $search) ||
                        $this->isMatch($item['employee_group'], $search) ||
                        $this->isMatch($item['status'], $search);
            });
        }

        // filter for asc and desc fields
        if (isset($filters['field'])) {
            $returnEntities = match($filters['order']) {
                 'ASC' => $returnEntities->sortBy($filters['field']),
                 'DESC' => $returnEntities->sortByDesc($filters['field'])
            };
         }

        // count
        $count = $returnEntities == [] ? 0 : count($returnEntities);

        // paginate
        $perPage = $filters['perPage'] ?? 10;
        $page = $filters['page'] ?? 1;
        $postRenderData = $this->paginate($returnEntities, $perPage, $page);

        return response($postRenderData)->withHeaders([
            'Access-Control-Expose-Headers' => 'Content-Range',
            'Content-Range' => 'bytes : */'.$count
        ]);
    }

    public function update($id){
        $this->checkUserAccess(auth()->user(), 'write service record');

        $body = $this->validation();

        // check date hired if true (false all date hired)
        if($body['date_hired']) {
            $employeeId = ServiceRecord::find($id)->employee_id ?? null;
            if($employeeId == null) // catch error
                return response([
                    'message' => 'Service record not found.'
                ], 400);

            activity()->disableLogging(); // for date hired revoking
            ServiceRecord::where('employee_id', $employeeId)->where('date_hired',true)->update(['date_hired' => false]);
            activity()->enableLogging(); // resume logging
        }

        $this->updateRecord('ServiceRecord', $id, $body);

        return response(null, 204);
    }

    public function delete($id){
        $this->checkUserAccess(auth()->user(), 'delete service record');

        $this->deleteRecord('ServiceRecord', $id);

        return response(null, 204);
    }

    public function attach($id){
        $this->checkUserAccess(auth()->user(), 'write service record');

        $body = $this->REQUEST->validate([
            'attachment' => 'required|file'
        ]);

        $this->updateRecord('ServiceRecord', $id, $body);

        return response(null, 204);

    }

    public function restore($id){
        $this->checkUserAccess(auth()->user(), 'restore service record');

        $this->restoreRecord('ServiceRecord', $id);

        return response(null, 204);
    }

}