<?php

namespace App\Http\Controllers;

use App\Models\Enrollment; // Asegúrate de tener este modelo
use App\Models\Student;    // Asegúrate de tener este modelo
use App\Models\Course;     // Asegúrate de tener este modelo
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log; // Para depuración en el catch

class EnrollmentController extends Controller
{
    /**
     * Display a listing of the resource (Matrículas).
     */
    public function index(Request $request)
    {
        // 1. Inicia la consulta base
        // Con eager loading para cargar Student y Course y evitar problemas N+1
        $query = Enrollment::with(['student', 'course'])->latest();

        // 2. Obtiene el término de búsqueda de la URL (?search=...)
        if ($search = $request->input('search')) {
            // Busca en el nombre del alumno, código del alumno, nombre del curso o código del curso
            $query->where(function ($q) use ($search) {
                $q->whereHas('student', function ($sq) use ($search) {
                    $sq->where('name', 'LIKE', '%' . $search . '%');
                        // ->orWhere('student_code', 'LIKE', '%' . $search . '%');
                })
                    ->orWhereHas('course', function ($cq) use ($search) {
                        $cq->where('name', 'LIKE', '%' . $search . '%')
                            ->orWhere('course_code', 'LIKE', '%' . $search . '%');
                    });
            });
        }

        // 3. Paginación
        $enrollments = $query->paginate(10)->withQueryString();

        // Necesitamos la lista de estudiantes y cursos para los selectores en los modales
        $students = Student::withTrashed()->orderBy('name')->get();
        $courses = Course::orderBy('name')->get();

        return view('enrollments', compact('enrollments', 'students', 'courses'));
    }

    /**
     * Show the form for creating a new resource. (No se usa directamente con modales)
     */
    public function create()
    {
        // Este método no es necesario si usas modales para crear
        // return view('enrollments.create', ['students' => Student::all(), 'courses' => Course::all()]);
    }

    /**
     * Store a newly created resource in storage (Matrícula).
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'student_id' => ['required', 'exists:students,id'],
                'course_id' => ['required', 'exists:courses,id'],
                'period' => ['required', 'string', 'max:255'],
                'enrollment_date' => ['required', 'date'],
                'status' => ['required', 'string', Rule::in(['enrolled', 'retired', 'approved', 'failed'])],
            ]);

            Enrollment::create($validated);

            return redirect()->route('enrollments.index')
                ->with('success', 'Matrícula registrada con éxito.');
        } catch (\Exception $e) { // Captura una excepción más general
            Log::error('Error al registrar matrícula: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return redirect()->back()
                ->with('error', 'Hubo un error al registrar la matrícula.')
                ->withInput(); // Mantiene los datos del formulario
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // No implementado para esta vista de tabla, pero podría mostrar detalles de una matrícula.
    }

    /**
     * Show the form for editing the specified resource. (No se usa directamente con modales)
     */
    public function edit(string $id)
    {
        // Este método no es necesario si usas modales para editar
        // $enrollment = Enrollment::findOrFail($id);
        // return view('enrollments.edit', compact('enrollment', 'students', 'courses'));
    }

    /**
     * Update the specified resource in storage (Matrícula).
     */
    public function update(Request $request, Enrollment $enrollment) // Se puede usar Route Model Binding
    {
        try {
            $enrollment = Enrollment::findOrFail($request->id);

            $validated = $request->validate([
                'student_id' => ['required', 'exists:students,id'],
                'course_id' => ['required', 'exists:courses,id'],
                'period' => ['required', 'string', 'max:255'],
                'enrollment_date' => ['required', 'date'],
                'status' => ['required', 'string', Rule::in(['enrolled', 'retired', 'approved', 'failed'])],
            ]);

            $enrollment->update($validated);

            return redirect()->route('enrollments.index')
                ->with('success', 'Información de matrícula actualizada con éxito.');
        } catch (\Exception $e) {
            Log::error('Error al actualizar matrícula: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return redirect()->back()
                ->with('error', 'Hubo un error al actualizar la matrícula.')
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage (Matrícula).
     */
    public function destroy(Enrollment $enrollment) // Route Model Binding
    {
        try {
            // Las matrículas rara vez se "desactivan" como los cursos.
            // Generalmente, se cambian de estado (e.g., a 'retired') o se eliminan.
            // Si necesitas soft deletes, asegúrate de que el modelo Enrollment use SoftDeletes trait.
            $enrollment->delete(); // Esto usará soft delete si el modelo lo tiene, o hard delete si no.

            return redirect()->route('enrollments.index')
                ->with('success', 'Matrícula eliminada con éxito.');
        } catch (\Exception $e) {
            Log::error('Error al eliminar matrícula: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);

            // Detectar si el error es por una restricción de clave foránea
            if (str_contains($e->getMessage(), 'SQLSTATE[23000]')) { // Código de error SQL Server para FK constraint
                return redirect()->back()
                    ->with('error', 'No se puede eliminar la matrícula porque tiene registros asociados (ej. calificaciones). Considera cambiar su estado a "Retirado".');
            }

            return redirect()->back()
                ->with('error', 'Hubo un error al eliminar la matrícula.');
        }
    }

    // Los métodos 'deactivate' y 'restore' de cursos no aplican directamente
    // a matrículas, ya que las matrículas tienen un enum 'status' más detallado.
    // En su lugar, el estado se actualiza mediante el método 'update'.

    // Ejemplo de un método para cambiar estado directamente si fuera necesario (alternativa a 'update')
    public function changeStatus(Request $request, Enrollment $enrollment)
    {
        $request->validate([
            'status' => ['required', 'string', Rule::in(['enrolled', 'retired', 'approved', 'failed'])],
        ]);

        $enrollment->status = $request->status;
        $enrollment->save();

        return redirect()->route('enrollments.index')->with('success', 'Estado de matrícula actualizado.');
    }
}
