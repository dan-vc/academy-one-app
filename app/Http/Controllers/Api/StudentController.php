<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

class StudentController extends Controller
{
    /**
     * Listar estudiantes (incluyendo eliminados, con búsqueda y paginación)
     * GET /api/students
     */
    public function index(Request $request)
    {
        // 1. Inicia la consulta base (incluyendo soft deletes como en tu web)
        $query = Student::withTrashed()->latest();

        // 3. Paginación
        $students = $query->paginate(10);

        return response()->json($students, 200);
    }

    /**
     * Crear estudiante
     * POST /api/students
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'student_code' => ['required', 'string', 'unique:students,student_code', 'max:255'],
                'name'         => ['required', 'string', 'max:255'],
                'email'        => ['required', 'email', 'unique:students,email', 'max:255'],
                'semester'     => ['nullable', 'string', 'max:255'],
                'phone'        => ['nullable', 'string', 'max:255'],
            ]);

            $student = Student::create($validated);

            return response()->json([
                'message' => 'Alumno creado con éxito.',
                'data'    => $student
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Throwable $th) {
            Log::error('Error creating student: ' . $th->getMessage());
            return response()->json(['message' => 'Error interno al crear estudiante'], 500);
        }
    }

    /**
     * Ver estudiante específico
     * GET /api/students/{id}
     */
    public function show($id)
    {
        try {
            // Buscamos incluso si está eliminado (soft deleted) para mostrar su info
            $student = Student::withTrashed()->findOrFail($id);

            return response()->json([
                'status' => 'success',
                'data'   => $student
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'Estudiante no encontrado'], 404);
        }
    }

    /**
     * Actualizar estudiante
     * PUT/PATCH /api/students/{id}
     */
    public function update(Request $request, $id)
    {
        try {
            // Buscamos incluso si está en papelera para poder editarlo
            $student = Student::withTrashed()->findOrFail($id);

            $validated = $request->validate([
                'student_code' => ['nullable', 'string', Rule::unique('students', 'student_code')->ignore($student->id), 'max:255'],
                'name'         => ['nullable', 'string', 'max:255'],
                'email'        => ['nullable', 'email', Rule::unique('students,email')->ignore($student->id), 'max:255'],
                'semester'     => ['nullable', 'string', 'max:255'],
                'phone'        => ['nullable', 'string', 'max:255'],
            ]);

            $student->update($validated);

            return response()->json([
                'message' => 'Información de alumno actualizada con éxito.',
                'data'    => $student
            ], 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'Estudiante no encontrado'], 404);
        } catch (\Throwable $th) {
            Log::error('Error updating student: ' . $th->getMessage());
            return response()->json(['message' => 'Error al actualizar estudiante'], 500);
        }
    }

    /**
     * Eliminar (Soft Delete)
     * DELETE /api/students/{id}
     */
    public function destroy($id)
    {
        try {
            // Buscamos solo los activos, si ya está eliminado no hacemos nada o lanzamos 404
            $student = Student::findOrFail($id);
            $student->delete();

            return response()->json([
                'message' => 'Alumno desactivado (enviado a papelera) con éxito.'
            ], 200);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'Estudiante no encontrado o ya eliminado'], 404);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Error al eliminar estudiante'], 500);
        }
    }

    /**
     * Restaurar estudiante eliminado
     * PATCH /api/students/{id}/restore
     */
    public function restore($id)
    {
        try {
            // Buscamos explícitamente solo en los eliminados (o todos)
            $student = Student::withTrashed()->findOrFail($id);

            if (!$student->trashed()) {
                return response()->json(['message' => 'El estudiante no estaba eliminado.'], 400);
            }

            $student->restore();

            return response()->json([
                'message' => 'Alumno activado (restaurado) con éxito.',
                'data'    => $student
            ], 200);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'Estudiante no encontrado'], 404);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Error al restaurar estudiante'], 500);
        }
    }
}