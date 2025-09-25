<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;

class FamilyController extends Controller
{
    public function getnewtree()
    {
        $member = Member::first(); // Root member

        $father = $member->children()->where('relation','Father')->first();
        $mother = $member->children()->where('relation','Mother')->first();
        $spouse = $member->children()->where('relation','Spouse')->first();
        $children = $member->children()->where('relation','Child')->get();

        return view('tree-new', compact('member','father','mother','spouse','children'));
    }

    public function children($id)
    {
        $member = Member::findOrFail($id);
        $children = $member->children()->get()->map(function($child){
            return [
                'id' => $child->id,
                'name' => $child->name,
                'image' => $child->image,
                'has_more' => $child->children()->count() > 0
            ];
        });
        return response()->json($children);
    }
}
