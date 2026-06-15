<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class SecurityPeripheral extends Model
{
    use HasFactory;
    protected $fillable=['asset_id','peripheral_type','placement'];
public function asset(){return $this->belongsTo(Asset::class);}
}
