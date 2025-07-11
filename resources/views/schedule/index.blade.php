@extends('layouts.app')

@section('title', 'Daftar Jadwal')

@section('content')
<head>
    <style>
        .main {
        text-align: center;
        margin: 30px auto;
        max-width: 480px;
        padding: 2rem 1rem;
        }

        .schedule-card {
        background-color: #f2f2f2;
        border-radius: 16px;
        box-shadow: 4px 4px 6px rgba(0,0,0,0.1);
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
        font-size: 1.3rem;
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
        box-shadow: 1px 1px 2px rgba(0,0,0,0.2);
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
@endsection
