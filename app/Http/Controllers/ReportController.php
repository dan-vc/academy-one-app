<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        /* Students */
        $students = Student::withCount(['enrollments as approved_courses_count' => function ($query) {
            $query->where('status', 'approved');
        }, 'enrollments as enrolled_courses_count' => function ($query) {
            $query->where('status', 'enrolled');
        }])->get();

        /* Courses */
        $courses = Course::with('teacher')
            ->withCount([
                'enrollments as total_students',
                'enrollments as approved_students' => function ($query) {
                    $query->where('status', 'approved');
                }
            ])
            ->get();

        /* Teachers */
        $teachers = Teacher::withCount([
            'courses as active_courses_count' => function ($query) {
                $query->where('status', 'active');
            }
        ])->get();

        return view('reports', compact('students', 'courses', 'teachers'));
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
        //
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function exportStudentsCSV()
    {
        // 1. Nombre del archivo a descargar
        $fileName = 'reporte_alumnos_' . date('Y-m-d_H-i') . '.csv';

        // 2. Obtener los datos (asegúrate de cargar las relaciones para optimizar)
        $students = Student::withCount(['enrollments as approved_courses_count' => function ($query) {
            $query->where('status', 'approved');
        }, 'enrollments as enrolled_courses_count' => function ($query) {
            $query->where('status', 'enrolled');
        }])->get();

        // 3. Crear la respuesta "streamed" (transmisión de datos)
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function () use ($students) {
            $file = fopen('php://output', 'w');

            // A. Escribir los encabezados del CSV (BOM para que Excel reconozca tildes y ñ)
            fputs($file, "\xEF\xBB\xBF");
            fputcsv($file, [
                'Nombre',
                'Email',
                'Teléfono',
                'Estado',
                'Cursos Completados',
                'Cursos Matriculados',
                'Promedio',
            ]);

            // B. Recorrer los cursos y escribir las filas
            foreach ($students as $student) {
                fputcsv($file, [
                    $student->name,
                    $student->email,
                    $student->phone,
                    $student->deleted_at ? 'inactivo' : 'activo',
                    $student->approved_courses_count,
                    $student->enrolled_courses_count,
                    '16.00',
                ]);
            }

            fclose($file);
        };

        return new StreamedResponse($callback, 200, $headers);
    }

    public function exportTeachersCSV()
    {
        // 1. Nombre del archivo a descargar
        $fileName = 'reporte_docentes_' . date('Y-m-d_H-i') . '.csv';

        // 2. Obtener los datos (asegúrate de cargar las relaciones para optimizar)
        $teachers = Teacher::withCount([
            'courses as active_courses_count' => function ($query) {
                $query->where('status', 'active');
            }
        ])->get();

        // 3. Crear la respuesta "streamed" (transmisión de datos)
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function () use ($teachers) {
            $file = fopen('php://output', 'w');

            // A. Escribir los encabezados del CSV (BOM para que Excel reconozca tildes y ñ)
            fputs($file, "\xEF\xBB\xBF");
            fputcsv($file, [
                'Nombre',
                'Código',
                'DNI o C.E.',
                'Título Profesional',
                'Fecha de Ingreso',
                'Cursos Activos',
            ]);

            // B. Recorrer los cursos y escribir las filas
            foreach ($teachers as $teacher) {
                fputcsv($file, [
                    $teacher->name,
                    (string) $teacher->teacher_code,
                    (string) $teacher->dni, // Convertirmos a string para evitar problemas con ceros a la izquierda
                    $teacher->profession,
                    $teacher->created_at->format('d/m/Y'),
                    $teacher->active_courses_count,
                ]);
            }

            fclose($file);
        };

        return new StreamedResponse($callback, 200, $headers);
    }

    public function exportCoursesCSV()
    {
        // 1. Nombre del archivo a descargar
        $fileName = 'reporte_cursos_' . date('Y-m-d_H-i') . '.csv';

        // 2. Obtener los datos (asegúrate de cargar las relaciones para optimizar)
        // Nota: Asumo que tienes las relaciones 'teacher' y 'students' (o similar)
        $courses = Course::with('teacher')
            ->withCount([
                'enrollments as total_students',
                'enrollments as approved_students' => function ($query) {
                    $query->where('status', 'approved');
                }
            ])
            ->get();

        // 3. Crear la respuesta "streamed" (transmisión de datos)
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function () use ($courses) {
            $file = fopen('php://output', 'w');

            // A. Escribir los encabezados del CSV (BOM para que Excel reconozca tildes y ñ)
            fputs($file, "\xEF\xBB\xBF");
            fputcsv($file, [
                'Nombre del Curso',
                'Código',
                'Docente',
                'Matriculados',
                'Capacidad',
                'Ocupación (%)',
                'Promedio',
                'Tasa Aprobación (%)'
            ]);

            // B. Recorrer los cursos y escribir las filas
            foreach ($courses as $course) {
                fputcsv($file, [
                    $course->name,
                    (string) $course->course_code,
                    $course->teacher->name ?? 'Sin asignar',
                    $course->total_students,
                    $course->max_capacity,
                    $course->occupationRate() . '%',
                    '16.00', // Valor estático según tu tabla, cámbialo por la lógica real si existe
                    $course->approvalRate() . '%',
                ]);
            }

            fclose($file);
        };

        return new StreamedResponse($callback, 200, $headers);
    }
}
