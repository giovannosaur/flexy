@extends('layouts.app')

@push('head')
<style>
.main-content {
    text-align: center;
    margin: 120px auto;
    max-width: 600px;
    font-family: "Verdana";
}
.history-card {
    width: 90%;
    max-width: 400px;
    background-color: #f1f1f1;
    border-radius: 12px;
    padding: 1rem 1rem;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
    text-align: left;
    margin-top: 2rem;
    margin-bottom: -1.5rem;
}
.history-card h4 {
    font-weight: bold;
}
.badge-status {
    padding: 0.35rem 1rem;
    font-size: 0.75rem;
    font-weight: 600;
    border-radius: 20px;
    color: white;
}
.badge-status.approved {
    background-color: #155791;
}
.badge-status.awaiting {
    background-color: #ccaf2f;
}
.badge-status.denied {
    background-color: #c9302c;
}
</style>
@endpush

@section('content')
<main class="main-content">
  <h2 class="text-center fw-bold mb-4">
    Riwayat Pengajuan<br />Pemindahan Jadwal
  </h2>

  <div class="d-flex flex-column align-items-center gap-3">
    @forelse($requests as $r)
      <div class="history-card">
        <div class="d-flex justify-content-end">
          <strong>{{ \Carbon\Carbon::parse($r->created_at)->format('d M') }}</strong>
        </div>
        <h4 class="fw-bold text-center my-2">{{ $r->schedule_option }}</h4>
        <div class="d-flex justify-content-between align-items-end">
          <small class="text-muted">{{ $r->user_id }}<br />For: {{ \Carbon\Carbon::parse($r->requested_date)->format('d F Y') }}</small>
          @if($r->status == 'accepted')
            <span class="badge-status approved">APPROVED</span>
          @elseif($r->status == 'pending')
            <span class="badge-status awaiting">AWAITING</span>
          @else
            <span class="badge-status denied">DENIED</span>
          @endif
        </div>
      </div>
    @empty
      <div class="history-card text-center">Belum ada pengajuan.</div>
    @endforelse
  </div>
</main>
@endsection
