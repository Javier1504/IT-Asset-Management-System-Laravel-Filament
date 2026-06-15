<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\BelongsToCompany;

class InternalNote extends Model
{
    use HasFactory;
    use BelongsToCompany;
protected $fillable=['company_id','stock_opname_id','stock_opname_item_id','created_by','type','priority','due_date','status','content'];
protected $casts=['due_date'=>'date'];
public function stockOpname(){return $this->belongsTo(StockOpname::class);}
public function item(){return $this->belongsTo(StockOpnameItem::class,'stock_opname_item_id');}
public function creator(){return $this->belongsTo(User::class,'created_by');}
}
