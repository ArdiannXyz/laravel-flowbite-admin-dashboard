<?php

namespace App\Http\Controllers;

use App\Services\StaffDashboardService;
use Illuminate\View\View; // Import Class View

class StaffDashboardController extends Controller
{
    public function __construct(
        protected StaffDashboardService $staffDashboardService
    ) {}

    public function index(): View // Tambahkan return type hint disini
    {
        $data = $this->staffDashboardService->getStaffDashboardData();

        return view('pages.dashboard-staff.index', $data);
    }
}