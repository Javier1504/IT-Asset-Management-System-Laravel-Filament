<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable;

    public const ROLE_SUPER_ADMIN = 'super_admin';
    public const ROLE_ADMIN = 'admin';
    public const ROLE_MANAGER = 'manager';
    public const ROLE_EMPLOYEE = 'employee';

    protected $fillable = [
        'company_id',
        'name',
        'employee_number',
        'email',
        'password',
        'role',
        'status',
        'job_title',
        'job_family',
        'team',
        'phone',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->status === 'active'
            && in_array($this->role, [self::ROLE_SUPER_ADMIN, self::ROLE_ADMIN, self::ROLE_MANAGER, self::ROLE_EMPLOYEE, 'user', 'pegawai'], true);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function endUserAssets()
    {
        return $this->hasMany(EndUserAsset::class);
    }

    public function requestedAssetRequests()
    {
        return $this->hasMany(AssetRequest::class, 'requested_by');
    }

    public function targetAssetRequests()
    {
        return $this->hasMany(AssetRequest::class, 'target_user_id');
    }

    public function stockOpnameAssignments()
    {
        return $this->hasMany(StockOpnameUser::class);
    }

    public function matrixSubTeams()
    {
        return $this->belongsToMany(MatrixSubTeam::class, 'matrix_sub_team_members')
            ->withPivot(['role_label', 'is_leader'])
            ->withTimestamps();
    }

    public function isAdmin(): bool
    {
        return in_array($this->role, [self::ROLE_SUPER_ADMIN, self::ROLE_ADMIN], true);
    }

    public function isManager(): bool
    {
        return in_array($this->role, [self::ROLE_SUPER_ADMIN, self::ROLE_ADMIN, self::ROLE_MANAGER], true);
    }

    public function isEmployee(): bool
    {
        return in_array($this->role, [self::ROLE_EMPLOYEE, 'user', 'pegawai'], true);
    }
}
