<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;

class MemberController extends Controller
{
    public function viewTree($slug, $relation = null)
    {
        $slug = strtolower($slug);
        $member = Member::whereRaw('LOWER(slug) = ?', [$slug])->firstOrFail();

        return view('tree', [
            'default_member' => $member
        ]);
    }

    public function getTree($slug)
    {
        $slug = strtolower($slug);
        $member = Member::whereRaw('LOWER(slug) = ?', [$slug])->firstOrFail();

        $relations = [
            'father'   => $member->children()->where('relation', 'Father')->first(),
            'mother'   => $member->children()->where('relation', 'Mother')->first(),
            'spouse'   => $member->children()->where('relation', 'Spouse')->first(),
            'siblings' => $member->siblings()->get(),
            'children' => $member->children()->where('relation', 'Child')->get(),
        ];

        $addHasMore = function($m){
            if(!$m) return null;
            return [
                'id' => $m->id,
                'slug' => $m->slug,
                'name' => $m->name,
                'image' => $m->image,
                'relation' => $m->relation,
                'has_more' => $m->children()->count() > 0
            ];
        };

        $root = $addHasMore($member);

        $relations = [
            'father' => $addHasMore($relations['father']),
            'mother' => $addHasMore($relations['mother']),
            'spouse' => $addHasMore($relations['spouse']),
            'siblings' => $relations['siblings']->map($addHasMore),
            'children' => $relations['children']->map($addHasMore)
        ];

        return response()->json([
            'root' => $root,
            'relations' => $relations
        ]);
    }
}
