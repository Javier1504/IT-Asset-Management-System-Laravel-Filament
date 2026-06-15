<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class AssetDisposalItem extends Model
{
    use HasFactory;
    protected $fillable=['asset_disposal_id','asset_id','sparepart_id','quantity','manual_type','manual_brand','manual_number','notes'];
public function disposal(){return $this->belongsTo(AssetDisposal::class,'asset_disposal_id');}
public function asset(){return $this->belongsTo(Asset::class);}
public function sparepart(){return $this->belongsTo(Sparepart::class);}
}
