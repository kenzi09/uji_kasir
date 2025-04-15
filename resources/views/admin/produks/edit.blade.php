<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f7f7f7;
        }
        .card {
            background: #ffffff;
            border-radius: 15px;
            padding: 20px;
        }
        .form-control {
            border-radius: 10px;
        }
        .btn-primary {
            background-color: #4caf50;
            border-color: #4caf50;
        }
        .btn-primary:hover {
            background-color: #45a049;
        }
        .btn-warning {
            background-color: #ff9800;
            border-color: #ff9800;
        }
        .btn-warning:hover {
            background-color: #e68900;
        }
    </style>
</head>

<body>
    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded">
                    <div class="card-body">
                        <h3 class="text-center mb-4">Edit Produk</h3>
                        <form action="#" method="POST" enctype="multipart/form-data">
                            <div class="form-group mb-4">
                                <label class="font-weight-bold">Gambar Produk</label>
                                <input type="file" class="form-control" name="image">
                            </div>

                            <div class="form-group mb-4">
                                <label class="font-weight-bold">Judul Produk</label>
                                <input type="text" class="form-control" name="title" placeholder="Masukkan Judul Produk">
                            </div>

                            <div class="form-group mb-4">
                                <label class="font-weight-bold">Deskripsi Produk</label>
                                <textarea class="form-control" name="description" rows="5" placeholder="Masukkan Deskripsi Produk"></textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-4">
                                        <label class="font-weight-bold">Harga Produk</label>
                                        <input type="number" class="form-control" name="price" placeholder="Masukkan Harga Produk">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-4">
                                        <label class="font-weight-bold">Stok Produk</label>
                                        <input type="number" class="form-control" name="stock" placeholder="Masukkan Stok Produk">
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-center">
                                <button type="submit" class="btn btn-md btn-primary me-3 px-4">Perbarui</button>
                                <button type="reset" class="btn btn-md btn-warning px-4">Reset</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
