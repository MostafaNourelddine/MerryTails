<?php
namespace App\Models;

use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;
    protected $fillable = ['image_path', 'item_id'];
    public function item()
    {
        return $this->belongsTo(Item::class);
    }

}