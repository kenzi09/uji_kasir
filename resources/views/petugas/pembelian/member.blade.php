@extends('layout.sidebar')

@section('content')
<div class="container py-4" style="margin-left: 130px;">
    <h3 class="fw-bold mb-4">Penjualan</h3>

    <div class="mx-auto" style="max-width: 900px;">
        <div class="bg-white rounded-4 shadow-sm p-4">
            <div class="row align-items-stretch">
                <div class="col-md-6 mb-4 mb-md-0 d-flex flex-column justify-content-between"
                     style="background-color: #f8f9fa; border: 1px solid #ddd; border-radius: 10px;">
                    <div>
                        <h5 class="fw-bold mb-3">Ringkasan Produk</h5>
                        <table class="table table-bordered mb-3">
                            <thead class="table-light">
                                <tr>
                                    <th>Nama Produk</th>
                                    <th>QTY</th>
                                    <th>Harga</th>
                                    <th>Sub Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Contoh Produk</td>
                                    <td class="text-center">2</td>
                                    <td class="text-end">Rp 15.000</td>
                                    <td class="text-end">Rp 30.000</td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="text-end">
                            <p class="mb-1"><strong>Total Harga:</strong> Rp 30.000</p>
                            <p class="mb-0"><strong>Total Bayar:</strong> Rp <span id="total_bayar_display">30.000</span></p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <form action="/petugas/pembelian/storeStep2" method="POST">
                        <input type="hidden" name="_token" value="...">
                        <input type="hidden" name="total_payment" id="total_payment_input" value="30000">
                        <!-- Tambahkan field lain sesuai kebutuhan -->
                        <button type="submit" class="btn btn-success w-100 mt-4">Konfirmasi Pembayaran</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
