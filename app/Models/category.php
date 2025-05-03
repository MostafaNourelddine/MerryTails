<?php
namespace App\Models;

use App\Models\Items;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class category extends Model
{
    use HasFactory;

    protected $table    = 'category';
    protected $fillable = [
        'name',
        'description',
        'src',
    ];
    public function items()
    {
        return $this->hasMany(Items::class, 'cat_id');
    }
    public function getData()
    {
        $items = DB::table('category')->get();
    }
}
