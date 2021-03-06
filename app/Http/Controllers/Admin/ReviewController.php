<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Response;
use Validator;
use Illuminate\Support\Facades\Auth;
use PDF;
use Yajra\Datatables\Datatables;
use File;
use Illuminate\Support\Str;

class ReviewController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application Barang.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (request()->ajax()) {
            $review = DB::table('review')
                ->select('review.*', 'users.username', 'produk.nama_produk', 'kategori.nama_kategori')
                ->join('users', 'users.id', '=', 'review.user_id')
                ->join('produk', 'produk.id', '=', 'review.produk_id')
                ->join('kategori', 'kategori.id', '=', 'produk.kategori_id')
                ->orderBy('created_at')->get();

            return DataTables::of($review)
                ->addColumn('aksi', function ($row) {
                    $data = '<a href="javascript:void(0)" class="btn btn-danger btn-icon-text" id="btnHapus" data-toggle="modal" data-id="' . $row->id . '"><i class="mdi mdi-trash-can-outline"></i></a>
                                    <meta name="csrf-token" content="{{ csrf_token() }}">';
                    return $data;
                })
                ->addColumn('foto_review', function ($row) {
                    $data = '<a href="http://localhost/ecommerce/public/foto/review/' . $row->foto . '" target="_blank"><img src="http://localhost/ecommerce/public/foto/review/' . $row->foto . '" width="300px"></img></a>';
                    return $data;
                })
                ->rawColumns(['aksi', 'foto_review'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.informasi.review');
    }

    public function edit($id)
    {
        $review = DB::table('review')
            ->where('id', $id)->first();

        return Response::json($review);
    }

    public function destroy(Request $request)
    {
        DB::table('review')->where('id', $request->id1)->delete();

        Alert::success('Sukses', 'Review Berhasil Dihapus');

        return redirect("/admin/review");
    }
}
