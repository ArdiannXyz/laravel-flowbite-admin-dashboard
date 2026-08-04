<?php

namespace App\Http\Controllers;

use App\Services\StaffDashboardService;

class StaffDashboardController extends Controller
{
    public function __construct(
        protected StaffDashboardService $staffDashboardService
    ) {}

    public function index()
    {
        $data = $this->staffDashboardService->getStaffDashboardData();

        return view('pages.dashboard-staff.index', $data);
    }
}