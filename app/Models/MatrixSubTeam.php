<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class MatrixSubTeam extends Model
{
    use HasFactory;
    protected $fillable=['company_id','code','name','is_active'];
protected $casts=['is_active'=>'boolean'];
public function members(){return $this->hasMany(MatrixSubTeamMember::class);}
public function users(){return $this->belongsToMany(User::class,'matrix_sub_team_members')->withPivot(['role_label','is_leader'])->withTimestamps();}
}
