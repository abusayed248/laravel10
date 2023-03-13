@extends('layouts.admin')


@section('title', 'Admin Login')

@section('admin_content')

<div class="bg-primary">
	<div id="layoutAuthentication">
	    <div id="layoutAuthentication_content">
	        <main>
	            <div class="container">
	                <div class="row justify-content-center">
	                    <div class="col-lg-5">
	                        <div class="card shadow-lg border-0 rounded-lg mt-5">
	                            <div class="card-header"><h3 class="text-center font-weight-light my-4">Admin Login</h3></div>
	                            
	                            <div class="card-body">
	                                <form  method="POST" action="{{ route('login') }}">
	                                	@csrf
	                                	@if(Session::has('error'))
				                            <div class="alert alert-danger" role="alert">
											  {{ Session::get('error') }}
											</div>
										@endif

	                                    <div class="form-floating mb-3">
	                                        <input class="form-control" type="email" name="email" value="{{ old('email') }}">
	                                        <label for="inputEmail">Email address</label>

			                                @error('email')
			                                    <strong class="text-danger">
			                                        <strong>{{ $message }}</strong>
			                                    </strong>
			                                @enderror
	                                    </div>
	                                    <div class="form-floating mb-3">
	                                        <input class="form-control" id="password" name="password" type="password" placeholder="Password" />
	                                        <label for="password">Password</label>

	                                        @error('password')
			                                    <strong class="text-danger">
			                                        <strong>{{ $message }}</strong>
			                                    </strong>
			                                @enderror
	                                    </div>
	                                    <div class="form-check mb-3">
	                                        <input class="form-check-input" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} type="checkbox"  />
	                                        <label class="form-check-label" for="remember">Remember Password</label>
	                                    </div>
	                                    <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
	                                        @if (Route::has('password.request'))
			                                    <a class="small" href="{{ route('password.request') }}">Forgot Your Password?</a>
			                                @endif
	                                        <button class="btn btn-primary" type="submit">Login</button>
	                                    </div>
	                                </form>
	                            </div>
	                        </div>
	                    </div>
	                </div>
	            </div>
	        </main>
	    </div>
	</div>
</div>


@endsection