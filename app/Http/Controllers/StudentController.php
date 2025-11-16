<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    /**
     * Muestra una lista paginada de todos los estudiantes activos.
     */
    public function index(Request $request)
    {
        // 1. Inicia la consulta base
        $query = Student::withTrashed()->latest();

        // 2. Obtiene el término de búsqueda de la URL (?search=...)
        if ($search = $request->input('search')) {
            // Agrupa las condiciones OR para que el filtro sea correcto
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', '%' . $search . '%') // Busca en nombre
                    ->orWhere('email', 'LIKE', '%' . $search . '%') // Busca en email
                    ->orWhere('student_code', 'LIKE', '%' . $search . '%'); // Busca en código
            });
        }

        // 3. Paginación
        $students = $query->paginate(10)->withQueryString();

        return view('students', compact('students'));
    }

    /**
     * Muestra el formulario para crear un nuevo estudiante.
     */
    public function create() {}

    /**
     * Almacena un estudiante recién creado en la base de datos.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'student_code' => ['required', 'string', 'unique:students,student_code', 'max:255'],
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', 'unique:students,email', 'max:255'],
                'semester' => ['nullable', 'string', 'max:255'],
                'phone' => ['nullable', 'string', 'max:255'],
            ]);

            Student::create($validated);

            return redirect()->route('students.index')
                ->with('success', 'Alumno creado con éxito.');
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    /**
     * Muestra la información de un estudiante específico.
     */
    public function show(Student $student) {}

    /**
     * Muestra el formulario para editar un estudiante.
     */
    public function edit(Student $student) {}

    /**
     * Actualiza la información de un estudiante en la base de datos.
     */
    public function update(Request $request)
    {
        $student = Student::withTrashed()->find($request['id']);

        // Usamos Rule::unique para que ignore al estudiante que estamos editando
        $validated = $request->validate([
            'student_code' => ['required', 'string', Rule::unique('students', 'student_code')->ignore($student->id), 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique('students', 'email')->ignore($student->id), 'max:255'],
            'semester' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
        ]);

        $student->update($validated);

        return redirect()->route('students.index')
            ->with('success', 'Información de alumno actualizada con éxito.');
    }

    /**
     * Elimina (suavemente) un estudiante de la base de datos.
     */
    public function destroy(Student $student)
    {
        try {
            // Con softDeletes, este método simplemente establece el campo 'deleted_at'.
            // El registro no se elimina físicamente.
            $student->delete();

            return redirect()->route('students.index')
                ->with('success', 'Alumno desactivado con éxito.');
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    public function restore($student)
    {
        // 1. Encuentra el registro, incluyendo los eliminados (withTrashed)
        $student = Student::withTrashed()->find($student);
        if (!$student) {
            return redirect()->route('students.index')->with('error', 'Alumno no encontrado.');
        }

        // 2. Ejecuta el método restore() para poner deleted_at a NULL
        $student->restore();

        return redirect()->route('students.index')
            ->with('success', 'Alumno activado (restaurado) con éxito.');
    }
}
