<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class MatrixSubTeamMember extends Model
{
    use HasFactory;
    protected $fillable=['matrix_sub_team_id','user_id','role_label','is_leader'];
protected $casts=['is_leader'=>'boolean'];
public function subTeam(){return $this->belongsTo(MatrixSubTeam::class,'matrix_sub_team_id');}
public function user(){return $this->belongsTo(User::class);}
}
