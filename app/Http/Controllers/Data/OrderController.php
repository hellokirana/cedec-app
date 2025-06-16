<?php

namespace App\Http\Controllers\Data;

use App\Models\Bank;
use App\Models\User;
use App\Models\Order;
use App\Models\Layanan;
use App\Models\UserWallet;
use App\Models\WorkerProof;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\DataTables\OrderDataTable;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;

class OrderController extends Controller
{
    public function index(OrderDataTable $dataTable)
    {
        // Render the appropriate DataTable
        return $dataTable->render('data.order.index');
    }

    public function success_order($id)
    {
        $data = Order::where('id', $id)->first();
        if (empty($data)) {
            return redirect()->back()->with('error', 'data tidak ditemukan');
        }
        $data_bank = Bank::where("status", 1)->orderBy('no_urut', 'asc')->get();
        return view('data.order.success_order', compact('data', 'data_bank'));
    }

    public function konfirmasi($id)
    {
        $data = Order::where('id', $id)->first();
        if (empty($data)) {
            return redirect()->back()->with('error', 'data tidak ditemukan');
        }
        $data_bank = Bank::where("status", 1)->orderBy('no_urut', 'asc')->get();
        return view('data.order.konfirmasi', compact('data', 'data_bank'));
    }

    public function send_konfirmasi(Request $request, $id)
    {
        // Validasi input
        $validated = Validator::make($request->all(), [
            'dari_bank' => 'required',
            'bank_id' => 'required|exists:banks,id',
            'nominal_transfer' => 'required',
            'bukti_transfer' => 'required',
            'g-recaptcha-response' => 'required', // Validasi reCAPTCHA
        ]);

        if ($validated->fails()) {
            Session::flash('warning', 'data gagal di simpan');
            return redirect()->back()
                ->withErrors($validated)
                ->withInput();
        }

        // Validasi reCAPTCHA
        $response = $request->input('g-recaptcha-response');
        $secret = env('RECAPTCHA_SECRET_KEY');

        $captchaResponse = Http::asForm()->post("https://www.google.com/recaptcha/api/siteverify", [
            'secret' => $secret,
            'response' => $response,
            'remoteip' => $request->ip()
        ]);

        $captchaData = $captchaResponse->json();

        if (!$captchaData['success']) {
            return back()->withErrors(['g-recaptcha-response' => 'CAPTCHA verification failed.']);
        }

        // Jika validasi berhasil, proses penyimpanan data
        $order = Order::where('id', $id)->first();
        if (empty($order)) {
            return redirect()->back()->with('error', 'data tidak ditemukan');
        }

        $order->dari_bank = $request->dari_bank;
        $order->bank_id = $request->bank_id;
        $order->nominal_transfer = $request->nominal_transfer;
        $order->status_pembayaran = 2;

        $fileimage = $request->file('bukti_transfer');
        if (!empty($fileimage)) {
            $fileimageName = date('dHis') . '.' . $fileimage->getClientOriginalExtension();
            Storage::putFileAs(
                'public/bukti_bayar',
                $fileimage,
                $fileimageName
            );

            $order->bukti_transfer = $fileimageName;
        }
        $order->update();

        return redirect('data/order')->with('success', 'data berhasil di simpan');
    }

    public function bayar_diterima($id)
    {
        $data = Order::where('id', $id)->first();
        if (empty($data)) {
            return redirect()->back()->with('error', 'data tidak ditemukan');
        }
        // $worker = User::where('kategori_id', $data->kategori_id)
        //     ->whereHas('roles', function ($query) {
        //         $query->where('name', 'worker');
        //     })
        //     ->inRandomOrder()
        //     ->first();

        // if ($worker) {
        //     $data->worker_id = $worker->id;
        $data->status_pembayaran = 3;
        $data->status_order = 2;
        $data->update();
        return redirect('data/order')->with('success', 'data berhasil di simpan');
    }

    public function terima_pekerjaan($id)
    {
        $data = Order::where('id', $id)->where('status_order', 2)->first();
        if (empty($data)) {
            return redirect()->back()->with('error', 'data tidak ditemukan');
        }
        $user = Auth::user();
        if (empty($user->province_code) || empty($user->city_code) || empty($user->no_telp)) {
            return redirect()->back()->with('error', 'Silakan lengkapi profil terlebih dahulu.');
        }
        if (Auth::user()->kategori_id !== $data->kategori_id) {
            return redirect()->back()->with('error', 'Anda tidak bisa mengambil pekerjaan di kategori ini.');
        }
        $data->worker_id = $user->id;
        $data->status_order = 3;
        $data->update();
        return redirect('data/order')->with('success', 'Pekerjaan berhasil diterima');
    }

    public function selesai_pekerjaan($id)
    {
        $data = Order::where('id', $id)->where('status_order', 3)->first();
        if (empty($data)) {
            return redirect()->back()->with('error', 'data tidak ditemukan');
        }
        $data->status_order = 4;
        $data->update();

        $user = User::where('id', $data->worker_id)->first();
        $user->wallet = $user->wallet + $data->harga_worker;
        $user->update();

        $wallet = new UserWallet();
        $wallet->user_id = $user->id;
        $wallet->type = 1;
        $wallet->nominal = $data->harga_worker;
        $wallet->save();
        return redirect('data/order')->with('success', 'data berhasil di simpan');
    }

    public function bayar_ditolak($id)
    {
        $data = Order::where('id', $id)->first();
        if (empty($data)) {
            return redirect()->back()->with('error', 'data tidak ditemukan');
        }
        $data->status_pembayaran = 1;
        $data->status_order = 1;
        $data->update();
        return redirect('data/order')->with('success', 'data berhasil di simpan');
    }

    public function show($id)
    {
        $data = Order::where('id', $id)->first();
        if (empty($data)) {
            return redirect()->back()->with('error', 'data tidak ditemukan');
        }
        $data = Order::with([
            'customer.village',
            'customer.district',
            'customer.city',
            'customer.province',
        ])->findOrFail($id);

        $workerProofs = WorkerProof::where('order_id', $id)->get();

        return view('data.order.show', compact('data'));
    }

    public function uploadProof(Request $request, $orderId)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'type' => 'required|in:sampai,sebelum,selesai',
        ]);

        $order = Order::findOrFail($orderId);

        // Pastikan hanya worker yang ditugaskan yang dapat mengunggah bukti
        if (Auth::user()->id !== $order->worker_id) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk mengunggah bukti ini.');
        }

        // Simpan gambar
        $imagePath = $request->file('image')->store('worker_proof', 'public');

        // Simpan ke database
        WorkerProof::create([
            'user_id' => Auth::id(),
            'order_id' => $orderId,
            'image_path' => $imagePath,
            'type' => $request->type,
        ]);

        return redirect()->back()->with('success', 'Bukti pekerjaan berhasil diunggah.');
    }
    public function submitDescription(Request $request, $orderId)
    {
        $request->validate([
            'description' => 'required|string|max:1000',
        ]);

        $order = Order::findOrFail($orderId);

        if (Auth::user()->id !== $order->worker_id) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk mengunggah deskripsi ini.');
        }

        $order->worker_description = $request->description;
        $order->save();

        return redirect()->back()->with('success', 'Deskripsi pekerjaan berhasil disimpan.');
    }

    public function destroy($id)
    {
        $data = Order::where('id', $id)->first();
        if (empty($data)) {
            return redirect()->back()->with('error', 'data tidak ditemukan');
        }
        $data->delete();
        return response()->json(['success' => 'hapus data berhasil']);
    }
}
