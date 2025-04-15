<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Pembelian</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background-color: #f8f9fa;">
    <div class="px-4 py-4" style="max-width: 900px; margin: 0 auto;">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-3">
                <li class="breadcrumb-item">Pembelian</li>
                <li class="breadcrumb-item active" aria-current="page">Detail</li>
            </ol>
        </nav>

        <h2 class="fw-bold mb-4">Detail Pembelian</h2>

        <div class="bg-white shadow-sm rounded-4 p-4">
            <div class="d-flex justify-content-between mb-3">
                <div>
                    <strong>Invoice:</strong> #INV-0001 <br>
                    <strong>Tanggal:</strong> 15-04-2025 14:30<br>
                    <strong>Status Member:</strong> Member
                </div>
                <div class="text-end">
                    <strong>Petugas:</strong> Admin <br>
                    <strong>Nama Member:</strong> Rina Wati <br>
                    <strong>Telepon:</strong> 0821-1234-5678
                </div>
            </div>

            <h5 class="fw-bold mt-4 mb-3">Produk Dibeli</h5>
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>Nama Produk</th>
                        <th>Qty</th>
                        <th>Harga</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Sabun Cuci</td>
                        <td>2</td>
                        <td>Rp10.000</td>
                        <td>Rp20.000</td>
                    </tr>
                    <tr>
                        <td>Sikat Gigi</td>
                        <td>3</td>
                        <td>Rp5.000</td>
                        <td>Rp15.000</td>
                    </tr>
                </tbody>
            </table>

            <div class="row bg-light rounded-3 p-3 mt-4">
                <div class="col-md-4">
                    <div class="fw-semibold small text-muted">POIN DIGUNAKAN</div>
                    <div class="fw-bold">15</div>
                </div>
                <div class="col-md-4">
                    <div class="fw-semibold small text-muted">KASIR</div>
                    <div class="fw-bold">Admin</div>
                </div>
                <div class="col-md-4 text-end">
                    <div class="fw-semibold small text-muted">KEMBALIAN</div>
                    <div class="fw-bold">Rp5.000</div>
                </div>
            </div>

            <div class="d-flex justify-content-end mt-4">
                <div class="bg-dark text-white rounded-4 p-4 text-end" style="min-width: 200px;">
                    <div class="fw-semibold small">TOTAL</div>
                    <h4 class="fw-bold text-white">Rp35.000</h4>
                </div>
            </div>

            <div class="mt-4">
                <a href="#" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </div>
</body>
</html>
