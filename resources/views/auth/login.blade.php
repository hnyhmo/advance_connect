<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="/img/favicon.png">

    <title>{{ config('app.name', 'CMS') }}</title>
	
	<!-- Styles -->
    <link href="{{ asset('theme/fontAwesome/css/fontawesome-all.min.css')}}" rel="stylesheet">
    <link href="{{ asset('theme/css/lib/themify-icons.css')}}" rel="stylesheet">
    <link href="{{ asset('theme/css/lib/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ asset('theme/css/lib/nixon.css')}}" rel="stylesheet">
    <link href="{{ asset('theme/css/style.css')}}" rel="stylesheet">
</head>

<body class="bg-default">

	<div class="Nixon-login">
		<div class="container">
			<div class="row">
				<div style="width: 360px; margin: auto">
					<div class="login-content">
						<div class="login-form">
							<h4 class="text-center">
                                <img src="/img/logo.png" style="width: 100%" />
                            </h4>
							
							@if(request()->session()->has('user_data'))
								<form class="form-horizontal" method="POST" action="{{ route('login_verify') }}">
									{{ csrf_field() }}
									@if ($errors->has('message'))         
										<div class='form-group'>
										<span class="text-danger">
											<strong>{{$errors->first('message')}}</strong>
										</span>
										</div>
									@endif
									@if ($errors->has('message_success'))         
										<div class='form-group'>
										<span class="text-success">
											<strong>{{$errors->first('message_success')}}</strong>
										</span>
										</div>
									@endif

									
									<p>A message with a verification code has been sent to your email. Enter the code and click verify.</p>
									<div>
										<input id="code" type="text" placeholder="Verification code" class="form-control" name="code" value="{{ old('code') }}" required autofocus>
									</div>
									<div class='text-right'>
										<button class="btn btn-dark btn-flat m-b-30 m-t-30 submit">Verify</button>
									</div>
								</form>

								<form class="form-horizontal" method="POST" action="{{ route('resend_verify_code') }}">
								{{ csrf_field() }}
									<button class="btn btn-default btn-flat m-b-30 submit">Resend Verification Code</button>
								<form>

								<a href="{{route('back_to_login')}}" class="btn btn-warning btn-flat m-b-30">Back to Login</a>
							@else
								<form method="POST" action="{{ route('login') }}">
									@csrf
									@if($errors->has('message'))  
										<div class="alert alert-danger">
											<strong>Invalid login!</strong> {{$errors->first('message')}}
										</div>
									@endif
									<div class="form-group">
										<label>Email address</label>
										<input type="email" class="form-control" name='email' placeholder="Email" required>
										@if($errors->has('email'))  
											<span class="text-error" role="alert">
												<strong>{{$errors->first('email')}}</strong>
											</span>
										@endif
									</div>
									
									<div class="form-group">
										<label>Password</label>
										<input type="password" class="form-control" name='password' placeholder="Password" required>
									</div>
									<div class="checkbox">
										<label>
											<input type="checkbox"> Remember Me
										</label>
										<!-- <label class="pull-right">
											<a href="">Forgotten Password?</a>
										</label> -->
										
									</div>
									<button type="submit" style="background: #013335" class="btn btn-info btn-flat m-b-30 m-t-30">Sign in</button>
									
								</form>
							@endif
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

</body>

</html>