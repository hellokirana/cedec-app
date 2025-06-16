<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;

class NotifikasiController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'User belum login'], 401);
        }

        $user = Auth::user();

        // Ambil notifikasi untuk mitra
        $notifications = Notification::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($notifications);
    }
}
