<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FlexyRequest;
use App\Models\User;

class ApprovalController extends Controller
{
    public function index(Request $request) {
        $status = $request->get('status'); // all, approved, denied, awaiting

        // Filter bawahan sesuai level
        $user = auth()->user();

        if ($user->role == 'Level 2') {
            $bawahan = ['Level 1'];
            $userIds = User::whereIn('role', $bawahan)->pluck('id');
        } else { // Level 3
            $bawahan = ['Level 2', 'Level 1'];
            $userIds = User::whereIn('role', $bawahan)->pluck('id')->toArray();
            $userIds[] = $user->id;
        }
        
        $query = FlexyRequest::with('user')
            ->whereIn('user_id', $userIds);

        if ($status && $status != 'all') {
            if ($status == 'awaiting') $dbStatus = 'pending';
            elseif ($status == 'approved') $dbStatus = 'accepted';
            elseif ($status == 'denied') $dbStatus = 'declined';
            else $dbStatus = $status;
            $query->where('status', $dbStatus);
        }    

        $requests = $query->orderByDesc('created_at')->get();

        return view('admin.approval.index', compact('requests', 'status'));
    }

    public function approve($id) {
        $req = FlexyRequest::findOrFail($id);
        if($req->status != 'pending') return back()->with('error', 'Sudah di-approve/deny.');
    
        //ubah status
        $req->status = 'accepted';
        $req->approved_by = auth()->id();
        $req->approved_at = now();
        $req->save();
    
        // Cek sudah ada schedule flexy?
        $sudahAda = \App\Models\Schedule::where('user_id', $req->user_id)
            ->where('meeting_date', $req->requested_date)
            ->where('type', 'flexy')
            ->exists();
    
        if(!$sudahAda) {
            [$start, $end] = explode('-', $req->schedule_option);
            \App\Models\Schedule::create([
                'id' => \Str::uuid(),
                'user_id' => $req->user_id,
                'description' => 'Flexy Schedule',
                'start_time' => trim($start),
                'end_time' => trim($end),
                'meeting_date' => $req->requested_date,
                'type' => 'flexy',
            ]);
        }
    
        return back()->with('success', 'Request telah di-approve dan schedule flexy otomatis dibuat!');
    }    

    public function deny($id) {
        $req = FlexyRequest::findOrFail($id);
        if($req->status != 'pending') return back()->with('error', 'Sudah di-approve/deny.');
        $req->status = 'declined';
        $req->approved_by = auth()->id();
        $req->approved_at = now();
        $req->save();
        return back()->with('success', 'Request telah di-decline.');
    }
}
