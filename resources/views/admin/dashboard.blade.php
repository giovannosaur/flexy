@extends('layouts.app')

@section('title', 'Admin Panel Flexy')

@push('head')
<style>
.main {
  text-align: center;
  margin: 100px auto;
  max-width: 600px;
  font-family: "Verdana";
}
.menu-box {
  display: inline-block;
  width: 160px;
  background-color: #f2f2f2;
  border-radius: 12px;
  padding: 1rem 0.75rem;
  margin: 1.5rem 0.75rem;
  box-shadow: 0 4px 6px rgba(0,0,0,0.3);
  text-align: center;
  transition: transform 0.2s ease;
}
.menu-box:hover {
  transform: translateY(-4px);
}
.menu-box i {
  font-size: 2rem;
  color: #000;
  margin-bottom: 0.5rem;
}
.menu-box p {
  margin: 0;
  font-weight: 600;
  font-size: 0.9rem;
  line-height: 1.2;
}
</style>
@endpush

@section('content')
<div class="main">
    <h2>
        <strong>Selamat {{ $greet ?? 'Pagi' }},<br />{{ auth()->user()->name ?? 'Sxxx' }}</strong>
    </h2>
    <p>{{ auth()->user()->position ?? 'Bidang pekerjaan' }}</p>

    <div class="d-flex justify-content-center flex-wrap">
        <a href="{{ route('admin.absensi') }}" class="menu-box text-decoration-none">
            <i class="bi bi-pencil-square"></i>
            <p>Attendance Data<br />Table</p>
        </a>
        <a href="{{ route('admin.approval') }}" class="menu-box text-decoration-none">
            <i class="bi bi-file-earmark-check"></i>
            <p>Approval</p>
        </a>
    </div>
</div>
@endsection
