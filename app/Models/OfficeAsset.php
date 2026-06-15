<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OfficeAsset extends Model
{
    use HasFactory;
    use SoftDeletes;
protected $fillable=['asset_id','location_id','previous_status'];
public function asset(){return $this->belongsTo(Asset::class);}
public function location(){return $this->belongsTo(Location::class);}
}
