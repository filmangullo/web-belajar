<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LinkPresentasi;
use App\Pertemuan;

class LinkPresentasiController extends Controller
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

    public function create($id)
    {
        $pertemuan      = Pertemuan::where('id', $id)->firstOrFail();
        return view('link-presentasi.create', [
            'pertemuan'     => $pertemuan
        ])->render();
    }

    public function store(Request $request, $id)
    {
        $pertemuan      = Pertemuan::where('id', $id)->firstOrFail();
        $deskripsi      = new LinkPresentasi();
        $deskripsi->pertemuan_id    = $pertemuan->id;
        $deskripsi->nama            = $request->nama;
        $deskripsi->link            = $request->link;
        if($deskripsi->save()) 
        {
            return redirect()->route('pertemuan.show', $pertemuan->id);
        }
    }

    public function destroy($id)
    {
        $query = LinkPresentasi::where('id', $id)->firstOrFail();
        $pertemuanId = $query->pertemuan_id;

        if($query->delete())
        {
            return redirect()->route('pertemuan.show', $pertemuanId);
        }
    }
}
