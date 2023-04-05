<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Perawat;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class PerawatController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $perawat = User::with('perawat')->where('type', 2)->orderBy('name', 'asc')->get();
            return DataTables::of($perawat)
                ->addIndexColumn()
                ->addColumn('comboBox', function ($data) {
                    $comboBox = "<input type='checkbox' class='checkbox' data-id='" . $data->id . "'>";
                    return $comboBox;
                })
                ->addColumn('nip', function ($data) {
                    $nip = $data->perawat->nip;
                    return $nip;
                })
                ->addColumn('jabatan', function ($data) {
                    $jabatan = $data->perawat->jabatan;
                    return $jabatan;
                })
                ->addColumn('status', function ($data) {
                    if ($data->perawat->status == '0') {
                        $badgeStatus = '<span class="badge bg-success">Aktif</span>';
                        return $badgeStatus;
                    } else {
                        $badgeStatus = '<span class="badge bg-danger">Tidak Aktif</span>';
                        return $badgeStatus;
                    }
                })
                ->addColumn('aksi', function ($data) {
                    $btn = '<a class="btn btn-warning btn-sm me-1" href="' . route('perawat.edit', $data->id) . '" ><i
                    class="mdi mdi-pencil"></i></a>';
                    $btn = $btn . '<button type="button" class="btn btn-danger btn-sm" data-id="' . $data->id . '" id="btnHapus"><i
                    class="mdi mdi-trash-can"></i></button>';
                    return $btn;
                })
                ->rawColumns(['aksi', 'comboBox', 'status'])
                ->make(true);
        }
        return view('backend.perawat.index');
    }

    public function create()
    {
        return view('backend.perawat.add');
    }

    public function store(Request $request)
    {
        $validated = Validator::make(
            $request->all(),
            [
                'nip' => 'required|string|unique:perawat,nip',
                'name' => 'required|string',
                'email' => 'required|email|unique:users,email',
                'no_telepon' => 'required|unique:users,no_telepon|min:11|max:15',
            ],
            [
                'nip.required' => 'Silakan isi nip terlebih dahulu!',
                'nip.unique' => 'NIP sudah digunakan!',
                'name.required' => 'Silakan isi nama terlebih dahulu!',
                'email.required' => 'Silakan isi email terlebih dahulu!',
                'email.unique' => 'Email sudah digunakan!',
                'no_telepon.required' => 'Silakan isi no telepon terlebih dahulu!',
                'no_telepon.unique' => 'No telepon sudah digunakan!',
                'no_telepon.min' => 'No telepon harus memiliki panjang minimal 11 karakter.',
                'no_telepon.max' => 'No telepon harus memiliki panjang maksimal 15 karakter.',
            ]
        );


        if ($validated->fails()) {
            return response()->json(['errors' => $validated->errors()]);
        } else {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->no_telepon = $request->no_telepon;
            $user->password = bcrypt($request->no_telepon);
            $user->type = 2;
            $user->gender = $request->gender;
            $user->address = $request->address;
            $user->save();

            $perawat = new Perawat();
            $perawat->user_id = $user->id;
            $perawat->nip = $request->nip;
            $perawat->gol_darah = $request->gol_darah;
            $perawat->tempat_lahir = $request->tempat_lahir;
            $perawat->tanggal_lahir = $request->tanggal_lahir;
            $perawat->agama = $request->agama;
            $perawat->status_nikah = $request->status_nikah;
            $perawat->jabatan = $request->jabatan;
            $perawat->save();

            return response()->json(['success' => 'Data barhasil ditambahkan']);
        }
    }

    public function edit($id)
    {
        $perawat = User::with('perawat')->findOrFail($id);
        return view('backend.perawat.edit', compact('perawat'));
    }

    public function update(Request $request)
    {
        $id = $request->id;
        $id_perawat = $request->id_perawat;
        $validated = Validator::make(
            $request->all(),
            [
                'nip' => 'required|string|unique:perawat,nip,' . $id_perawat . ',id',
                'name' => 'required|string',
                'email' => 'required|email|unique:users,email,' . $id . ',id',
                'no_telepon' => 'required|unique:users,no_telepon,' . $id . ',id|min:11|max:15',
            ],
            [
                'nip.required' => 'Silakan isi nip terlebih dahulu!',
                'nip.unique' => 'NIP sudah digunakan!',
                'name.required' => 'Silakan isi nama terlebih dahulu!',
                'email.required' => 'Silakan isi email terlebih dahulu!',
                'email.unique' => 'Email sudah digunakan!',
                'no_telepon.required' => 'Silakan isi no telepon terlebih dahulu!',
                'no_telepon.unique' => 'No telepon sudah digunakan!',
                'no_telepon.min' => 'No telepon harus memiliki panjang minimal 11 karakter.',
                'no_telepon.max' => 'No telepon harus memiliki panjang maksimal 15 karakter.',
            ]
        );

        if ($validated->fails()) {
            return response()->json(['errors' => $validated->errors()]);
        } else {

            $user = User::find($id);
            $perawat = $user->perawat;

            // Mengupdate data pada tabel users
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'no_telepon' => $request->no_telepon,
                'gender' => $request->gender,
                'address' => $request->address,
            ]);

            // Mengupdate data pada tabel perawat
            $perawat->update([
                'nip' => $request->nip,
                'gol_darah' => $request->gol_darah,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'agama' => $request->agama,
                'status_nikah' => $request->status_nikah,
                'jabatan' => $request->jabatan,
            ]);
            return response()->json(['success' => 'Data barhasil diedit']);
        }
    }

    public function destroy(Request $request)
    {
        $perawat = User::findOrFail($request->id);

        if ($perawat->avatar !== 'avatar.png') {
            Storage::delete('users-avatar/' . $perawat->avatar);
            $perawat->delete();
        } else {
            $perawat->delete();
        }

        return Response()->json(['perawat' => $perawat, 'success' => 'Data berhasil dihapus']);
    }

    public function deleteMultiple(Request $request)
    {
        $perawat = User::whereIn('id', explode(",", $request->id))->get();

        foreach ($perawat as $row) {
            if ($row->avatar !== 'avatar.png') {
                Storage::delete('users-avatar/' . $row->avatar);
                $row->delete();
            } else {
                $row->delete();
            }
        }

        return response()->json(['success' => "Data berhasil dihapus"]);
    }
}
