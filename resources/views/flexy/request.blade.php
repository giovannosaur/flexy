@extends('layouts.app')

@section('title', 'Request Flexy Time')

@push('head')
<style>
body {
  min-height: 100vh;
  background: #f5f7fa;
}
main {
  min-height: calc(100vh - 120px); /* Atur sesuai tinggi navbar+footer */
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  text-align: center;
  max-width: 400px;
  margin: 0 auto;
  font-family: "Verdana";
  font-weight: bold;
}
.time-option {
  background: #f1f1f1;
  padding: 15px;
  margin: 18px 0;
  width: 100%;
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
}
.form-control.w-auto {
  min-width: 180px;
  max-width: 220px;
  margin: 0 auto;
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
  <h3>
    <strong>Pengajuan Flexy</strong>
  </h3>
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
