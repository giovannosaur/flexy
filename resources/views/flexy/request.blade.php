@extends('layouts.app')

@section('title', 'Request Flexy Time')

@push('head')
<style>
body {
        font-family: "Segoe UI", sans-serif;
        margin: 0;
        padding-bottom: 60px;
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

      main {
        text-align: center;
        margin: 150px auto;
        max-width: 600px;
        font-family: "Verdana";
        font-weight: bold;
      }

      .time-option {
        background: #f1f1f1;
        padding: 15px;
        margin: 20px auto;
        width: 350px;
        border-radius: 12px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
      }

      .time-option p {
        font-size: 25px;
        font-weight: bold;
        margin-bottom: 10px;
      }

      .time-option button {
        background-color: #155791;
        color: white;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.5);
        font-weight: bold;
        border-radius: 20px;
        padding: 8px 24px;
        border: none;
        font-size: 15px
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
@endpush

@section('content')

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
  const input = document.querySelector('input[type="date"][name="requested_date"]');
  if(!input) return;
  input.addEventListener('input', function() {
    const val = this.value;
    const day = new Date(val).getDay();
    if (day === 0 || day === 6) { // 0 = Minggu, 6 = Sabtu
      alert('Hanya bisa pilih hari kerja (Senin-Jumat)!');
      this.value = '';
    }
  });
  // Juga, block via keyboard / calendar picker
  input.addEventListener('keydown', function(e) {
    setTimeout(() => {
      const val = this.value;
      const day = new Date(val).getDay();
      if (day === 0 || day === 6) {
        this.value = '';
      }
    }, 1);
  });
});
</script>
@endpush

<main>
  <h2>
    <strong>Pengajuan Flexy</strong>
  </h2>
  @if(session('success'))
      <div class="alert alert-success mt-2">{{ session('success') }}</div>
  @endif
  @if(session('error'))
      <div class="alert alert-danger mt-2">{{ session('error') }}</div>
  @endif
  <form action="{{ url('/flexy/request') }}" method="POST" style="width:100%">
    @csrf
    <div class="mt-5">
      <input
        type="date"
        name="requested_date"
        class="form-control w-auto mx-auto"
        min="{{ $minDate }}"
        max="{{ $maxDate }}"
        required
        style="box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.3)"
      />
    </div>

    <div class="time-option">
      <p>09.00 - 18.00</p>
      <button type="submit" name="schedule_option" value="09:00-18:00">CHOOSE</button>
    </div>
    <div class="time-option">
      <p>10.00 - 19.00</p>
      <button type="submit" name="schedule_option" value="10:00-19:00">CHOOSE</button>
    </div>
  </form>
</main>
@endsection
