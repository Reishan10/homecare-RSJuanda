<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Bayar;
use App\Models\Homecare;
use App\Models\Kategori;
use App\Models\Poli;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class HomecareController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $homecare = Homecare::with('bayar', 'kategori', 'poli')->orderBy('kode_homecare', 'asc')->get();
            return DataTables::of($homecare)
                ->addIndexColumn()
                ->addColumn('bayar', function ($data) {
                    $bayar = $data->bayar->name;
                    return $bayar;
                })
                ->addColumn('kategori', function ($data) {
                    $kategori = $data->kategori->name;
                    return $kategori;
                })
                ->addColumn('poli', function ($data) {
                    $poli = $data->poli->name;
                    return $poli;
                })
                ->addColumn('comboBox', function ($data) {
                    $comboBox = "<input type='checkbox' class='checkbox' data-id='" . $data->id . "'>";
                    return $comboBox;
                })
                ->addColumn('aksi', function ($data) {
                    $btn = '<button type="button" class="btn btn-info btn-sm me-1" id="btn-detail" data-id="' . $data->id . '" data-bs-toggle="modal" data-bs-target="#detailModal"><i class="fa-solid fa-circle-info"></i></button>';
                    $btn = $btn . '<a class="btn btn-warning btn-sm me-1" href="' . route('homecare.edit', $data->id) . '" ><i
                    class="mdi mdi-pencil"></i></a>';
                    $btn = $btn . '<button type="button" class="btn btn-danger btn-sm" data-id="' . $data->id . '" id="btnHapus"><i
                    class="mdi mdi-trash-can"></i></button>';
                    return $btn;
                })
                ->rawColumns(['aksi', 'comboBox'])
                ->make(true);
        }
        return view('backend.homecare.index');
    }

    public function detail(Request $request)
    {
        $homecare = Homecare::with('bayar', 'kategori', 'poli')->orderBy('name', 'asc')->findOrFail($request->id);
        return response()->json(['homecare' => $homecare]);
    }

    public function create()
    {
        $lastKode = Homecare::orderByDesc('created_at')->first();
        $nextKodeNumber = $lastKode ? intval(substr($lastKode->kode_homecare, -4)) + 1 : 1;
        $homecareCode = "HMR" . sprintf('%04d', $nextKodeNumber);

        $kategori = Kategori::orderBy('name', 'asc')->get();
        $poli = Poli::orderBy('name', 'asc')->get();
        $bayar = Bayar::orderBy('name', 'asc')->get();
        return view('backend.homecare.add', compact(['kategori', 'poli', 'bayar', 'homecareCode']));
    }

    public function store(Request $request)
    {
        $validated = Validator::make(
            $request->all(),
            [
                'name' => 'required|string|unique:homecare,name',
                'kategori' => 'required|string',
                'poli' => 'required|string',
                'bayar' => 'required|string',
            ],
            [
                'name.required' => 'Silakan isi nama terlebih dahulu!',
                'name.unique' => 'Nama sudah digunakan!',
                'kategori.required' => 'Silakan isi kategori terlebih dahulu!',
                'poli.required' => 'Silakan isi poli terlebih dahulu!',
                'bayar.required' => 'Silakan isi jenis bayar terlebih dahulu!',
            ]
        );


        if ($validated->fails()) {
            return response()->json(['errors' => $validated->errors()]);
        } else {
            $homecare = new Homecare();
            $homecare->kode_homecare = $request->kode_homecare;
            $homecare->name = $request->name;
            $homecare->bayar_id = $request->bayar;
            $homecare->kategori_id = $request->kategori;
            $homecare->poli_id = $request->poli;
            $homecare->paket_obat = $request->paket_obat;
            $homecare->kso = $request->kso;
            $homecare->jasa_medis_dokter = $request->jasa_medis_dokter;
            $homecare->jasa_medis_perawat = $request->jasa_medis_perawat;
            $homecare->jasa_rumah_sakit = $request->jasa_rumah_sakit;
            $homecare->menejemen = $request->menejemen;
            $homecare->total_biaya_dokter = $request->total_biaya_dokter;
            $homecare->total_biaya_perawat = $request->total_biaya_perawat;
            $homecare->total_biaya_perawat_dokter = $request->total_biaya_perawat_dokter;
            $homecare->save();

            return response()->json(['success' => 'Data barhasil ditambahkan']);
        }
    }

    public function edit($id)
    {
        $homecare = Homecare::with('bayar', 'kategori', 'poli')->orderBy('name', 'asc')->findOrFail($id);
        $kategori = Kategori::orderBy('name', 'asc')->get();
        $poli = Poli::orderBy('name', 'asc')->get();
        $bayar = Bayar::orderBy('name', 'asc')->get();
        return view('backend.homecare.edit', compact(['kategori', 'poli', 'bayar', 'homecare']));
    }

    public function update(Request $request)
    {
        $id = $request->id;
        $validated = Validator::make(
            $request->all(),
            [
                'name' => 'required|string|unique:homecare,name,' . $id . ',id',
                'kategori' => 'required|string',
                'poli' => 'required|string',
                'bayar' => 'required|string',
            ],
            [
                'name.required' => 'Silakan isi nama terlebih dahulu!',
                'name.unique' => 'Nama sudah digunakan!',
                'kategori.required' => 'Silakan isi kategori terlebih dahulu!',
                'poli.required' => 'Silakan isi poli terlebih dahulu!',
                'bayar.required' => 'Silakan isi jenis bayar terlebih dahulu!',
            ]
        );


        if ($validated->fails()) {
            return response()->json(['errors' => $validated->errors()]);
        } else {
            $homecare = Homecare::find($id);
            $homecare->name = $request->name;
            $homecare->bayar_id = $request->bayar;
            $homecare->kategori_id = $request->kategori;
            $homecare->poli_id = $request->poli;
            $homecare->paket_obat = $request->paket_obat;
            $homecare->kso = $request->kso;
            $homecare->jasa_medis_dokter = $request->jasa_medis_dokter;
            $homecare->jasa_medis_perawat = $request->jasa_medis_perawat;
            $homecare->jasa_rumah_sakit = $request->jasa_rumah_sakit;
            $homecare->menejemen = $request->menejemen;
            $homecare->total_biaya_dokter = $request->total_biaya_dokter;
            $homecare->total_biaya_perawat = $request->total_biaya_perawat;
            $homecare->total_biaya_perawat_dokter = $request->total_biaya_perawat_dokter;
            $homecare->save();

            return response()->json(['success' => 'Data barhasil ditambahkan']);
        }
    }

    public function destroy(Request $request)
    {
        $homecare = Homecare::where('id', $request->id)->delete();
        return Response()->json(['homecare' => $homecare, 'success' => 'Data berhasil dihapus']);
    }

    public function deleteMultiple(Request $request)
    {
        $id = $request->id;
        Homecare::whereIn('id', explode(",", $id))->delete();
        return response()->json(['success' => "Data berhasil dihapus"]);
    }
}
