<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

final class DashboardController extends Controller
{
    public function __invoke(Request $request): Response
    {
        $latestTransactions = Auth::user()
            ->transactions()
            ->with('category')
            ->limit(5)
            ->orderBy('transaction_date', 'desc')
            ->get();

        return Inertia::render('Dashboard', compact('latestTransactions'));
    }
}
