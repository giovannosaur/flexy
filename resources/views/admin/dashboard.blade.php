@extends('layouts.app')

@section('title', 'Admin Panel Flexy')

@push('head')
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

      .navbar .navbar-brand {
        display: flex;
        align-items: center;
        gap: 1rem;
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
        color: #fff !important;
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
        margin: 200px auto;
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
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
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
        color:black;
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
