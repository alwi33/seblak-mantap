<?php

namespace App\Http\Controllers;

use App\Models\Kondimen;
use App\Models\Paket;
use App\Models\Pengaturan;

class MenuController extends Controller
{
    public function index()
    {
        $pakets = Paket::where('status', 'aktif')->orderBy('nama_paket')->get();
        $kondimens = Kondimen::where('status', 'aktif')->orderBy('nama_kondimen')->get();
        $pengaturan = Pengaturan::aktif();

        return view('pages.home', compact('pakets', 'kondimens', 'pengaturan'));
    }
}
