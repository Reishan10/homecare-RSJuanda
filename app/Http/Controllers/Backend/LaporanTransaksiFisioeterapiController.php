<?php

namespace App\Http\Controllers\backend;

use App\Exports\LaporanTransaksiFisioterapiExport;
use App\Http\Controllers\Controller;
use App\Models\TransaksiFisioterapi;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Maatwebsite\Excel\Facades\Excel;

class LaporanTransaksiFisioeterapiController extends Controller
{
    public function waktu(Request $request)
    {
        if (request()->ajax()) {
            if (!empty($request->start_date)) {
                $transaksiFisioterapi = TransaksiFisioterapi::with('pasien', 'perawat', 'dokter', 'fisioterapi')->whereBetween('created_at', array($request->start_date, $request->end_date))
                    ->get();
            } else {
                $transaksiFisioterapi = TransaksiFisioterapi::with('pasien', 'perawat', 'dokter', 'fisioterapi')->get();
            }
            return DataTables::of($transaksiFisioterapi)
                ->addIndexColumn()
                ->addColumn('pasien', function ($data) {
                    $pasien = $data->pasien->name;
                    return $pasien;
                })
                ->addColumn('perawat', function ($data) {
                    $perawat = $data->perawat->name;
                    return $perawat;
                })
                ->addColumn('dokter', function ($data) {
                    $dokter = $data->dokter->name;
                    return $dokter;
                })
                ->addColumn('layanan', function ($data) {
                    $layanan = $data->fisioterapi->name;
                    return $layanan;
                })
                ->addColumn('waktu', function ($data) {
                    $waktu = $data->waktu;
                    return $waktu;
                })
                ->make(true);
        }
        return view('backend.transaksiFisioterapi.laporan.filter_waktu');
    }

    public function printPDF(Request $request)
    {
        if (!empty($request->start_date)) {
            $transaksiFisioterapi = TransaksiFisioterapi::with('pasien', 'perawat', 'dokter', 'fisioterapi')->whereBetween('created_at', array($request->start_date, $request->end_date))
                ->get();
        } else {
            $transaksiFisioterapi = TransaksiFisioterapi::with('pasien', 'perawat', 'dokter', 'fisioterapi')->get();
        }
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $pdf = Pdf::loadView('backend.transaksiFisioterapi.laporan.printPDF', compact('transaksiFisioterapi', 'start_date', 'end_date'));
        return $pdf->download('laporan-transaksi-fisioterapi-' . time() . '.pdf');
    }

    public function exportExcel(Request $request)
    {
        // ambil nilai start date dan end date dari request
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // query data dari database dengan menggunakan nilai start date dan end date
        $transaksiFisioterapi = TransaksiFisioterapi::with('pasien', 'perawat', 'dokter', 'fisioterapi')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at', 'asc')
            ->get();

        // download file excel dengan data yang telah di-query
        return Excel::download(new LaporanTransaksiFisioterapiExport($transaksiFisioterapi), 'laporan-transaksi-fisioterapi.xlsx');
    }
}
