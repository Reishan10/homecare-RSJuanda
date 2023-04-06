<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Layanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class LayananController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $layanan = Layanan::orderBy('kode_layanan', 'asc')->get();
            return DataTables::of($layanan)
                ->addIndexColumn()
                ->addColumn('harga', function ($data) {
                    $harga = "Rp " . number_format($data->harga, 0, ',', '.');
                    return $harga;
                })
                ->addColumn('comboBox', function ($data) {
                    $comboBox = "<input type='checkbox' class='checkbox' data-id='" . $data->id . "'>";
                    return $comboBox;
                })
                ->addColumn('aksi', function ($data) {
                    $btn = '<button type="button" class="btn btn-warning btn-sm me-1" data-id="' . $data->id . '" id="btnEdit"><i
                    class="mdi mdi-pencil"></i></button>';
                    $btn = $btn . '<button type="button" class="btn btn-danger btn-sm" data-id="' . $data->id . '" id="btnHapus"><i
                    class="mdi mdi-trash-can"></i></button>';
                    return $btn;
                })
                ->rawColumns(['aksi', 'comboBox'])
                ->make(true);
        }
        return view('backend.layanan.index');
    }

    public function store(Request $request)
    {
        $id = $request->id;
        $validated = Validator::make(
            $request->all(),
            [
                'name' => 'required|unique:layanan,name,' . $id,
                'harga' => 'required'
            ],
            [
                'name.required' => 'Silakan isi nama terlebih dahulu!',
                'name.unique' => 'Layanan sudah tersedia!',
                'harga.required' => 'Silakan isi harga terlebih dahulu!',
            ]
        );

        if ($validated->fails()) {
            return response()->json(['errors' => $validated->errors()]);
        } else {
            if (!$id) {
                $lastLayanan = Layanan::orderByDesc('created_at')->first();
                $nextLayananNumber = $lastLayanan ? intval(substr($lastLayanan->kode_layanan, -4)) + 1 : 1;
                $LayananCode = 'LYN' . sprintf('%04d', $nextLayananNumber);

                $layanan = new Layanan();
                $layanan->kode_layanan = $LayananCode;
            } else {
                $layanan = Layanan::find($id);
                if ($layanan->kode_layanan != $request->kode_layanan) {
                    $request->merge(['kode_layanan' => $layanan->kode_layanan]);
                }
            }

            $layanan->name = $request->name;
            $layanan->harga = $request->harga;
            $layanan->save();

            return response()->json($layanan);
        }
    }

    public function edit($id)
    {
        $data = Layanan::where('id', $id)->first();
        return response()->json($data);
    }

    public function destroy(Request $request)
    {
        $kategori = Layanan::where('id', $request->id)->delete();
        return Response()->json(['kategori' => $kategori, 'success' => 'Data berhasil dihapus']);
    }

    public function deleteMultiple(Request $request)
    {
        $id = $request->id;
        Layanan::whereIn('id', explode(",", $id))->delete();
        return response()->json(['success' => "Data berhasil dihapus"]);
    }
}
