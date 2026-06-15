<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class StockOpnameTeam extends Model
{
    use HasFactory;
    protected $fillable=['stock_opname_id','team','matrix_sub_team_id'];
public function stockOpname(){return $this->belongsTo(StockOpname::class);}
public function matrixSubTeam(){return $this->belongsTo(MatrixSubTeam::class);}
public function users(){return $this->hasMany(StockOpnameUser::class);}
}
