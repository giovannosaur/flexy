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
        $filterDate = $request->get('date');
        $perPage = $request->get('perPage', 10); // default 10, bisa custom
    
        $query = Attendance::with(['user', 'schedule']);
        if ($filterDate) {
            $query->whereDate('checkin_time', $filterDate);
        }
        $attendances = $query->orderByDesc('checkin_time')->paginate($perPage);
    
        return view('admin.absensi.index', compact('attendances', 'filterDate', 'perPage'));
    }    
}
