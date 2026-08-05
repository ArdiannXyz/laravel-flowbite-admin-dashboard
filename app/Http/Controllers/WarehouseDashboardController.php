<?php

namespace App\Http\Controllers;

use App\Services\WarehouseDashboardService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WarehouseDashboardController extends Controller
{
    public function __construct(
        protected WarehouseDashboardService $dashboardService
    ) {}

    public function index(): View
    {
        $summary = $this->dashboardService->getDashboardSummary();
        return view('pages.warehouse.dashboard', compact('summary'));
    }
}
