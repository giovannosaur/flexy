@extends('layouts.app')

@push('head')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
.main {
    text-align: center;
    margin: 100px auto;
    padding: -0.5px;
    font-family: "Verdana";
}
.table th, .table td { text-align: center; vertical-align: middle; }
.date-filter-form { margin-top: 2rem; }
</style>
@endpush

@section('content')
<div class="main">
    <h2><strong>Index Absen</strong></h2>

    <form method="GET" class="date-filter-form">
        <input type="date" name="date" value="{{ $filterDate }}" class="form-control w-auto d-inline-block mb-2" />
        <button type="submit" class="btn btn-primary mb-1">Filter</button>
        @if($filterDate)
            <a href="{{ route('admin.absensi') }}" class="btn btn-link mb-1">Reset</a>
        @endif
    </form>

    <div>
        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Tanggal</th>
                    <th>Jam Kerja</th>
                    <th>Recorded at</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($attendances as $a)
                    <tr>
                        <td>{{ $a->user->id ?? '-' }}</td>
                        <td>{{ $a->user->name ?? '-' }}</td>
                        <td>{{ \Carbon\Carbon::parse($a->schedule->meeting_date ?? $a->created_at)->format('d/m/Y') }}</td>
                        <td>
                            {{ $a->schedule ? ($a->schedule->start_time . '–' . $a->schedule->end_time) : '-' }}
                        </td>
                        <td>{{ \Carbon\Carbon::parse($a->created_at)->format('H.i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">Belum ada data absensi.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-2 d-flex justify-content-center">
            {{ $attendances->withQueryString()->links() }}
        </div>
    </div>
</div>
@endsection
