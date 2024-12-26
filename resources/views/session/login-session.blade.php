@extends('layouts.user_type.guest')

@section('title', 'Otoparts - Login')

@section('content')

<main class="main-content mt-0">
  <section>
    <div class="page-header min-vh-100 d-flex align-items-center">
      <div class="container">
        <div class="row justify-content-center align-items-center">
          <!-- Form Login -->
          <div class="col-xl-4 col-lg-5 col-md-6 d-flex flex-column mx-auto">
            <div class="card card-plain shadow-lg p-4">
              <div class="card-header pb-0 text-left bg-transparent">
                <h3 class="font-weight-bolder text-info text-gradient">Welcome back</h3>
              </div>
              <div class="card-body">
                <form role="form" method="POST" action="session">
                  @csrf
                  <label>Username</label>
                  <div class="mb-3">
                    <input type="text" class="form-control" name="username" id="username" placeholder="Username" aria-label="Username" aria-describedby="username-addon">
                    @error('username')
                      <p class="text-danger text-xs mt-2">{{ $message }}</p>
                    @enderror
                  </div>
                  <label>Password</label>
                  <div class="mb-3">
                    <input type="password" class="form-control" name="password" id="password" placeholder="Password" aria-label="Password" aria-describedby="password-addon">
                    @error('password')
                      <p class="text-danger text-xs mt-2">{{ $message }}</p>
                    @enderror
                  </div>
                  <div class="text-center">
                    <button type="submit" class="btn bg-gradient-info w-100 mt-4 mb-0">Sign in</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <!-- Gambar -->
          <div class="col-xl-6 col-lg-7 d-none d-md-block">
            <div class="position-relative h-100 d-flex justify-content-center align-items-center">
              <img src="/assets/img/logo.png" alt="Logo" class="img-fluid" style="max-height: 100%; max-width: 100%;">
            </div>
          </div>          
        </div>
      </div>
    </div>
  </section>
</main>

@endsection
