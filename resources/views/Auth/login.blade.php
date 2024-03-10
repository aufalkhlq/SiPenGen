<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>Kanakku - Bootstrap Admin HTML Template</title>
    <link rel="shortcut icon" href="{{ asset('assets/img/favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <script src="https://unpkg.com/sweetalert@2"></script>
</head>

<body>
    <div class="main-wrapper login-body">
        <div class="login-wrapper">
            <div class="container">
                <div class="loginbox">
                    <div class="login-right">
                        <div id="alertMessage" class="alert-message"></div>
                        <div class="login-right-wrap">
                            <h1>Login</h1>
                            <p class="account-subtitle">Access to our dashboard</p>
                            <form id="login-form" action="{{ route('login.post') }}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label class="form-control-label">Email Address</label>
                                    <input type="email" class="form-control" name="email" >
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">Password</label>
                                    <div class="pass-group">
                                        <input type="password" class="form-control pass-input" name="password">
                                        <span class="fas fa-eye toggle-password"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="cb1"
                                                    name="remember">
                                                <label class="custom-control-label" for="cb1">Remember me</label>
                                            </div>
                                        </div>
                                        <div class="col-6 text-end">
                                            <a class="forgot-link" href="{{ url('forgot-password.html') }}">Forgot
                                                Password ?</a>
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-lg btn-block btn-primary w-100" type="button"
                                    id="login-button">Login</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/feather.min.js') }}"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#login-button').click(function(e) {
                e.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: '{{ route('login.post') }}',
                    data: $('#login-form').serialize(),
                    success: function(response) {
                        if (response.success) {
                            swal({
                                    title: "Success!",
                                    text: response.success,
                                    icon: "success",
                                    button: "OK",
                                })
                                .then((value) => {
                                    window.location.href = response.redirect;
                                });
                        } else if (response.error) {
                            swal({
                                title: "Error!",
                                text: response.error,
                                icon: "error",
                                button: "OK",
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        // Handle validation errors if needed
                        var jsonResponse = JSON.parse(xhr.responseText);
                        var errorMessage = jsonResponse.error || 'Username or password cannot be empty!';
                        swal({
                            title: "Error!",
                            text: errorMessage,
                            icon: "error",
                            button: "OK",
                        });
                    }
                });
            });
        });
    </script>

</body>

</html>
