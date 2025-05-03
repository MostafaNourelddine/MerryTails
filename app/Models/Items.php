<?php
namespace App\Models;

use App\Models\category;
use App\Models\Img;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Items extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'name',
        'price',
        'description',
        'cat_id',
    ];
    public function images()
    {
        return $this->hasMany(Img::class, 'item_id');
    }
    public function category()
    {
        return $this->belongsTo(category::class, 'cat_id');
    }
}
