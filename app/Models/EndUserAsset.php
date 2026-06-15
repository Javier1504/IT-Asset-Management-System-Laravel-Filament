<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EndUserAsset extends Model
{
    use HasFactory;
    use SoftDeletes;
protected $fillable=['asset_id','user_id','classification','previous_status'];
public function asset(){return $this->belongsTo(Asset::class);}
public function user(){return $this->belongsTo(User::class);}
}
