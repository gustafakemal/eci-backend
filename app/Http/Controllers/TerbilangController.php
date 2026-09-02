<?php

namespace App\Http\Controllers;

use App\Models\TerbilangHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TerbilangController extends Controller
{
    protected $satuan = ['', 'satu', 'dua', 'tiga', 'empat', 'lima', 'enam', 'tujuh', 'delapan', 'sembilan', 'sepuluh', 'sebelas'];

    public function convert(Request $request)
    {
        $request->validate([
            'angka' => 'required|numeric|min:0',
        ]);

        $angka = $request->angka;
        $hasil = preg_replace('/\s+/', ' ', trim($this->ubahKeHuruf((int) $angka))) . ' rupiah';

        $history = TerbilangHistory::create([
            'angka' => $angka,
            'hasil' => $hasil,
        ]);

        return response()->json([
            'success' => true,
            'data' => [
                'angka' => $angka,
                'terbilang' => $hasil,
                'id' => $history->_id,
            ]
        ]);
    }

    public function history()
    {
        $data = TerbilangHistory::orderBy('created_at', 'desc')->get();

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    protected function ubahKeHuruf($angka)
    {
        $angka = abs($angka);

        if ($angka < 12) {
            return ' ' . $this->satuan[$angka];
        } elseif ($angka < 20) {
            return $this->ubahKeHuruf($angka - 10) . ' belas';
        } elseif ($angka < 100) {
            return $this->ubahKeHuruf(intval($angka / 10)) . ' puluh' . $this->ubahKeHuruf($angka % 10);
        } elseif ($angka < 200) {
            return ' seratus' . $this->ubahKeHuruf($angka - 100);
        } elseif ($angka < 1000) {
            return $this->ubahKeHuruf(intval($angka / 100)) . ' ratus' . $this->ubahKeHuruf($angka % 100);
        } elseif ($angka < 2000) {
            return ' seribu' . $this->ubahKeHuruf($angka - 1000);
        } elseif ($angka < 1000000) {
            return $this->ubahKeHuruf(intval($angka / 1000)) . ' ribu' . $this->ubahKeHuruf($angka % 1000);
        } elseif ($angka < 1000000000) {
            return $this->ubahKeHuruf(intval($angka / 1000000)) . ' juta' . $this->ubahKeHuruf($angka % 1000000);
        } elseif ($angka < 1000000000000) {
            return $this->ubahKeHuruf(intval($angka / 1000000000)) . ' milyar' . $this->ubahKeHuruf(fmod($angka, 1000000000));
        }

        return $this->ubahKeHuruf(intval($angka / 1000000000000)) . ' triliun' . $this->ubahKeHuruf(fmod($angka, 1000000000000));
    }
}
