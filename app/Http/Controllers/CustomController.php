<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rules\Formvalidation;
use App\Rules\Uppercase;
use Illuminate\Support\Facades\Validator;
class CustomController extends Controller
{
    public function Customelogin()
    {

        return view('admin.addUser');
    }


    public function CustomePost(Request $req)
    {
     
           $req->validate([
                  'name'=>['required', new Uppercase],
                  'password'=>'required',
                  'email' => 'required|email|unique:users',
           ]);
       
    }
}
