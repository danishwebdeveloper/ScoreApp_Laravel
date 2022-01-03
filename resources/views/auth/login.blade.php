@extends('layouts.auth')


@section('content')
	<!-- BEGIN LOGIN FORM -->
	<form class="login-form" action="{{ route('login') }}" method="post">
		{{ csrf_field() }}
		<div class="form-title">
		    <span class="form-title">Welcome Here, Please Login</span>
		</div>
		<div class="alert alert-danger display-hide">
		    <button class="close" data-close="alert"></button>
		    <span> Enter your email/username and password! </span>
		</div>
		@if (count($errors->all()) > 0)
		<div class="alert alert-danger">
		    <button class="close" data-close="alert"></button>
		    @foreach ($errors->all() as $error)
		    <span> {{ $error }} </span>
		    @endforeach
		</div>
		@endif

		<div class="form-group">
		    <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
		    <label class="control-label visible-ie8 visible-ie9">Email/Username</label>
		    <input class="form-control form-control-solid placeholder-no-fix" type="text"  placeholder="Email/Username" name="email" value="{{ old('email') }}" /> 
		</div>

		<div class="form-group">
		    <label class="control-label visible-ie8 visible-ie9">Password</label>
		    <input class="form-control form-control-solid placeholder-no-fix" type="password" autocomplete="off" placeholder="Password" name="password" />
		</div>

		<div class="form-actions">
		    <button type="submit" class="btn red btn-block uppercase">Login</button>
		</div>

		<!-- <div class="form-actions">
		    <div class="pull-left">
		        <label class="rememberme mt-checkbox mt-checkbox-outline">
		            <input type="checkbox" name="remember" value="1" /> Remember me
		            <span></span>
		        </label>
		    </div>
		    <div class="pull-right forget-password-block">
		        <a href="javascript:;" id="forget-password" class="forget-password">Forgot Password?</a>
		    </div>
		</div> -->
	</form>
	<!-- END LOGIN FORM -->

	<!-- BEGIN FORGOT PASSWORD FORM -->
	<form class="forget-form" action="index.html" method="post">
	    <div class="form-title">
	        <span class="form-title">Forget Password ?</span>
	        <span class="form-subtitle">Enter your e-mail to reset it.</span>
	    </div>
	    <div class="form-group">
	        <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Email" name="email" /> </div>
	    <div class="form-actions">
	        <button type="button" id="back-btn" class="btn btn-default">Back</button>
	        <button type="submit" class="btn btn-primary uppercase pull-right">Submit</button>
	    </div>
	</form>
	<!-- END FORGOT PASSWORD FORM -->
@endsection