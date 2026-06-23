<?php

namespace App\Http\Controllers;

use App\Services\VoucherSheetService;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    public function index(VoucherSheetService $voucherSheetService)
    {
        $vouchers = array_map(function (array $voucher) use ($voucherSheetService): array {
            $voucher['label'] = $voucherSheetService->formatDiscount($voucher);

            return $voucher;
        }, $voucherSheetService->active());

        return view('vouchers.index', compact('vouchers'));
    }

    public function check(Request $request, VoucherSheetService $voucherSheetService)
    {
        $voucher = $voucherSheetService->findActiveVoucher((string) $request->code);

        if ($voucher) {
            return response()->json([
                'success' => true,
                'discount' => $voucher['discount'],
                'type' => $voucher['type'],
                'message' => 'Áp dụng mã giảm giá thành công!',
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Mã giảm giá không hợp lệ hoặc đã hết hạn!',
        ]);
    }
}
