<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FamilyTree extends Model
{
    // Fillable fields
     protected $table = 'members';
    protected $fillable = ['name', 'image', 'relation', 'parent_id', 'slug'];

    // Relation: Children of this member
    public function children()
    {
        return $this->hasMany(FamilyTree::class, 'parent_id');
    }

    // Relation: Parent of this member
    public function parent()
    {
        return $this->belongsTo(FamilyTree::class, 'parent_id');
    }
}
