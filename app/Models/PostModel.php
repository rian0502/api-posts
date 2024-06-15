<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostModel extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'posts';
    protected $fillable = [
        'title',
        'content',
        'image',
        'category_id',
        'user_id'
    ];

    public function category()
    {
        return $this->belongsTo(CategoryModel::class, 'category_id', 'id', 'categories');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id', 'users');
    }
}
