<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Services\VoucherSheetService;
use Illuminate\Support\Collection;

class HomeController extends Controller
{
    public function index(VoucherSheetService $voucherSheetService)
    {
        try {
            $rooms = Room::latest()
                ->take(6)
                ->get();
        } catch (\Throwable $e) {
            $rooms = new Collection();
        }

        $featuredVoucher = $voucherSheetService->featured();
        $featuredVoucherLabel = $featuredVoucher
            ? $voucherSheetService->formatDiscount($featuredVoucher)
            : null;

        return view('home.index', compact('rooms', 'featuredVoucher', 'featuredVoucherLabel'));
    }
}
