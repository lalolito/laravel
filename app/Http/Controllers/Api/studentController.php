<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Student;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::all();
        
        if ($students->isEmpty()) {
            return response()->json(['message' => 'No hay estudiantes registrados'], 404);
        }

        return response()->json($students, 200); // Devuelve la lista de estudiantes
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'lenguaje' => 'required'
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error al guardar el estudiante',
                'errors' => $validator->errors()
            ];
            return response()->json($data, 400);
        }

        $student = Student::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'lenguaje' => $request->lenguaje
        ]);

        if (!$student) {
            return response()->json([
                'status' => '404',
                'message' => 'No se pudo guardar el estudiante'
            ], 404);
        }

        return response()->json([
            'student' => $student,
            'status' => 201
        ], 201); 
    }
   
    public function show($id) {
        $student = Student::find($id);

        if (!$student) {
            return response()->json([
                'status' => '404',
                'message' => 'No se encontro el estudiante'
            ], 404);
        }

        return response()->json([
            'student' => $student,
            'status' => 200
        ], 200);   
    }
   
    public function update(Request $request, $id) {
    $student = Student::find($id);
    if (!$student) {
        $data = [
            'message' => 'No se encontró el estudiante',
            'status' => 404
        ];
        return response()->json($data, 404);
    }

    $validator = Validator::make($request->all(), [
        'name' => 'required',
        'email' => 'required|email|unique:students,email,' . $student->id,
        'phone' => 'required|numeric',
        'lenguaje' => 'required',
    ]);

    if ($validator->fails()) {
        $data = [
            'message' => 'Error en los datos',
            'errors' => $validator->errors(),
            'status' => 400
        ];
        return response()->json($data, 400); 
    }


    $student->name = $request->name;
    $student->email = $request->email; 
    $student->phone = $request->phone;
    $student->lenguaje = $request->lenguaje;
    $student->save();

    $data = [
        'message' => 'Estudiante actualizado correctamente',
        'student' => $student,
        'status' => 200
    ];
    return response()->json($data, 200);
}

   public function destroy($id) {

    $student = Student::find($id);
    if (!$student) {
        $data = [
            'message' => 'No se encontró el estudiante',
            'status' => 404
        ];
        return response()->json($data, 404);
    }

    $student->delete();
        $data = [        
        'message' => 'El estudiante se eliminó correctamente', 
        'status' => 200,
    ];
    return response()->json($data, 200);
}


}