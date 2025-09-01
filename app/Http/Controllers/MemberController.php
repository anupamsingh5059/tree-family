<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
  


     public function getTree($id)
    {
        $root = Member::find($id);
        if(!$root) return response()->json(['error'=>'Member not found'],404);

        $relations = [
            'father' => Member::where('parent_id',$id)->where('relation','father')->first(),
            'mother' => Member::where('parent_id',$id)->where('relation','mother')->first(),
            'spouse' => Member::where('parent_id',$id)->where('relation','spouse')->first(),
            'siblings' => Member::where('parent_id',$root->parent_id)
                                ->where('id','!=',$id)
                                ->where('relation','sibling')->get(),
            'children' => Member::where('parent_id',$id)->where('relation','child')->get()
        ];

        return response()->json([
            'root'=>$root,
            'relations'=>$relations
        ]);
    }
 
}
// C:\Users\payni\OneDrive\Documents\WindowsPowerShell\Microsoft.PowerShell_profile
