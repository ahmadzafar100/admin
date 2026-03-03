<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
	<meta name="author" content="AdminKit">
	<meta name="keywords" content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link rel="shortcut icon" href="{{asset('img/icons/icon-48x48.png')}}" />

	<title>Login</title>

	<link href="{{asset('css/app.css')}}" rel="stylesheet">
	<link href="{{asset('css/alert.css')}}" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
</head>

<body>
	<main class="d-flex w-100">
		<div class="container d-flex flex-column">
			<div class="row vh-100">
				<div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 mx-auto d-table h-100">
					<div class="d-table-cell align-middle">

						<div class="text-center mt-4">
							<h1 class="h2">Login</h1>
							<p class="lead"></p>
						</div>

						<div class="card">
							<div class="card-body">
								<div class="m-sm-3">
									<form method="post" action="{{url('/admin/login')}}">
										@csrf
										@if(session()->has('err_msg'))
										<div class="alert alert-danger">
											{{session('err_msg')}}
										</div>
										@endif
										@if(session()->has('success_msg'))
										<div class="alert alert-success">
											{{session('success_msg')}}
										</div>
										@endif
										<div class="mb-3">
											<label class="form-label">Email</label>
											<input class="form-control form-control-lg" type="text" name="email" placeholder="Enter your email" />
											@error('email')
											<span class="text-danger">{{ $message }}</span>
											@enderror
										</div>
										<div class="mb-3">
											<label class="form-label">Password</label>
											<input class="form-control form-control-lg" type="password" name="password" placeholder="Enter your password" />
											@error('password')
											<span class="text-danger">{{ $message }}</span>
											@enderror
										</div>
										<div>
											<div class="mb-3 text-center" id="captcha-container">
												<img src="{{ url('/captcha-image') }}" alt="Captcha">
											</div>
											<input type="text" name="captcha" class="form-control form-control-lg" placeholder="Enter Captcha">

											@error('captcha')
											<span class="text-danger">{{ $message }}</span>
											@enderror
										</div>
										<div class="d-grid gap-2 mt-3">
											<button type="submit" class="btn btn-lg btn-primary">Login</button>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</main>

	<script src="{{asset('js/app.js')}}"></script>
	@include('sweetalert::alert')
</body>

</html>