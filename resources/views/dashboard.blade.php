@extends('layouts.app')

@section('title', 'Dashboard Flexy')

@section('content')
    @php
    $hour = now()->format('H');
    if ($hour >= 5 && $hour < 11) {
        $greet = 'Pagi';
    } elseif ($hour >= 11 && $hour < 15) {
        $greet = 'Siang';
    } elseif ($hour >= 15 && $hour < 18) {
        $greet = 'Sore';
    } else {
        $greet = 'Malam';
    }
    @endphp

    <h2><strong>
        Selamat {{ $greet }},<br>{{ auth()->user()->name ?? 'Guest' }}
    </strong></h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card-schedule">
        <div class="d-flex justify-content-between mb-2">
            <strong>Working Schedule</strong>
            <strong>{{ $todaySchedule['date'] }}</strong>
        </div>
        
        @if ($todaySchedule['id'])
            <h3>{{ $todaySchedule['time'] }}</h3>
            <form method="POST" action="{{ route('checkin') }}" id="checkin-form">
                @csrf
                <input type="hidden" name="location_coordinates" id="location_coordinates">
                <button class="btn-checkin mt-2" {{ $alreadyCheckedIn ? 'disabled' : '' }}>
                    {{ $alreadyCheckedIn ? 'SUDAH ABSEN' : 'CHECK IN' }}
                </button>
            </form>
            @push('scripts')
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const form = document.getElementById('checkin-form');
                    if(form){
                        form.addEventListener('submit', function(e){
                            e.preventDefault();
                            if (navigator.geolocation) {
                                navigator.geolocation.getCurrentPosition(function(position) {
                                    let coords = position.coords.latitude + ',' + position.coords.longitude;
                                    document.getElementById('location_coordinates').value = coords;
                                    form.submit();
                                }, function(error){
                                    alert('Gagal mendapatkan lokasi. Coba lagi.');
                                });
                            } else {
                                alert('Geolocation tidak didukung browser.');
                            }
                        });
                    }
                });
            </script>
            @endpush
        @else
            <div class="alert alert-info mt-3">
                Hari ini libur atau tidak ada jadwal
            </div>
        @endif
    </div>

    <div class="d-flex justify-content-center flex-nowrap">
        <a href="{{ route('flexy.request') }}" class="icon-box text-decoration-none">
            <i class="bi bi-calendar3"></i>
            <p>Request Flexy</p>
        </a>
        <a href="{{ route('schedule.index') }}" class="icon-box text-decoration-none">
            <i class="bi bi-calendar2-check-fill"></i>
            <p>Schedule</p>
        </a>
        <a href="{{ route('history') }}" class="icon-box text-decoration-none">
            <i class="bi bi-clipboard-data"></i>
            <p>Riwayat <br>Pengajuan Flexy</p>
        </a>
        @if(in_array(auth()->user()->role, ['Level 2', 'Level 3']))
            <a href="{{ route('admin.dashboard') }}" class="icon-box text-decoration-none">
                <i class="bi bi-person-gear"></i>
                <p>Admin</p>
            </a>
        @endif
    </div>
@endsection
