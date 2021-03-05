<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Transformers\CommentTransformer;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
        'comment_parent_id',
        'user_id'
    ];

    public $transformer = CommentTransformer::class;

    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function parent()
    {
        return $this->belongsTo('App\Models\Comment', 'comment_parent_id');
    }

    public function replies()
    {
        return $this->hasMany('App\Models\Comment', 'comment_parent_id');
    }
}
