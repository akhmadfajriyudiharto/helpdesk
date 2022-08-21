<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\Setting;
use App\Models\Ticket;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Http\JsonResponse;

class StatsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function count(): JsonResponse
    {
        return response()->json([
            'open_tickets' => Ticket::where('status_id', 1)->count(),
            'pending_tickets' => Ticket::where('status_id', 2)->count(),
            'solved_tickets' => Ticket::whereIn('status_id', [3, 4])->count(),
            'without_agent' => Ticket::whereNull('agent_id')->count(),
        ]);
    }

    public function registeredUsers(): JsonResponse
    {
        $graph = [];
        $month = 1;
        while ($month <= 12) {
            $graph[] = User::whereMonth('created_at', '=', $month)->count();
            $month++;
        }
        return response()->json($graph);
    }

    public function openedTickets(): JsonResponse
    {
        $graph = [];
        $month = 1;
        while ($month <= 12) {
            $graph[] = Ticket::whereMonth('created_at', '=', $month)->count();
            $month++;
        }
        return response()->json($graph);
    }
}
