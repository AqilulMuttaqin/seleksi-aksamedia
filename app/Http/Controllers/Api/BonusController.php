<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BonusController extends Controller
{
    public function getNilaiRT() {
        $nilaiRT = DB::table('nilai')
            ->select('nama', 'nisn', 'nama_pelajaran', 'skor')
            ->where('materi_uji_id', 7)
            ->where('nama_pelajaran', '!=', 'Pelajaran Khusus')
            ->get()
            ->groupBy('nama')
            ->map(function($items) {
                $nilaiRT = [];

                foreach ($items as $item) {
                    $nilaiRT[$item->nama_pelajaran] = $item->skor;
                }

                return [
                    'nama' => $items->first()->nama,
                    'nilaiRT' => $nilaiRT,
                    'nisn' => $items->first()->nisn,
                ];
            })
            ->values();

        return response()->json($nilaiRT);
    }

    public function getNilaiST() {
        $nilaiST = DB::table('nilai')
            ->select('nama', 'nisn', 'nama_pelajaran', 'pelajaran_id', 'skor')
            ->where('materi_uji_id', 4)
            ->get()
            ->groupBy('nama')
            ->map(function($items) {
                $nilaiST = [];
                $total = 0;

                foreach ($items as $item) {
                    $skorNilai = $item->skor;

                    switch ($item->pelajaran_id) {
                        case 44:
                            $skorNilai = $item->skor * 41.67;
                            break;
                        case 45:
                            $skorNilai = $item->skor * 29.67;
                            break;
                        case 46:
                            $skorNilai = $item->skor * 100;
                            break;
                        case 47:
                            $skorNilai = $item->skor * 23.81;
                            break;
                    }

                    $nilaiST[$item->nama_pelajaran] = $skorNilai;
                    $total += $skorNilai;
                }

                return [
                    'nilaiST' => $nilaiST,
                    'nama' => $items->first()->nama,
                    'nisn' => $items->first()->nisn,
                    'total' => $total,
                ];
            })
            ->sortByDesc('total')
            ->values();

        return response()->json($nilaiST);
    }
}
