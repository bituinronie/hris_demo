# Context API
This help's you to generate `Migrations`, `Models`, `Routes`, `CRUD`, and `API Documentation` inside the Controller for Coding seamlessly, and getting rid of repetative development.

## Files Use:
- `app/Console/Commands/*`
- `app/Console/ContextClasses/*`
- `app/Context/*`
- `api-docs/*`
- `app/Traits/ModelTrait.php`
- `app/Traits/Scopes/ModelScope.php`
- `app/Traits/Attributes/ModelAttribute.php`

## Usage Flow:
1. Create Context JSON using this command: `php artisan context:create {ModelName}`
2. Locate **ContextJSON** on `app/Context/`, filename structure: `{ModelName}Context.php`
3. Update **ContextJSON**. (Check Context JSON Content)
4. Run the generate command: `php artisan context:generate {ModelName}`. By doing this command the API will generate `Model`, `Migration`,`CRUD Controller`, and `Routes`.

## Context JSON Content
To determine the entities of the table, and generate CRUD easily you need to prepare first the **Entity Definition**, **Enabling Soft Delete**, and **Controller Location** inside the table.

### Entity Definition
Intializing entity requires two parts, first the key of the entity object is the column name, then inside of it has two object value.

**:information_source: There are pre-applied `primary_key` and `timestamps` (created_at and updated_at) on all entities**

1. **definition** - `String`

To declare a definition, it must be under the [Laravel Migration Column Type](https://laravel.com/docs/8.x/migrations#available-column-types).
Passing parameters inside the string uses colon (`:`) character.
Example:
> "definition" : "enum:MALE,FEMALE"

**:information_source: When you want to define **related column id** you can use the pre-applied `relatedTo:{table_name}`**

**:information_source: When you want to define **array column** you can use the pre-applied `array`**

2. **additionalValidation** *(optional)* - `String`

In declaring validations, in default `required` and `nullable` already declared, also on `max` and `in` or enum values are already applied base on the `definition` you spec out.
The basis of this column uses the [Laravel Validation](https://laravel.com/docs/8.x/validation#available-validation-rules).

3. **additionalDefinition** *(optional)* - `Array`

When it comes to additionalDefinition, it must be under the [Laravel Migration Column Modifiers](https://laravel.com/docs/8.x/migrations#column-modifiers).
Passing parameters inside the string uses colon (`:`) character.

Example: 
> { "phoneNumber" : { "definition" : "string:15", "validation" : "nullable|max:100", "additionalDefinition" : ["nullable"] } }

### Portal Access

To access by `portal permission`, toggle the bolean value to **true** if you want to generate API functionalities under `portalAccess`.

### Has Delete

To enable delete API put **true** on `hasDelete`.

### Enabling Soft Delete

To enable soft delete put **true** on `isSoftDelete`. To learn more: [click here](https://laravel.com/docs/8.x/eloquent#soft-deleting).

**:information_source:This will generate one more API: `/restore/`, only with `restore {permissionKey}` permission will see deleted records on `/search/`.**

### Log Settings

To enable Activity Log on API just put a value to `logSetting` on the **JSON** then set the API `logName`.

**:information_source:`logSetting` accepts this values: .**

- default
-assignTo:`parameter`



### Controller Location

In default location is on `Api`, to put it inside a Folder just use the dot (`.`) symbol. Example: `Api.SampleFolder`. The file location is `app/Http/Controllers`.

### Route Prefix

This is the prefix for your routes.

### API Version

For controlling versions in API Documentation.


