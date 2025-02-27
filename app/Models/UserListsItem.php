<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserListsItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'user_lists_items';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_list_id',
        'header',
        'description',
        'status'
    ];
}
