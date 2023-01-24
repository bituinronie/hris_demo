<?php
namespace App\Console\ContextClasses;

use Symfony\Component\Yaml\Yaml;

use Illuminate\Support\Str;

class TemplateClass{
    private $JSON;

    public function __construct($contextJSON){
        $this->JSON = $contextJSON;
    }

    public function getModelTemplate(){
        // init variables
        $e = "\r\n";
        $content = "<?php$e";

        // content
        $content .= "namespace App\Models;$e$e";
        $content .= "use Illuminate\Database\Eloquent\Factories\HasFactory;$e";
        $content .= "use Illuminate\Database\Eloquent\Model;$e$e";

        if($this->JSON['isSoftDelete'])
            $content .= "use Illuminate\Database\Eloquent\SoftDeletes;$e$e";

        if($this->JSON['logSetting'] != null) {
            $content .= "use App\Traits\ModelTrait;$e";
            $content .= "use Spatie\Activitylog\Traits\LogsActivity;$e$e";
        }
        $content .= "use App\Traits\Scopes\ModelScope;$e";
        $content .= "use App\Traits\Attributes\ModelAttribute;$e$e";
        
        $content .= "class ".$this->JSON['modelName']." extends Model$e{\r\n";

        $content .= "    use HasFactory, ModelScope, ModelAttribute";

        if($this->JSON['isSoftDelete'])
            $content .=", SoftDeletes";

        if($this->JSON['logSetting'] != null)
            $content .=", LogsActivity, ModelTrait";

        $content .= ";$e$e";

        $content .= '    protected $fillable = ['.$e;
        foreach ($this->JSON['entity'] as $columnName => $specs) {
            $content .= "        '$columnName',$e";
        }
        $content .= "    ];$e$e";

        $content .= '    protected $hidden = ['.$e;
        $content .= "    ];$e$e";

        $content .= '    protected $casts = ['.$e;
        $arrayFields = $this->getArrayFields();
        foreach ($arrayFields as $field) {
            $content .= "        '$field' => 'array',$e";
        }
        $content .= "    ];$e$e";

        if($this->JSON['logSetting'] != null) {
            $logName = $this->JSON['logName'];

            $content .= "    protected static \$logName = '$logName';$e$e";

            $content .= "    public function getDescriptionForEvent(string \$eventName): string".$e;
            $content .= "    {\r\n";

            $logSetting = $this->getLogSetting();

            if($logSetting['isDefault']) {
                $content .= '        return "A '.$logName.' is $eventName";'.$e;
            }else {
                $assignTo = $logSetting['assignTo'];

                $content .= "        if (\$eventName=='created')$e";
                $content .= "            return 'A $logName has been assigned to an $assignTo.';$e";
                $content .= "        if (\$eventName=='updated')$e";
                $content .= "            return 'A $logName of an $assignTo has been updated.';$e";
                $content .= "        if (\$eventName=='deleted')$e";
                $content .= "            return 'A $logName has been removed from an $assignTo.';$e";
            }

            $content .= "    }$e$e";
        }


        $content .= "}";

        return $content;
    }

    public function getMigrationTemplate(){
        // init variables
        $e = "\r\n";
        $content = "<?php$e$e";

        // content
        $content .= "use Illuminate\Database\Migrations\Migration;$e";
        $content .= "use Illuminate\Database\Schema\Blueprint;$e";
        $content .= "use Illuminate\Support\Facades\Schema;$e$e";

        $pieces = explode("_", $this->JSON['tableName']);
        $postTableToClass = '';
        foreach ($pieces as $piece) {
            $postTableToClass .= ucfirst($piece);
        }

        $className ='Create'.$postTableToClass.'Table';

        $content .= "class $className extends Migration$e{\r\n\r\n";
        $content .= "    public function up()$e    {\r\n";
        $content .= '        Schema::create(\''.$this->JSON['tableName'].'\', function (Blueprint $table) {'.$e;
        $content .= '            $table->id();'.$e;

        foreach ($this->JSON['entity'] as $columnName => $specs) {
            $isRelatedTo = false;
            // definition
            $parsedDef = $this->parseDefinition($specs['definition']);

            switch ($parsedDef['function']) { // parsing pre-set functions
                case 'relatedTo':
                    $content .= "            \$table->unsignedBigInteger('$columnName')";
                    $isRelatedTo = true;
                    break;
                case 'array':
                    $content .= "            \$table->longText('$columnName')";
                    break;
                default:
                    $insideContent = $parsedDef['param'] != null?', ':'';
                    $insideContent .= $parsedDef['param'];
                    $content .= '            $table->'.$parsedDef['function']."('$columnName'$insideContent)";
                    break;
            }

            // additional definition
            foreach ($specs['additionalDefinition'] as $addtDef) {
                $parsedAddtDef = $this->parseDefinition($addtDef);
                $content .= '->'.$parsedAddtDef['function'].'('.$parsedAddtDef['param'].')';
            }
            $content .= ";$e";

            if($isRelatedTo)
                $content .= "            \$table->foreign('$columnName')->references('id')->on(".$parsedDef['param'].");$e";
        }

        $content .= '            $table->timestamps();'.$e;

        if($this->JSON['isSoftDelete'])
            $content .= '            $table->softDeletes();'.$e;

        $content .= "        });$e";

        $content .= "    }$e$e";
        $content .= "    public function down()$e    {\r\n";
        $content .= "        Schema::dropIfExists('".$this->JSON['tableName']."');$e";
        $content .= "    }$e";

        $content .= "}";

        return $content;
    }

    public function getControllerTemplate(){
        // init variables
        $e = "\r\n";
        $permissionKey = $this->getPermissionKey();
        $modelName = $this->JSON['modelName'];
        $content = "<?php$e$e";

        // content
        $namespace = 'namespace App\Http\Controllers\Api';
        $appendToNamespace = str_replace('/','\\',$this->JSON['controllerLocation']);

        $namespace .= $this->JSON['controllerLocation'] != null?'\\'.$appendToNamespace.';':''.';';

        $content .= "$namespace$e$e";

        $content .= "use App\Http\Controllers\Controller;$e";
        $content .= "use Illuminate\Http\Request;$e$e";
        $content .= "use App\\Models\\$modelName;$e$e";

        $controllerName = ucfirst($modelName).'Controller';
        $content .= "class $controllerName extends Controller$e{\r\n\r\n";

        $content .= "    public function __construct($e";
        $content .= '        public Request $REQUEST'.$e;
        $content .= "    ){}$e$e";

        $content .= "    private function validation(){\r\n";
        $content .= "        \$body = \$this->REQUEST->validate([$e";

        foreach ($this->JSON['entity'] as $columnName => $specs) {
            $validation = $this->getValidation($specs);
            $content .= "           '$columnName' => '$validation',$e";
        }

        $content .= "        ]);$e$e";
        $content .= "        return \$body;$e";
        $content .= "    }$e$e";

        $content .= "    private function renderData(\$column){\r\n";
        $content .= "        return [$e";
        $content .= "            'id' => \$column->id,$e";

        foreach ($this->JSON['entity'] as $columnName => $specs) {
            $content .= "            '$columnName' => \$column->$columnName,$e";
        }

        $content .= "            'created_at' => \$column->created_at,$e";
        $content .= "            'updated_at' => \$column->updated_at,$e";
        if($this->JSON['isSoftDelete'])
            $content .= "            'deleted_at' => \$column->deleted_at,$e";

        $content .= "            'isNew' => \$column->is_new$e";

        $content .= "        ];$e";
        $content .= "    }$e$e";

        $content .= "    public function create(){\r\n";
        $content .= "        \$this->checkUserAccess(auth()->user(), 'write $permissionKey');$e$e";
        $content .= "        \$body = \$this->validation();$e$e";
        $content .= "        \$this->createRecord('$modelName', \$body);$e$e";
        $content .= "        return response(['message' => '".strtolower($modelName)." successfully created.'], 201);$e";
        $content .= "    }$e$e";

        $content .= "    public function search(\$id = null){\r\n";
        $content .= "        \$this->checkUserAccess(auth()->user(), 'search $permissionKey');$e$e";
        $content .= "        if(\$id != null) {\r\n";
        $content .= "            \$entity = $modelName::find(\$id);$e$e";
        $content .= "            if(\$entity == null)$e";
        $content .= "                return response(['message' => 'no $permissionKey record found.'], 400);$e$e";
        $content .= "            return response(\$this->renderData(\$entity), 200);$e";
        $content .= "        }$e$e";
        $content .= "        \$query = $modelName::select('*');$e$e";

        if($this->JSON['isSoftDelete']) {
            $content .= "        if(\$this->userCan(auth()->user(), 'restore $permissionKey'))\r\n";
            $content .= "            \$query = \$query->withTrashed();$e$e";
        }

        $content .= "        // Filters$e";
        $content .= "        \$filters = \$this->REQUEST->validate([$e";
        $content .= "            'searchValue' => 'nullable',$e";
        $content .= "            'page' => 'nullable|integer',$e";
        $content .= "            'perPage' => 'nullable|integer',$e";
        $content .= "            'field' => 'nullable|in:".$this->getStrFields()."',$e";
        $content .= "            'order' => 'required_unless:field,!=,null|in:ASC,DESC'$e";
        $content .= "        ]);$e$e";

        $content .= "        \$filters['perPage'] = \$filters['perPage'] ?? 10;$e$e";

        $content .= "        if (isset(\$filters['field']))$e";
        $content .= "           \$query = \$query->orderBy(\$filters['field'], \$filters['order']);$e$e";

        $content .= "        // return response$e";
        $content .= "        \$count = \$query->get() ==[]? 0:count(\$query->get());$e$e";

        $content .= "        // paginate$e";
        $content .= "        \$entities = \$query->paginate(\$filters['perPage']);$e$e";

        $content .= "        \$renderedData = \$entities->map(function (\$item, \$key) {\r\n";
        $content .= "            return \$this->renderData(\$item);$e";
        $content .= "        });$e$e";

        $content .= "        return response(\$renderedData)->withHeaders([$e";
        $content .= "            'Access-Control-Expose-Headers' => 'Content-Range',$e";
        $content .= "            'Content-Range' => 'bytes : */'.\$count$e";
        $content .= "        ]);$e";
        $content .= "    }$e$e";

        $content .= "    public function update(\$id){\r\n";
        $content .= "        \$this->checkUserAccess(auth()->user(), 'write $permissionKey');$e$e";
        $content .= "        \$body = \$this->validation();$e$e";
        $content .= "        \$this->updateRecord('$modelName', \$id, \$body);$e$e";
        $content .= "        return response(null, 204);$e";
        $content .= "    }$e$e";

        if($this->JSON['hasDelete']) {
            $content .= "    public function delete(\$id){\r\n";
            $content .= "        \$this->checkUserAccess(auth()->user(), 'delete $permissionKey');$e$e";
            
            $content .= "        \$this->deleteRecord('$modelName', \$id);$e$e";

            $content .= "        return response(null, 204);$e";
            $content .= "    }$e$e";
        }
        if($this->JSON['isSoftDelete']) {
            $content .= "    public function restore(\$id){\r\n";
            $content .= "        \$this->checkUserAccess(auth()->user(), 'restore $permissionKey');$e$e";
            
            $content .= "        \$this->restoreRecord('$modelName', \$id);$e$e";

            $content .= "        return response(null, 204);$e";
            $content .= "    }$e$e";
        }

        // portal access
        if($this->JSON['portalAccess']['search']) {
            $content .= "    public function portalSearch(){\r\n";
            $content .= "        \$user = auth()->user();$e$e";
            $content .= "        \$this->checkUserAccess(\$user, 'portal $permissionKey');$e$e";
                
            $content .= "        // Do something...$e$e";
    
            $content .= "        return response([], 200);$e$e";
            $content .= "    }$e$e";
        }

        if($this->JSON['portalAccess']['update']) {
            $content .= "    public function portalUpdate(){\r\n";
            $content .= "        \$user = auth()->user();$e$e";
            $content .= "        \$this->checkUserAccess(\$user, 'portal $permissionKey');$e$e";
            $content .= "        \$body = \$this->validation();$e$e";
                
            $content .= "        // Do something...$e$e";
    
            $content .= "        return response([], 200);$e";
            $content .= "    }$e$e";
        }
        if($this->JSON['portalAccess']['create']) {
            $content .= "    public function portalCreate(){\r\n";
            $content .= "        \$user = auth()->user();$e$e";
            $content .= "        \$this->checkUserAccess(\$user, 'portal $permissionKey');$e$e";
            $content .= "        \$body = \$this->validation();$e$e";

            $content .= "        // Do something...$e$e";
    
            $content .= "        return response([], 200);$e";
            $content .= "    }$e$e";
        }
        if($this->JSON['portalAccess']['delete']) {
            $content .= "    public function portalDelete(){\r\n";
            $content .= "        \$user = auth()->user();$e$e";
            $content .= "        \$this->checkUserAccess(\$user, 'portal $permissionKey');$e$e";
                
            $content .= "        // Do something...$e$e";
    
            $content .= "        return response([], 200);$e";
            $content .= "    }$e$e";
        }

        $content .= "}";

        return $content;
    }

    public function getRouteTemplate(){
        // init variables
        $e = "\r\n";
        $modelName = $this->JSON['modelName'];
        $prefix = $this->JSON['routePrefix'];
        $controllerLoc = $this->JSON['controllerLocation'] != null?'\\'.str_replace('/','\\', $this->JSON['controllerLocation']):'';
        $content = $e;

        $content .= "//**********************$e";
        $content .= "//* $modelName$e";
        $content .="Route::group([$e";
        $content .= "    'middleware' => 'auth:api',$e";
        $content .= "    'prefix' => '$prefix',$e";
        $content .= "    'namespace' => \$namespace.'$controllerLoc'$e";
        $content .= "], function (\$r) {\r\n";
        $content .="    \$r->post('create', '".ucfirst($modelName)."Controller@create');$e";
        $content .="    \$r->get('search/{id?}', '".ucfirst($modelName)."Controller@search');$e";
        $content .="    \$r->put('update/{id}', '".ucfirst($modelName)."Controller@update');$e";

        if($this->JSON['hasDelete'])
            $content .="    \$r->delete('delete/{id}', '".ucfirst($modelName)."Controller@delete');$e";

        if($this->JSON['isSoftDelete'])
            $content .="    \$r->post('restore/{id}', '".ucfirst($modelName)."Controller@restore');$e";


        if($this->JSON['portalAccess']['search'])
            $content .="    \$r->get('portal/search', '".ucfirst($modelName)."Controller@portalSearch');$e";

        if($this->JSON['portalAccess']['update'])
            $content .="    \$r->put('portal/update', '".ucfirst($modelName)."Controller@portalUpdate');$e";

        if($this->JSON['portalAccess']['create'])
            $content .="    \$r->post('portal/create', '".ucfirst($modelName)."Controller@portalCreate');$e";

        if($this->JSON['portalAccess']['delete'])
            $content .="    \$r->delete('portal/delete', '".ucfirst($modelName)."Controller@portalDelete');$e";
        
        $content.= "});$e";

        return $content;
    }

    public function generateApiDocsTemplate(){
        // init variable
        $tag = strtolower($this->JSON['modelName']);
        $modelName = $this->JSON['modelName'];
        $prefix = strtolower($this->JSON['routePrefix']);

        $message = function($description, $message = null) {
            return [
                'description' => $description,
                'content' => $message != null?[
                    'application/json' => [
                        'schema' => [
                            'type' => 'object',
                            'properties' => [
                                'message' => [
                                    'type' => 'string',
                                    'example' => $message
                                ]
                            ]
                        ]
                    ]
                ]:null
            ];
        };

        $objMessage = function($description, $message) {
            return [
                'description' => $description,
                'content' => [
                    'application/json' => [
                        'schema' => [
                            'type' => 'array',
                            'example' => [$message, $message]
                        ]
                    ]
                ]
            ];
        };

        $unauthorized = [
            'description' => 'Bearer token not authorized',
            'content' => [
                'application/json' => [
                    'schema' => [
                        'type' => 'object',
                        'properties' => [
                            'message' => [
                                'type' => 'string',
                                'example' => 'Unauthenticated'
                            ]
                        ]
                    ]
                ]
            ]
        ];

        $docs = [
            'openapi' => '3.0.0',
            'info' => [
                'title' => env('APP_NAME')." API - $modelName",
                'version' => $this->JSON['apiVersion']
            ],
            'servers' => [
                [
                    'url' => env('APP_URL').'/api/',
                    'description' => 'URI'
                ]
            ],
            'components' => [
                'parameters' => [
                    'acceptsJson' => [
                        'name' => 'Accept',
                        'in' => 'header',
                        'required' => true,
                        'schema' => [
                            'type' => 'string',
                            'example' => 'application/json',
                            'default' => 'application/json'
                        ]
                    ]
                ],
                'examples' => [
                    'dummyuser' => [
                        'summary' => 'Dummy username and password',
                        'value' => [
                            'username' => 'dummyuser',
                            'password' => 'secret'
                        ]
                    ]
                ],
                'securitySchemes' => [ 
                    'bearerAuth' => [
                        'type' => 'http',
                        'scheme' => 'bearer',
                        'bearerFormat' => 'JWT'
                    ]
                ]
            ],
            'tags' => [
                [
                    'name' => $tag,
                    'description' => "Everything about $modelName API"
                ]
            ],
            'paths' => [
                "/$prefix/create" => [
                    'post' => [
                        'summary' => 'create record',
                        'tags' => [$tag],
                        'requestBody' => $this->getRequestBody(),
                        'security' => [ [ 'bearerAuth' => [] ] ],
                        'parameters' => [ [ '$ref' => '#/components/parameters/acceptsJson' ] ],
                        'responses' => [
                            "\"201\"" => $message("$modelName created message","$prefix successfully created."),
                            "\"401\"" => $unauthorized
                        ]
                    ]
                ],
                "/$prefix/search/{id}" => [
                    'get' => [
                        'summary' => 'get record',
                        'tags' => [$tag],
                        'security' => [ [ 'bearerAuth' => [] ] ],
                        'parameters' => [
                            [ '$ref' => '#/components/parameters/acceptsJson' ],
                            [
                                'in' => 'path',
                                'name' => 'id',
                                'required' => false,
                                'schema' => ['type' => 'integer'],
                                'description' => 'primary key'
                            ],
                            [
                                'in' => 'query',
                                'name' => 'searchValue',
                                'schema' => ['type' => 'string'],
                                'description' => 'search value'
                            ],
                            [
                                'in' => 'query',
                                'name' => 'page',
                                'schema' => ['type' => 'integer'],
                                'description' => 'for pagination'
                            ],
                            [
                                'in' => 'query',
                                'name' => 'perPage',
                                'schema' => ['type' => 'integer'],
                                'description' => 'for pagination'
                            ],
                            [
                                'in' => 'query',
                                'name' => 'field',
                                'schema' => ['type' => 'string'],
                                'description' => 'for sorting'
                            ],
                            [
                                'in' => 'query',
                                'name' => 'order',
                                'schema' => ['type' => 'string', 'enum' => ['ASC','DESC']],
                                'description' => 'for sorting'
                            ],
                        ],
                        'responses' => [
                            "\"200\"" => $objMessage("return $modelName records",$this->getSearchResponse()),
                            "\"401\"" => $unauthorized
                        ]
                    ]
                ],
                "/$prefix/update/{id}" => [
                    'put' => [
                        'summary' => 'update record',
                        'tags' => [$tag],
                        'requestBody' => $this->getRequestBody(),
                        'security' => [ [ 'bearerAuth' => [] ] ],
                        'parameters' => [
                            [ '$ref' => '#/components/parameters/acceptsJson' ],
                            [
                                'in' => 'path',
                                'name' => 'id',
                                'required' => true,
                                'schema' => ['type' => 'integer'],
                                'description' => 'primary key'
                            ]
                        ],
                        'responses' => [
                            "\"204\"" => $message("$modelName update message",null),
                            "\"401\"" => $unauthorized
                        ]
                    ]
                ]
            ]
        ];

        // has delete
        if($this->JSON['hasDelete'])
            $docs['paths']["/$prefix/delete/{id}"] = [
                'delete' => [
                    'summary' => 'delete record',
                    'tags' => [$tag],
                    'security' => [ [ 'bearerAuth' => [] ] ],
                    'parameters' => [
                        [ '$ref' => '#/components/parameters/acceptsJson' ],
                        [
                            'in' => 'path',
                            'name' => 'id',
                            'required' => true,
                            'schema' => ['type' => 'integer'],
                            'description' => 'primary key'
                        ]
                    ],
                    'responses' => [
                        "\"204\"" => $message("$modelName delete message",null),
                        "\"401\"" => $unauthorized
                    ]
                ]
            ];

        // isSoftDelete
        if($this->JSON['isSoftDelete'])
            $docs['paths']["/$prefix/restore/{id}"] = [
                'post' => [
                    'summary' => 'restore record',
                    'tags' => [$tag],
                    'security' => [ [ 'bearerAuth' => [] ] ],
                    'parameters' => [
                        [ '$ref' => '#/components/parameters/acceptsJson' ],
                        [
                            'in' => 'path',
                            'name' => 'id',
                            'required' => true,
                            'schema' => ['type' => 'integer'],
                            'description' => 'primary key'
                        ]
                    ],
                    'responses' => [
                        "\"204\"" => $message("$modelName sucessfully restored",null),
                        "\"401\"" => $unauthorized
                    ]
                ]
            ];

        // portal user
        if($this->JSON['portalAccess']['search'])
            $docs['paths']["/$prefix/portal/search/"] = [
                'get' => [
                    'summary' => 'get portal record',
                    'tags' => [$tag],
                    'security' => [ [ 'bearerAuth' => [] ] ],
                    'parameters' => [
                        [ '$ref' => '#/components/parameters/acceptsJson' ]
                    ],
                    'responses' => [
                        "\"200\"" => $objMessage("return $modelName records",$this->getSearchResponse()),
                        "\"401\"" => $unauthorized
                    ]
                ]
            ];

        if($this->JSON['portalAccess']['update'])
            $docs['paths']["/$prefix/portal/update/"] = [
                'put' => [
                    'summary' => 'update portal record',
                    'tags' => [$tag],
                    'requestBody' => $this->getRequestBody(),
                    'security' => [ [ 'bearerAuth' => [] ] ],
                    'parameters' => [
                        [ '$ref' => '#/components/parameters/acceptsJson' ]
                    ],
                    'responses' => [
                        "\"204\"" => $message("$modelName update message",null),
                        "\"401\"" => $unauthorized
                    ]
                ]
            ];

        if($this->JSON['portalAccess']['create'])
            $docs['paths']["/$prefix/portal/create/"] = [
                'post' => [
                    'summary' => 'create portal record',
                    'tags' => [$tag],
                    'requestBody' => $this->getRequestBody(),
                    'security' => [ [ 'bearerAuth' => [] ] ],
                    'parameters' => [ [ '$ref' => '#/components/parameters/acceptsJson' ] ],
                    'responses' => [
                        "\"201\"" => $message("$modelName created message","$prefix successfully created."),
                        "\"401\"" => $unauthorized
                    ]
                ]
            ];

        if($this->JSON['portalAccess']['delete'])
            $docs['paths']["/$prefix/portal/delete/"] = [
                'delete' => [
                    'summary' => 'delete portal record',
                    'tags' => [$tag],
                    'requestBody' => $this->getRequestBody(),
                    'security' => [ [ 'bearerAuth' => [] ] ],
                    'parameters' => [
                        [ '$ref' => '#/components/parameters/acceptsJson' ],
                        [
                            'in' => 'path',
                            'name' => 'id',
                            'required' => true,
                            'schema' => ['type' => 'integer'],
                            'description' => 'primary key'
                        ]
                    ],
                    'responses' => [
                        "\"204\"" => $message("$modelName update message",null),
                        "\"401\"" => $unauthorized
                    ]
                ]
            ];

        $returnDocs = Yaml::dump($docs, 12, 2);

        return $returnDocs;
    }

    /**
     * Parsing Definition from entity
     * 
     * @return string
     */
    private function parseDefinition($def){
        $splitStr = explode(':',$def);
        $func = $splitStr[0];
        $param = isset($splitStr[1])?$splitStr[1]:null;

        $returnParam = null;
        if($param != null) {
            if( strpos($param,',') !== false && $func != 'double') {
                $appendTo = '[';
                $arrParam = explode(',', $param);

                foreach ($arrParam as $item) {
                    $appendTo .="'$item',";
                }
                $appendTo = trim($appendTo, ",");
                $appendTo .= ']';

                $returnParam = $appendTo;
            }else {
                $returnParam = $param;

                if($func != 'string' && $func != 'double')
                    $returnParam = match ($param) {
                        'true', 'false', '1', '0' => $param,
                        default => "'$param'"
                    };
            }
        }

        return [
            'function' => $func,
            'param' => $returnParam
        ];
    }

    private function renderDefinition($def){
        $splitStr = explode(':',$def);
        $func = $splitStr[0];
        $param = isset($splitStr[1])?$splitStr[1]:null;

        $returnParam = null;
        if($param != null) {
            if( strpos($param,',') !== false && $func != 'double') {
                $arrParam = explode(',', $param);
                $returnParam = $arrParam;
            }else {
                $returnParam = $param;

                if($func != 'string' && $func != 'double')
                    $returnParam = match ($param) {
                        'true', 'false', '1', '0' => $param,
                        default => "'$param'"
                    };
            }
        }

        return [
            'function' => $func,
            'param' => $returnParam
        ];
    }

    private function getLogSetting(){
        $logSetting = $this->JSON['logSetting'];
        if($logSetting == null)
            return null;

        $splitStr = explode(':',$logSetting);
        $func = $splitStr[0];
        $param = isset($splitStr[1])?$splitStr[1]:null;

        if($param != null && $func != 'assignTo')
            $param = null;

        return [
            'isDefault' => $param == null,
            'assignTo' => $param
        ];
    }

    public function getRequestBody(){
        // init variable
        $entities = $this->JSON['entity'];
        $required = [];
        $properties = [];

        foreach ($entities as $columnName => $specs) {
            if(!in_array('nullable', $specs['additionalDefinition']))
                $required[] = $columnName;

            $parsedDef = $this->renderDefinition($specs['definition']);

            $properties[$columnName] = match($parsedDef['function']) {
                'enum' => [
                    'type' => 'string',
                    'enum' => $parsedDef['param']
                ],
                'relatedTo' => ['type' => 'integer'],
                'array' => ['type' => 'array'],
                'decimal' => ['type' => 'number'],
                'double' => ['type' => 'number'],
                default => [
                    'type' => $parsedDef['function']
                ]
            };
        }
        return [
            'required' => true,
            'content' => [
                'application/json' => [
                    'schema' => [
                        'type' => 'object',
                        'properties' => $properties,
                        'required' => $required
                    ]
                ]
            ]
        ];
    }

    public function getSearchResponse(){
        $data = [
            'id' => 1,
        ];

        foreach ($this->JSON['entity'] as $columnName => $specs) {
            $parsedDef = $this->renderDefinition($specs['definition']);
            $data[$columnName] = $parsedDef['function'];
        }

        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');

        return $data;
    }


    /**
     * Get Validation
     * 
     * @return string
     */
    private function getValidation(array $specs){
        // init variable
        $returnValidation = '';

        if(in_array('nullable', $specs['additionalDefinition']))
            $returnValidation .= 'nullable|';
        else
            $returnValidation .= 'required|';

        $def = $this->renderDefinition($specs['definition']);

        $strParam = '';
        if(is_array($def['param'])) {
            foreach ($def['param'] as $item) {
                $strParam .= $item.',';
            }
            $strParam = trim($strParam, ",");
        }

        $returnValidation .= match ($def['function']) {
            'enum' => "in:$strParam",
            'date' => 'date_format:Y-m-d',
            'double' => 'numeric',
            'array' => 'array',
            'timestamp' => 'date_format:Y-m-d H:i:s',
            'relatedTo' => 'exists:'.trim($def['param'], '\'').',id',
            default => $def['param'] != null?'max:'.$def['param']:''
        };

        $returnValidation .= '|'.$specs['additionalValidation'];

        $returnValidation = trim($returnValidation, "|");
        return $returnValidation;
    }

    private function getPermissionKey(){
        $pieces = preg_split('/(?=[A-Z])/',$this->JSON['modelName']);
        $key = '';
        foreach ($pieces as $piece) {
            $key .=strtolower($piece).' ';
        }
        $key = trim($key, " ");

        return $key;
    }

    private function getStrFields(){
        $returnStr = "";
        foreach ($this->JSON['entity'] as $columnName => $def) {
            if($def['definition'] != 'array')
                $returnStr .= "$columnName,";
        }

        return rtrim($returnStr, ',');
    }

    public function getArrayFields(){
        $fields = [];

        foreach ($this->JSON['entity'] as $columnName => $def) {
            if($def['definition'] == 'array')
                $fields[] = $columnName;
        }

        return $fields;
    }
}
