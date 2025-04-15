<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\Produk;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Exports\PenjualanExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Laravel\Pail\ValueObjects\Origin\Console;

class PembelianController extends Controller
{

    public function index(Request $request)
    {
        $keyword = $request->input('search');

        $penjualans = Penjualan::with('members')
            ->when($keyword, function ($query, $keyword) {
                $query->whereHas('members', function ($q) use ($keyword) {
                    $q->where('nama_member', 'like', '%' . $keyword . '%');
                });
            })
            ->latest()
            ->paginate(10)
            ->appends(['search' => $keyword]); 
        return view('petugas.pembelian.index', compact('penjualans'));
    }

    public function indexAdmin(Request $request)
    {
        $keyword = $request->input('search');

        $penjualans = Penjualan::with('members')
            ->when($keyword, function ($query, $keyword) {
                $query->whereHas('members', function ($q) use ($keyword) {
                    $q->where('nama_member', 'like', '%' . $keyword . '%');
                });
            })
            ->latest()
            ->paginate(10)
            ->appends(['search' => $keyword]); 

        return view('admin.pembelian.index', compact('penjualans'));
    }

    public function create()
    {
        $produks = Produk::where('stock', '>', 0)->get();
        return view('petugas.pembelian.create', compact('produks'));
    }

    public function store(Request $request)
    {
        // Validasi awal
        $rules = [
            'produk_id'      => 'required|exists:produks,id',
            'jumlah'         => 'required|integer|min:1',
            'total_payment'  => 'required|numeric',
            'is_member'      => 'required|in:bukan_member,member',
        ];

        // Validasi tambahan jika member
        if ($request->is_member === 'member') {
            $rules['customer_phone'] = 'required|string|max:20|exists:members,nomor_telepon';
        }

        $request->validate($rules);

        $produk = Produk::findOrFail($request->produk_id);

        if ($produk->stock < $request->jumlah) {
            return back()->withInput()->with('error', 'Stok produk tidak mencukupi. Stok tersedia: ' . $produk->stock);
        }
        // Proses data member jika dipilih
        $member = null;
        if ($request->is_member === 'member') {
            $member = Member::where('nomor_telepon', $request->customer_phone)->first();

            if (!$member) {
                return back()->withInput()->with('error', 'Member dengan nomor telepon tersebut tidak ditemukan.');
            }
        } else {
            // Jika bukan member, isi customer_phone default
            $request->merge(['customer_phone' => '-']);
        }

        // Generate nomor invoice unik
        $invoiceNumber = 'INV-' . now()->format('Ymd') . '-' . strtoupper(uniqid());

        // Hitung total harga barang
        $totalHargaBarang = $request->total_price;

        // Total uang dibayar dari input
        $totalDibayar = $request->total_payment;

        // Hitung uang kembalian
        $uangKembalian = max(0, $totalDibayar - $totalHargaBarang);


        // Simpan ke tabel Penjualan
        $penjualan = Penjualan::create([
            'member_id'         => $member ? $member->id : null,
            'invoice_number'    => $invoiceNumber,
            'tanggal_penjualan' => now(),
            'total_payment'     => $totalDibayar,
            'user_id'           => Auth::id(),
            'point_used'        => 0,
            'change'            => $uangKembalian,
            'customer_phone'    => $request->customer_phone,
        ]);


        foreach ($request->produk as $item) {
            $produkDetail = Produk::findOrFail($item['id']);

            // Simpan ke tabel detail_penjualans
            $penjualan->detailPenjualan()->create([
                'produk_id' => $item['id'],
                'qty'       => $item['jumlah'],
                'price'     => $produkDetail->price,
                'sub_total' => $produkDetail->price * $item['jumlah']
            ]);
            $produkDetail->decrement('stock', $item['jumlah']);
        }

        // Update stok

        return redirect()->route('petugas.pembelian.struk', $penjualan->id);
    }


    public function storeStep2(Request $request)
{
    $request->validate([
        'nama_member'     => 'nullable|string|max:255',
        'customer_phone'  => 'required|string|max:20',
        'total_payment'   => 'required|numeric',
        'point_used'      => 'nullable|in:1',
    ]);

    // Cari member berdasarkan nomor telepon
    $member = Member::where('nomor_telepon', $request->customer_phone)->first();

    // Jika tidak ditemukan, buat member baru
    if (!$member) {
        $member = Member::create([
            'nama_member'    => $request->nama_member ?? '-',
            'nomor_telepon'  => $request->customer_phone,
            'points'         => 0,
        ]);
    }

    $selectedProducts = session('selected_products', []);
    if (empty($selectedProducts)) {
        return back()->with('error', 'Tidak ada produk yang dipilih.');
    }

    // Validasi stok
    foreach ($selectedProducts as $item) {
        $produk = Produk::where('title', $item['nama_produk'])->first();
        if (!$produk || $produk->stock < $item['qty']) {
            return back()->with('error', "Stok tidak mencukupi untuk produk: {$item['nama_produk']}. Stok tersedia: {$produk->stock}");
        }
    }

    // Hitung total belanja
    $totalBelanja = array_sum(array_column($selectedProducts, 'sub_total'));

    // Proses pemotongan poin
    $pointUsed = 0;
    $potongan = 0;
    $totalSetelahDiskon = $totalBelanja;

    if ($request->has('point_used') && $member->points > 0) {
        $pointUsed = min($member->points, $totalBelanja);
        $potongan = $pointUsed;
        $totalSetelahDiskon = $totalBelanja - $potongan;

        // Kurangi poin member
        $member->points = 0; // langsung nol
        $member->save();
    }

    $totalDibayar = $request->total_payment;
    $uangKembalian = max(0, $totalDibayar - $totalSetelahDiskon);

    // Simpan penjualan
    $penjualan = Penjualan::create([
        'invoice_number'    => 'INV-' . now()->format('Ymd') . '-' . strtoupper(uniqid()),
        'user_id'           => Auth::id(),
        'member_id'         => $member->id,
        'customer_phone'    => $member->nomor_telepon,
        'is_member'         => true,
        'total_payment'     => $totalSetelahDiskon,
        'point_used'        => $pointUsed,
        'change'            => $uangKembalian,
        'tanggal_penjualan' => now()->timezone('Asia/Jakarta'),
    ]);

    // Simpan detail dan kurangi stok
    foreach ($selectedProducts as $item) {
        $produk = Produk::where('title', $item['nama_produk'])->first();

        $penjualan->detailPenjualan()->create([
            'produk_id' => $produk->id,
            'qty'       => $item['qty'],
            'price'     => $produk->price,
            'sub_total' => $produk->price * $item['qty'],
        ]);

        $produk->decrement('stock', $item['qty']);
    }

    // Tambah poin baru (0.001 x total setelah diskon)
    if ($totalSetelahDiskon > 0) {
        $poinBaru = round($totalSetelahDiskon * 0.001, 3);
        $member->points += $poinBaru;
        $member->save();
    }

    session()->forget(['selected_products', 'total_payment']);

    return redirect()->route('petugas.pembelian.struk', $penjualan->id);
}

    



    public function export()
    {
        return Excel::download(new PenjualanExport, 'data_pembelian.xlsx');
    }

    public function show($id)
    {
        $pembelian = Penjualan::with(['detailPenjualan.produk', 'user', 'members'])->findOrFail($id);
        return view('petugas.pembelian.show', compact('pembelian'));
    }

    public function showPdf($id)
    {
        $pembelian = Penjualan::with(['detailPenjualan.produk', 'user', 'members'])->findOrFail($id);
        $pdf = Pdf::loadView('petugas.pembelian.pdf', compact('pembelian'))->setPaper('A5', 'portrait');
        return $pdf->stream('struk-pembelian-' . $pembelian->invoice_number . '.pdf');
    }

    public function downloadPdf($id)
    {
        $pembelian = Penjualan::with(['detailPenjualan.produk', 'user', 'members'])->findOrFail($id);
        $pdf = Pdf::loadView('petugas.pembelian.pdf', compact('pembelian'))->setPaper('A5', 'portrait');
        return $pdf->download('struk-pembelian-' . $pembelian->invoice_number . '.pdf');
    }

    public function detail(Request $request)
    {
        $dataProduk = $request->input('produk'); // ini bentuknya array
        $daftarProduk = [];
        $totalKeseluruhan = 0;


        foreach ($dataProduk as $id => $detail) {
            if (isset($detail['pilih']) && $detail['pilih'] > 0) {
                $produk = Produk::findOrFail($id);
                $jumlah = intval($detail['jumlah'] ?? 1);
                $subtotal = $produk->price * $jumlah;

                $daftarProduk[] = [
                    'id' => $produk->id,
                    'title' => $produk->title,
                    'price' => $produk->price,
                    'jumlah' => $jumlah,
                    'subtotal' => $subtotal,
                ];
                $jumlah = $request->jumlah;
                $total = $produk->price * $jumlah;

                $totalKeseluruhan += $subtotal;
            }
        }


        return view('petugas.pembelian.detail', [
            'daftarProduk' => $daftarProduk,
            'totalKeseluruhan' => $totalKeseluruhan,
        ]);
    }


    public function struk($id)
    {
        $penjualan = Penjualan::with(['detailPenjualan.produk', 'user', 'members'])->findOrFail($id);
        return view('petugas.pembelian.struk', compact('penjualan'));
    }

    public function member(Request $request)
    {
        $produk = Produk::find($request->produk_id);
        if (!$produk) {
            return back()->with('error', 'Produk tidak ditemukan.');
        }

        if ($produk->stock < $request->jumlah) {
            return back()->with('error', 'Stok produk tidak mencukupi.');
        }

        $produkAll = [];
        foreach ($request->produk as $item) {
            $produkGet = Produk::findOrFail($item['id']);
            $produkItem = [
                'nama_produk'  => $produkGet->title,
                'qty'          => $item['jumlah'],
                'harga_produk' => $produkGet->price,
                'sub_total'    => $produkGet->price * $item['jumlah']
            ];
            array_push($produkAll,$produkItem);
        }
        session(
            [
                # code...
                'selected_products' => 
                $produkAll
                ,
                'total_payment' => $request->total_payment
            ]
        );   
        $customerPhone = $request->input('customer_phone');
        $member = Member::where('nomor_telepon', $customerPhone)->first();

        $point = $member ? $member->points : 0;

        return view('petugas.pembelian.member', [
            'selectedProducts' => session('selected_products'),
            'total_payment' => session('total_payment'),
            'member' => $member,
            'point' => $point
        ]);
    }
}
