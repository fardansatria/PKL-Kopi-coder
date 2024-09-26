<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Management</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    <style>
    </style>
</head>

<body>
    @include('user.header-test')
    <section class="section dashboard mt-4" >
        <div class="container">
            <form action="{{ route('user.order') }}" method="GET" class="mb-4">
                <div class="row">
                    <div class="col-md-3">
                        <select name="status" id="status" class="form-control">
                            <option value="">Semua</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Shipped</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="canceled" {{ request('status') == 'canceled' ? 'selected' : '' }}>Canceled</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary">Filter</button>
                    </div>
                </div>
            </form>

            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr class="text-center">
                                <th>ID Pesanan</th>
                                <th>Gambar Produk</th>
                                <th>Nama Produk</th>
                                <th>Kuantitas</th>
                                <th>Status Pengiriman</th>
                                <th>Total</th>
                                <th>Aksi</th>
                                <th>Batalkan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($orders as $order)
                            <tr class="text-center align-middle">
                                <td>{{ $order->id }}</td>
                                <td class="d-flex flex-column align-items-center">
                                    @foreach ($order->items as $item)
                                    <img src="{{ asset('storage/products/' . $item->product->image) }}" class="img-fluid" style="width: 60px; height: 60px;">
                                    @endforeach
                                </td>
                                <td>
                                    @foreach ($order->items as $item)
                                    <div>{{ $item->product->title }}</div>
                                    @endforeach
                                </td>
                                <td>
                                    @foreach ($order->items as $item)
                                    {{ $item->qty }}
                                    @endforeach
                                </td>
                                <td>{{ ucfirst($order->status) }}</td>
                                <td>Rp{{ number_format($order->total, 0, ',', '.') }}</td>
                                <td>
                                    <div class="d-grid gap-2">
                                        <a href="{{ route('order.show', $order->id) }}" class="btn btn-sm btn-primary">Tampilkan</a>
                                        @if ($order->status != 'canceled')
                                        <button type="button" class="btn btn-sm btn-success pay-button" data-snap-token="{{ $order->snap_token }}">Bayar</button>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    @if ($order->status == 'pending')
                                    <button type="button" class="btn btn-sm btn-danger cancel-button" data-order-id="{{ $order->id }}" data-url="{{ route('order.cancel', $order->id) }}">Batalkan</button>
                                    @else
                                    <span class="text-muted">Tidak dapat dibatalkan</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center">Tidak ada pesanan.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal for cancellation reason -->
    <div class="modal fade" id="cancelModal" tabindex="-1" aria-labelledby="cancelModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cancelModalLabel">Alasan Pembatalan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="cancelModalForm" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="modal-body">
                        <label for="cancel_product">Pilih Alasan:</label>
                        <select name="cancel_product" id="cancel_product" class="form-control" required>
                            <option value="">Pilih Alasan</option>
                            <option value="Tidak membutuhkan produk">Tidak membutuhkan produk</option>
                            <option value="Produk tidak sesuai deskripsi">Produk tidak sesuai deskripsi</option>
                            <option value="Harga terlalu mahal">Harga terlalu mahal</option>
                            <option value="Menemukan harga lebih murah di tempat lain">Menemukan harga lebih murah di tempat lain</option>
                            <option value="Alasan lainnya">Alasan lainnya</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-danger">Konfirmasi Pembatalan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Midtrans JS -->
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>

    <!-- Payment and Cancellation Scripts -->
    <script type="text/javascript">
        document.querySelectorAll('.pay-button').forEach(button => {
            button.addEventListener('click', function() {
                let snapToken = this.getAttribute('data-snap-token');
                if (snapToken) {
                    snap.pay(snapToken, {
                        onSuccess: function(result) {
                            console.log(result);
                        },
                        onPending: function(result) {
                            console.log(result);
                        },
                        onError: function(result) {
                            console.log(result);
                        }
                    });
                }
            });
        });

        document.querySelectorAll('.cancel-button').forEach(button => {
            button.addEventListener('click', function() {
                let formAction = this.getAttribute('data-url');
                document.getElementById('cancelModalForm').setAttribute('action', formAction);
                new bootstrap.Modal(document.getElementById('cancelModal')).show();
            });
        });
    </script>
</body>

</html>
