<?php

namespace App\Http\Controllers;

use App\Models\Member;

class MemberController extends Controller
{
    public function getTree($id)
    {
        $member = Member::findOrFail($id);

        // Relations collect karo
        $relations = [
            'father'   => $member->children()->where('relation', 'Father')->first(),
            'mother'   => $member->children()->where('relation', 'Mother')->first(),
            'spouse'   => $member->children()->where('relation', 'Spouse')->first(),
            'siblings' => $member->siblings()->get(),
            'children' => $member->children()->where('relation', 'Child')->get(),
        ];

        // Helper: has_more flag add karne ke liye
        $addHasMore = function ($m) {
            if (!$m) return null;
            return [
                'id' => $m->id,
                'name' => $m->name,
                'image' => $m->image,
                'relation' => $m->relation,
                'has_more' =>
                    $m->children()->count() > 0
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
