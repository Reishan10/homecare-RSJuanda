<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\Kota;
use App\Models\Pelayanan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class PelayananController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $pelayanan = Pelayanan::with('user')->orderBy('created_at', 'asc')->get();
            return DataTables::of($pelayanan)
                ->addIndexColumn()
                ->addColumn('name', function ($data) {
                    $name = $data->user->name;
                    return $name;
                })
                ->addColumn('no_telepon', function ($data) {
                    $no_telepon = $data->user->no_telepon;
                    return $no_telepon;
                })
                ->addColumn('address', function ($data) {
                    $address = $data->user->address;
                    return $address;
                })
                ->addColumn('countdown', function ($data) {
                    $waktu_selesai = Carbon::parse($data->waktu_selesai);
                    $now = Carbon::now();
                    $diff = $waktu_selesai->diffInSeconds($now);

                    $days = floor($diff / (3600 * 24));
                    $hours = floor(($diff - $days * 3600 * 24) / 3600);
                    $minutes = floor(($diff - $days * 3600 * 24 - $hours * 3600) / 60);
                    $seconds = $diff - $days * 3600 * 24 - $hours * 3600 - $minutes * 60;

                    return sprintf("%02d Hari %02d Jam %02d Menit %02d Detik", $days, $hours, $minutes, $seconds);
                })
                ->addColumn('comboBox', function ($data) {
                    $comboBox = "<input type='checkbox' class='checkbox' data-id='" . $data->id . "'>";
                    return $comboBox;
                })
                ->addColumn('aksi', function ($data) {
                    $btn = '<button type="button" class="btn btn-danger btn-sm" data-id="' . $data->id . '" id="btnHapus"><i
                    class="mdi mdi-trash-can"></i></button>';
                    return $btn;
                })
                ->rawColumns(['aksi', 'comboBox', 'countdown'])
                ->make(true);
        }
        return view('backend.pelayanan.index');
    }

    public function hitungHarga(Request $request)
    {
        $layanan = $request->layanan;
        $paket = $request->paket;

        if ($layanan == 'Perawat' || $layanan == 'Fisioterapi' || $layanan == 'Telemedicine') {
            if ($paket == '1x12') {
                $harga = 1000000;
                $harga_rupiah = "Rp " . number_format($harga, 0, ',', '.');
            } elseif ($paket == '3x24') {
                $harga = 2700000;
                $harga_rupiah = "Rp " . number_format($harga, 0, ',', '.');
            } elseif ($paket == '7x24') {
                $harga = 6300000;
                $harga_rupiah = "Rp " . number_format($harga, 0, ',', '.');
            } else {
                $harga = 0;
                $harga_rupiah = "Rp " . number_format($harga, 0, ',', '.');
            }
        } else {
            $harga = 0;
            $harga_rupiah = "Rp " . number_format($harga, 0, ',', '.');
        }

        return response()->json(['harga' => $harga_rupiah]);
    }

    public function show($id)
    {
        $pasien = User::findOrFail($id);

        return response()->json([
            'alamat' => $pasien->address,
            'no_telepon' => $pasien->no_telepon
        ]);
    }

    public function create()
    {
        $pasien = User::where('type', 0)->orderBy('name', 'asc')->get();
        $dokter = User::where('type', 3)
            ->join('dokter', 'users.id', '=', 'dokter.user_id')
            ->where('dokter.status', '=', '0')
            ->orderBy('users.name', 'asc')->get();

        $kota = Kota::orderBy('name', 'asc')->get();

        $lastLayanan = Pelayanan::orderByDesc('created_at')->first();
        $nextLayananNumber = $lastLayanan ? intval(substr($lastLayanan->kode_pelayanan, -4)) + 1 : 1;
        $LayananCode = 'HC-' . date('Ymd') . '-' . sprintf('%04d', $nextLayananNumber);

        return view('backend.pelayanan.add', compact(['pasien', 'dokter', 'kota', 'LayananCode']));
    }

    public function store(Request $request)
    {
        $validated = Validator::make(
            $request->all(),
            [
                'pasien' => 'required|string|unique:pelayanan,pasien_id',
                'no_telepon' => 'required|min:11|max:15',
                'alamat' => 'required|string',
                'riwayat_penyakit' => 'required|string',
                'dokter' => 'required|string',
                'layanan' => 'required|string',
                'paket' => 'required|string',
                'kota' => 'required|string',
                'waktu_mulai' => 'required|string',
                'waktu_selesai' => 'required|string',
            ],
            [
                'pasien.required' => 'Silakan pilih pasien terlebih dahulu!',
                'pasien.unique' => 'Data sudah tersedia!',
                'no_telepon.required' => 'Silakan isi no telepon terlebih dahulu!',
                'no_telepon.min' => 'No telepon harus memiliki panjang minimal 11 karakter.',
                'no_telepon.max' => 'No telepon harus memiliki panjang maksimal 15 karakter.',
                'riwayat_penyakit.required' => 'Silakan isi riwayat penyakit terlebih dahulu!',
                'dokter.required' => 'Silakan pilih dokter terlebih dahulu!',
                'layanan.required' => 'Silakan pilih layanan terlebih dahulu!',
                'paket.required' => 'Silakan pilih paket terlebih dahulu!',
                'kota.required' => 'Silakan pilih kota terlebih dahulu!',
                'waktu_mulai.required' => 'Silakan isi waktu mulai terlebih dahulu!',
                'waktu_selesai.required' => 'Silakan isi waktu selesai terlebih dahulu!',
            ]
        );


        if ($validated->fails()) {
            return response()->json(['errors' => $validated->errors()]);
        } else {
            $pelayanan = new Pelayanan();
            $pelayanan->kode_pelayanan = $request->kode_pelayanan;
            $pelayanan->pasien_id = $request->pasien;
            $pelayanan->dokter_id = $request->dokter;
            $pelayanan->layanan = $request->layanan;
            $pelayanan->paket = $request->paket;
            $pelayanan->alamat = $request->alamat;
            $pelayanan->kota_id = $request->kota;
            $pelayanan->riwayat_penyakit = $request->riwayat_penyakit;
            $pelayanan->no_telepon = $request->no_telepon;
            $pelayanan->waktu_mulai = $request->waktu_mulai;
            $pelayanan->waktu_selesai = $request->waktu_selesai;
            $pelayanan->harga = $request->harga;
            $pelayanan->save();

            $dokter_id = $request->dokter;
            $dokter = Dokter::find($dokter_id);

            $dokter->update([
                'status' => 1,
            ]);

            return response()->json(['success' => 'Data barhasil ditambahkan']);
        }
    }

    public function destroy(Request $request)
    {
        $pelayanan = Pelayanan::findOrFail($request->id);
        $dokter = Dokter::find($pelayanan->dokter_id);
        $dokter->update([
            'status' => 0,
        ]);

        $pelayanan->delete();

        return Response()->json(['pelayanan' => $pelayanan, 'success' => 'Data berhasil dihapus']);
    }

    public function deleteMultiple(Request $request)
    {
        $pelayanan = Pelayanan::select('pelayanan.*', 'dokter.status')
            ->join('dokter', 'dokter.id', '=', 'pelayanan.dokter_id')
            ->whereIn('pelayanan.id', explode(",", $request->id))
            ->get();
        foreach ($pelayanan as $row) {
            Pelayanan::where('id', $row->id)->delete();
            Dokter::where('id', $row->dokter_id)->update(['status' => 0]);
        }

        return response()->json(['success' => "Data berhasil dihapus"]);
    }
}
