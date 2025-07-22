@extends('layouts.app')

@push('head')
<style>
.main {
    text-align: center;
    margin: 30px auto;
    padding: 2rem;
    font-family: "Verdana";
}
.filter-section {
    margin-bottom: 2rem;
}
.filter-section input[type="date"] {
    padding: 0.4rem 1rem;
    border: 1px solid #ccc;
    border-radius: 8px;
    margin-top: 2rem;
}
.filter-section button {
    background-color: #1a66c6;
    color: white;
    padding: 0.4rem 1rem;
    border: none;
    border-radius: 8px;
    font-weight: 100;
    margin-left: -0.5rem;
}
.table th, .table td { text-align: center; vertical-align: middle; }
</style>
@endpush

@section('content')
<div class="main">
    <h2><strong>Index Absen</strong></h2>
    <form method="GET" 
        class="filter-section mb-2 d-flex align-items-baseline justify-content-center gap-2">
        <input type="date" name="date" value="{{ $filterDate }}" />
        <label for="perPage" class="mb-0 ms-2">Show</label>
        <input type="number" min="1" max="100" name="perPage" id="perPage"
                value="{{ $perPage }}" style="width:70px;">
        <span class="me-2">entries</span>

        <button type="submit" class="btn btn-primary me-1">Filter</button>
        @if($filterDate || $perPage != 10)
            <a href="{{ route('admin.absensi') }}" 
            class="btn btn-danger" 
            style="border-radius: 8px;"
            >Reset</a>
        @endif
    </form>
    <div class="d-flex flex-column align-items-center">
        <table class="table table-bordered align-middle w-auto">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
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
                    <td>{{ $a->user->id ?? '-' }}</td>
                    <td>{{ $a->user->name ?? '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($a->schedule->meeting_date ?? $a->checkin_time)
                                  ->format('d/m/Y') }}</td>
                    <td>{{ $a->schedule 
                          ? ($a->schedule->start_time . '–' . $a->schedule->end_time) 
                          : '-' }}</td>
                    <td>{{ $a->checkin_time 
                          ? \Carbon\Carbon::parse($a->checkin_time)->format('H.i') 
                          : '-' }}</td>
                    <td>
                        @php
                            $inTime   = $a->checkin_time 
                                        ? \Carbon\Carbon::parse($a->checkin_time) 
                                        : null;
                            $jadwalIn = $a->schedule 
                                        ? \Carbon\Carbon::parse(
                                              $a->schedule->meeting_date.' '.
                                              $a->schedule->start_time
                                          ) 
                                        : null;
                            $late     = $inTime && $jadwalIn 
                                        && $inTime->gt($jadwalIn->copy()->addMinutes(5));
                        @endphp
                        @if(!$inTime)
                            <span class="text-muted">-</span>
                        @elseif($late)
                            <span class="text-danger fw-bold">Telat</span>
                        @else
                            <span class="text-success fw-bold">Tepat</span>
                        @endif
                    </td>
                    <td>{{ $a->checkout_time 
                          ? \Carbon\Carbon::parse($a->checkout_time)->format('H.i') 
                          : '-' }}</td>
                    <td>
                        @if($a->checkout_time)
                            @if($a->status == 'early_leave')
                                <span class="text-warning fw-bold">Cepat</span>
                            @else
                                <span class="text-success fw-bold">Tepat</span>
                            @endif
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8">Belum ada data absensi.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
        <div class="mt-2">
            {{ $attendances->withQueryString()->links() }}
        </div>
    </div>
</div>
@endsection

