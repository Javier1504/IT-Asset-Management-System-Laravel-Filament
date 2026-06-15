<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\BelongsToCompany;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssetDisposal extends Model
{
    use HasFactory;
    use BelongsToCompany, SoftDeletes;
protected $fillable=['company_id','document_number','method','disposal_date','location','status','notes'];
protected $casts=['disposal_date'=>'date'];
public function items(){return $this->hasMany(AssetDisposalItem::class);}
}
