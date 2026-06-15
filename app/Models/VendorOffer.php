<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VendorOffer extends Model
{
    use HasFactory;
    use SoftDeletes;
protected $fillable=['asset_offer_request_id','vendor_id','vendor_name','offer_number','offer_date','valid_until','unit_price','total_price','warranty','delivery_estimation','document_path','status','notes'];
protected $casts=['offer_date'=>'date','valid_until'=>'date','unit_price'=>'decimal:2','total_price'=>'decimal:2'];
public function request(){return $this->belongsTo(AssetOfferRequest::class,'asset_offer_request_id');}
public function vendor(){return $this->belongsTo(Vendor::class);}
}
