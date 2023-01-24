# Time Keeping Report

- [Daily Time Record](#daily-time-record)
- [Log-in and Log-out summary](#log-in-and-log-out-summary)
- [Summary of Employees Tardiness](#summary-of-employees-tardiness)
- [Monthly Attendance Report](#monthly-attendance-report)
- [Summary of Employees Absences](#summary-of-employees-absences)

## Generating Token
Check Token API documention [here!](/api-docs/Token.yml)

Generating Token requires an `permission_id`, every report has it's permission to sucure printing reports, just follow the permission provided on the **Example Body**. Thanks!

## Daily Time Record
### Single Printing: 
 **URI:** `/generate/report/2/single/dtr/{token}`
 **Example Body:**
 ```json
    {
        "permission": "print dtr",
        "model_name": {
            "employeeId" : 3,
            "dateFrom": null,
            "dateTo": null,
            "month": null,
            "year": null,
            "perPage": 31,
            "supervisor": "Jane Doe"
        }
    }
 ```

### Multiple Printing: 
 **URI:** `/generate/report/2/multiple/dtr/{token}`
 **Example Body:**
 ```json
    {
        "permission": "print dtr",
        "model_name": {
            "employeeId" : [1,3],
            "dateFrom": null,
            "dateTo": null,
            "month": null,
            "year": null,
            "perPage": 31,
            "supervisor": "Jane Doe"
        }
    }
 ```

### Portal Printing: 
 **URI:** `/generate/report/2/portal/dtr/{token}`
 **Example Body:**
 ```json
    {
        "permission": "portal dtr",
        "model_name": {
            "dateFrom": null,
            "dateTo": null,
            "month": null,
            "year": null,
            "perPage": 31,
            "supervisor": "Jane Doe"
        }
    }
 ```

 ## Log-in and Log-out Summary
### Single Printing: 
 **URI:** `/generate/report/2/single/bandi-summary/{token}`
 **Example Body:**
 ```json
    {
        "permission": "print dtr",
        "model_name": {
            "divisionId" : null,
            "placeOfWork" : null,
            "month": 1,
            "year": 2021,
            "prepared" : "John Doe",
            "preparedPosition" : "CEO",
            "supervisor" : "Jane Doe",
            "supervisorPosition" : "CTO"
        }
    }
 ```

 ## Summary of Employees Tardiness
 ### Single Printing: 
 **URI:** `/generate/report/2/single/tardiness-summary/{token}`
 **Example Body:**
 ```json
    {
        "permission": "print dtr",
        "model_name": {
            "placeOfWork" : null,
            "dateFrom": null,
            "dateTo": null,
            "month": null,
            "year": null,
            "prepared" : "John Doe",
            "preparedPosition" : "CEO",
            "supervisor" : "Jane Doe",
            "supervisorPosition" : "CTO"
        }
    }
 ```

## Monthly Attendance Report
### Single Printing: 
 **URI:** `/generate/report/2/single/monthly-attendance/{token}`
 **Example Body:**
 ```json
    {
        "permission": "print dtr",
        "model_name": {
            "divisionId" : null,
            "placeOfWork" : null,
            "month": 1,
            "year": 2021,
            "prepared" : "John Doe",
            "preparedPosition" : "CEO",
            "supervisor" : "Jane Doe",
            "supervisorPosition" : "CTO"
        }
    }
```

## Summary of Employees Absences
### Single Printing: 
 **URI:** `/generate/report/2/single/employee-absences/{token}`
 **Example Body:**
 ```json
    {
        "permission": "print dtr",
        "model_name": {
            "placeOfWork" : null,
            "month": 1,
            "year": 2021,
            "prepared" : "John Doe",
            "preparedPosition" : "CEO",
            "supervisor" : "Jane Doe",
            "supervisorPosition" : "CTO"
        }
    }
```