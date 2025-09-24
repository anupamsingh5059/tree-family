<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Member;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Str;
class FamilyTreeController extends Controller
{
    //


    public function index() {
		  return view('dashboard.bashbord');
	}
	// handle fetch all tree ajax request
	public function fetchAll() {
		// $emps = Member::all();
		$emps = Member::all();
		// $emps = Member::orderBy('id', 'DESC')->get();

		// dd($emps);
		$output = '';
		if ($emps->count() > 0) {
			$output .= '<table class="table table-striped table-sm text-center align-middle">
            <thead>
              <tr>
                <th>ID</th>
              
                <th>Name</th>
				 <th>IMAGE</th>
                <th>Relation</th>
                <th>Parents_ID</th>
              
                <th>Action</th>
              </tr>
            </thead>
            <tbody>';
			foreach ($emps as $emp) {
				$output .= '<tr>
                <td>' . $emp->id . '</td>
            
                <td>' . $emp->name .'</td>
				 <td><img src="uploads/' . $emp->image . '" width="100" class="img-thumbnail rounded-circle"></td>
                <td>' . $emp->relation . '</td>
                <td>' . $emp->parent_id . '</td>
              
                <td>
                  <a href="#" id="' . $emp->id . '" class="text-success mx-1 editIcon" data-bs-toggle="modal" data-bs-target="#editEmployeeModal"><i class="bi-pencil-square h4"></i></a>
                  <a href="#" id="' . $emp->id . '" class="text-danger mx-1 deleteIcon"><i class="bi-trash h4"></i></a>
                </td>
              </tr>';
			}
			$output .= '</tbody></table>';
			echo $output;
		} else {
			echo '<h1 class="text-center text-secondary my-5">No record present in the database!</h1>';
		}
	}
	// handle insert a new tree ajax request
	public function store(Request $request) {

					$validator = Validator::make($request->all(), [
					'name' => 'required|max:255',
					'relation' => 'required|max:255',
					'parent_id' => 'required',
				     'image' => 'required|image|mimes:jpg,jpeg,png,gif|max:3048',
				]);

				if ($validator->fails()) {
					return response()->json([
						'status' => false,
						'errors' => $validator->errors()
					], 422);
				}

				// save image
				$fileName = time() . '.' . $request->image->extension();
				$request->image->move(public_path('uploads'), $fileName);

				// save database (example)
				Member::create([
					'name' => $request->name,
					'relation' => $request->relation,
					'parent_id' => $request->parent_id,
					'image' => $fileName,
					 'slug' => Str::slug($request->name) // <-- automatically convert name to slug
				]);

				return response()->json([
					'status' => true,
					'message' => 'Family member added successfully!'
				]);


		  
}
	// handle edit an tree ajax request
	public function edit(Request $request) {
		$id = $request->id;
		$emp = Member::find($id);
		return response()->json($emp);
	}
	// handle update an tree ajax request
	public function update(Request $request) {
        
					$validator = Validator::make($request->all(), [
					'name' => 'required|max:255',
					'relation' => 'required|max:255',
					'parent_id' => 'required',
					// image optional rakha hai update me
					'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
					
				]);

				if ($validator->fails()) {
					return response()->json([
						'status' => false,
						'errors' => $validator->errors()
					], 422);
				}

    // record find
             $family = Member::findOrFail($request->emp_id);
             	// $emp = Employee::find($request->emp_id);
			//  dd($family);

				// agar image aayi hai to update karo
				if ($request->hasFile('image')) {
					// purani image delete karo (agar chahiye to)
					if ($family->image && file_exists(public_path('uploads/'.$family->image))) {
						unlink(public_path('uploads/'.$family->image));
					}

					// nayi image save
					$fileName = time().'.'.$request->image->extension();
					$request->image->move(public_path('uploads'), $fileName);
					$family->image = $fileName;
				}

				// baaki fields update
				$family->name = $request->name;
				$family->relation = $request->relation;
				$family->parent_id = $request->parent_id;
				$family->slug = Str::slug($request->name) ;// <-- automatically convert name to slug
				$family->save();

				return response()->json([
					'status' => true,
					'message' => 'Family member updated successfully!',
					'data' => $family
				]);
	}
	// handle delete an tree ajax request
	public function delete(Request $request) {
		$id = $request->id;
		$emp = Member::find($id);
		$emp->delete();
		
	}


	
}
