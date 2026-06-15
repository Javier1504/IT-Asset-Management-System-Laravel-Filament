<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\BelongsToCompany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Asset extends Model
{
    use HasFactory;
    use BelongsToCompany, SoftDeletes;
protected $fillable = ['company_id','asset_type_id','asset_number','name','brand','model','serial_number','specification','purchase_date','purchase_price','cut_off_date','condition','status','notes','image_path'];
protected $casts=['purchase_date'=>'date','cut_off_date'=>'date','purchase_price'=>'decimal:2'];
public function company(){return $this->belongsTo(Company::class);}
public function assetType(){return $this->belongsTo(AssetType::class);}
public function endUserAsset(){return $this->hasOne(EndUserAsset::class);}
public function officeAsset(){return $this->hasOne(OfficeAsset::class);}
public function maintenances(){return $this->hasMany(AssetMaintenance::class);}
}
