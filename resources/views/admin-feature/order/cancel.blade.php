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
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: 10px;
        }
    </style>
</head>

<body>

    <x-header-admin></x-header-admin>
    <x-sidebar-admin></x-sidebar-admin>

    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Order Cancel</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/index">Home</a></li>
                    <li class="breadcrumb-item active">Order Cancel</li>
                </ol>
            </nav>
        </div>

        <section class="section dashboard">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            {{-- Form Filter --}}
                            <form action="{{ route('order.index') }}" method="GET">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="status">Status:</label>
                                        <select name="status" id="status" class="form-control">
                                            <option value="">All</option>
                                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                            <option value="canceled" {{ request('status') == 'canceled' ? 'selected' : '' }}>canceled</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 mt-4">
                                        <button type="submit" class="btn btn-primary mt-2">Filter</button>
                                    </div>
                                </div>
                            </form>

                            {{-- Tabel Order --}}
                            <table class="table table-bordered mt-4">
                                <thead>
                                    <tr class="text-center">
                                        <th scope="col">Order ID</th>
                                        <th scope="col">User Name</th>
                                        <th scope="col">Product Image</th>
                                        <th scope="col">Nama Product</th>
                                        <th scope="col">Quantity</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Tanggal</th>
                                        <th scope="col">Total</th>
                                        <th scope="col" style="width: 20%">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($cancelOrders as $order)
                                    <tr class="text-center">
                                        <td>{{ $order->id }}</td>
                                        <td>{{ $order->user->name }}</td>
                                        <td>
                                            @foreach ($order->items as $item)
                                            <div>
                                                <img src="{{ asset('storage/products/' . $item->product->image) }}" style="width: 50px; height: 50px;">
                                            </div>
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach ($order->items as $item)
                                            {{ $item->product->title }}<br>
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach ($order->items as $item)
                                            {{ $item->qty }}<br>
                                            @endforeach
                                        </td>
                                        <td>
                                        @if ($order->status == 'canceled' && $order->cancel_product)
                                            {{ $order->status }} - {{ $order->cancel_product }}
                                            @else
                                            {{ $order->status }}
                                            @endif
                                        </td>
                                        <td>{{ $order->updated_at->format('d-m-Y ') }}</td>
                                        <td>{{ number_format($order->total, 0, ',', '.') }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="11" class="text-center">Belum Ada Order</td>
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
            Swal.fire({
                title: 'Apakah kamu yakin?',
                text: 'Kamu akan mengubah status menjadi ' + status + '.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'YA',
                cancelButtonText: 'Tidak',
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('status-input-' + orderId).value = status;
                    document.getElementById('status-form-' + orderId).submit();
                }
            });
        }
    </script>
</body>

</html>