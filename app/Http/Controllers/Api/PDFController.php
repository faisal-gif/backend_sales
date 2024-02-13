<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Dompdf\Dompdf;

class PDFController extends Controller
{
    public function exportPDF(Request $request)
    {
        $data = Customer::join('users', 'users.id', '=', 'customer.user_id')->join('paket', 'paket.id', '=', 'customer.paket_id')->select('users.name as sales', 'customer.*', 'paket.nama as nama_paket', 'paket.harga as harga_paket')->get();


        // Membuat instance Dompdf
        $pdf = new Dompdf();

        // Membuat konten HTML untuk PDF
        $html = '<h1>Rekap Customer Via PDF</h1>';
        $html .= '<table border="1" style="width:100%"><tr>
        <th>Sales</th>
        <th>Nama Customer</th>
        <th>Paket</th>
        <th>Harga</th>
        <th>Alamat</th>
        <th>Nomor Telepon</th></tr>';
        foreach ($data as $row) {
            $html .= '<tr><td>' . $row['sales'] . '</td><td>' . $row['nama'] . '</td><td>' . $row['nama_paket'] . '</td><td>' . $row['harga_paket'] . '</td><td>' . $row['alamat'] . '</td><td>' . $row['nomor_telepon'] . '</td></tr>';
        }
        $html .= '</table>';

        // Memuat HTML ke Dompdf
        $pdf->loadHtml($html);

        // Mengatur ukuran dan orientasi kertas
        $pdf->setPaper('A4', 'landscape');

        // Render PDF
        $pdf->render();

        // Mengirimkan respons PDF ke browser
        return $pdf->stream('exported_data.pdf');
    }
}
