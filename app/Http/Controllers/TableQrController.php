<?php

namespace App\Http\Controllers;

use App\Models\Table;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Response;

class TableQrController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, Table $table)
    {
        // Pastikan tabel memiliki relasi restoran
        $restaurant = $table->restaurant;
        if (!$restaurant) {
            abort(404, 'Restaurant not found for this table.');
        }

        // Buat URL untuk scan
        $url = url("/menu/{$restaurant->slug}/{$table->qr_code_token}");

        // Generate QR code as SVG (no imagick required)
        $qr = QrCode::format('svg')
            ->size(500)
            ->margin(2)
            ->generate($url);

        // Download Response
        return Response::make($qr, 200, [
            'Content-Type' => 'image/svg+xml',
            'Content-Disposition' => 'attachment; filename="qr_table_' . $table->table_number . '.svg"',
        ]);
    }
}
