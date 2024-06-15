<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryModel extends Model
{
    use HasFactory, HasUuids;
    
    protected $table = 'categories';
    protected $fillable = [
        'name'
    ];

    public function posts()
    {
        return $this->hasMany(PostModel::class, 'category_id', 'id');
    }
}
