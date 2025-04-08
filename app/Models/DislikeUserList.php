<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class DislikeUserList extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'dislike_user_lists';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'user_list_id'
    ];

    public function userList(): BelongsTo
    {
        return $this->belongsTo(UserList::class, 'user_list_id', 'id');
    }
}
