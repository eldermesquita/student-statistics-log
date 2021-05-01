<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    public const ROLE_ADMIN = 'admin';
    public const ROLE_TEACHER = 'teacher';
    public const ROLE_GUEST = 'guest';
    public const ROLE_TECHNICAL_SPECIALIST = 'specialist';
    public const ROLE_ROOT = 'root';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'surname',
        'patronymic',
        'email',
        'password',
        'role',
        'username'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
        'abbreviated_name'
    ];

    public function session()
    {
        return $this->hasOne(Session::class);
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class);
    }

    public function scopeFullName(Builder $query, $fullName)
    {
        return $query->orWhereRaw("concat(surname, ' ', name, ' ', patronymic) like '%$fullName%' ");
    }

    public function scopeWorkers(Builder $query)
    {
        return $query->where('role', '=', User::ROLE_TEACHER)
            ->orWhere('role', '=', User::ROLE_ADMIN);
    }

    public function getAbbreviatedNameAttribute()
    {
        return "$this->surname $this->name $this->patronymic";
    }

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isTechnicalSpecialist(): bool
    {
        return $this->role === self::ROLE_TECHNICAL_SPECIALIST;
    }

    public function isTeacher(): bool
    {
        return $this->role === self::ROLE_TEACHER;
    }

    public function isRoot(): bool
    {
        return $this->role === self::ROLE_ROOT;
    }

    public function isGuest(): bool
    {
        return $this->role === self::ROLE_GUEST;
    }

    public function isSchoolWorker(): bool
    {
        return $this->isAdmin() || $this->isTeacher();
    }

    public function roleAlreadyBeenAssigned(string $role): bool
    {
        return $this->role === $role;
    }

    public static function getRoles(bool $withRootRole = false): array
    {
        $roles = [];

        if ($withRootRole) {
            $roles[User::ROLE_ROOT] = __('roles.root');
        }

        $roles[User::ROLE_ADMIN] = __('roles.admin');
        $roles[User::ROLE_GUEST] = __('roles.guest');
        $roles[User::ROLE_TEACHER] = __('roles.teacher');
        $roles[User::ROLE_TECHNICAL_SPECIALIST] = __('roles.technical_specialist');

        return $roles;
    }
}
