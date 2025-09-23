<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;

class MemberController extends Controller
{
    // This method loads the Blade view for a given member
    public function viewTree($id = 1, $relation = null, Request $request)
    {
        $member = Member::findOrFail($id);

        // You can pass member info to the Blade view
        return view('tree', [
            'member_id' => $member->id,
            'member_name' => $member->name,
            'relation' => $relation ?? 'self'
        ]);
    }

    // Existing method for JSON response
    public function getTree($id)
    {
        $member = Member::findOrFail($id);

        $relations = [
            'father'   => $member->children()->where('relation', 'Father')->first(),
            'mother'   => $member->children()->where('relation', 'Mother')->first(),
            'spouse'   => $member->children()->where('relation', 'Spouse')->first(),
            'siblings' => $member->siblings()->get(),
            'children' => $member->children()->where('relation', 'Child')->get(),
        ];

        $addHasMore = function ($m) {
            if (!$m) return null;
            return [
                'id' => $m->id,
                'name' => $m->name,
                'image' => $m->image,
                'relation' => $m->relation,
                'has_more' => $m->children()->count() > 0
            ];
        };

        $root = $addHasMore($member);

        $relations = [
            'father'   => $addHasMore($relations['father']),
            'mother'   => $addHasMore($relations['mother']),
            'spouse'   => $addHasMore($relations['spouse']),
            'siblings' => $relations['siblings']->map($addHasMore),
            'children' => $relations['children']->map($addHasMore),
        ];

        return response()->json([
            'root' => $root,
            'relations' => $relations
        ]);
    }
}
