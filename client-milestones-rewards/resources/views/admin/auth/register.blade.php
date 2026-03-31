@extends('admin.layouts.auth')

@section('title', 'Sign Up — Admin')

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
          <p class="h5 fw-semibold mb-2 text-center">Sign Up</p>
          <p class="mb-4 text-muted op-7 fw-normal text-center">Create your admin account.</p>

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

          <form method="POST" action="{{ url('/register') }}">
            @csrf

            <div class="row gy-3">
              <div class="col-xl-12">
                <label class="form-label text-default">Name</label>
                <input
                  type="text"
                  class="form-control form-control-lg"
                  name="name"
                  value="{{ old('name') }}"
                  placeholder="Enter your name"
                  required
                >
              </div>

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

              <div class="col-xl-12">
                <label class="form-label text-default">Password</label>
                <input
                  type="password"
                  class="form-control form-control-lg"
                  name="password"
                  placeholder="Create password"
                  required
                >
              </div>

              <div class="col-xl-12">
                <label class="form-label text-default">Confirm Password</label>
                <input
                  type="password"
                  class="form-control form-control-lg"
                  name="password_confirmation"
                  placeholder="Confirm password"
                  required
                >
              </div>

              <div class="col-xl-12 d-grid mt-2">
                <button type="submit" class="btn-1 white text-center">Create Account</button>
              </div>
            </div>
          </form>

          <div class="text-center">
            <p class="fs-12 text-muted mt-3">
              Already have an account?
              <a href="{{ url('/login') }}" class="custom-blue">Sign In</a>
            </p>
          </div>

        </div>
      </div>

    </div>
  </div>
</div>
@endsection