<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
class CustomtreeController extends Controller
{
    //

     public function getFamilyOne($id)
    {
        $self = Member::find($id);

        if (!$self) {
            return response()->json(['error' => 'Member not found']);
        }

        // Parents (by parent_id)
        $father = Member::where('relation', 'Father')->first();
        $mother = Member::where('relation', 'Mother')->first();

        // Spouse
        $spouse = $self->spouse_id ? Member::find($self->spouse_id) : null;

        // Siblings (same parent but different id)
        $siblings = Member::where('parent_id', $self->parent_id)
                                ->where('id', '!=', $self->id)
                                ->get();

        // Children
        $children = Member::where('parent_id', $self->id)->get();

        return response()->json([
            'self'     => $self,
            'father'   => $father,
            'mother'   => $mother,
            'spouse'   => $spouse,
            'siblings' => $siblings,
            'children' => $children,
        ]);
    }
}
