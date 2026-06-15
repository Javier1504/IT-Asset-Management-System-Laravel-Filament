<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\BelongsToCompany;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssetOfferRequest extends Model
{
    use HasFactory;
    use BelongsToCompany, SoftDeletes;
protected $fillable=['company_id','request_number','item_name','item_category','required_specification','quantity','estimated_unit_budget','estimated_total_budget','needed_date','pic_user_id','status','notes'];
protected $casts=['needed_date'=>'date','estimated_unit_budget'=>'decimal:2','estimated_total_budget'=>'decimal:2'];
public function pic(){return $this->belongsTo(User::class,'pic_user_id');}
public function offers(){return $this->hasMany(VendorOffer::class);}
}
