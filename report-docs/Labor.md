# Labor Report

- [Summary of Appraisal](#summary-of-appraisal)
- [Summary of Awards](#summary-of-awards)
- [Summary of Offenses](#summary-of-offenses)

## Generating Token
Check Token API documention [here!](/api-docs/Token.yml)

Generating Token requires an `permission_id`, every report has it's permission to sucure printing reports, just follow the permission provided on the **Example Body**. Thanks!

## Summary of Appraisal
### Single Printing: 
 **URI:** `/generate/report/5/single/appraisal-summary/{token}`
 **Example Body:**
 ```json
    {
        "permission": "print appraisal",
        "model_name": {
            "year" : "2021",
            "prepared": "Jane Doe",
            "preparedPosition": "CTO",
            "noted": "John Doe",
            "notedPosition": "CEO"
        }
    }
 ```

 ## Summary of Awards
### Single Printing: 
 **URI:** `/generate/report/5/single/award-summary/{token}`
 **Example Body:**
 ```json
    {
        "permission": "print award",
        "model_name": {
            "prepared": "Jane Doe",
            "preparedPosition": "CTO",
            "noted": "John Doe",
            "notedPosition": "CEO"
        }
    }
 ```

 ## Summary of Offenses
 ### Single Printing: 
 **URI:** `/generate/report/5/single/offense-summary/{token}`
 **Example Body:**
 ```json
    {
        "permission": "print offense",
        "model_name": {
            "prepared": "Jane Doe",
            "preparedPosition": "CTO",
            "noted": "John Doe",
            "notedPosition": "CEO"
        }
    }
 ```