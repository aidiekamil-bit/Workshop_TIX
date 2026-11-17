<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class TicketController extends Controller
{
    public function downloadPdf(Registration $registration)
    {
        // Pastikan yang mendownload adalah pemilik tiket
        if ($registration->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Load view khusus untuk cetak PDF (gunakan tanda $ pada variabel $pdf)
        $pdf = Pdf::loadView('pdf.ticket', compact('registration'));

        // Unduh file PDF dengan nama kode tiketnya
        return $pdf->download('E-Tiket-' . $registration->ticket_code . '.pdf');
    }
    public function show(Registration $registration)
{
    // WAJIB ADA: Tolak jika user yang login bukan pemilik tiket ini!
    if ($registration->user_id !== Auth::id()) {
        abort(403, 'Unauthorized action. Anda tidak berhak melihat tiket ini.');
    }

    // Load relasi workshop jika diperlukan di view detail
    $registration->load('workshop');

    return view('tickets.show', compact('registration')); // Sesuaikan nama view detail kamu
}
}