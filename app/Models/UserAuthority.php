<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserAuthority extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'user_authorities';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'owner_user_id',
        'authorized_user_id',
        'user_list_id',
        'authority_id',
    ];

    public function authorizedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'authorized_user_id', 'id');
    }

    public function ownerUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_user_id', 'id');
    }

    public function userList(): BelongsTo
    {
        return $this->belongsTo(UserList::class, 'user_list_id', 'id');
    }

    public function authority(): BelongsTo
    {
        return $this->belongsTo(Authority::class, 'authority_id', 'id');
    }
}
