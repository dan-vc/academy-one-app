<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

class TeacherController extends Controller
{
    /**
     * Listar docentes (incluye eliminados, búsqueda y paginación)
     * GET /api/teachers
     */
    public function index(Request $request)
    {
        // 1. Inicia la consulta base (incluyendo eliminados para gestión completa)
        $query = Teacher::withTrashed()->latest();

        // 3. Paginación
        $teachers = $query->paginate(10);

        return response()->json($teachers, 200);
    }

    /**
     * Crear docente
     * POST /api/teachers
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'teacher_code' => ['required', 'string', 'unique:teachers,teacher_code', 'max:255'],
                'name'         => ['required', 'string', 'max:255'],
                'dni'          => ['required', 'unique:teachers,dni', 'max:255'],
                'profession'   => ['required', 'string', 'max:255'],
            ]);

            $teacher = Teacher::create($validated);

            return response()->json([
                'message' => 'Docente creado con éxito.',
                'data'    => $teacher
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Throwable $th) {
            Log::error('Error creating teacher: ' . $th->getMessage());
            return response()->json(['message' => 'Error interno al crear docente'], 500);
        }
    }

    /**
     * Ver docente específico
     * GET /api/teachers/{id}
     */
    public function show($id)
    {
        try {
            $teacher = Teacher::withTrashed()->findOrFail($id);

            return response()->json([
                'status' => 'success',
                'data'   => $teacher
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'Docente no encontrado'], 404);
        }
    }

    /**
     * Actualizar docente
     * PUT/PATCH /api/teachers/{id}
     */
    public function update(Request $request, $id)
    {
        try {
            // Buscamos incluso si está eliminado para permitir correcciones
            $teacher = Teacher::withTrashed()->findOrFail($id);

            $validated = $request->validate([
                'teacher_code' => ['nullable', 'string', Rule::unique('teachers', 'teacher_code')->ignore($teacher->id), 'max:255'],
                'name'         => ['nullable', 'string', 'max:255'],
                'dni'          => ['nullable', Rule::unique('teachers', 'dni')->ignore($teacher->id), 'max:255'],
                'profession'   => ['nullable', 'string', 'max:255'],
            ]);

            $teacher->update($validated);

            return response()->json([
                'message' => 'Información de docente actualizada con éxito.',
                'data'    => $teacher
            ], 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Error al actualizar docente'], 500);
        }
    }

    /**
     * Eliminar docente (Soft Delete)
     * DELETE /api/teachers/{id}
     */
    public function destroy($id)
    {
        try {
            // Solo buscamos activos para eliminar
            $teacher = Teacher::findOrFail($id);

            // 1. Validación de integridad (Regla de negocio crítica)
            if ($teacher->courses()->exists()) {
                return response()->json([
                    'message' => 'No puedes desactivar este docente porque tiene cursos asignados.'
                ], 409); // 409 Conflict: El estado actual del recurso impide la acción
            }

            // 2. Soft Delete
            $teacher->delete();

            return response()->json([
                'message' => 'Docente desactivado con éxito.'
            ], 200);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'Docente no encontrado'], 404);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Error al eliminar docente'], 500);
        }
    }

    /**
     * Restaurar docente eliminado
     * PATCH /api/teachers/{id}/restore
     */
    public function restore($id)
    {
        try {
            $teacher = Teacher::withTrashed()->findOrFail($id);

            if (!$teacher->trashed()) {
                return response()->json(['message' => 'El docente ya está activo.'], 400);
            }

            $teacher->restore();

            return response()->json([
                'message' => 'Docente activado (restaurado) con éxito.',
                'data'    => $teacher
            ], 200);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'Docente no encontrado'], 404);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Error al restaurar docente'], 500);
        }
    }
}