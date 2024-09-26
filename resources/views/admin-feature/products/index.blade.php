<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Dashboard - NiceAdmin Bootstrap Template</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- link font awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">


    <!-- Favicons -->
    <link href="admin/assets/img/favicon.png" rel="icon">
    <link href="admin/assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="admin/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="admin/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="admin/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="admin/assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="admin/assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="admin/assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="admin/assets/vendor/simple-datatables/style.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="admin/assets/css/style.css" rel="stylesheet">

    <style>
        .action-buttons {
            display: flex;
            gap: 2px;
            justify-content: center;
        }

        .btn {
            padding: 8px 16px;
            font-size: 16px;
        }

        .btn-secondary i {
            margin-right: 4px;
        }

        .pagination-btn {
            padding: 6px 12px;
            /* Mengatur padding lebih kecil */
            font-size: 14px;
            /* Menyesuaikan ukuran font */
        }

        .btn {
            transition: background-color 0.3s, color 0.3s;
        }

        .btn:hover {
            background-color: #0056b3;
            color: white;
        }
    </style>
</head>

<body>

    <x-header-admin></x-header-admin>
    <x-sidebar-admin></x-sidebar-admin>

    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Produk</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/index">Home</a></li>
                    <li class="breadcrumb-item active">Produk</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section dashboard">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <a href="{{ route('products.create') }}" class="btn btn-md btn-success mb-3">ADD PRODUCT</a>
                            <table class="table table-bordered">
                                <!-- filter merek -->
                                <form method="GET" action="{{ route('products.index') }}" class="mb-3">
                                    <div class="form-row align-items-end">
                                        <div class="col-auto">
                                            <label for="merek_id" class="sr-only">Pilih Merek</label>
                                            <select name="merek_id" id="merek_id" class="form-control" onchange="this.form.submit()">
                                                <option value="">Semua Merek</option>
                                                @foreach ($mereks as $merek)
                                                <option value="{{ $merek->id }}" {{ request('merek_id') == $merek->id ? 'selected' : '' }}>
                                                    {{ $merek->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>    
                                    </div>
                                </form>
                                <!-- end filter merek -->

                                <!-- table produk -->
                                <thead>
                                    <tr>
                                        <th scope="col">IMAGE</th>
                                        <th scope="col">TITLE</th>
                                        <th scope="col">PRICE</th>
                                        <th scope="col">STOCK</th>
                                        <th scope="col">MEREK</th>
                                        <th scope="col" style="width: 20%">ACTIONS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($products as $product)
                                    <tr>
                                        <td class="text-center">
                                            <img src="{{ asset('/storage/products/'.$product->image) }}" class="img-fluid rounded" style="max-width: 150px">
                                        </td>
                                        <td>{{ $product->title }}</td>
                                        <td>{{ "Rp " . number_format($product->price, 0, ',', '.') }}</td>
                                        <td>{{ $product->stock }}</td>
                                        <td>{{ optional($product->merek)->name }}</td>
                                        <td class="text-center">
                                            <div class="action-buttons">
                                                <!-- ikon show -->
                                                <a href="{{ route('products.show', $product->id) }}" class="btn btn-sm btn-dark" title="Lihat Produk">
                                                    <i class="fa fa-eye"></i>
                                                </a>

                                                <!-- ikon edit -->
                                                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-primary" title="Edit Produk">
                                                    <i class="fa fa-pencil-alt"></i>
                                                </a>

                                                <!-- ikon hapus -->
                                                <form onsubmit="return confirm('Apakah Anda Yakin Untuk menghapus produk ini?');" action="{{ route('products.destroy', $product->id) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" title="Hapus Produk" style="cursor: pointer;">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>

                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center">
                                            <div class="alert alert-danger">
                                                Data Products belum Tersedia.
                                            </div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                                <!-- end table produk -->
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-center mt-3">
                @if ($products->onFirstPage())
                <span class="btn btn-secondary pagination-btn disabled">
                    <i class="fa fa-arrow-left"></i> Previous
                </span>
                @else
                <a href="{{ $products->previousPageUrl() }}" class="btn btn-secondary pagination-btn">
                    <i class="fa fa-arrow-left"></i> Previous
                </a>
                @endif

                <span class="mx-3 my-auto">Page {{ $products->currentPage() }} of {{ $products->lastPage() }}</span>

                @if ($products->hasMorePages())
                <a href="{{ $products->nextPageUrl() }}" class="btn btn-secondary pagination-btn">
                    Next <i class="fa fa-arrow-right"></i>
                </a>
                @else
                <span class="btn btn-secondary pagination-btn disabled">
                    Next <i class="fa fa-arrow-right"></i>
                </span>
                @endif
            </div>


        </section>
    </main>

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="admin/assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="admin/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="admin/assets/vendor/chart.js/chart.umd.js"></script>
    <script src="admin/assets/vendor/echarts/echarts.min.js"></script>
    <script src="admin/assets/vendor/quill/quill.js"></script>
    <script src="admin/assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="admin/assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="admin/assets/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="admin/assets/js/main.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Message with Sweetalert
        @if(session('success'))
        Swal.fire({
            icon: "success",
            title: "BERHASIL",
            text: "{{ session('success') }}",
            showConfirmButton: false,
            timer: 2000
        });
        @elseif(session('error'))
        Swal.fire({
            icon: "error",
            title: "GAGAL!",
            text: "{{ session('error') }}",
            showConfirmButton: false,
            timer: 2000
        });
        @endif
    </script>

</body>

</html>