<?php

namespace App\Http\Controllers;

use App\Models\BintangHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BintangController extends Controller
{
    public function generate(Request $request)
    {
        $request->validate([
            'jumlah' => 'required|integer|min:1|max:30',
            'tipe' => 'nullable|string|in:piramida,piramida_terbalik,siku,siku_kanan,belah_ketupat',
        ]);

        $jumlah = (int) $request->jumlah;
        $tipe = $request->tipe ?? 'piramida';
        $pola = $this->buatPola($jumlah, $tipe);

        $history = BintangHistory::create([
            'jumlah' => $jumlah,
            'tipe' => $tipe,
            'pola' => $pola,
        ]);

        return response()->json([
            'success' => true,
            'data' => [
                'jumlah' => $jumlah,
                'tipe' => $tipe,
                'pola' => $pola,
                'id' => $history->_id,
            ]
        ]);
    }

    public function history()
    {
        $data = BintangHistory::orderBy('created_at', 'desc')->get();

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    protected function buatPola($n, $tipe)
    {
        $baris = [];

        if ($tipe == 'siku') {
            for ($i = 1; $i <= $n; $i++) {
                $baris[] = str_repeat('* ', $i);
            }
        } elseif ($tipe == 'siku_kanan') {
            for ($i = 1; $i <= $n; $i++) {
                $baris[] = str_repeat(' ', 2 * ($n - $i)) . str_repeat('* ', $i);
            }
        } elseif ($tipe == 'piramida_terbalik') {
            for ($i = $n; $i >= 1; $i--) {
                $baris[] = str_repeat(' ', $n - $i) . str_repeat('* ', $i);
            }
        } elseif ($tipe == 'belah_ketupat') {
            for ($i = 1; $i <= $n; $i++) {
                $baris[] = str_repeat(' ', $n - $i) . str_repeat('* ', $i);
            }

            for ($i = $n - 1; $i >= 1; $i--) {
                $baris[] = str_repeat(' ', $n - $i) . str_repeat('* ', $i);
            }
        } else {
            for ($i = 1; $i <= $n; $i++) {
                $baris[] = str_repeat(' ', $n - $i) . str_repeat('* ', $i);
            }
        }

        return $baris;
    }
}
