@extends('layouts.app')

@section('content')

<h2>Đặt phòng</h2>

<form>

    <div class="mb-3">
        <label>Ngày nhận phòng</label>

        <input type="date"
               class="form-control">
    </div>

    <div class="mb-3">
        <label>Ngày trả phòng</label>

        <input type="date"
               class="form-control">
    </div>

    <div class="mb-3">
        <label>Số người</label>

        <input type="number"
               class="form-control">
    </div>
<div class="form-group mb-3 flex justify-center">
        <div class="g-recaptcha" data-sitekey="6LeYGy4tAAAAAEZ5RbWMHeG1akKzenTZEcwD4bDA"></div>
    </div>
    <button class="btn btn-primary">
        Xác nhận đặt phòng
    </button>

</form>

@endsection
