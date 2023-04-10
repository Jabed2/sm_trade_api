<?php

namespace App\Http\Controllers\Api;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;




class StudentsController extends Controller
{
    //
    public function index()
    {
        $students = Student::all();
        if ($students->count() > 0) {
            $data = [
                'status' => 200,
                'students' => $students
            ];
            return response()->json($data, 200);
        } else {
            return response()->json([
                'status' => 404,
                'students' => "No Record Found"
            ], 404);
        }

    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:191',
            'course' => 'required|string|max:50',
            'email' => 'required|string|max:100',
            'phone' => 'required|digits:10',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ], 422);
        } else {
            $student = Student::create([
                'name' => $request->name,
                'course' => $request->course,
                'email' => $request->email,
                'phone' => $request->phone,
            ]);

        }
        if ($student) {
            return response()->json([
                'status' => 200,
                'message' => 'Studens Register Success',
            ], 200);
        } else {
            return response()->json([
                'status' => 500,
                'message' => 'Somethis is Wrong!',
            ], 500);
        }

    }


    public function show($id){
        $student = Student::find($id);
        if($student){
            return response()->json([
                'status' => 200,
                'student' => $student,
            ], 200);
        } else {
return response()->json([
                'status' => 404,
                'message' => 'No Record Found',
            ], 404);
        }
    }

    public function edit($id){
        $student = Student::find($id);
        if($student){
            return response()->json([
                'status' => 200,
                'student' => $student,
            ], 200);
        } else {
return response()->json([
                'status' => 404,
                'message' => 'No Record Found',
            ], 404);
        }
    }
    public function update( Request $request, int $id){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:191',
            'course' => 'required|string|max:50',
            'email' => 'required|string|max:100',
            'phone' => 'required|digits:10',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ], 422);
        } else {
            $student = Student::find($id);

            if($student){
                $student->update([
                    'name' => $request->name,
                    'course' => $request->course,
                    'email' => $request->email,
                    'phone' => $request->phone,
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => "Student Update Successful",
                ], 200);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'Student not found!',
                ], 404);
            }

           

        }
        

    }
public function delete($id){
    $student = Student::find($id);
    if($student){
      $student->delete();
      return response()->json([
        'status' => 200,
        'message' => "Student Delete Successful",
    ], 200);
    } else {
        return response()->json([
            'status' => 404,
            'message' => 'Student not found!',
        ], 404);
    }
}
}