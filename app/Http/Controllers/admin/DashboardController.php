<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\GaransiKlaim;
use App\Models\Notification;
use App\Models\Voucher;
use App\Models\Layanan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPesanan = Order::count();
        $totalKlaim = GaransiKlaim::where('status', 'pending')->count();
        $totalVoucher = Voucher::count();
        $totalLayanan = Layanan::count();

        return view('admin.dashboard', compact('totalPesanan', 'totalKlaim', 'totalVoucher', 'totalLayanan'));
    }
}
