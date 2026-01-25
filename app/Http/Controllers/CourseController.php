<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Teacher;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // 1. Inicia la consulta base
        $query = Course::latest();

        // 2. Obtiene el término de búsqueda de la URL (?search=...)
        if ($search = $request->input('search')) {
            // Agrupa las condiciones OR para que el filtro sea correcto
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', '%' . $search . '%') // Busca en nombre
                    ->orWhere('course_code', 'LIKE', '%' . $search . '%'); // Busca en código
            });
        }

        // 3. Paginación
        $courses = $query->paginate(7)->withQueryString();
        $teachers = Teacher::all();

        return view('courses', compact('courses', 'teachers'));
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
                'course_code' => ['required', 'string', 'unique:courses,course_code', 'max:255'],
                'teacher_id' => ['nullable', 'exists:teachers,id'],
                'name' => ['required', 'string', 'max:255'],
                'credits' => ['required', 'integer'],
                'max_capacity' => ['required', 'integer'],
                'status' => ['required', 'string', Rule::in(['active', 'inactive'])],
            ]);

            Course::create($validated);

            return redirect()->route('courses.index')
                ->with('success', 'Curso creado con éxito.');
        } catch (Exception $th) {
            return redirect()->route('courses.index')
            ->with('success', $th->getMessage());
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
        $course = Course::find($request['id']);

        $validated = $request->validate([
            'course_code' => ['required', 'string', Rule::unique('courses', 'course_code')->ignore($course->id), 'max:255'],
            'teacher_id' => ['nullable', Rule::exists('teachers', 'id')],
            'name' => ['required', 'string', 'max:255'],
            'credits' => ['required', 'integer'],
            'max_capacity' => ['required', 'integer'],
            'status' => ['required', 'string', Rule::in(['active', 'inactive'])],
        ]);

        $course->update($validated);

        return redirect()->route('courses.index')
            ->with('success', 'Información de curso actualizada con éxito.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        try {
            // Con softDeletes, este método simplemente establece el campo 'deleted_at'.
            // El registro no se elimina físicamente.
            $course->delete();

            return redirect()->route('courses.index')
                ->with('success', 'Curso eliminado con éxito.');
        } catch (Exception $th) {
            return redirect()->route('courses.index')
            ->with('error', "No se pudo eliminar el curso porque tiene estudiantes asignados.");
        }
    }

    public function deactivate(Course $course)
    {
        // 1. Encuentra el registro, incluyendo los eliminados (withTrashed)
        $course->status = 'inactive';

        // 2. Ejecuta el método restore() para poner deleted_at a NULL
        $course->save();

        return redirect()->route('courses.index')
            ->with('success', 'Curso desactivado con éxito.');
    }

    public function restore(Course $course)
    {
        // 1. Encuentra el registro, incluyendo los eliminados (withTrashed)
        $course->status = 'active';

        // 2. Ejecuta el método restore() para poner deleted_at a NULL
        $course->save();

        return redirect()->route('courses.index')
            ->with('success', 'Curso activado (restaurado) con éxito.');
    }
}
