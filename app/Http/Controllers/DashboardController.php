<?php

namespace App\Http\Controllers;

use App\Models\Course;
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

        $start = Carbon::parse(User::min("created_at"));
        $end = Carbon::now();
        $period = CarbonPeriod::create($start, "1 month", $end);

        $usersPerMonth = collect($period)->map(function ($date) {
            $endDate = $date->copy()->endOfMonth();

            return [
                "count" => User::where("created_at", "<=", $endDate)->count(),
                "month" => $endDate->format("Y-m-d")
            ];
        });

        $data = $usersPerMonth->pluck("count")->toArray();
        $labels = $usersPerMonth->pluck("month")->toArray();

        $chart = Chartjs::build()
            ->name("UserRegistrationsChart")
            ->type("line")
            ->size(["width" => 400, "height" => 200])
            ->labels($labels)
            ->datasets([
                [
                    "label" => "User Registrations",
                    "backgroundColor" => "rgba(38, 185, 154, 0.31)",
                    "borderColor" => "rgba(38, 185, 154, 0.7)",
                    "data" => $data
                ]
            ])
            ->options([
                'scales' => [
                    'x' => [
                        'type' => 'time',
                        'time' => [
                            'unit' => 'month'
                        ],
                        'min' => $start->format("Y-m-d"),
                    ]
                ],
                'plugins' => [
                    'title' => [
                        'display' => true,
                        'text' => 'Monthly User Registrations'
                    ]
                ]
            ]);


        $activeStudents = Student::count();
        $activeTeachers = Teacher::count();
        $activeCourses = Course::where('status', '=', 'active');

        return view("dashboard", compact("chart", 'activeStudents', 'activeTeachers', 'activeCourses'));
    }
}
