<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Classes;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::select('students.*','classes.name as class_name')->latest('id')
                    ->leftJoin('classes','classes.id','=','students.student_class')
                    ->paginate(5);
        return view('index',['students'=>$students]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $class_list = Classes::latest()->get();
        return view('create',['classes'=>$class_list]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'class' => 'required|integer',
            'age' => 'required|integer|max:50|min:18',
            'gender' => 'required|string',
        ]);

        $student = new Student;
        $student->student_name = $request->name;
        $student->student_class = $request->class;
        $student->student_age = $request->age;
        $student->student_gender = $request->gender;
        $student->save();
        return '1';
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $class_list = Classes::latest()->get();
        $student = Student::find($id);

        return view('edit',['student'=>$student,'classes'=>$class_list]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'class' => 'required|integer',
            'age' => 'required|integer|max:50|min:18',
            'gender' => 'required|string',
        ]);

        $student= Student::where(['id'=>$id])->update([
            'student_name'=>$request->input('name'),
            'student_class'=>$request->input('class'),
            'student_age'=>$request->input('age'),
            'student_gender'=>$request->input('gender'),
        ]);
        return '1';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $destroy = Student::where('id',$id)->delete();
        return $destroy;
    }
}
