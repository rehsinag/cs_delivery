<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserByBranch extends Model
{
    protected $table = 'usersByBranches';

    protected $fillable = ['userId', 'branchId'];

    public $timestamps = false;
}
