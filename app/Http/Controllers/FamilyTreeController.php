<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Member;
class FamilyTreeController extends Controller
{
    //


    public function index() {
		  return view('dashboard.bashbord');
	}
	// handle fetch all eamployees ajax request
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
	// handle insert a new employee ajax request
	public function store(Request $request) {
		// $file = $request->file('avatar');
		// $fileName = time() . '.' . $file->getClientOriginalExtension();
		// $file->storeAs('public/images', $fileName);
		$empData = ['name' => $request->name, 'relation' => $request->relation,  'parent_id' => $request->parent_id];
		Member::create($empData);
		return response()->json([
			'status' => 200,
		]);
	}
	// handle edit an employee ajax request
	public function edit(Request $request) {
		$id = $request->id;
		$emp = Member::find($id);
		return response()->json($emp);
	}
	// handle update an employee ajax request
	public function update(Request $request) {
		$fileName = '';
		$emp = Member::find($request->emp_id);
		// dd($emp);
		
		$empData = ['name' => $request->name, 'relation' => $request->relation,  'parent_id' => $request->parent_id];
		$emp->update($empData);
		return response()->json([
			'status' => 200,
		]);
	}
	// handle delete an employee ajax request
	public function delete(Request $request) {
		$id = $request->id;
		$emp = Member::find($id);

		$emp->delete();
		
	}
}
