<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    //
     protected $fillable = ['name', 'parent_id', 'relation'];
}
// php artisan make:seeder MemberSeeder