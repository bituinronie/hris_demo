# Employee Management Report

- [Employee PDS](#employee-pds)
- [Employees alphalist](#employees-alphalist)
- [Position Description Form](#position-description-form)
- [Service Record](#service-record)
- [Certification of Employment](#certificate-of-employment)
- [Manpower Updates](#manpower-updates)
- [Manpower Complement](#manpower-complement)
- [Statistical Summary](#statistical-summary)

## Generating Token
Check Token API documention [here!](/api-docs/Token.yml)

Generating Token requires an `permission_id`, every report has it's permission to sucure printing reports, just follow the permission provided on the **Example Body**. Thanks!

## Employee PDS
### Single Printing: 
 **URI:** `/generate/report/1/single/pds/{token}`
 **Example Body:**
 ```json
    {
        "permission": "print employee",
        "model_name": {
            "employeeId" : 3
        }
    }
 ```

### Multiple Printing: 
 **URI:** `/generate/report/1/multiple/pds/{token}`
 **Example Body:**
 ```json
    {
        "permission": "print employee",
        "model_name": {
            "employeeIds" : [1,3]
        }
    }
 ```

### Portal Printing: 
 **URI:** `/generate/report/1/portal/pds/{token}`
 **Example Body:**
 ```json
    {
        "permission": "portal employee",
        "model_name": null
    }
 ```

## Employees Alphalist
### Plantilla:
 **URI:** `/generate/report/1/plantilla/ea/{token}`
 **Example Body:**
 ```json
    {
        "permission": "print employee",
        "model_name": {
            "prepared" : "John Doe",
            "preparedPosition" : "CEO",
            "supervisor" : "Jane Doe",
            "supervisorPosition" : "CTO"
        }
    }
 ```

### JO & COS: 
 **URI:** `/generate/report/1/jocos/ea/{token}`
 **Example Body:**
 ```json
    {
        "permission": "print employee",
        "model_name": {
            "prepared" : "John Doe",
            "preparedPosition" : "CEO",
            "supervisor" : "Jane Doe",
            "supervisorPosition" : "CTO"
        }
    }
 ```

 ## Position Description Form
### Single Printing: 
 **URI:** `/generate/report/1/single/pdf/{token}`
 **Example Body:**
 ```json
    {
        "permission": "print position",
        "model_name": {
            "positionId" : 3,
            "employeeName" : "John Doe",
		    "supervisorName": "Jane Doe"
        }
    }
 ```

### Multiple Printing: 
 **URI:** `/generate/report/1/multiple/pdf/{token}`
 **Example Body:**
 ```json
    {
        "permission": "print position",
        "model_name": {
            "positionIds" : [1,3],
            "employeeName" : "John Doe",
		    "supervisorName": "Jane Doe"
        }
    }
 ```
## Service Record
### Single Printing: 
 **URI:** `/generate/report/1/single/sr/{token}`
 **Example Body:**
 ```json
    {
        "permission": "print service record",
        "model_name": {
            "employeeId" : 3,
            "supervisorName" : "John Doe",
            "position" : "CEO",
            "division" : "Division #1"
        }
    }
 ```

### Multiple Printing: 
 **URI:** `/generate/report/1/multiple/sr/{token}`
 **Example Body:**
 ```json
    {
        "permission": "print service record",
        "model_name": {
            "employeeIds" : [3],
            "supervisorName" : "John Doe",
            "position" : "CEO",
            "division" : "Division #1"
        }
    }
 ```

## Certificate of Employment
### Single Printing: 
 **URI:** `/generate/report/1/single/ce/{token}`
 **Example Body:**
 ```json
    {
        "permission": "print service record",
        "model_name": {
            "employeeId" : 3,
            "name1" : "John Doe",
            "position1" : "CEO",
            "division1" : "Division #1",
            "name2" : "Jane Doe",
            "position2" : "CTO",
            "division2" : "Division #2"
        }
    }
 ```

### Multiple Printing: 
 **URI:** `/generate/report/1/multiple/ce/{token}`
 **Example Body:**
 ```json
    {
        "permission": "print service record",
        "model_name": {
            "employeeId" : [3],
            "name1" : "John Doe",
            "position1" : "CEO",
            "division1" : "Division #1",
            "name2" : "Jane Doe",
            "position2" : "CTO",
            "division2" : "Division #2"
        }
    }
 ```

 ## Manpower Updates
### Single Printing: 
 **URI:** `/generate/report/1/single/mu/{token}`
 **Example Body:**
 ```json
    {
        "permission": "print service record",
        "model_name": {
            "prepared" : "John Doe",
            "preparedPosition" : "CEO",
            "supervisor" : "Jane Doe",
            "supervisorPosition" : "CTO"
        }
    }
 ```

 ## Manpower Complement
### Single Printing: 
 **URI:** `/generate/report/1/single/mc/{token}`
 **Example Body:**
 ```json
    {
        "permission": "print service record",
        "model_name": {
            "prepared" : "John Doe",
            "preparedPosition" : "CEO",
            "preparedDivision" : "Division #1",
            "supervisor" : "Jane Doe",
            "supervisorPosition" : "CTO",
            "supervisorDivision" : "Division #1"
        }
    }
 ```

## Statistical Summary
### Single Printing: 
 **URI:** `/generate/report/1/single/ss/{token}`
 **Example Body:**
 ```json
    {
        "permission": "print service record",
        "model_name": {
            "prepared" : "John Doe",
            "preparedPosition" : "CEO",
            "preparedDivision" : "Division #1",
            "supervisor" : "Jane Doe",
            "supervisorPosition" : "CTO",
            "supervisorDivision" : "Division #1"
        }
    }
 ```



