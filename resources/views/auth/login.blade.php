@extends('layouts.app')

@section('title','Đăng nhập - CloudStay')

@section('content')

<div class="login-page">

```
<div class="container">

    <div class="row justify-content-center align-items-center min-vh-100">

        <div class="col-lg-10">

            <div class="login-card shadow-lg">

                <div class="row g-0">


                    <!-- LEFT CONTENT -->
                    <div class="col-lg-6 login-banner">

                        <div class="login-overlay"></div>

                        <div class="login-info">

                            <h1>
                                CloudStay
                            </h1>

                            <h3>
                                Tìm nơi nghỉ dưỡng
                                hoàn hảo cho bạn
                            </h3>

                            <p>
                                Đặt homestay nhanh chóng,
                                an toàn và tiện lợi.
                                Hàng nghìn địa điểm chờ bạn khám phá.
                            </p>


                            <div class="login-feature">

                                <div>
                                    🏡
                                    <span>
                                        Homestay chất lượng
                                    </span>
                                </div>


                                <div>
                                    🔒
                                    <span>
                                        Thanh toán an toàn
                                    </span>
                                </div>


                                <div>
                                    ⭐
                                    <span>
                                        Đánh giá uy tín
                                    </span>
                                </div>

                            </div>

                        </div>

                    </div>



                    <!-- RIGHT FORM -->
                    <div class="col-lg-6 bg-white">

                        <div class="login-form">


                            <h2>
                                Đăng nhập
                            </h2>

                            <p class="text-muted">
                                Chào mừng bạn quay trở lại CloudStay
                            </p>



                            @if(session('error'))

                            <div class="alert alert-danger">
                                {{session('error')}}
                            </div>

                            @endif



                            <form method="POST"
                                  action="/login">

                                @csrf


                                <!-- Email -->

                                <div class="mb-3">

                                    <label class="form-label">
                                        Email
                                    </label>


                                    <input type="email"
                                           name="email"
                                           class="form-control"
                                           placeholder="Nhập email"
                                           required>

                                </div>



                                <!-- Password -->

                                <div class="mb-3">

                                    <label class="form-label">
                                        Mật khẩu
                                    </label>


                                    <input type="password"
                                           name="password"
                                           class="form-control"
                                           placeholder="Nhập mật khẩu"
                                           required>

                                </div>



                                <div class="d-flex justify-content-between mb-3">

                                    <div>
                                        <input type="checkbox">
                                        Ghi nhớ đăng nhập
                                    </div>


                                    <a href="#">
                                        Quên mật khẩu?
                                    </a>

                                </div>



                                <button class="btn btn-primary w-100">

                                    Đăng nhập

                                </button>


                            </form>



                            <!-- GOOGLE LOGIN -->

                            <div class="text-center my-3">

                                <span class="text-muted">
                                    Hoặc
                                </span>

                            </div>


                            <a href="/auth/google"
                               class="btn btn-google w-100">

                                <img src="https://cdn-icons-png.flaticon.com/512/300/300221.png">

                                Đăng nhập bằng Google

                            </a>



                            <p class="text-center mt-4">

                                Chưa có tài khoản?

                                <a href="/register">
                                    Đăng ký ngay
                                </a>

                            </p>


                        </div>

                    </div>


                </div>

            </div>

        </div>


    </div>

</div>
```

</div>

@endsection
