<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;


class DokterController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $dokter = $dokter = User::with('dokter')->where('type', 3)->orderBy('name', 'asc')->get(['id', 'name', 'email', 'no_telepon', 'address']);
            return DataTables::of($dokter)
                ->addIndexColumn()
                ->addColumn('comboBox', function ($data) {
                    $comboBox = "<input type='checkbox' class='checkbox' data-id='" . $data->id . "'>";
                    return $comboBox;
                })
                ->addColumn('status', function ($data) {
                    if ($data->dokter->status == '0') {
                        $badgeStatus = '<span class="badge bg-success">Melayanani</span>';
                        return $badgeStatus;
                    } else {
                        $badgeStatus = '<span class="badge bg-danger">Sedang Melayanani</span>';
                        return $badgeStatus;
                    }
                })
                ->addColumn('aksi', function ($data) {
                    $btn = '<a class="btn btn-warning btn-sm me-1" href="' . route('dokter.edit', $data->id) . '" ><i
                    class="mdi mdi-pencil"></i></a>';
                    $btn = $btn . '<button type="button" class="btn btn-danger btn-sm" data-id="' . $data->id . '" id="btnHapus"><i
                    class="mdi mdi-trash-can"></i></button>';
                    return $btn;
                })
                ->rawColumns(['aksi', 'comboBox', 'status'])
                ->make(true);
        }
        return view('backend.dokter.index');
    }

    public function create()
    {
        return view('backend.dokter.add');
    }

    public function store(Request $request)
    {
        $validated = Validator::make(
            $request->all(),
            [
                'name' => 'required|string',
                'email' => 'required|email|unique:users,email',
                'no_telepon' => 'required|unique:users,no_telepon|min:11|max:15',
                'gender' => 'required',
                'avatar' => 'image|mimes:jpg,png,jpeg,webp,svg',
                'spesialis' => 'required',
                'pengalaman' => 'required|numeric|max:50',
                'deskripsi' => 'required',
            ],
            [
                'name.required' => 'Silakan isi nama terlebih dahulu!',
                'email.required' => 'Silakan isi email terlebih dahulu!',
                'email.unique' => 'Email sudah digunakan!',
                'no_telepon.required' => 'Silakan isi no telepon terlebih dahulu!',
                'no_telepon.unique' => 'No telepon sudah digunakan!',
                'no_telepon.min' => 'No telepon harus memiliki panjang minimal 11 karakter.',
                'no_telepon.max' => 'No telepon harus memiliki panjang maksimal 15 karakter.',
                'gender.required' => 'Silakan isi jenis kelamin terlebih dahulu!',
                'avatar.image' => 'File harus berupa gambar!',
                'avatar.mimes' => 'Pilihan gambar yang diunggah harus dalam format JPG, PNG, JPEG, WEBP, atau SVG.',
                'spesialis.required' => 'Silakan isi spesialis terlebih dahulu!',
                'pengalaman.required' => 'Silakan isi pengalaman terlebih dahulu!',
                'pengalaman.max' => 'Maksimal pengisian pengalaman :max tahun.',
                'deskripsi.required' => 'Silakan isi deskripsi terlebih dahulu!',
            ]
        );


        if ($validated->fails()) {
            return response()->json(['errors' => $validated->errors()]);
        } else {
            if ($request->hasFile('avatar')) {
                $file = $request->file('avatar');
                if ($file->isValid()) {
                    $guessExtension = $request->file('avatar')->guessExtension();
                    $request->file('avatar')->storeAs('users-avatar/', $request->name . '.' . $guessExtension, 'public');

                    $user = new User();
                    $user->name = $request->name;
                    $user->email = $request->email;
                    $user->no_telepon = $request->no_telepon;
                    $user->password = bcrypt($request->no_telepon);
                    $user->type = 3;
                    $user->gender = $request->gender;
                    $user->address = $request->address;
                    $user->avatar = $request->name . '.' . $guessExtension;
                    $user->save();

                    $dokter = new Dokter();
                    $dokter->user_id = $user->id;
                    $dokter->spesialis = $request->spesialis;
                    $dokter->pengalaman_tahun = $request->pengalaman;
                    $dokter->deskripsi = $request->deskripsi;
                    $dokter->save();
                    return response()->json(['success' => 'Data barhasil ditambahkan']);
                }
            } else {
                $user = new User();
                $user->name = $request->name;
                $user->email = $request->email;
                $user->no_telepon = $request->no_telepon;
                $user->password = bcrypt($request->no_telepon);
                $user->type = 3;
                $user->gender = $request->gender;
                $user->address = $request->address;
                $user->save();

                $dokter = new Dokter();
                $dokter->user_id = $user->id;
                $dokter->spesialis = $request->spesialis;
                $dokter->pengalaman_tahun = $request->pengalaman;
                $dokter->deskripsi = $request->deskripsi;
                $dokter->save();

                return response()->json(['success' => 'Data barhasil ditambahkan']);
            }
        }
    }

    public function edit($id)
    {
        $user = User::with('dokter')->find($id);
        $dokter = $user->dokter;
        return view('backend.dokter.edit', compact('user', 'dokter'));
    }

    public function update(Request $request)
    {
        $id = $request->id;
        $validated = Validator::make(
            $request->all(),
            [
                'name' => 'required|string',
                'email' => 'required|email|unique:users,email,' . $id . ',id',
                'no_telepon' => 'required|unique:users,no_telepon,' . $id . ',id|min:11|max:15',
                'gender' => 'required',
                'avatar' => 'image|mimes:jpg,png,jpeg,webp,svg',
                'spesialis' => 'required',
                'pengalaman' => 'required|numeric|max:50',
                'deskripsi' => 'required',
            ],
            [
                'name.required' => 'Silakan isi nama terlebih dahulu!',
                'email.required' => 'Silakan isi email terlebih dahulu!',
                'email.unique' => 'Email sudah digunakan!',
                'no_telepon.required' => 'Silakan isi no telepon terlebih dahulu!',
                'no_telepon.unique' => 'No telepon sudah digunakan!',
                'no_telepon.min' => 'No telepon harus memiliki panjang minimal 11 karakter.',
                'no_telepon.max' => 'No telepon harus memiliki panjang maksimal 15 karakter.',
                'gender.required' => 'Silakan isi jenis kelamin terlebih dahulu!',
                'avatar.image' => 'File harus berupa gambar!',
                'avatar.mimes' => 'Pilihan gambar yang diunggah harus dalam format JPG, PNG, JPEG, WEBP, atau SVG.',
                'spesialis.required' => 'Silakan isi spesialis terlebih dahulu!',
                'pengalaman.required' => 'Silakan isi pengalaman terlebih dahulu!',
                'pengalaman.max' => 'Maksimal pengisian pengalaman :max tahun.',
                'deskripsi.required' => 'Silakan isi deskripsi terlebih dahulu!',
            ]
        );

        if ($validated->fails()) {
            return response()->json(['errors' => $validated->errors()]);
        } else {
            if ($request->hasFile('avatar')) {
                $file = $request->file('avatar');
                if ($file->isValid()) {
                    $dokter = User::findOrFail($id);

                    if ($dokter->avatar !== 'avatar.png') {
                        Storage::delete('users-avatar/' . $dokter->avatar);
                    }

                    $guessExtension = $request->file('avatar')->guessExtension();
                    $request->file('avatar')->storeAs('users-avatar/', $request->name . '.' . $guessExtension, 'public');

                    $user = User::find($id);
                    $dokter = $user->dokter;

                    // Mengupdate data pada tabel users
                    $user->update([
                        'name' => $request->name,
                        'email' => $request->email,
                        'no_telepon' => $request->no_telepon,
                        'gender' => $request->gender,
                        'address' => $request->address,
                        'avatar' => $request->name . '.' . $guessExtension,
                    ]);

                    // Mengupdate data pada tabel dokter
                    $dokter->update([
                        'spesialis' => $request->spesialis,
                        'pengalaman_tahun' => $request->pengalaman,
                        'deskripsi' =>  $request->deskripsi,
                    ]);

                    return response()->json(['success' => 'Data barhasil diubah']);
                }
            } else {
                $user = User::find($id);
                $dokter = $user->dokter;

                // Mengupdate data pada tabel users
                $user->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'no_telepon' => $request->no_telepon,
                    'gender' => $request->gender,
                    'address' => $request->address,
                ]);

                // Mengupdate data pada tabel dokter
                $dokter->update([
                    'spesialis' => $request->spesialis,
                    'pengalaman_tahun' => $request->pengalaman,
                    'deskripsi' =>  $request->deskripsi,
                ]);

                return response()->json(['success' => 'Data barhasil diubah']);
            }
        }
    }

    public function destroy(Request $request)
    {
        $dokter = User::findOrFail($request->id);

        if ($dokter->avatar !== 'avatar.png') {
            Storage::delete('users-avatar/' . $dokter->avatar);
            $dokter->delete();
        } else {
            $dokter->delete();
        }

        return Response()->json(['dokter' => $dokter, 'success' => 'Data berhasil dihapus']);
    }


    public function deleteMultiple(Request $request)
    {
        $dokter = User::whereIn('id', explode(",", $request->id))->get();

        foreach ($dokter as $row) {
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
