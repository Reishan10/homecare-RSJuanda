<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ChatPayment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class ChatPaymentController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $chatpayment =  ChatPayment::all();
            return DataTables::of($chatpayment)
                ->addIndexColumn()
                ->addColumn('comboBox', function ($data) {
                    $comboBox = "<input type='checkbox' class='checkbox' data-id='" . $data->user->id . "'>";
                    return $comboBox;
                })
                ->addColumn('aksi', function ($data) {
                    $btn = '<button type="button" class="btn btn-info btn-sm me-1" id="btn-detail" data-id="' . $data->id . '" data-bs-toggle="modal" data-bs-target="#detailModal"><i class="fa-solid fa-circle-info"></i></button>';
                    $btn = $btn . '<a class="btn btn-warning btn-sm me-1" href="' . route('chatpayment.edit', $data->user->id) . '" ><i
                    class="mdi mdi-pencil"></i></a>';
                    $btn = $btn . '<button type="button" class="btn btn-danger btn-sm" data-id="' . $data->user->id . '" id="btnHapus"><i
                    class="mdi mdi-trash-can"></i></button>';
                    return $btn;
                })
                ->rawColumns(['aksi', 'comboBox', 'status'])
                ->make(true);
        }
        return view('backend.chatpayment.index');
    }

    public function create()
    {
        $pasien = User::where('type', 0)->orderBy('name', 'asc')->get();
        $dokter = User::where('type', 3)->orderBy('name', 'asc')->get();
        return view('backend.chatpayment.add', compact(['pasien', 'dokter']));
    }

    public function store(Request $request)
    {
        $validated = Validator::make(
            $request->all(),
            [
                'pasien' => 'required|string',
                'dokter' => 'required|string',
                'waktu_mulai' => 'required|string',
                'waktu_selesai' => 'required|string',
            ],
            [
                'pasien.required' => 'Silakan isi pasien terlebih dahulu!',
                'dokter.required' => 'Silakan isi dokter terlebih dahulu!',
                'waktu_mulai.required' => 'Silakan isi waktu mulai terlebih dahulu!',
                'waktu_selesai.required' => 'Silakan isi waktu selesai terlebih dahulu!',
            ]
        );


        if ($validated->fails()) {
            return response()->json(['errors' => $validated->errors()]);
        } else {
            $chatpayment = new ChatPayment();
            $chatpayment->user_id = $request->pasien;
            $chatpayment->dokter_id = $request->dokter;
            $chatpayment->waktu_mulai = $request->waktu_mulai;
            $chatpayment->waktu_selesai = $request->waktu_selesai;
            $chatpayment->biaya_chat = $request->biaya_chat;
            $chatpayment->save();

            return response()->json(['success' => 'Data barhasil ditambahkan']);
        }
    }
}
