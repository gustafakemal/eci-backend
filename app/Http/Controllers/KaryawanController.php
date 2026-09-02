<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\SalaryLevel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KaryawanController extends Controller
{
    public function index()
    {
        $data = Karyawan::orderBy('created_at', 'desc')->get();

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:150',
            'jabatan' => 'required|string|max:100',
            'level' => 'required|string|exists:salary_levels,level',
            'gaji_pokok' => 'required|numeric|min:0',
            'email' => 'required|email|unique:karyawans,email',
            'no_hp' => 'nullable|string|max:20',
        ]);

        $rangeError = $this->cekRangeGaji($data['level'], $data['gaji_pokok']);
        if ($rangeError) {
            return response()->json([
                'success' => false,
                'message' => $rangeError
            ], 422);
        }

        $karyawan = Karyawan::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Data karyawan berhasil disimpan',
            'data' => $karyawan
        ], 201);
    }

    public function show($id)
    {
        $karyawan = Karyawan::find($id);

        if (!$karyawan) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $karyawan
        ]);
    }

    public function update(Request $request, $id)
    {
        $karyawan = Karyawan::find($id);

        if (!$karyawan) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        $data = $request->validate([
            'nama' => 'sometimes|required|string|max:150',
            'jabatan' => 'sometimes|required|string|max:100',
            'level' => 'sometimes|required|string|exists:salary_levels,level',
            'gaji_pokok' => 'sometimes|required|numeric|min:0',
            'email' => 'sometimes|required|email|unique:karyawans,email,' . $id,
            'no_hp' => 'nullable|string|max:20',
        ]);

        $level = $data['level'] ?? $karyawan->level;
        $gajiPokok = $data['gaji_pokok'] ?? $karyawan->gaji_pokok;

        $rangeError = $this->cekRangeGaji($level, $gajiPokok);
        if ($rangeError) {
            return response()->json([
                'success' => false,
                'message' => $rangeError
            ], 422);
        }

        $karyawan->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Data karyawan berhasil diupdate',
            'data' => $karyawan
        ]);
    }

    public function destroy($id)
    {
        $karyawan = Karyawan::find($id);

        if (!$karyawan) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        $karyawan->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data karyawan berhasil dihapus'
        ]);
    }

    protected function cekRangeGaji($level, $gajiPokok)
    {
        $salaryLevel = SalaryLevel::where('level', $level)->first();

        if (!$salaryLevel) {
            return null;
        }

        if ($gajiPokok < $salaryLevel->gaji_min || $gajiPokok > $salaryLevel->gaji_max) {
            return 'Gaji pokok untuk level ' . $level . ' harus di antara Rp' . number_format($salaryLevel->gaji_min, 0, ',', '.') . ' - Rp' . number_format($salaryLevel->gaji_max, 0, ',', '.');
        }

        return null;
    }
}
