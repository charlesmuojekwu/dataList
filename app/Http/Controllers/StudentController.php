<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\student;

class StudentController extends Controller
{
    public function index()
    {
        return view('student.index');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name'=>'required|max:191',
            'email'=>'required|email|max:191',
            'phone'=>'required|max:191',
            'course'=>'required|max:191',
        ]);

        if ($validator->fails()) {
           return response()->json([
               'status'=>400,
               'errors'=>$validator->messages(),
           ]);
        }
        else
        {
            $student = new Student;
            $student->name = $request->input('name');
            $student->phone = $request->input('phone');
            $student->email = $request->input('email');
            $student->course = $request->input('course');
            $student->save();
            return response()->json([
                'status'=>200, 
                'message'=>'student added successfully',
            ]);
        }


    
        
    }

    public function fetchStudent()
    {
        $students = Student::all();
        return response()->json([
            'students'=> $students,
            'status'=>200, 
        ]);
    }
}
