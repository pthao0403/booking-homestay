@extends('layouts.app')

@section('title','Đăng ký - CloudStay')

@section('content')

<div class="login-page">

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
                                Bắt đầu hành trình
                                khám phá homestay
                            </h3>


                            <p>
                                Tạo tài khoản miễn phí để
                                đặt phòng nhanh chóng,
                                lưu lịch sử booking và nhận
                                ưu đãi hấp dẫn.
                            </p>



                            <div class="login-feature">


                                <div>
                                    🏡
                                    <span>
                                        Hàng nghìn homestay
                                    </span>
                                </div>


                                <div>
                                    📅
                                    <span>
                                        Quản lý đặt phòng dễ dàng
                                    </span>
                                </div>


                                <div>
                                    🎁
                                    <span>
                                        Nhận ưu đãi độc quyền
                                    </span>
                                </div>

                            </div>

                        </div>

                    </div>

                    <!-- REGISTER FORM -->

                    <div class="col-lg-6 bg-white">


                        <div class="login-form">


                            <h2>
                                Tạo tài khoản
                            </h2>


                            <p class="text-muted">
                                Đăng ký để trải nghiệm CloudStay
                            </p>



                            @if($errors->any())

                            <div class="alert alert-danger">

                                <ul class="mb-0">

                                    @foreach($errors->all() as $error)

                                    <li>
                                        {{$error}}
                                    </li>

                                    @endforeach

                                </ul>

                            </div>

                            @endif

                            <form method="POST"
                                  action="/register">

                                @csrf

                                <!-- NAME -->

                                <div class="mb-3">

                                    <label class="form-label">
                                        Họ và tên
                                    </label>

                                    <input type="text"
                                           name="name"
                                           class="form-control"
                                           placeholder="Nhập họ tên"
                                           value="{{old('name')}}"
                                           required>

                                </div>

                                <!-- EMAIL -->

                                <div class="mb-3">

                                    <label class="form-label">
                                        Email
                                    </label>


                                    <input type="email"
                                           name="email"
                                           class="form-control"
                                           placeholder="Nhập email"
                                           value="{{old('email')}}"
                                           required>

                                </div>

                                <!-- PASSWORD -->

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

                                <!-- CONFIRM PASSWORD -->

                                <div class="mb-3">

                                    <label class="form-label">
                                        Xác nhận mật khẩu
                                    </label>

                                    <input type="password"
                                           name="password_confirmation"
                                           class="form-control"
                                           placeholder="Nhập lại mật khẩu"
                                           required>

                                </div>

                                <div class="form-check mb-3">

                                    <input class="form-check-input"
                                           type="checkbox"
                                           required>

                                    <label class="form-check-label">

                                        Tôi đồng ý với điều khoản sử dụng

                                    </label>

                                </div>

                                <button class="btn btn-primary w-100">

                                    Đăng ký

                                </button>

                            </form>

                            <div class="text-center my-3">

                                <span class="text-muted">
                                    Hoặc
                                </span>

                            </div>

                            <!-- GOOGLE REGISTER -->

                            <a href="/auth/google"
                               class="btn btn-google w-100">

                                <img src="https://cdn-icons-png.flaticon.com/512/300/300221.png">

                                Đăng ký bằng Google

                            </a>

                            <p class="text-center mt-4">

                                Đã có tài khoản?

                                <a href="/login">

                                    Đăng nhập

                                </a>

                            </p>

                        </div>

                    </div>

                </div>

            </div>
        </div>

    </div>

</div>

</div>

@endsection
