<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

class EnrollmentController extends Controller
{
    /**
     * Listar matrículas (con búsqueda y paginación)
     * GET /api/enrollments
     */
    public function index(Request $request)
    {
        // 1. Inicia la consulta con las relaciones cargadas (Eager Loading)
        $query = Enrollment::with(['student', 'course'])->latest();

        // 3. Paginación
        $enrollments = $query->paginate(10);

        return response()->json($enrollments, 200);
    }

    /**
     * Crear nueva matrícula
     * POST /api/enrollments
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'student_id'      => ['required', 'exists:students,id'],
                'course_id'       => ['required', 'exists:courses,id'],
                'period'          => ['required', 'string', 'max:255'],
                'enrollment_date' => ['required', 'date'],
                'status'          => ['required', 'string', Rule::in(['enrolled', 'retired', 'approved', 'failed'])],
            ]);

            $enrollment = Enrollment::create($validated);

            // Cargamos las relaciones para devolver el objeto completo al frontend
            $enrollment->load(['student', 'course']);

            return response()->json([
                'message' => 'Matrícula registrada con éxito.',
                'data'    => $enrollment
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Throwable $th) {
            Log::error('API Error store enrollment: ' . $th->getMessage());
            return response()->json(['message' => 'Error interno al registrar matrícula'], 500);
        }
    }

    /**
     * Ver detalles de una matrícula
     * GET /api/enrollments/{id}
     */
    public function show($id)
    {
        try {
            $enrollment = Enrollment::with(['student', 'course'])->findOrFail($id);
            
            return response()->json([
                'status' => 'success',
                'data'   => $enrollment
            ], 200);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'Matrícula no encontrada'], 404);
        }
    }

    /**
     * Actualizar matrícula
     * PUT/PATCH /api/enrollments/{id}
     */
    public function update(Request $request, $id)
    {
        try {
            $enrollment = Enrollment::findOrFail($id);

            $validated = $request->validate([
                'student_id'      => ['nullable', 'exists:students,id'],
                'course_id'       => ['nullable', 'exists:courses,id'],
                'period'          => ['nullable', 'string', 'max:255'],
                'enrollment_date' => ['nullable', 'date'],
                'status'          => ['nullable', 'string', Rule::in(['enrolled', 'retired', 'approved', 'failed'])],
            ]);

            $enrollment->update($validated);
            
            // Refrescamos relaciones
            $enrollment->load(['student', 'course']);

            return response()->json([
                'message' => 'Matrícula actualizada con éxito.',
                'data'    => $enrollment
            ], 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Throwable $th) {
            Log::error('API Error update enrollment: ' . $th->getMessage());
            return response()->json(['message' => 'Error al actualizar matrícula'], 500);
        }
    }

    /**
     * Eliminar matrícula
     * DELETE /api/enrollments/{id}
     */
    public function destroy($id)
    {
        try {
            $enrollment = Enrollment::findOrFail($id);
            $enrollment->delete();

            return response()->json([
                'message' => 'Matrícula eliminada con éxito.'
            ], 200);

        } catch (\Illuminate\Database\QueryException $e) {
            // Manejo específico de error de llave foránea (Integridad referencial)
            if ($e->errorInfo[1] == 1451 || str_contains($e->getMessage(), 'SQLSTATE[23000]')) {
                return response()->json([
                    'message' => 'No se puede eliminar porque tiene registros asociados (ej. notas). Intente cambiar el estado a "Retirado".'
                ], 409); // 409 Conflict
            }
            return response()->json(['message' => 'Error de base de datos'], 500);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Error al eliminar matrícula'], 500);
        }
    }

    /**
     * Cambiar estado (Endpoint específico opcional)
     * PATCH /api/enrollments/{id}/status
     */
    public function changeStatus(Request $request, $id)
    {
        try {
            $request->validate([
                'status' => ['required', 'string', Rule::in(['enrolled', 'retired', 'approved', 'failed'])],
            ]);

            $enrollment = Enrollment::findOrFail($id);
            $enrollment->status = $request->status;
            $enrollment->save();

            return response()->json([
                'message' => 'Estado actualizado.',
                'data'    => $enrollment
            ]);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Error al cambiar estado'], 500);
        }
    }
}