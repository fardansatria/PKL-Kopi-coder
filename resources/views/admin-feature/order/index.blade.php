<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Dashboard - NiceAdmin Bootstrap Template</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="admin/assets/img/favicon.png" rel="icon">
    <link href="admin/assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

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
        .button-group {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(120px, 1fr)); /* Menyesuaikan jumlah tombol per baris */
        gap: 10px; /* Jarak antar tombol */
    }
    </style>
</head>

<body>

    <x-header-admin></x-header-admin>

    <x-sidebar-admin></x-sidebar-admin>

    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Order</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/index">Home</a></li>
                    <li class="breadcrumb-item active">Order</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section dashboard">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">

                            <table class="table table-bordered">
                                <thead>
                                    <tr class="text-center">
                                        <th scope="col">Order ID</th>
                                        <th scope="col">User Name</th>
                                        <th scope="col">Product image</th>
                                        <th scope="col">nama product</th>
                                        <th scope="col">quantity</th>
                                        <th scope="col">Nomor HP</th>
                                        <th scope="col">Alamat</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Total</th>
                                        <th scope="col">Metode Pembayaran</th>
                                        <th scope="col" style="width: 20%">ACTIONS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($orders as $order)
                                    <tr class="text-center">
                                        <td>{{ $order->id }}</td>
                                        <td>{{ $order->user->name }}</td>
                                        <td>
                                            @foreach ($order->items as $item)
                                            <div>
                                                <img src="{{ asset('storage/products/' . $item->product->image) }}" style="width: 50px; height: 50px;">
                                            </div>
                                        <td>{{$item->product->title}}</td>
                                        <td>{{$item->qty}}</td>
                                        @endforeach
                                        </td>
                                        <td>{{ $order->phone }}</td>
                                        <td>{{ $order->addres }}</td>
                                        <td>{{ $order->status }}</td>
                                        <td>{{ number_format( $order->total, 0, ',', '.' ) }}</td>
                                        <td>{{ $order->payment_method }}</td>
                                        <td>
                                            <form id="status-form-{{ $order->id }}" action="{{ route('order.statusUpdate', $order->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" id="status-input-{{ $order->id }}">
                                            </form>
                                            <div class="button-group">
                                                <button type="button" class="btn btn-warning btn-sm" onclick="confirmUpdateStatus('{{ $order->id }}', 'shipped')">shipped</button>
                                                <button type="button" class="btn btn-success btn-sm" onclick="confirmUpdateStatus('{{ $order->id }}', 'completed')">completed</button>
                                                <a href="{{route('order.show', $order->id)}}" class="btn btn-primary">Show</a>
                                            </div>

                                        </td>
                                    </tr>

                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center">Belum Ada Order</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
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
        function confirmUpdateStatus(orderId, status) {
            swal.fire({
                title: 'apakah kamu yakin?',
                text: 'kamu akan mengubah status menjadi ' + status + '.',
                icon: 'warning',
                showCancelButton: true,
                confirmButton: '#3085d6',
                cancelButton: '#d33',
                confirmButtonText: 'YA',
                cancelButtonText: 'Tidak',
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('status-input-' + orderId).value = status
                    document.getElementById('status-form-' + orderId).submit()
                }
            })
        }

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