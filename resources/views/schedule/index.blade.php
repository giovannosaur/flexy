@extends('layouts.app')

@section('title', 'Daftar Jadwal')

@section('content')
<head>
    <style>
        body {
        font-family: "Segoe UI", sans-serif;
        margin: 0;
        padding: 0;
        background-color: #fff;
      }

      .navbar {
        background-color: #19597f;
        padding: 1rem 2rem;
      }

      .logo-circle {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background-color: white;
        display: flex;
        align-items: center;
        justify-content: center;
      }

      .logo-circle img {
        width: 100%;
        height: auto;
      }

      .navbar-nav .nav-link {
        color: white !important;
        font-weight: 500;
        text-transform: uppercase;
        margin-left: 1rem;
      }

      .navbar-nav .nav-link.active {
        font-weight: bold;
        text-shadow: 0px 4px 6px rgba(0, 0, 0, 0.3);
      }

      .main {
        text-align: center;
        margin: -2rem auto;
        max-width: 480px;
        font-family: "Verdana";
        padding: 5rem 1rem;
      }

      .main h2 {
        font-weight: bold;
        margin-bottom: 2rem;
      }

      .schedule-card {
        background-color: #f1f1f1;
        border-radius: 16px;
        box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.3);
        padding: 1rem 1rem 2.5rem;
        margin-bottom: 1rem;
        position: relative;
        text-align: left;
      }

      .schedule-date {
        font-weight: bold;
        font-size: 1rem;
        margin-bottom: 0.5rem;
      }

      .schedule-time {
        font-weight: bold;
        font-size: 1.5rem;
        text-align: center;
      }

      .badge-status {
        position: absolute;
        right: 16px;
        bottom: 16px;
        background-color: #329718;
        color: #fff;
        font-size: 0.75rem;
        font-weight: bold;
        padding: 4px 12px;
        border-radius: 20px;
      }

      footer {
        background-color: #19597f;
        color: white;
        position: fixed;
        bottom: 0;
        width: 100%;
        z-index: 1000;
      }
    </style>
</head>
<div class="main">
    <h2>Daftar Jadwal</h2>

    <form method="GET" class="mb-3">
        <select name="minggu" onchange="this.form.submit()" class="form-select w-auto d-inline-block">
            <option value="ini" {{ request('minggu', 'ini') == 'ini' ? 'selected' : '' }}>Minggu Ini</option>
            <option value="depan" {{ request('minggu') == 'depan' ? 'selected' : '' }}>Minggu Depan</option>
        </select>
    </form>

    @foreach($finalSchedules as $sch)
    <div class="schedule-card">
        <div class="schedule-date">
        {{ \Carbon\Carbon::parse($sch->meeting_date)->translatedFormat('D, d F Y') }}
        </div>
        <div class="schedule-time">
        {{ \Carbon\Carbon::parse($sch->start_time)->format('H.i') }} – {{ \Carbon\Carbon::parse($sch->end_time)->format('H.i') }}
        </div>
        @if($sch->type == 'flexy')
        <div class="badge-status">CHANGED</div>
        @endif
    </div>
    @endforeach
</div>

<div class="d-flex justify-content-center my-4">
    <a href="{{ route('absen.index') }}" class="btn btn-primary" style="border-radius: 20px; font-weight: bold;">
        <i class="bi bi-clipboard-data"></i> Lihat Riwayat Absen
    </a>
</div>

@endsection
