<style>
    table.table {
        width: 100%;
        text-align: left;
    }

    table.table img {
        margin-right: 20px;
    }

    .table th,
    .table td {
        vertical-align: middle;
    }

    .form-control {
        max-width: 80px;
    }

    .text-muted {
        color: #ff7e00;
    }

    .table-striped tbody tr:nth-of-type(odd) {
        background-color: #f9f9f9;
    }

    .btn-success {
        background-color: #000;
        border-color: #000;
    }

    .btn-success:hover {
        background-color: #444;
    }
</style>

@include('user.header-test')

<div class="container mt-5">
    <div class="container">
        <div class="cart-section">
            <?php $value = 0; ?>
            @if($cart->isEmpty())
            <div class="empty-cart">
                <p>Keranjang belanja Anda kosong.</p>
            </div>
            @else
            <h2>Your Cart ({{ $cart->count() }} items)</h2>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Action</th> <!-- Tambahkan kolom untuk aksi -->
                    </tr>
                </thead>
                <tbody>
                    @foreach($cart as $cartItem)
                    <tr>
                        <td>
                            <img src="{{ asset('storage/products/' . $cartItem->product->image) }}" alt="{{ $cartItem->product->title }}" style="width: 100px;">
                            <strong>{{ Str::limit($cartItem->product->title, 15) }}</strong>
                        </td>
                        <td>Rp{{ number_format($cartItem->product->price, 2, ',', '.') }}</td>
                        <td>
                            <input type="number" name="quantity" value="{{ $cartItem->qty }}" min="1" class="form-control w-1 d-inline">
                        </td>
                        <td>Rp{{ number_format($cartItem->product->price * $cartItem->qty, 2, ',', '.') }}</td>
                        <td>
                            <form action="{{ url('cart_delete', $cartItem->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                            <a class="btn btn-primary" href="{{ route('checkout.fromProduct', $cartItem->product_id) }}">Bayar</a> <!-- Aksi Bayar -->
                        </td>
                    </tr>
                    <?php $value += $cartItem->product->price * $cartItem->qty; ?>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>
    </div>
    
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
</div>
