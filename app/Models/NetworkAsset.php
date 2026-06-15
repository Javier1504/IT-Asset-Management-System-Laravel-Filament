<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class NetworkAsset extends Model
{
    use HasFactory;
    protected $fillable=['asset_id','ip_address','mac_address','network_role'];
public function asset(){return $this->belongsTo(Asset::class);}
}
