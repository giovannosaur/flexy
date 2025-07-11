{{-- resources/views/login.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login Flexy</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
  <!-- Custom CSS -->
  <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
</head>
<body>
  <div class="login-wrapper">
    <div class="login-box">
      <div class="login-logo mb-0 text-center">
        <img src="{{ asset('img/Logo_Bank BJB Syariah.png') }}" alt="bank bjb syariah" />
      </div>

      <!-- Laravel Login Form -->
      <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="form-group mb-2">
          <div class="input-icon">
            <i class="bi bi-person"></i>
            <input
              type="text"
              name="login"
              placeholder="NIK / EMAIL"
              class="form-control"
              required
              autofocus
              value="{{ old('login') }}"
            />
          </div>
          @error('login')
            <div class="text-danger small mt-1">{{ $message }}</div>
          @enderror
        </div>
        <div class="form-group mb-3">
          <div class="input-icon">
            <i class="bi bi-lock"></i>
            <input
              type="password"
              name="password"
              placeholder="PASSWORD"
              class="form-control"
              required
            />
          </div>
          @error('password')
            <div class="text-danger small mt-1">{{ $message }}</div>
          @enderror
        </div>
        <button type="submit" class="btn btn-login w-100">LOGIN</button>
        @if ($errors->any())
          <div class="text-danger small mt-2">{{ $errors->first() }}</div>
        @endif
</form>
    </div>
  </div>
</body>
</html>
