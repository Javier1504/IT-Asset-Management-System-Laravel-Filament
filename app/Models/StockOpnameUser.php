<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class StockOpnameUser extends Model
{
    use HasFactory;
    protected $fillable=['stock_opname_id','stock_opname_team_id','user_id','team'];
public function stockOpname(){return $this->belongsTo(StockOpname::class);}
public function opnameTeam(){return $this->belongsTo(StockOpnameTeam::class,'stock_opname_team_id');}
public function user(){return $this->belongsTo(User::class);}
}
