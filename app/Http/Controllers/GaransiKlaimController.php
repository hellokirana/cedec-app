<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\GaransiKlaim;
use App\Models\Order;
use App\Models\Notification;
use Carbon\Carbon;

class GaransiKlaimController extends Controller
{
    // User mengajukan klaim garansi
    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'deskripsi' => 'required|string',
        ]);

        $order = Order::findOrFail($request->order_id);

        // Cek apakah pesanan milik user yang sedang login
        if ($order->user_id !== Auth::id()) {
            return response()->json(['message' => 'Anda tidak dapat mengajukan klaim untuk pesanan ini'], 403);
        }

        // Cek apakah layanan dalam pesanan memiliki garansi
        if (!$order->hasWarranty()) {
            return response()->json(['message' => 'Pesanan ini tidak memiliki garansi'], 400);
        }

        // Cek apakah masih dalam masa garansi (3 hari sejak selesai)
        $batasGaransi = Carbon::parse($order->updated_at)->addDays(3);
        if (Carbon::now()->greaterThan($batasGaransi)) {
            return response()->json(['message' => 'Masa garansi sudah habis'], 400);
        }

        // Buat klaim garansi
        $klaim = GaransiKlaim::create([
            'user_id' => Auth::id(),
            'order_id' => $order->id,
            'deskripsi' => $request->deskripsi,
            'status' => 'pending',
        ]);

        // Kirim notifikasi ke mitra
        if ($order->mitra_id) {
            Notification::create([
                'user_id' => $order->mitra_id,
                'message' => "Klaim garansi baru dari {$order->user->name}",
                'is_read' => false,
            ]);
        }

        return response()->json(['message' => 'Klaim garansi berhasil diajukan', 'klaim' => $klaim]);
    }

    // Admin menyetujui atau menolak klaim garansi
    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
        ]);

        $klaim = GaransiKlaim::findOrFail($id);

        // Update status klaim
        $klaim->update([
            'status' => $request->status,
        ]);

        // Kirim notifikasi ke user
        Notification::create([
            'user_id' => $klaim->user_id,
            'message' => "Klaim garansi Anda telah {$request->status}",
            'is_read' => false,
        ]);

        return response()->json(['message' => "Klaim garansi berhasil {$request->status}"]);
    }

    // User melihat daftar klaimnya
    public function index()
    {
        $klaim = GaransiKlaim::where('user_id', Auth::id())->get();
        return response()->json($klaim);
    }
}
