<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $root = Member::where('relation', 'self')->first();
        return view('family', compact('root'));
    }

     public function familytree()
    {
         $users = Member::all();
         return response()->json($users);
        //  return   response()->json([
        //     'success'=>'fetch records',
        //     'root'=>$root
        //  ]);
    }

   
    
    public function show( $id)
    {
        // $member = Member::findOrFail($id);

        // return response()->json([
        //     'member'   => $member,
        //     'father'   => Member::where('parent_id', $member->id)->where('relation', 'father')->first(),
        //     'mother'   => Member::where('parent_id', $member->id)->where('relation', 'mother')->first(),
        //     'spouse'   => Member::where('parent_id', $member->id)->where('relation', 'spouse')->first(),
        //     'children' => Member::where('parent_id', $member->id)->where('relation', 'child')->get(),
        //     'siblings' => Member::where('parent_id', $member->id)->where('relation', 'sibling')->get(),
        // ]);

       $user = Member::find($id);

        if (!$user) {
            return response()->json(['error' => 'Member not found'], 404);
        }

        // Relations load karna
        $relations = [
            'self' => $user,
            'spouse' => Member::where('parent_id', $id)->where('relation', 'spouse')->first(),
            'father' => Member::where('parent_id', $id)->where('relation', 'father')->first(),
            'mother' => Member::where('parent_id', $id)->where('relation', 'mother')->first(),
            'children' => Member::where('parent_id', $id)->where('relation', 'child')->get(),
            // 'husband' => Member::where('parent_id', $id)->where('relation', 'husband')->get(),
            'siblings' => Member::where('parent_id', $user->parent_id)
                                ->where('id', '!=', $id)
                                ->where('relation', 'sibling')
                                ->get()
        ];

        return response()->json($relations);
    }


 public function getTree($id)
    {
        $root = Member::find($id);
        if(!$root) return response()->json(['error'=>'Member not found'],404);

        $relations = [
            'father' => Member::where('parent_id',$id)->where('relation','father')->first(),
            'mother' => Member::where('parent_id',$id)->where('relation','mother')->first(),
            // 'husband' => Member::where('parent_id',$id)->where('relation','husband')->first(),
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
