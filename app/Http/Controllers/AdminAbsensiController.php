<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Schedule;
use App\Models\User;

class AdminAbsensiController extends Controller
{
    public function index(Request $request)
    {
        $filterDate = $request->get('date'); // YYYY-MM-DD dari date picker

        $query = \App\Models\Attendance::with(['user', 'schedule']);

        if ($filterDate) {
            $query->whereDate('created_at', $filterDate);
        }

        $attendances = $query->orderByDesc('created_at')->paginate(10); // 10 per page

        return view('admin.absensi.index', compact('attendances', 'filterDate'));
    }

}
