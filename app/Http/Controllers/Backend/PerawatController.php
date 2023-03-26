<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class PerawatController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $perawat = User::where('type', 2)->orderBy('name', 'asc')->get(['id', 'name', 'email', 'no_telepon', 'address']);
            return DataTables::of($perawat)
                ->addIndexColumn()
                ->addColumn('comboBox', function ($data) {
                    $comboBox = "<input type='checkbox' class='checkbox' data-id='" . $data->id . "'>";
                    return $comboBox;
                })
                ->addColumn('aksi', function ($data) {
                    $btn = '<a class="btn btn-warning btn-sm me-1" href="' . route('perawat.edit', $data->id) . '" ><i
                    class="mdi mdi-pencil"></i></a>';
                    $btn = $btn . '<button type="button" class="btn btn-danger btn-sm" data-id="' . $data->id . '" id="btnHapus"><i
                    class="mdi mdi-trash-can"></i></button>';
                    return $btn;
                })
                ->rawColumns(['aksi', 'comboBox'])
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
                'name' => 'required|string',
                'email' => 'required|email|unique:users,email',
                'no_telepon' => 'required|unique:users,no_telepon|min:11|max:15',
                'gender' => 'required',
                'avatar' => 'image|mimes:jpg,png,jpeg,webp,svg',
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
                    $data = [
                        'name' => $request->name,
                        'email' => $request->email,
                        'no_telepon' => $request->no_telepon,
                        'password' => bcrypt($request->no_telepon),
                        'type' => 2,
                        'gender' => $request->gender,
                        'address' => $request->address,
                        'avatar' => $request->name . '.' . $guessExtension,
                    ];
                    $perawat = User::create($data);
                    return response()->json($perawat);
                }
            } else {
                $data = [
                    'name' => $request->name,
                    'email' => $request->email,
                    'no_telepon' => $request->no_telepon,
                    'password' => bcrypt($request->no_telepon),
                    'type' => 2,
                    'gender' => $request->gender,
                    'address' => $request->address,
                ];
                $perawat = User::create($data);
                return response()->json($perawat);
            }
        }
    }

    public function edit($id)
    {
        $perawat = User::where('type', 2)->find($id);
        return view('backend.perawat.edit', compact('perawat'));
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
            ]
        );

        if ($validated->fails()) {
            return response()->json(['errors' => $validated->errors()]);
        } else {
            if ($request->hasFile('avatar')) {
                $file = $request->file('avatar');
                if ($file->isValid()) {
                    $perawat = User::findOrFail($id);

                    if ($perawat->avatar !== 'avatar.png') {
                        Storage::delete('users-avatar/' . $perawat->avatar);
                    }

                    $guessExtension = $request->file('avatar')->guessExtension();
                    $request->file('avatar')->storeAs('users-avatar/', $request->name . '.' . $guessExtension, 'public');
                    $data = [
                        'name' => $request->name,
                        'email' => $request->email,
                        'no_telepon' => $request->no_telepon,
                        'gender' => $request->gender,
                        'address' => $request->address,
                        'avatar' => $request->name . '.' . $guessExtension,
                    ];
                    $perawat = User::where('id', $id)->update($data);
                    return response()->json($perawat);
                }
            } else {
                $data = [
                    'name' => $request->name,
                    'email' => $request->email,
                    'no_telepon' => $request->no_telepon,
                    'gender' => $request->gender,
                    'address' => $request->address,
                ];
                $perawat = User::where('id', $id)->update($data);
                return response()->json($perawat);
            }
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
