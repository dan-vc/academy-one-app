<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // 1. Inicia la consulta base
        $query = Teacher::withTrashed()->latest();

        // 2. Obtiene el término de búsqueda de la URL (?search=...)
        if ($search = $request->input('search')) {
            // Agrupa las condiciones OR para que el filtro sea correcto
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', '%' . $search . '%') // Busca en nombre
                    ->orWhere('dni', 'LIKE', '%' . $search . '%') // Busca en dni
                    ->orWhere('teacher_code', 'LIKE', '%' . $search . '%'); // Busca en código
            });
        }

        // 3. Paginación
        $teachers = $query->paginate(10)->withQueryString();

        return view('teachers', compact('teachers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'teacher_code' => ['required', 'string', 'unique:teachers,teacher_code', 'max:255'],
                'name' => ['required', 'string', 'max:255'],
                'dni' => ['required', 'unique:teachers,dni', 'max:255'],
                'profession' => ['required', 'string', 'max:255'],
            ]);

            Teacher::create($validated);

            return redirect()->route('teachers.index')
                ->with('success', 'Docente creado con éxito.');
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id = null)
    {
        $teacher = Teacher::withTrashed()->find($request['id']);

        // Usamos Rule::unique para que ignore al estudiante que estamos editando
        $validated = $request->validate([
            'teacher_code' => ['required', 'string', Rule::unique('teachers', 'teacher_code')->ignore($teacher->id), 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'dni' => ['required', Rule::unique('teachers', 'dni')->ignore($teacher->id), 'max:255'],
            'profession' => ['required', 'string', 'max:255'],
        ]);

        $teacher->update($validated);

        return redirect()->route('teachers.index')
            ->with('success', 'Información de docente actualizada con éxito.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Teacher $teacher)
    {
        try {
            // Verificar si el docente tiene cursos asignados
            if ($teacher->courses()->exists()) {
                return redirect()
                    ->route('teachers.index')
                    ->with('error', 'No puedes desactivar este docente porque tiene cursos asignados.');
            }

            // Con softDeletes, este método simplemente establece el campo 'deleted_at'.
            // El registro no se elimina físicamente.
            $teacher->delete();

            return redirect()->route('teachers.index')
                ->with('success', 'Docente desactivado con éxito.');
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    public function restore($teacher)
    {
        // 1. Encuentra el registro, incluyendo los eliminados (withTrashed)
        $teacher = Teacher::withTrashed()->find($teacher);
        if (!$teacher) {
            return redirect()->route('teachers.index')->with('error', 'Docente no encontrado.');
        }

        // 2. Ejecuta el método restore() para poner deleted_at a NULL
        $teacher->restore();

        return redirect()->route('teachers.index')
            ->with('success', 'Docente activado (restaurado) con éxito.');
    }
}
