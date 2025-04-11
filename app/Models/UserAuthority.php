<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
        'authority_id'
    ];
}
