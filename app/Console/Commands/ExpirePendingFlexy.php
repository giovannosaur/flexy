<?php

// app/Console/Commands/ExpirePendingFlexy.php
namespace App\Console\Commands;
use Illuminate\Console\Command;
use App\Models\FlexyRequest;
use Carbon\Carbon;

class ExpirePendingFlexy extends Command
{
    protected $signature = 'flexy:expire';
    protected $description = 'Auto deny flexy requests yang expired (udah H, belum di-approve)';

    public function handle()
    {
        $today = Carbon::now()->toDateString();
        $expired = FlexyRequest::where('status', 'pending')
            ->where('requested_date', '<', $today)
            ->update([
                'status' => 'declined',
                'approved_at' => now(),
                'approved_by' => null, // bisa isi id sistem/admin khusus
            ]);
        $this->info("Flexy request expired: $expired");
    }
}
