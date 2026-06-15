<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\BelongsToCompany;

class Location extends Model
{
    use HasFactory;
    use BelongsToCompany;
protected $fillable = ['company_id','name','code','floor','description'];
public function company(){return $this->belongsTo(Company::class);}
}
