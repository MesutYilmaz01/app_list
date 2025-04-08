<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class DislikeComment extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'dislike_comments';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'comment_id'
    ];

    public function comment(): BelongsTo
    {
        return $this->belongsTo(Comment::class, 'comment_id', 'id');
    }
}
