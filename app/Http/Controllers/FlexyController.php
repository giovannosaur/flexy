<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FlexyController extends Controller
{
    public function create() {
        // set default min (besok), max (seminggu ke depan)
        $minDate = now()->addDay()->toDateString();
        $maxDate = now()->addDays(7)->toDateString();
        return view('flexy.request', compact('minDate', 'maxDate'));
    }
    
    public function store(Request $request) {
        $request->validate([
            'requested_date' => 'required|date',
            'schedule_option' => 'required|in:09:00-18:00,10:00-19:00',
        ]);
    
        // cek tanggal valid (H+1 <= tanggal <= H+7)
        $minDate = now()->addDay()->toDateString();
        $maxDate = now()->addDays(7)->toDateString();
        if ($request->requested_date < $minDate || $request->requested_date > $maxDate) {
            return back()->with('error', 'Tanggal request harus H+1 sampai seminggu ke depan.');
        }

        // === Tambahin ini: Validasi hari kerja (Senin-Jumat) ===
        $date = \Carbon\Carbon::parse($request->requested_date);
        if ($date->isWeekend()) {
            return back()->with('error', 'Pengajuan hanya bisa untuk hari kerja (Senin–Jumat)!');
        }

        // cek udah ada request flexy di tanggal tsb
        $ada = \App\Models\FlexyRequest::where('user_id', auth()->id())
            ->where('requested_date', $request->requested_date)
            ->exists();
        if ($ada) {
            return back()->with('error', 'Kamu sudah pernah request flexy di tanggal itu!');
        }

    
        \App\Models\FlexyRequest::create([
            'id' => \Str::uuid(),
            'user_id' => auth()->id(),
            'requested_date' => $request->requested_date,
            'schedule_option' => $request->schedule_option,
            'status' => 'pending',
            'created_at' => now(),
        ]);
    
        return back()->with('success', 'Request Flexy berhasil diajukan!');
    }    

    public function history() {
        $user = auth()->user();
    
        $requests = \App\Models\FlexyRequest::where('user_id', $user->id)
            ->orderByDesc('created_at')
            ->get();
    
        return view('flexy.history', compact('requests'));
    }
    
}
