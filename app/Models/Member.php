<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $table = 'members';
    protected $fillable = ['name', 'parent_id', 'relation', 'image'];

    // 🔹 Parent (jiska ye child hai)
    public function parent()
    {
        return $this->belongsTo(Member::class, 'parent_id');
    }

    // 🔹 Children (jo iske child hain)
    public function children()
    {
        return $this->hasMany(Member::class, 'parent_id');
    }

    // 🔹 Father (relation = Father)
    public function father()
    {
        return $this->children()->where('relation', 'Father');
    }

    // 🔹 Mother (relation = Mother)
    public function mother()
    {
        return $this->children()->where('relation', 'Mother');
    }

    // 🔹 Spouse (relation = Spouse)
    public function spouse()
    {
        return $this->children()->where('relation', 'Spouse');
    }

    // 🔹 Siblings (same parent ke children but relation = Sibling)
    public function siblings()
    {
        return Member::where('parent_id', $this->parent_id)
            ->where('id', '!=', $this->id)
            ->where('relation', 'Sibling');
    }
}
