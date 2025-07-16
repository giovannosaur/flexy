@extends('layouts.app')

@push('head')
<style>
    .filter-buttons .btn {
        margin-right: 0.5rem;
        font-weight: 600;
        border-radius: 20px;
        padding: 0.4rem 1rem;
        font-size: 0.9rem;
        margin-top: 2rem;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.5);
      }
    .btn-all {
        background-color: #155791;
        color: white;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.5);
      }
    .table td, .table th {
        vertical-align: middle;
        text-align: center;
      }
    .btn-action {
        border: none;
        padding: 0.3rem 0.6rem;
        border-radius: 50px;
        font-size: 1rem;
        box-shadow: 0 2px 6px rgba(0,0,0,0.3);
    }
    .btn-approve {
        background-color: #28a745;
        color: white;
        margin-right: 0.4rem;
      }
    .btn-deny {
        background-color: #dc3545;
        color: white;
      }
    .btn-approve:hover, .btn-deny:hover {
        opacity: 0.9;
      }
</style>
@endpush

@section('content')
<div class="main">
    <h2>
        <strong>Permintaan Pemindahan<br />Jadwal</strong>
    </h2>

    <div class="filter-buttons">
        <a href="{{ route('admin.approval', ['status'=>'all']) }}"
        class="btn {{ ($status == 'all' || !$status) ? 'btn-all' : 'btn-secondary' }}">ALL</a>
        <a href="{{ route('admin.approval', ['status'=>'approved']) }}"
        class="btn {{ $status == 'approved' || $status == 'accepted' ? 'btn-all' : 'btn-secondary' }}">APPROVED</a>
        <a href="{{ route('admin.approval', ['status'=>'denied']) }}"
        class="btn {{ $status == 'denied' || $status == 'declined' ? 'btn-all' : 'btn-secondary' }}">DENIED</a>
        <a href="{{ route('admin.approval', ['status'=>'awaiting']) }}"
        class="btn {{ $status == 'awaiting' || $status == 'pending' ? 'btn-all' : 'btn-secondary' }}">AWAITING</a>
    </div>


    <div class="table-responsive mt-4">
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Requested at</th>
                    <th>Flexy Time</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            @forelse($requests as $r)
                <tr>
                    <td>{{ $r->user->id }}</td>
                    <td>{{ \Carbon\Carbon::parse($r->created_at)->format('d/m/Y H:i') }}</td>
                    <td>
                        {{ \Carbon\Carbon::parse($r->requested_date)->format('d/m/Y') }}<br>
                        {{ $r->schedule_option }}
                    </td>
                    <td>
                        @if($r->status == 'pending')
                            Awaiting
                        @elseif($r->status == 'accepted')
                            <span class="text-success fw-bold">Approved</span>
                        @else
                            <span class="text-danger fw-bold">Denied</span>
                        @endif
                    </td>
                    <td>
                        @if($r->status == 'pending')
                            <form action="{{ route('admin.approval.approve', $r->id) }}" method="POST" class="d-inline">@csrf
                                <button type="submit" class="btn-action btn-approve" title="Approve">
                                    <i class="bi bi-check"></i>
                                </button>
                            </form>
                            <form action="{{ route('admin.approval.deny', $r->id) }}" method="POST" class="d-inline">@csrf
                                <button type="submit" class="btn-action btn-deny" title="Deny">
                                    <i class="bi bi-x"></i>
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="5">Belum ada request.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
