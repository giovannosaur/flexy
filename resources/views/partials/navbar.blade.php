<nav class="navbar navbar-expand-lg">
  <div class="container-fluid">
    <div class="navbar-brand">
      <div class="logo-circle">
        <img src="{{ asset('img/Logo_Bank BJB Syariah.png') }}" alt="Logo" width="30">
      </div>
    </div>
    <div class="navbar-nav ms-auto align-items-center d-flex flex-row">
      <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">HOME</a>
      <a class="nav-link" href="{{ route('flexy.request') }}">FLEXY TIME</a>
      <a class="nav-link" href="{{ route('schedule.index') }}">SCHEDULE</a>
      <a class="nav-link" href="{{ route('history') }}">HISTORY</a>
      <form action="{{ route('logout') }}" method="POST" class="d-inline m-0 p-0">
        @csrf
        <a href="#" class="nav-link" style="color:#fff; font-weight:500; text-transform:uppercase;"
          onclick="event.preventDefault(); this.closest('form').submit();">
          LOGOUT
        </a>
      </form>
    </div>
  </div>
</nav>

