@extends('layout.auth')
@section('content')

<div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center align-items-center min-vh-100">

        <div class="col-xl-6 col-lg-6 col-md-9">

            <div class="card o-hidden border-0 shadow-lg">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <!-- <div class="col-lg-6 d-none d-lg-block bg-login-image"></div> -->
                        <div class="col-lg-12">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Login Page</h1>
                                </div>
                                <form id="form-data" class="user" method="POST" action="{{ route('auth.check_login') }}">
                                    @csrf
                                    <div class="form-group">
                                        <input type="text" name="email" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter Email Address...">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Password">
                                    </div>
                                    <button class="btn btn-primary btn-user btn-block" id="btn_login">
                                        <i class="loading-icon fas fa-spinner fa-spin" style="visibility: hidden;"></i><span class="btn-txt">Login</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>

@endsection

@section('js_script')
<script>
    var url, method;

    $(document).ready(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        const token = localStorage.getItem('api_token');

        if (token) {
            // Kirim request ke API untuk cek token valid
            $.ajax({
                url: '/api/user', // asumsi route ini butuh token dan return user data
                method: 'GET',
                headers: {
                    'Authorization': 'Bearer ' + token
                },
                success: function(response) {
                    // Jika token valid, redirect ke dashboard
                    // window.location.href = '/dashboard';
                    // console.log(response);
                    // console.log('ini');
                    window.location.href = '/dashboard';
                },
                error: function(xhr) {
                    // Jika token invalid/expired, biarkan tetap di halaman login
                    console.log('Token expired atau tidak valid');
                }
            });
        }


        $('#btn_login').click(function() {
            event.preventDefault(); // Mencegah form submit default
            // alert('hehe');
            // return;
            // var code = $("#code_npa").val();
            $(".result").text("");
            $(".loading-icon").css("visibility", "visible");
            $("#btn_login").attr("disabled", true);
            $(".btn-txt").text("Dalam Proses, Silahkan Ditunggu...");

            method = 'POST';
            url = "{{ route('auth.check_login') }}";
            var data_form = $('#form-data').serialize();
            var data_token = $('meta[name="csrf-token"]').attr('content');

            if (data_token === undefined) {
                // Jika token tidak ada, bisa menggunakan cara lain (misal fallback)
                console.error("CSRF Token tidak ditemukan!");
                return;
            }

            $.ajax({
                url: url,
                method: 'POST',
                data: data_form + '&_token=' + data_token,
                cache: false,
                dataType: 'json',
                success: function(response) {
                    console.log('Login Success!');
                    console.log('Email: ' + response.email);
                    console.log('Token: ' + response.token);
                    console.log(data_token);
                    localStorage.setItem('api_token', response.token);
                    window.location.href = '/dashboard';
                },
                error: function(response) {

                    console.log(response);
                }
            });
        });
    });
</script>
@endsection