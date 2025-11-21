<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CourseController extends Controller
{
    /**
     * Listar cursos
     * GET /api/cursos
     */
    public function index()
    {
        // 1. Consulta optimizada con conteos
        // Esto es vital para que tus $appends funcionen rápido
        $query = Course::with('teacher')->latest();

        // 3. Paginación
        // Laravel convertirá esto automáticamente a un JSON con "data", "total", "per_page", etc.
        $courses = $query->paginate(10);

        return response()->json($courses);
    }

    /**
     * Crear curso
     * POST /api/cursos
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'course_code' => ['required', 'string', 'unique:courses,course_code', 'max:255'],
                'teacher_id'  => ['nullable', 'exists:teachers,id'],
                'name'        => ['required', 'string', 'max:255'],
                'credits'     => ['required', 'integer'],
                'max_capacity'=> ['required', 'integer'],
            ]);

            $validated['status'] = 'active';

            $course = Course::create($validated);

            // Devolvemos el objeto creado y estado 201
            return response()->json([
                'message' => 'Curso creado con éxito.',
                'data' => $course
            ], 201);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error al crear el curso',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Mostrar un curso
     * GET /api/cursos/{id}
     */
    public function show($id)
    {
        try {
            $course = Course::with('teacher')->findOrFail($id);

            return response()->json([
                'status' => 'success',
                'data'   => $course
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'Curso no encontrado'], 404);
        }
    }

    /**
     * Actualizar curso
     * PUT/PATCH /api/cursos/{id}
     */
    public function update(Request $request, $id) // Recibimos el ID por URL, es lo estándar
    {
        try {
            $course = Course::findOrFail($id);

            $validated = $request->validate([
                'course_code' => ['nullable', 'string', Rule::unique('courses', 'course_code')->ignore($course->id), 'max:255'],
                'teacher_id'  => ['nullable', 'exists:teachers,id'],
                'name'        => ['nullable', 'string', 'max:255'],
                'credits'     => ['nullable', 'integer'],
                'max_capacity'=> ['nullable', 'integer'],
                'status'      => ['nullable', 'string', Rule::in(['active', 'inactive'])],
            ]);

            $course->update($validated);

            // Refrescamos para devolver los datos actualizados
            return response()->json([
                'message' => 'Curso actualizado con éxito.',
                'data' => $course
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error al actualizar',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Eliminar curso
     * DELETE /api/cursos/{id}
     */
    public function destroy($id)
    {
        try {
            $course = Course::findOrFail($id);
            $course->delete();

            return response()->json([
                'message' => 'Curso eliminado con éxito.'
            ], 200);

        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
}