<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>Login - Sistem Jadwal</title>
    <link rel="shortcut icon" href="{{ asset('assets/img/favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <meta name="csrf-token" content="{{ csrf_token() }}">
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
                                    <label class="form-control-label">Email atau NIM</label>
                                    <input type="text" class="form-control" name="identifier">
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">Password</label>
                                    <div class="pass-group">
                                        <input type="password" class="form-control pass-input" name="password">
                                        <span class="fas fa-eye toggle-password"></span>
                                    </div>
                                </div>
                                <button class="btn btn-lg btn-block btn-primary w-100" type="submit" id="login-button">Login</button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/plugins/sweetalert/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/feather.min.js') }}"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>

    <script type="text/javascript">
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
    </script>
    <script>
        $(document).ready(function() {
            $('#login-button').click(function(e) {
                e.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: '{{ route('login.post') }}',
                    data: $('#login-form').serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            swal.fire({
                                    title: "Success!",
                                    text: response.success,
                                    icon: "success",
                                    timer: 1000,
                                    button: "OK",
                                })
                                .then((value) => {
                                    console.log(response.redirect); // Tambahkan log ini
                                    window.location.href = response.redirect;

                                });
                        } else if (response.error) {
                            toastr.error(response.error);
                        }
                    },
                    error: function(xhr, status, error) {
                        // Handle validation errors if needed
                        var jsonResponse = JSON.parse(xhr.responseText);
                        var errorMessage = jsonResponse.error ||
                            'Username or password cannot be empty!';
                        toastr.error(errorMessage);
                    }
                });
            });
        });
    </script>

</body>

</html>
