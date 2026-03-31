@extends('admin.layouts.auth')

@section('title', 'Sign In — Admin')

@section('content')
<div class="container">
  <div class="row justify-content-center align-items-center" style="min-height:100vh;">
    <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-6 col-sm-8 col-12">

      <div class="my-5 d-flex justify-content-center">
        <a href="{{ url('/login') }}">
          <img src="{{ asset('admin/assets/images/brand-logos/desktop-logo.png') }}" alt="logo" class="desktop-logo">
        </a>
      </div>

      <div class="card-1 custom-card">
        <div class="card-body p-5">
          <p class="h5 fw-semibold mb-2 text-center">Sign In</p>
          <p class="mb-4 text-muted op-7 fw-normal text-center">Welcome back!</p>

          @if($errors->any())
            <div class="alert alert-danger">
              <div class="fw-semibold mb-1">Fix the following:</div>
              <ul class="mb-0">
                @foreach($errors->all() as $e)
                  <li>{{ $e }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          <form method="POST" action="{{ url('/login') }}">
            @csrf

            <div class="row gy-3">
              <div class="col-xl-12">
                <label class="form-label text-default">Email</label>
                <input
                  type="email"
                  class="form-control form-control-lg"
                  name="email"
                  value="{{ old('email') }}"
                  placeholder="Enter email"
                  required
                >
              </div>

              <div class="col-xl-12 mb-2">
                <label class="form-label text-default d-block">Password</label>
                <div class="input-group">
                  <input
                    type="password"
                    class="form-control form-control-lg"
                    name="password"
                    placeholder="Password"
                    required
                  >
                  <button class="btn btn-light" type="button" onclick="togglePw(this)">
                    <i class="ri-eye-off-line align-middle"></i>
                  </button>
                </div>

                <div class="mt-2">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                    <label class="form-check-label text-muted fw-normal" for="remember">
                      Remember me
                    </label>
                  </div>
                </div>
              </div>

              <div class="col-xl-12 d-grid mt-2">
                <button type="submit" class="btn-1 white text-center">Sign In</button>
              </div>
            </div>
          </form>

          <div class="text-center">
            <p class="fs-12 text-muted mt-3">
              Don’t have an account?
              <a href="{{ url('/register') }}" class="custom-blue">Sign Up</a>
            </p>
          </div>

        </div>
      </div>

    </div>
  </div>
</div>

@push('scripts')
<script>
  function togglePw(btn){
    const input = btn.parentElement.querySelector('input');
    const icon = btn.querySelector('i');
    if (!input) return;

    const isPw = input.type === 'password';
    input.type = isPw ? 'text' : 'password';

    if (icon) {
      icon.className = isPw ? 'ri-eye-line align-middle' : 'ri-eye-off-line align-middle';
    }
  }
</script>
@endpush
@endsection