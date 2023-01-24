<?php

namespace App\Models;

use App\Models\Employee;
use App\Traits\Scopes\ModelScope;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use App\Traits\Attributes\ModelAttribute;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable, HasRoles, ModelScope, ModelAttribute;

    // for roles and permissions
    protected $guard_name = 'api';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'isActive',
        'shouldChange',
        'isForgotPassword'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'isActive' => 'boolean',
        'shouldChange' => 'boolean',
        'isForgotPassword' => 'boolean',
    ];

    // Rest omitted for brevity

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * sync permissions by roles
     */
    public function syncPermissionByRole(){
        $permissions = $this->getPermissionsViaRoles()->pluck('name');
        $this->syncPermissions($permissions);
    }

    public function employee(){
        return $this->hasOne(Employee::class);
    }

    public static function findByEmail($email){
        return self::where('email', $email)->first();
    }

    public function getRoleAttribute()
    {
        return $this->roles()->first()?->name;
    }

    public function getPermissionsArrayAttribute()
    {
        return $this->permissions()->pluck('name');
    }

    public function getEmployeeNameAttribute()
    {
        return $this->employee?->name;
    }

    public function getEmployeeNumberAttribute()
    {
        return $this->employee?->employee_number;
    }
}
