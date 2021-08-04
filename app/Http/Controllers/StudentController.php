<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use DataTables;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       $students="";
        if ($request->ajax()) {
            $students = Student::latest()->get();
            return Datatables::of($students)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editProduct">Edit</a>';
   
                           $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteProduct">Delete</a>';
    
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
      
        return view('student',compact('students'));
    }

    public function store(Request $request)
    {
        Student::updateOrCreate(['id' => $request->product_id],
                ['name' => $request->name, 'email' => $request->email]);        
   
        return response()->json(['success'=>'Product saved successfully.']);
    }
     
   
    public function edit($id)
    {
        $product = Student::find($id);
        return response()->json($product);
    }
  


    
    public function destroy($id)
    {
        Student::find($id)->delete();
     
        return response()->json(['success'=>'Product deleted successfully.']);
    } 


}
