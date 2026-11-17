<?php

namespace App\Http\Controllers;

use App\Models\Workshop;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\Snap;
use Exception;

class RegistrationController extends Controller
{
   public function store(Workshop $workshop)
{
    try {
        // 1. Konfigurasi Midtrans terlebih dahulu agar kita bisa ambil Snap Token-nya
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $user = Auth::user();
        $ticketCode = 'TIX-' . strtoupper(Str::random(8));

        // Buat parameter payload untuk Midtrans Snap
        // 6. Buat parameter payload untuk Midtrans Snap
        $params = [
            'transaction_details' => [
                'order_id' => $ticketCode,
                'gross_amount' => (int) $workshop->price,
            ],
            'customer_details' => [
                'first_name' => $user->name,
                'email' => $user->email,
            ],
            'callbacks' => [
                'finish' => route('dashboard') // <--- TAMBAHKAN BARIS INI
            ]
        ];
        // Dapatkan Snap Token dari Midtrans sebelum database transaction
        $snapToken = Snap::getSnapToken($params);

        // Menggunakan Database Transaction untuk menjaga konsistensi data
        $result = DB::transaction(function () use ($workshop, $ticketCode, $snapToken) {
            // 1. Cek apakah user sudah terdaftar
            $existing = Registration::where('user_id', Auth::id())
                ->where('workshop_id', $workshop->id)
                ->lockForUpdate()
                ->first();

            if ($existing) {
                throw new \Exception('Kamu sudah terdaftar di workshop ini!');
            }

            // 2. Cek kuota
            if ($workshop->quota <= 0) {
                throw new \Exception('Mohon maaf, kuota workshop sudah habis.');
            }

          // 3. Buat record registrasi dengan status default 'pending'
            $registration = Registration::create([
                'user_id' => Auth::id(),
                'workshop_id' => $workshop->id,
                'ticket_code' => $ticketCode,
                'payment_status' => 'pending', // Kembalikan ke pending
                'snap_token' => $snapToken,
            ]);
            // 4. Kurangi kuota workshop
            $workshop->decrement('quota');

            return $registration;
        });
        
        // Lempar ke view pembayaran checkout
        return view('payments.checkout', [
            'registration' => $result,
            'snapToken' => $snapToken,
            'workshop' => $workshop
        ]);
        
    } catch (Exception $e) {
        return redirect()->back()->with('error', $e->getMessage());
    }
}
public function updatePaymentStatus(Request $request)
{
    $orderIdInput = $request->order_id;

    if (!$orderIdInput) {
        return response()->json(['success' => false, 'message' => 'Order ID tidak valid.'], 400);
    }

    // Bersihkan order_id jika mengandung timestamp tambahan (misal: TIX-ABCDEF12-1718293847)
    // Kita ambil 2 bagian awal yaitu prefix "TIX" dan kode random 8 karakternya
    $parts = explode('-', $orderIdInput);
    $ticketCode = (isset($parts[0]) && isset($parts[1])) ? $parts[0] . '-' . $parts[1] : $orderIdInput;

    // Cari tiket berdasarkan ticket_code bersih, atau yang mengandung order_id tersebut
    $registration = Registration::where('ticket_code', $ticketCode)
                        ->orWhere('ticket_code', $orderIdInput)
                        ->orWhere('snap_token', 'LIKE', '%' . $orderIdInput . '%')
                        ->first();

    if ($registration) {
        $registration->payment_status = 'paid';
        $registration->save();
        
        return response()->json([
            'success' => true, 
            'message' => 'Status pembayaran berhasil diperbarui ke paid.'
        ]);
    }

    return response()->json([
        'success' => false, 
        'message' => 'Tiket dengan Order ID ' . $orderIdInput . ' tidak ditemukan.'
    ], 404);
}
public function simulatePaid($id)
{
    $registration = Registration::findOrFail($id);
    $registration->payment_status = 'paid';
    $registration->save();

    return redirect()->route('dashboard')->with('success', 'Pembayaran berhasil disimulasikan lunas!');
}
public function renewToken($id)
{
    $registration = Registration::with('workshop')->findOrFail($id);

    // Set konfigurasi Midtrans
    \Midtrans\Config::$serverKey = config('services.midtrans.server_key');
    \Midtrans\Config::$isProduction = config('services.midtrans.is_production');
    \Midtrans\Config::$isSanitized = true;
    \Midtrans\Config::$is3ds = true;

    // Tambahkan angka unik di belakang order_id agar tidak kena error "already been taken"
    $uniqueOrderId = $registration->ticket_code . '-' . time();

    $params = [
        'transaction_details' => [
            'order_id' => $uniqueOrderId,
            'gross_amount' => $registration->workshop->price,
        ],
        'customer_details' => [
            'first_name' => Auth::user()->name,
            'email' => Auth::user()->email,
        ],
    ];

    try {
        $snapToken = \Midtrans\Snap::getSnapToken($params);
        
        $registration->snap_token = $snapToken;
        $registration->save();

        return response()->json(['success' => true, 'snap_token' => $snapToken]);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
    }
}
public function paymentFinish(Request $request)
{
    $orderId = $request->query('order_id');

    if ($orderId) {
        $parts = explode('-', $orderId);
        $ticketCode = (isset($parts[0]) && isset($parts[1])) ? $parts[0] . '-' . $parts[1] : $orderId;

        $registration = Registration::where('ticket_code', $ticketCode)
                            ->orWhere('ticket_code', $orderId)
                            ->first();

        if ($registration && $registration->payment_status !== 'paid') {
            $registration->payment_status = 'paid';
            $registration->save();
        }
    }

    return redirect()->route('dashboard')->with('success', 'Pembayaran berhasil dikonfirmasi!');
}
}