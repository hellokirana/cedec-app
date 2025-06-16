<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Layanan;
use App\Models\User;
use App\Events\OrderCreated;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'layanan_ids' => 'required|array',
            'layanan_ids.*' => 'exists:layanans,id',
            'alamat' => 'required|string',
            'kode_pos' => 'required|string',
            'kelurahan' => 'required|string',
            'kecamatan' => 'required|string',
        ]);

        if (!Auth::check()) {
            return response()->json(['message' => 'User belum login'], 401);
        }

        $user = Auth::user();
        $totalHarga = 0;

        foreach ($request->layanan_ids as $layanan_id) {
            $layanan = Layanan::findOrFail($layanan_id);
            $totalHarga += $layanan->harga;
        }

        // Buat pesanan
        $order = Order::create([
            'user_id' => $user->id,
            'mitra_id' => null, // Mitra belum dipilih
            'status' => 'pending',
            'alamat' => $request->alamat,
            'kode_pos' => $request->kode_pos,
            'kelurahan' => $request->kelurahan,
            'kecamatan' => $request->kecamatan,
            'total_harga' => $totalHarga,
        ]);

        // Simpan detail pesanan
        foreach ($request->layanan_ids as $layanan_id) {
            $layanan = Layanan::findOrFail($layanan_id);
            OrderDetail::create([
                'order_id' => $order->id,
                'layanan_id' => $layanan->id,
                'harga' => $layanan->harga,
            ]);
        }

        // Trigger event untuk notifikasi
        event(new OrderCreated($order));

        return response()->json(['message' => 'Pesanan berhasil dibuat!', 'order' => $order]);
    }
}
