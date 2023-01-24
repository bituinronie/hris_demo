# Self Service Report

- [Leave Application Form](#leave-application-form)
- [Leave Ledger](#leave-ledger)
- [Leave Balances Report](#leave-balances-report)
- [Certification of Leave Credits](#certification-of-leave-credits)
- [Certification of Without Pay](#certification-of-without-pay)
- [Report of Salary Deduction/Cancellation from Restoration to Payroll](#report-of-salary-deduction/cancellation-from-restoration-to-payroll)
- [Monetization](#monetization)
- Update Employees Organization
- Import Organization
- [Summary of Approved/Disapproved/Cancelled leave and CTO requests](#summary-of-approved/disapproved/cancelled-leave-and-cto-requests)
- [Summary of Employees with Approved Request to Render Overtime](#summary'of'employees'with'approved'request'to'render'overtime)
- [Summary of Employees with Approved Request for Night Differential Pay](#summary-of-employees-with-approved-request-for-night-differential-pay)
- [Monthly Summary of employees with negative VL and SL credits](#monthly-summary-of-employees-with-negative-vl-and-sl-credits)
- [Year-end list of employees unused VL and SL for commutation](#year-end-list-of-employees-unused-vl-and-sl-for-commutation)

## Generating Token
Check Token API documention [here!](/api-docs/Token.yml)

Generating Token requires an `permission_id`, every report has it's permission to sucure printing reports, just follow the permission provided on the **Example Body**. Thanks!

## Leave Application Form
### Single Printing: 
**URI:** `/generate/report/3/single/leave-application-form/{token}`
**Example Body:**
```json
{
    "permission": "print request",
    "model_name": {
        "requestId" : 1
    }
}
```

### Portal Printing: 
**URI:** `/generate/report/3/portal/leave-application-form/{token}`
**Example Body:**
```json
{
    "permission": "portal request",
    "model_name": {
        "requestId" : 1
    }
}
```

## Leave Ledger
### Single Printing:
**URI:** `/generate/report/3/single/leave-ledger/{token}`
**Example Body:**
```json
{
    "permission": "print request",
    "model_name": {
        "employeeId": 1,
        "certified" : "John Doe",
        "certifiedPosition" : "CEO",
        "certifiedDivision" : "Test Division",
        "prepared" : "Jane Doe"
    }
}
```

## Leave Balances Report
### Single Printing:
**URI:** `/generate/report/3/single/leave-balance/{token}`
**Example Body:**
```json
{
    "permission": "print request",
    "model_name": {
        "divisionId" : null,
        "refDate": "2021-01-01",
        "employee" : "John Doe",
        "employeePosition" : "CEO",
        "employeeDivision" : "Test Division",
        "supervisor" : "Jane Doe",
        "supervisorDivision" : "Test Division",
    }
}
```

## Certification of Leave Credits
### Single Printing:
**URI:** `/generate/report/3/single/certification-leave-credits/{token}`
**Example Body:**
```json
{
    "permission": "print request",
    "model_name": {
        "employeeId" : [1,2],
        "refDate": "2021-01-01",
        "supervisor" : "Jane Doe",
        "supervisorPosition" : "CTO",
        "supervisorDivision" : "Test Division"
    }
}
```

## Certification of Without Pay
### Single Printing:
**URI:** `/generate/report/3/single/certification-without-pay/{token}`
**Example Body:**
```json
{
    "permission": "print request",
    "model_name": {
        "employeeId" : [1,2],
        "dateFrom": "2021-01-01",
        "dateTo": "2021-01-31",
        "supervisor" : "Jane Doe",
        "supervisorPosition" : "CTO",
        "supervisorDivision" : "Test Division"
    }
}
```

## Report of Salary Deduction/Cancellation from Restoration to Payroll
### Single Printing:
**URI:** `/generate/report/3/single/salary-deduction-payroll/{token}`
**Example Body:**
```json
{
    "permission": "print request",
    "model_name": {
        "month": 1,
        "year": 2021,
        "for" : "John Doe",
        "forPosition" : "CEO",
        "forDivision" : "Test Division",
        "signed" : "Jane Doe",
        "signedDivision" : "Test Division"
    }
}
```

## Monetization
### Single Printing:
**URI:** `/generate/report/3/single/monetization/{token}`
**Example Body:**
```json
{
    "permission": "print request",
    "model_name": {
        "printType" : "FOR_APPROVAL | FOR_APPROPRIATE_ACTION",
        "month": 1,
        "year": 2021,
        "for" : "John Doe",
        "forPosition" : "CEO",
        "forDivision" : "Test Division",
        "through" : "Jane Doe",
        "throughPosition" : "CTO",
        "throughDivision" : "Test Division",
        "signed" : "Clark Kent",
        "signedPosition" : "CFO",
        "signedDivision" : "Test Division",
    }
}
```

## Summary of Approved/Disapproved/Cancelled leave and CTO requests
### Single Printing:
**URI:** `/generate/report/3/single/summary-request/{token}`
**Example Body:**
```json
{
    "permission": "print request",
    "model_name": {
        "status" : "ALL | APPROVED | DISAPPROVED | CANCELLED",
        "divisionId" : null,
        "dateFrom": "2021-01-01",
        "dateTo": "2021-01-31",
    }
}
```

## Summary of Employees with Approved Request to Render Overtime
### Single Printing:
**URI:** `/generate/report/3/single/summary-employees-render-ot/{token}`
**Example Body:**
```json
{
    "permission": "print request",
    "model_name": {
        "divisionId" : null,
        "dateFrom": "2021-01-01",
        "dateTo": "2021-01-31",
    }
}
```

## Summary of Employees With Approved Request for Night Differential Pay
### Single Printing:
**URI:** `/generate/report/3/single/summary-employees-night-differential/{token}`
**Example Body:**
```json
{
    "permission": "print request",
    "model_name": {
        "divisionId" : null,
        "dateFrom": "2021-01-01",
        "dateTo": "2021-01-31",
    }
}
```

## Monthly Summary of employees with negative VL and SL credits
### Single Printing:
**URI:** `/generate/report/3/single/summary-employees-negative-leave-credits/{token}`
**Example Body:**
```json
{
    "permission": "print request",
    "model_name": {
        "divisionId" : null,
        "dateFrom": "2021-01-01",
        "dateTo": "2021-01-31",
    }
}
```

## Year-end list of employees unused VL and SL for commutation
### Single Printing:
**URI:** `/generate/report/3/single/annual-employees-unused-leave/{token}`
**Example Body:**
```json
{
    "permission": "print request",
    "model_name": {
        "divisionId" : null,
        "refDate": "2021-01-01",
        "for" : "John Doe",
        "forPosition" : "CEO",
        "forDivision" : "Test Division",
        "signed" : "Clark Kent",
        "signedDivision" : "Test Division",
    }
}
```