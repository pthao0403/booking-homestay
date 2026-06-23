@extends('layouts.app')

@section('title', 'Đặt phòng ' . $room->name . ' - CloudStay')

@section('content')
<div class="booking-container">
    <h1>Đặt phòng {{ $room->name }}</h1>

    <div class="booking-content" style="background: #f8f9fa; padding: 2rem; border-radius: 8px; max-width: 600px; margin: 0 auto;">
        <div class="room-summary" style="margin-bottom: 1.5rem; border-bottom: 1px solid #dee2e6; padding-bottom: 1rem;">
            <h3>{{ $room->name }}</h3>
            <p><i class="bi bi-geo-alt"></i> {{ $room->location }}</p>
            <p class="price" style="font-size: 1.2rem; color: #6366f1; font-weight: 600;">
                {{ number_format($room->price) }} VNĐ / đêm
            </p>
        </div>

        <form action="{{ route('bookings.store') }}" method="POST" class="booking-form">
            @csrf
            <input type="hidden" name="room_id" value="{{ $room->id }}">

            <input type="hidden" name="voucher_code" id="voucher_code_hidden">
            <input type="hidden" name="discount_amount" id="discount_amount_hidden">
            <input type="hidden" name="final_total" id="final_total_hidden">

            <div class="form-group mb-3">
                <label for="check_in" class="form-label">Ngày nhận phòng</label>
                <input type="date" id="check_in" name="check_in" class="form-control" required>
            </div>

            <div class="form-group mb-3">
                <label for="check_out" class="form-label">Ngày trả phòng</label>
                <input type="date" id="check_out" name="check_out" class="form-control" required>
            </div>

            <div class="form-group mb-3">
                <label for="guests" class="form-label">Số người đi cùng</label>
                <input type="number" id="guests" name="guests" min="1" max="{{ $room->capacity }}" class="form-control" required>
            </div>

            @if($featuredVoucher && $featuredVoucherLabel)
                <div class="alert alert-info border-0 py-2 px-3 mb-3" style="background: #e0f2fe; color: #0f172a;">
                    Mã gợi ý hôm nay: <strong>{{ $featuredVoucher['code'] }}</strong> - {{ $featuredVoucherLabel }}
                </div>
            @endif

            <div class="form-group mb-3">
                <label for="voucher_code" class="form-label">Mã giảm giá</label>
                <div class="input-group">
                    <input type="text" id="voucher_code" class="form-control" placeholder="Ví dụ: CLOUD10">
                    <button type="button" class="btn btn-success" id="apply-voucher">
                        Áp dụng
                    </button>
                </div>
                <small id="voucher-message" class="d-block mt-2"></small>
            </div>

            <div class="booking-summary mb-4" style="font-size: 1.2rem; font-weight: bold; border-top: 1px solid #dee2e6; padding-top: 1rem;">
                <p>Tổng tiền ban đầu: <span id="total-price" style="color: #ef4444;">0</span> VNĐ</p>
                <p>Giảm giá: <span id="discount-price" style="color: #16a34a;">0</span> VNĐ</p>
                <p>Thanh toán sau giảm: <span id="final-price" style="color: #2563eb;">0</span> VNĐ</p>
            </div>

            <button type="submit" class="btn btn-primary btn-lg w-100">Xác nhận đặt phòng</button>
            <a href="{{ route('rooms.show', $room) }}" class="btn btn-secondary w-100 mt-2">Hủy bỏ</a>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const checkInInput = document.getElementById('check_in');
    const checkOutInput = document.getElementById('check_out');

    const totalPriceSpan = document.getElementById('total-price');
    const discountPriceSpan = document.getElementById('discount-price');
    const finalPriceSpan = document.getElementById('final-price');

    const voucherInput = document.getElementById('voucher_code');
    const applyVoucherBtn = document.getElementById('apply-voucher');
    const voucherMessage = document.getElementById('voucher-message');

    const voucherCodeHidden = document.getElementById('voucher_code_hidden');
    const discountAmountHidden = document.getElementById('discount_amount_hidden');
    const finalTotalHidden = document.getElementById('final_total_hidden');

    const pricePerNight = {{ $room->price }};

    let currentTotal = 0;
    let discountAmount = 0;

    function formatMoney(number) {
        return Number(number).toLocaleString('vi-VN');
    }

    function calculatePrice() {
        discountAmount = 0;
        voucherMessage.textContent = '';
        voucherCodeHidden.value = '';
        discountAmountHidden.value = '';
        finalTotalHidden.value = '';

        if (checkInInput.value && checkOutInput.value) {
            const checkIn = new Date(checkInInput.value);
            const checkOut = new Date(checkOutInput.value);
            const diffTime = checkOut - checkIn;
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

            if (diffDays > 0) {
                currentTotal = diffDays * pricePerNight;
            } else {
                currentTotal = 0;
            }
        } else {
            currentTotal = 0;
        }

        totalPriceSpan.textContent = formatMoney(currentTotal);
        discountPriceSpan.textContent = '0';
        finalPriceSpan.textContent = formatMoney(currentTotal);
        finalTotalHidden.value = currentTotal;
    }

    applyVoucherBtn.addEventListener('click', function() {
        const code = voucherInput.value.trim();

        if (!code) {
            voucherMessage.textContent = 'Vui lòng nhập mã giảm giá.';
            voucherMessage.className = 'd-block mt-2 text-danger';
            return;
        }

        if (currentTotal <= 0) {
            voucherMessage.textContent = 'Vui lòng chọn ngày nhận và trả phòng trước.';
            voucherMessage.className = 'd-block mt-2 text-danger';
            return;
        }

        fetch("{{ route('voucher.check') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                code: code
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                if (data.type === 'percent') {
                    discountAmount = currentTotal * Number(data.discount) / 100;
                } else {
                    discountAmount = Number(data.discount);
                }

                if (discountAmount > currentTotal) {
                    discountAmount = currentTotal;
                }

                const finalTotal = currentTotal - discountAmount;

                discountPriceSpan.textContent = formatMoney(discountAmount);
                finalPriceSpan.textContent = formatMoney(finalTotal);

                voucherCodeHidden.value = code.toUpperCase();
                discountAmountHidden.value = discountAmount;
                finalTotalHidden.value = finalTotal;

                voucherMessage.textContent = data.message;
                voucherMessage.className = 'd-block mt-2 text-success';
            } else {
                discountAmount = 0;
                discountPriceSpan.textContent = '0';
                finalPriceSpan.textContent = formatMoney(currentTotal);

                voucherCodeHidden.value = '';
                discountAmountHidden.value = '';
                finalTotalHidden.value = currentTotal;

                voucherMessage.textContent = data.message;
                voucherMessage.className = 'd-block mt-2 text-danger';
            }
        });
    });

    checkInInput.addEventListener('change', calculatePrice);
    checkOutInput.addEventListener('change', calculatePrice);
});
</script>
@endsection
