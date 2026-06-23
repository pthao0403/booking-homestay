<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use App\Models\User;
use App\Services\VoucherSheetService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

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

        try {
            $stats = [
                [
                    'value' => number_format(Room::query()->where('status', 'available')->count()) . '+',
                    'label' => 'Homestay',
                ],
                [
                    'value' => number_format(User::count()) . '+',
                    'label' => 'Khách hàng',
                ],
                [
                    'value' => number_format(Booking::count()) . '+',
                    'label' => 'Lượt đặt',
                ],
                [
                    'value' => number_format(
                        Room::query()
                            ->select(DB::raw('COALESCE(address, "") as location_name'))
                            ->distinct()
                            ->count('location_name')
                    ) . '+',
                    'label' => 'Địa điểm',
                ],
            ];
        } catch (\Throwable $e) {
            $stats = [
                ['value' => '0+', 'label' => 'Homestay'],
                ['value' => '0+', 'label' => 'Khách hàng'],
                ['value' => '0+', 'label' => 'Lượt đặt'],
                ['value' => '0+', 'label' => 'Địa điểm'],
            ];
        }

        $featuredVoucher = $voucherSheetService->featured();
        $featuredVoucherLabel = $featuredVoucher
            ? $voucherSheetService->formatDiscount($featuredVoucher)
            : null;

        return view('home.index', compact('rooms', 'stats', 'featuredVoucher', 'featuredVoucherLabel'));
    }
}
