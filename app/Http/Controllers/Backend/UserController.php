<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $user = $user = User::where('id', '!=', auth()->user()->id)->orderBy('name', 'asc')->get();
            return DataTables::of($user)
                ->addIndexColumn()
                ->addColumn('comboBox', function ($data) {
                    $comboBox = "<input type='checkbox' class='checkbox' data-id='" . $data->id . "'>";
                    return $comboBox;
                })
                ->addColumn('aksi', function ($data) {
                    $btn = '<a class="btn btn-warning btn-sm me-1" href="' . route('user.edit', $data->id) . '" ><i
                    class="mdi mdi-pencil"></i></a>';
                    $btn = $btn . '<button type="button" class="btn btn-danger btn-sm" data-id="' . $data->id . '" id="btnHapus"><i
                    class="mdi mdi-trash-can"></i></button>';
                    return $btn;
                })
                ->rawColumns(['aksi', 'comboBox'])
                ->make(true);
        }
        return view('backend.user.index');
    }

    public function create()
    {
        return view('backend.user.add');
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
                        'type' => 1,
                        'gender' => $request->gender,
                        'address' => $request->address,
                        'avatar' => $request->name . '.' . $guessExtension,
                    ];
                    $user = User::create($data);
                    return response()->json($user);
                }
            } else {
                $data = [
                    'name' => $request->name,
                    'email' => $request->email,
                    'no_telepon' => $request->no_telepon,
                    'password' => bcrypt($request->no_telepon),
                    'type' => 1,
                    'gender' => $request->gender,
                    'address' => $request->address,
                ];
                $user = User::create($data);
                return response()->json($user);
            }
        }
    }

    public function edit($id)
    {
        $user = User::find($id);
        return view('backend.user.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $id = $request->id;
        $validated = Validator::make(
            $request->all(),
            [
                'name' => 'required',
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
                    $user = User::findOrFail($id);
                    if ($user->avatar !== 'avatar.png') {
                        Storage::delete('users-avatar/' . $user->avatar);
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
                    $user = User::where('id', $id)->update($data);
                    return response()->json($user);
                }
            } else {
                $data = [
                    'name' => $request->name,
                    'email' => $request->email,
                    'no_telepon' => $request->no_telepon,
                    'gender' => $request->gender,
                    'address' => $request->address,
                ];
                $user = User::where('id', $id)->update($data);
                return response()->json($user);
            }
        }
    }

    public function destroy(Request $request)
    {
        $user = User::findOrFail($request->id);

        if ($user->avatar !== 'avatar.png') {
            Storage::delete('users-avatar/' . $user->avatar);
            $user->delete();
        } else {
            $user->delete();
        }

        return Response()->json(['user' => $user, 'success' => 'Data berhasil dihapus']);
    }

    public function deleteMultiple(Request $request)
    {
        $user = User::whereIn('id', explode(",", $request->id))->get();

        foreach ($user as $row) {
            if ($row->avatar !== 'avatar.png') {
                Storage::delete('users-avatar/' . $row->avatar);
                $row->delete();
            } else {
                $row->delete();
            }
        }

        return response()->json(['success' => "Data berhasil dihapus"]);
    }

    public function profile()
    {
        return view('backend.user.profile');
    }

    public function updateProfile(Request $request)
    {
        $id = $request->id;
        $validated = Validator::make(
            $request->all(),
            [
                'email' => 'email|unique:users,email,' . $id . ',id',
                'no_telepon' => 'unique:users,no_telepon,' . $id . ',id|min:11|max:15',
                'avatar' => 'image|mimes:jpg,png,jpeg,webp,svg',
            ],
            [
                'email.unique' => 'Email sudah digunakan!',
                'no_telepon.unique' => 'No telepon sudah digunakan!',
                'no_telepon.min' => 'No telepon harus memiliki panjang minimal 11 karakter.',
                'no_telepon.max' => 'No telepon harus memiliki panjang maksimal 15 karakter.',
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
                    $user = User::findOrFail($id);
                    if ($user->avatar !== 'avatar.png') {
                        Storage::delete('users-avatar/' . $user->avatar);
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
                    $user = User::where('id', $id)->update($data);
                    return response()->json($user);
                }
            } else {
                $data = [
                    'name' => $request->name,
                    'email' => $request->email,
                    'no_telepon' => $request->no_telepon,
                    'gender' => $request->gender,
                    'address' => $request->address,
                ];
                $user = User::where('id', $id)->update($data);
                return response()->json($user);
            }
        }
    }
}
