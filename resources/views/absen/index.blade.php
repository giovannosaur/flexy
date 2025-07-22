@extends('layouts.app')

@push('head')
<style>
.table th, .table td { text-align: center; vertical-align: middle; }
</style>
@endpush

@section('content')
<div class="main">
    <h2 class="mb-4"><strong>Riwayat Absensi Saya</strong></h2>

    <form method="GET" class="filter-section mb-2 d-flex align-items-baseline justify-content-center gap-2">
    <input type="date" name="date" value="{{ $filterDate }}"
        style="box-shadow: 0 2px 6px rgba(0,0,0,0.3); border-radius: 6px; padding: 4px 8px;" />
    
    <label for="perPage" class="mb-0 ms-2">Show</label>
    
    <input type="number" min="1" max="100" name="perPage" id="perPage"
        value="{{ $perPage }}" style="width:70px; border-radius: 6px; padding: 4px 8px;" />
    
    <span class="me-2">entries</span>
    
    <button type="submit" class="btn btn-primary me-1"
        style="border-radius:8px; box-shadow: 0 2px 6px rgba(0,0,0,0.5); font-weight:bold;">
        Filter
    </button>

    @if($filterDate || $perPage != 10)
        <a href="{{ route('absen.index') }}"
            class="btn btn-danger"
            style="border-radius:8px; box-shadow: 0 2px 6px rgba(0,0,0,0.5); font-weight:bold;">
            Reset
        </a>
    @endif
</form>


    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>Date</th>
                    <th>Time</th>
                    <th>In</th>
                    <th>Status In</th>
                    <th>Out</th>
                    <th>Status Out</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($attendances as $a)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($a->schedule->meeting_date ?? $a->checkin_time)->format('D, d/m/Y') }}</td>
                        <td>
                            {{ $a->schedule ? ($a->schedule->start_time . '–' . $a->schedule->end_time) : '-' }}
                        </td>
                        <td>
                            {{ $a->checkin_time ? \Carbon\Carbon::parse($a->checkin_time)->format('H.i') : '-' }}
                        </td>
                        <td>
                            @php
                                $inTime = $a->checkin_time ? \Carbon\Carbon::parse($a->checkin_time) : null;
                                $jadwalIn = $a->schedule ? \Carbon\Carbon::parse($a->schedule->meeting_date . ' ' . $a->schedule->start_time) : null;
                                $late = $inTime && $jadwalIn && $inTime->gt($jadwalIn->copy()->addMinutes(5));
                            @endphp
                            @if(!$inTime)
                                <span class="text-muted">-</span>
                            @elseif($late)
                                <span class="badge bg-danger">Telat</span>
                            @else
                                <span class="badge bg-success">Tepat</span>
                            @endif
                        </td>
                        <td>
                            {{ $a->checkout_time ? \Carbon\Carbon::parse($a->checkout_time)->format('H.i') : '-' }}
                        </td>
                        <td>
                            @if($a->checkout_time)
                                @if($a->status == 'early_leave')
                                    <span class="badge bg-warning text-dark">Cepat</span>
                                @else
                                    <span class="badge bg-success">Tepat</span>
                                @endif
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">Belum ada data absensi.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="d-flex justify-content-center my-4">
            <a href="{{ route('schedule.index') }}" class="btn btn-secondary" style="border-radius: 20px;box-shadow: 0 2px 6px rgba(0,0,0,0.5);font-weight: bold;">
                <i class="bi bi-arrow-left-circle"></i> Kembali ke Jadwal
            </a>
        </div>
        <div class="mt-2 d-flex justify-content-center">
            {{ $attendances->withQueryString()->links() }}
        </div>
    </div>
</div>
@endsection
