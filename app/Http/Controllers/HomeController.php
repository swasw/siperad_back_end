<?php



namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\PeminjamanBarang;
use App\Models\PeminjamanRuang;
use Illuminate\Http\Request;



class HomeController extends Controller

{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('user/home');
    }

    public function adminHome()
    {
        $barang = PeminjamanBarang::where('status_peminjaman', 0)->get();
        $ruang = PeminjamanRuang::where('status_peminjaman', 0)->get();
        // $data = Barang::all();
        return view('admin/dashboard', [
            'title' => 'Data',
            'barang' => $barang,
            'ruang' => $ruang
        ]);
        // return view('admin/dashboard');
    }
}
