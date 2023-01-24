# Training Report

- [Summary of Training](#summary-of-training)

## Generating Token
Check Token API documention [here!](/api-docs/Token.yml)

Generating Token requires an `permission_id`, every report has it's permission to sucure printing reports, just follow the permission provided on the **Example Body**. Thanks!

## Summary of Training
### Single Printing: 
 **URI:** `/generate/report/4/single/training-summary/{token}`
 **Example Body:**
 ```json
    {
        "permission": "print training",
        "model_name": null
    }
 ```