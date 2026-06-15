<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\BelongsToCompany;

class AssetInstallation extends Model
{
    use HasFactory;
    use BelongsToCompany;
protected $fillable=['company_id','asset_id','installed_for','location_id','installed_at','status','notes'];
protected $casts=['installed_at'=>'date'];
public function asset(){return $this->belongsTo(Asset::class);}
public function user(){return $this->belongsTo(User::class,'installed_for');}
public function location(){return $this->belongsTo(Location::class);}
}
