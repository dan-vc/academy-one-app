<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use IcehouseVentures\LaravelChartjs\Facades\Chartjs;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {

        // 1. Obtenemos cursos con su conteo de matriculas
        // Ordenamos por los que tienen más alumnos y tomamos el Top 10 para que la gráfica no sea gigante
        $coursesData = Course::withCount('enrollments')
            ->orderBy('enrollments_count', 'desc')
            ->take(10)
            ->get();

        // 2. Preparamos etiquetas (Nombres) y Datos (Cantidades)
        $courseLabels = $coursesData->pluck('name')->toArray(); // O usa 'course_code' si prefieres
        $courseCounts = $coursesData->pluck('enrollments_count')->toArray();
        $capacityData = $coursesData->pluck('max_capacity')->toArray(); // Nueva línea para capacidades

        // 3. Construimos el gráfico
        $enrollmentChart = Chartjs::build()
            ->name("EnrollmentsPerCourseChart")
            ->type("bar") // 'bar' es mejor para comparar cantidades
            ->size(["width" => 400, "height" => 200])
            ->labels($courseLabels)
            ->datasets([
                [
                    "label" => "Estudiantes Matriculados",
                    "backgroundColor" => 'rgba(99, 100, 255, 0.5)',
                    "borderColor" => "rgba(54, 162, 235, 1)",
                    "data" => $courseCounts
                ],
                // BARRA 2: Capacidad (Gris o Rojo)
                [
                    "label" => "Capacidad Máxima",
                    "backgroundColor" => "rgba(201, 203, 207, 0.5)", // Gris para dar contexto de "fondo"
                    "borderColor" => "rgba(201, 203, 207, 1)",
                    "borderWidth" => 1,
                    "data" => $capacityData // <--- Aquí inyectamos la capacidad
                ]
            ]);

        // 2. Construimos el gráfico tipo 'pie'
        $distributionChart = Chartjs::build()
            ->name("StudentsDistributionChart")
            ->type("pie") // Tipo 'pie' para gráfico circular
            ->size(["width" => 100, "height" => 100]) // Aspecto cuadrado para que se vea redondo
            ->labels($courseLabels)
            ->datasets([
                [
                    "label" => "Alumnos",
                    "data" => $courseCounts,
                    // Una paleta de colores variada para distinguir cada rebanada
                    "backgroundColor" => [
                        'rgba(255, 99, 132, 0.8)',
                        'rgba(54, 162, 235, 0.8)',
                        'rgba(255, 206, 86, 0.8)',
                        'rgba(75, 192, 192, 0.8)',
                        'rgba(153, 102, 255, 0.8)',
                        'rgba(255, 159, 64, 0.8)',
                        'rgba(199, 199, 199, 0.8)',
                        'rgba(83, 102, 255, 0.8)',
                        'rgba(40, 159, 64, 0.8)',
                        'rgba(210, 99, 132, 0.8)',
                    ],
                    'borderColor' => 'transparent',
                    "hoverOffset" => 4 // Efecto visual al pasar el mouse
                ]
            ]);


        // 1. Definir el rango: Últimos 6 meses (para que se parezca a tu imagen de Ene a Jun)
        $startMonth = Carbon::now()->subMonths(5)->startOfMonth();
        $endMonth = Carbon::now()->endOfMonth();
        $periodHistory = CarbonPeriod::create($startMonth, '1 month', $endMonth);

        $historyLabels = [];
        $historyData = [];

        foreach ($periodHistory as $date) {
            // Etiqueta: Nombre del mes (Ej: "Ene", "Feb"). 
            // Nota: Asegúrate de tener Carbon en español en AppServiceProvider, 
            // sino saldrá en inglés (Jan, Feb).
            $historyLabels[] = ucfirst($date->isoFormat('MMM'));

            // Datos: Contamos matrículas en ese mes y año específico
            $count = Enrollment::whereYear('enrollment_date', $date->year)
                ->whereMonth('enrollment_date', $date->month)
                ->count();

            $historyData[] = $count;
        }

        // 2. Construir el Gráfico
        $monthlyEnrollmentsChart = Chartjs::build()
            ->name("MonthlyEnrollmentsChart")
            ->type("line")
            ->size(["width" => 400, "height" => 200])
            ->labels($historyLabels)
            ->datasets([
                [
                    "label" => "Matrículas",
                    // Color Morado (Purple-500 de Tailwind)
                    "backgroundColor" => "rgba(139, 92, 246, 0.2)",
                    "borderColor" => "rgba(139, 92, 246, 1)",
                    "pointBackgroundColor" => "white", // Punto blanco con borde morado
                    "pointBorderColor" => "rgba(139, 92, 246, 1)",
                    "pointBorderWidth" => 2,
                    "pointRadius" => 5, // Puntos visibles como en la imagen
                    "borderWidth" => 3,
                    "tension" => 0.4, // <--- ¡IMPORTANTE! Esto hace la línea curva
                    "fill" => false,  // Solo línea, sin rellenar el fondo
                    "data" => $historyData
                ]
                ]);


        // --- OPCIÓN B: CARGA DOCENTE (Barra Horizontal) ---

        $topTeachers = Teacher::withCount('courses')
            ->orderByDesc('courses_count')
            ->take(5)
            ->get();

        $teacherChart = Chartjs::build()
            ->name("TeacherWorkloadChart")
            ->type("bar")
            ->size(["width" => 400, "height" => 200])
            ->labels($topTeachers->pluck('name')->toArray())
            ->datasets([
                [
                    "label" => "Cursos Asignados",
                    "backgroundColor" => "rgba(245, 158, 11, 0.7)", // Ámbar/Naranja
                    "borderColor" => "rgba(245, 158, 11, 1)",
                    "borderWidth" => 1,
                    "data" => $topTeachers->pluck('courses_count')->toArray()
                ]
                ]);

        // --- TARJETAS DE RESUMEN ---
        $activeStudents = Student::count();
        $activeTeachers = Teacher::count();
        $activeCourses = Course::where('status', 'active')->count();
        $totalEnrollments = Enrollment::count();

        // Corrección: Faltaba el ->count() en tu código original
        $activeCourses = Course::where('status', 'active')->count();

        return view("dashboard", compact(
            "enrollmentChart",
            "distributionChart",
            "monthlyEnrollmentsChart",
            "teacherChart",
            'activeStudents',
            'activeTeachers',
            'activeCourses',
            'totalEnrollments'
        ));
    }
}
