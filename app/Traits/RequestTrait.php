<?php
namespace App\Traits;

use App\Models\Employee;
use Carbon\CarbonPeriod;
use App\Models\LeaveLedger;
use App\Models\RequestType;
use App\Traits\ConstantTrait;
use Illuminate\Support\Carbon;
use App\Traits\LeaveLedgerTrait;

/**
 * Request Controller Trait
 */
trait RequestTrait
{
    use LeaveLedgerTrait, ConstantTrait;

    //* Renders
    public function renderData($column, $isPortal = true){
        return [
            'id' => $column->id,
            'dateFiled' => Carbon::parse($column->created_at)->format('F d Y'),
            'request_type_id' => $column->request_type_id,
            'requestType' => $column->requestType->id != 29 ? "{$column->requestType->code} - {$column->requestType->description}" : "{$column->requestType->description}: {$column->others_description}",
            'others_description' => $column->others_description,
            'from' => $column->from?->format('Y M d'),
            'to' => $column->to?->format('Y M d'),
            'credit' => $column->credit,
            'status' => $column->status,
            'remarks' => $column->remarks,

            'reason' => $column->reason,
            'ob_venue' => $column->ob_venue,
            'proof_type' => $column->proof_type,
            'proof' => $column->proofUrl,
            'approverStatus' => [
                'firstApprover' => $column->approverStatus[0] ?? null,
                'secondApprover' => $column->approverStatus[1] ?? null,
                'finalApprover' => $column->approverStatus[2] ?? null
            ],
            'category' => $column->requestType->category,
            'isActive' => $column->isActive,
            'isNew' => $column->is_new,
            'isCounted' => $column->isCounted,
            'isToCancel' => $isPortal?$column->isToCancel:($column->status == 6? true:$column->isToCancel),
            'canUpdate' => !$isPortal?$column->canUpdate:false
        ];
    }

    public function renderApproverData($column, $employee){
        $index = $this->getApproverIndex($employee, $column->requestType->category, $column->employee_id);

        return [
            'id' => $column->id,
            'dateFiled' => Carbon::parse($column->created_at)->format('F d Y'),
            'name' => $column->employee->name,
            'request_type_id' => $column->request_type_id,
            'requestType' => $column->requestType->id != 29 ? "{$column->requestType->code} - {$column->requestType->description}" : "{$column->requestType->description}: {$column->others_description}",
            'others_description' => $column->others_description,
            'from' => $column->from?->format('Y M d | h:i A'),
            'to' => $column->to?->format('Y M d | h:i A'),
            'status' => $column->approverStatus[$index] ?? null,

            'remarks' => $column->remarks,
            'reason' => $column->reason,
            'ob_venue' => $column->ob_venue,
            'proof_type' => $column->proof_type,
            'proof' => $column->proofUrl,
            'approverStatus' => [
                'firstApprover' => $column->approverStatus[0] ?? null,
                'secondApprover' => $column->approverStatus[1] ?? null,
                'finalApprover' => $column->approverStatus[2] ?? null
            ],
            'category' => $column->requestType->category,
            'isActive' => $column->isActive,
            'isNew' => $column->is_new
        ];
    }

    public function renderRawData($column){
        return [
            'id' => $column->id,
            'request_type_id' => $column->request_type_id,
            'others_description' => $column->others_description,
            'requestType' => $column->requestType->id != 29 ? "{$column->requestType->code} - {$column->requestType->description}" : "{$column->requestType->description}: {$column->others_description}",
            'from' => $column->from?->format('Y-m-d H:i:s'),
            'to' => $column->to?->format('Y-m-d H:i:s'),
            'credit' => $column->credit,
            'remarks' => $column->remarks,
            'reason' => $column->reason,
            'ob_venue' => $column->ob_venue,
            'proof_type' => $column->proof_type,
            'proof' => $column->proofUrl,
            'is_start' => $column->is_start,
            'created_at' => $column->created_at,
            'updated_at' => $column->updated_at
        ];
    }

    //* Filters & Validation
    public function listFilter(){
        $body = $this->REQUEST->validate([
            'searchValue' => 'nullable',
            'request_type_id' => 'nullable|exists:request_types,id',
            'category' => 'nullable|in:LEAVES,OB,OVERTIME,REQUEST',
            'isNew' => 'nullable|boolean',
            'status' => 'nullable|in:1,2,3,4,5,6,7',
            'page' => 'nullable|integer',
            'perPage' => 'nullable|integer'
        ]);

        $dateFilters = $this->getDateFilters();

        if($dateFilters) {
            $body['dateFrom'] = $dateFilters->from;
            $body['dateTo'] = $dateFilters->to;
        }

        return $body;
    }

    // get keys => for getting important components of leave_ledger table
    public function getKeys(){
        $body = $this->REQUEST->validate([
            // For multiple days
            'from' => 'required|date_format:Y-m-d H:i:s',
            'to' => 'required|date_format:Y-m-d H:i:s',

            'percent' => 'nullable|numeric|min:1|max:100',

            'request_type_id' => 'required|exists:request_types,id',
            'others_description' => 'nullable|string'
        ]);

        if (in_array($body['request_type_id'], [14, 17])) // For Monetization
            $this->REQUEST->validate([
                'percent' => 'required'
            ]);

        if ($body['request_type_id'] == 29)
            $this->REQUEST->validate([
                'others_description' => 'required'
            ]);
        else
            unset($body['others_description']);

        //* Carbon parsed from & to
        $body['from'] = Carbon::parse($body['from']);
        $body['to'] = Carbon::parse($body['to']);

        //* clearing data
        unset($body['refDate']);
        unset($body['halfDay']);

        return $body;
    }

    //* Functions & Responses
    public function getParameterResonse(){
        return response([
            'halfDay' => ['AM','PM'],
            'request_type_id' => RequestType::all()->map(fn($item) => [
                'id' => $item->id,
                'code' => $item->code,
                'name' => "{$item->code} - {$item->description}"
            ]),
            'ob' => $this->obSelection,
            'category' => ['LEAVES','OB','OVERTIME','REQUEST'],
            'status' => collect($this->requestStatus),
            'proof_type' => LeaveLedger::generateAutoSuggest('proof_type'),
            'others_description' => LeaveLedger::generateAutoSuggest('others_description')
        ], 200);
    }

    public function getRequestResponse($employee, $isPortal = true){
        $leaveLedgers = $employee->leaveLedgers()->orderBy('from', 'DESC')->get()->map(function($item) use ($isPortal) {
            return $this->renderData($item, $isPortal);
        });

        // Filters
        $filters = $this->listFilter();

        if(isset($filters['searchValue'])) {
            $search = $filters['searchValue'];

            $leaveLedgers = $leaveLedgers->filter(function ($item) use ($search) {
                return $this->isMatch($item['reason'], $search) ||
                    $this->isMatch($item['requestType'], $search);
            });
        }

        if(isset($filters['request_type_id']))
            $leaveLedgers = $leaveLedgers->where('request_type_id', $filters['request_type_id']);

        if(isset($filters['category']))
            $leaveLedgers = $leaveLedgers->where('category', $filters['category']);

        if(isset($filters['isNew']))
            $leaveLedgers = $leaveLedgers->where('isNew', $filters['isNew']);

        if(isset($filters['status']))
            $leaveLedgers = $leaveLedgers->where('status', $filters['status']);

        if(isset($filters['dateFrom']) && isset($filters['dateTo'])) {
            $dateFrom = $filters['dateFrom'];
            $dateTo = $filters['dateTo'];

            $leaveLedgers = $leaveLedgers->filter(function ($item) use ($dateFrom, $dateTo) {
                return $this->isBetweenDates($item['dateFiled'], $dateFrom, $dateTo);
            });
        }

        // count
        $count = $leaveLedgers == [] ? 0 : count($leaveLedgers);

        // paginate
        $perPage = $filters['perPage'] ?? 10;
        $page = $filters['page'] ?? 1;
        $postRenderData = $this->paginate($leaveLedgers, $perPage, $page);

        return response($postRenderData)->withHeaders([
            'Access-Control-Expose-Headers' => 'Content-Range',
            'Content-Range' => 'bytes : */'.$count
        ]);
    }

    /**
     * get computation response
     * 
     * @param Employee employee
     * @param Boolean isStrict
     * 
     * @return Response()
     */
    public function getComputationResponse($employee, $isStrict = true){
        // Get keys
        $body = $this->getKeys();

        // find requestType
        $requestType = RequestType::find($body['request_type_id']);

        // Get Credit (by getCredit)
        $credit = $this->getCredit($employee, $body['from'], $body['to'], $body['request_type_id']);
        $absCredit = abs($credit);

        // Validate Request based on Request Type Settings
        if($isStrict) {
            // filling validation
            if($message = $requestType->isFilingAllowed($body['from']))
                return response([
                    'message' => $message
                ], 400);

            // repetition of request
            if($this->hasExsitingRequest($employee, $body['from'], $body['to'], $body['request_type_id']))
                return response([
                    'message' => 'Duplicate request.'
                ], 400);

            // Final Validation based on Request Limit & Credit Limit
            // Request Limit
            if($requestType->request_limit_min && $requestType->request_limit_max){
                if(!($requestType->request_limit_min <= $absCredit && $requestType->request_limit_max >= $absCredit))
                    return response([
                        'message' => "Exceeded request limit filled. There's a minimum of {$requestType->request_limit_min} and maximum of {$requestType->request_limit_max} can be applied."
                    ], 400);
            }

            // Credit Limit
            if(in_array($requestType->id, $this->hasCreditLimit)) {
                $balance = $this->getBalance($employee)[$requestType->code];

                $newBalance = $balance - $absCredit;
                
                if($newBalance < 0)
                    return response([
                        'message' => 'Insuficient credit earned.'
                    ], 400);
            }
        }

        return response([
            'credit' => $credit
        ], 200);
    }

    public function getBalance($employee, $refDate = null){
        return RequestType::all()->mapWithKeys(function($item) use ($employee, $refDate) {
            $balance = $employee->leaveLedgers()
                            ->where('request_type_id', $item->id)
                            ->whereIn('status', [2,4,5,6,7]); // HARD CODED

            if ($refDate)
                $balance = $balance->where('from', '<=', $refDate);

            $balance = $balance->get()
                            ->filter(fn($item) => $item->isCounted)
                            ->sum('credit');

            return [$item->code => $balance];
        });
    }

    public function getBalanceOnDisplay($employee, $refDate = null){
        return collect($this->getBalance($employee, $refDate))->mapWithKeys(fn($item, $key) =>[$key => round($item,3)]);
    }

    //* Functions
    /**
     * get credit
     * 
     * @param Employee employee
     * @param Carbon from
     * @param Carbon to
     * @param Integer requestTypeId
     * 
     * @return Integer|NULL
     */
    public function getCredit($employee, $from, $to, $requestTypeId){
        $requestType = RequestType::find($requestTypeId);

        if (in_array($requestType->category, ['OB', 'REQUEST']))
            return null;

        $credit = 0;

        switch ($requestType->based_on) {
            case 'SCHEDULE':
                $period = CarbonPeriod::create($from, $to);

                foreach ($period as $date) {
                    // date to apply
                    $date = $date->format('Y-m-d');

                    // get schedule
                    $schedule = Employee::getScheduleByDate($employee->id, $date);

                    if ($schedule == null)
                        continue;

                    // apply credit
                    $credit += $this->convertMinutesToCredit($schedule->workMinutes);
                }

                $credit = -$credit;

                break;
            case 'CALENDAR':
                $credit = -$from->diffInDays($to);
                break;
            case 'OVERTIME':
                $entities = $employee->dtrs()->whereBetween('ref_date' ,[$from->format('Y-m-d'), $to->format('Y-m-d')])->get();

                $credit = $entities->map(function($item) {
                    $item->showStats = true;
                    return $item->parseDtr['stats']->otToDays();
                })->filter()->values()->sum();

                break;
            case '1':
                // TODO
                break;
            case '2':
                // TODO
                break;
        }

        return $credit;
    }

    public function convertMinutesToCredit($minutes){
        return ($minutes / 60) / 8;
    }

    /**
     * get computation error
     * 
     * @param Employee employee
     * @param Boolean isStrict
     * 
     * @return String|NULL
     */
    public function getComputationError($employee, $isStrict = false){
        // Get keys
        $body = $this->getKeys();

        $requestType = RequestType::find($body['request_type_id']);

        // Validate Request based on Request Type Settings
        if($isStrict) {
            // filling validation
            if($message = $requestType->isFilingAllowed($body['from']))
                return $message;

            // repetition of request
            if($this->hasExsitingRequest($employee, $body['from'], $body['to'], $body['request_type_id']))
                return 'Duplicate request.';
        }

        // Get Credit (by getCredit)
        $credit = $this->getCredit($employee, $body['from'], $body['to'], $body['request_type_id']);
        $absCredit = abs($credit);

        // Final Validation based on Request Limit & Credit Limit
        // Request Limit
        if($requestType->request_limit_min && $requestType->request_limit_max){
            if($requestType->request_limit_min >= $absCredit || $requestType->request_limit_max <= $absCredit)
                return "Exceeded request limit filled. There's a minimum of {$requestType->request_limit_min} and maximum of {$requestType->request_limit_max} can be applied.";
        }

        // Credit Limit
        if(in_array($requestType->id, $this->hasCreditLimit)) {
            $balance = $this->getBalance($employee)[$requestType->code];

            $newBalance = $balance - $absCredit;
            
            if($newBalance < 0)
                return 'Insuficient balance.';
        }

        return null;
    }

    public function hasExsitingRequest($employee, $from, $to, $requestTypeId){
        // $status = [1,2,5,6]; on DOTr
        $status = [1,2,5]; // remove manual input

        if($requestTypeId == 14 || $requestTypeId == 17 || $requestTypeId == 16){

            if ($requestTypeId == 14 || $requestTypeId==17){
                $from = date('Y-01-01',strtotime($from));
                $to = date('Y-12-31',strtotime($to));
            }

            $leaveLedgerData = $employee->leaveLedgers()
                                    ->whereIn('status',$status)
                                    ->whereRaw('((`from` BETWEEN ? AND ?) OR (`to` BETWEEN ? and ?) OR (? BETWEEN `from` AND `to`) OR (? BETWEEN `from` AND `to`))',[$from,$to,$from,$to,$from,$to])
                                    ->where('request_type_id',$requestTypeId)
                                    ->get();
        } else {
            $leaveLedgerData = $employee->leaveLedgers()
                                    ->whereIn('status',$status)
                                    ->whereRaw('((`from` BETWEEN ? AND ?) OR (`to` BETWEEN ? and ?) OR (? BETWEEN `from` AND `to`) OR (? BETWEEN `from` AND `to`))',[$from,$to,$from,$to,$from,$to])
                                    ->get();
        }
        if ($leaveLedgerData->count()>0)
            return true;

        return false;
    }

}
