<?php
namespace App\Traits;

/**
 * constants variable
 */
trait ConstantTrait
{
    public $passwordLength = 8;

    public $remarkIdNotApplied = [17, 18, 20, 25, 26, 29];

    public static $remarkIdNotAppliedOnStatic = [17, 18, 20, 25, 26, 29];

    public $timeKeepingTypes = ['time_in', 'lunch_out', 'lunch_in', 'time_out'];

    public $minimumOtOnSchedule = 2; // Hour

    public $minimumOtOnOff = 4 * 60; // (Hour) multiply to 60 to be minutes

    public $daysPerHour = .125;

    public $visualDateFormat = 'd F Y';

    public $noBasedOnRequestType = [14, 17];

    public $requestStatus = [
        [
            'id' => 1,
            'value' => 'REQUESTED'
        ], [
            'id' => 2,
            'value' => 'APPROVED'
        ], [
            'id' => 3,
            'value' => 'DISAPPROVED'
        ], [
            'id' => 4,
            'value' => 'CANCELLED'
        ], [
            'id' => 5,
            'value' => 'AUTOMATIC'
        ], [
            'id' => 6,
            'value' => 'MANUAL'
        ], [
            'id' => 7,
            'value' => 'SYSTEM GENERATED'
        ]
    ];

    public $obSelection = [
        [
            'id' => 1,
            'name' => 'Seminar/Training'
        ],
        [
            'id' => 2,
            'name' => 'Conference/Meeting'
        ],
        [
            'id' => 3,
            'name' => 'Document Tracking/Pick-up/Delivery'
        ],
        [
            'id' => 4,
            'name' => 'Renewal of Passport (for official travel/training/scholarship abroad)'
        ],
        [
            'id' => 5,
            'name' => 'Reconciliation of GSIS/PAG-IBIG Records/Phil Health'
        ],
        [
            'id' => 6,
            'name' => 'Medical Check-up (for employee concerned only)'
        ],
        [
            'id' => 7,
            'name' => 'Renewal of Licenses/Permits of CPAs, Engineers, Lawyers, Medical Practitioners  and Drivers whose Items are under the DOTr-CO Plantilla of Personnel – Filing and Pick- up only and subject to submission of photocopy of license/permit'
        ],
        [
            'id' => 8,
            'name' => 'Work From Home'
        ],
        [
            'id' => null,
            'name' => 'Others'
        ]
    ];

    public $hasCreditLimit = [3, 5, 18, 6, 7, 8, 9, 10, 11, 12, 13, 18];

    public $dayNotCountedOnAutoApprove = ['sat', 'sun']; // NOTE: only three letter days are allowed

    public $daysToAutoApprove = 0;

    public $employmentStatusNotAllowedToEarn = [10, 11];

    public $leaveDivisibleBy = .5;

    public $monthlyLeaveEarning = 1.250;

    public $leavesPerDay = 1.250 / 30;

    public $printTypeArr = ['FOR_APPROPRIATE_ACTION', 'FOR_APPROVAL'];

    public $statusTypeArr = ['ALL', 'APPROVED', 'DISAPPROVED', 'CANCELLED'];

    public $adjectivalRating = [
        'Outstanding',
        'Very Satisfactory',
        'Satisfactory',
        'Unsatisfactory',
        'Poor'
    ];

    public $commonFactor = .0481927;
}
