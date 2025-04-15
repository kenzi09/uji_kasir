<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Struk Pembelian</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { padding: 8px; border: 1px solid #ccc; text-align: left; }
        th { background-color: #f2f2f2; }
        .text-end { text-align: right; }
        .mt-3 { margin-top: 1rem; }
        .mt-5 { margin-top: 2rem; }
    </style>
</head>
<body>
    <h3>Indo April</h3>
    <p>Member Status: Member</p>
    <p>No. HP: 08123456789</p>
    <p>Bergabung Sejak: 2022-01-10</p>
    <p>Poin Member: 120</p>

    <table>
        <thead>
            <tr>
                <th>Nama Produk</th>
                <th>QTY</th>
                <th>Harga</th>
                <th>Sub Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Minyak Goreng 1L</td>
                <td>2</td>
                <td>Rp. 15.000</td>
                <td>Rp. 30.000</td>
            </tr>
            <tr>
                <td>Beras 5kg</td>
                <td>1</td>
                <td>Rp. 65.000</td>
                <td>Rp. 65.000</td>
            </tr>
        </tbody>
    </table>

    <table class="mt-3">
        <tr>
            <td>Poin Digunakan</td>
            <td>:</td>
            <td>20</td>
            <td class="text-end"><strong>Total Harga</strong></td>
            <td class="text-end">Rp. 95.000</td>
        </tr>
        <tr>
            <td colspan="3"></td>
            <td class="text-end"><strong>Harga Setelah Poin</strong></td>
            <td class="text-end">Rp. 90.000</td>
        </tr>
        <tr>
            <td colspan="3"></td>
            <td class="text-end"><strong>Total Kembalian</strong></td>
            <td class="text-end">Rp. 10.000</td>
        </tr>
    </table>

    <p class="mt-5">2025-04-15 14:40 | Admin</p>
    <p><strong>Terima kasih atas pembelian Anda!</strong></p>
</body>
</html>
