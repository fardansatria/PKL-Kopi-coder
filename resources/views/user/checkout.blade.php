<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to bottom, #001355, #0029BB);
        }

        .checkout-container {
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.2);
            padding: 30px;
            margin-top: 50px;
            max-width: 1200px;
            margin: auto;
            box-shadow: 15px 15px 25px 4px rgba(0, 0, 0, 0.87);
            margin-top: 30px;
            margin-bottom: 30px;
        }

        .form-group label {
            font-weight: bold;
        }

        h2 {
            font-size: 28px;
            font-weight: bold;
            color: #333;
        }

        .order-summary {
            margin-top: 20px;
        }

        .btn {
            width: auto;
        }

        .btn-success {
            width: 50%;
            padding: 12px;
            font-size: 16px;
        }

        .btn-back {
            width: 50%;
            padding: 12px;
            font-size: 16px;
        }

        .table th,
        .table td {
            vertical-align: middle;
        }

        .form-control {
            background-color: #f9f9f9;
            border: 1px solid #ced4da;
            border-radius: 4px;
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #28a745;
        }

        .custom-input-row {
            display: flex;
            gap: 15px;
        }

        .custom-input-row .form-group {
            flex: 1;
        }

        /* Custom styling for date section */
        .input-date {
            display: flex;
            gap: 10px;
            align-items: center;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="checkout-container">
            <h2 class="mb-4 text-center">Delivery Information</h2>

            @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
            @endif
            <form action="{{ route('checkout.store', $product->id) }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" class="form-control" id="name" value="{{ old('name', $user->name ?? '') }}" required>
                </div>

                <div class="custom-input-row">
                    <div class="form-group">
                        <label for="phone">Number</label>
                        <input type="text" name="phone" class="form-control" id="phone" value="{{ old('phone', $profile->phone ?? '') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" class="form-control" id="email" value="{{ old('email', $user->email ?? '') }}" required>
                    </div>
                </div>

                <div class="custom-input-row">
                    <div class="form-group">
                        <label for="province">Provinsi</label>
                        <select id="province" name="province" class="form-control" required>
                            <option value="">Select State</option>
                            @foreach($provinces as $province)
                            <option value="{{ $province['province_id'] }}">{{ $province['province'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="city">Kota/Kabupaten:</label>
                        <select id="city" name="city_id" class="form-control" required>
                            <option value="">Pilih Kota/Kabupaten</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="addres">Alamat Lengkap</label>
                    <textarea name="addres" class="form-control" id="addres" rows="2" required>{{ old('addres', $profile->addres ?? '') }}</textarea>
                </div>

                <div class="form-group">
                    <label for="courier">Kurir:</label>
                    <select id="courier" name="courier" class="form-control" required>
                        <option value="jne">JNE</option>
                        <option value="pos">POS</option>
                        <option value="tiki">TIKI</option>
                    </select>
                </div>
                <input type="hidden" name="shipping_cost" id="shipping_cost" value="0">
                <h4 class="order-summary">Rincian Pesanan:</h4>
                <table class="table table-bordered">
                    <thead class="thead-light">
                        <tr>
                            <th>Produk</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $subtotal = 0; @endphp
                        @foreach($cartItems as $item)
                        @php $total = $item->product->price * $item->qty; @endphp
                        <tr>
                            <td>{{ Str::limit($item->product->title, 20) }}</td>
                            <td>Rp {{ number_format($item->product->price, 0, ',', '.') }}</td>
                            <td>{{ $item->qty }}</td>
                            <td>Rp {{ number_format($total, 0, ',', '.') }}</td>
                        </tr>
                        @php $subtotal += $total; @endphp
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="3" class="text-right">Subtotal</th>
                            <td>Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th colspan="3" class="text-right">Ongkos Kirim</th>
                            <td id="shipping-cost">Rp 0</td>
                        </tr>
                        <tr>
                            <th colspan="3" class="text-right">Total Biaya</th>
                            <td id="total-cost">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
                <div class="btn d-flex justify-content-end">
                    <a href="{{ '/dashboard' }}" class="btn btn-danger mt-4 btn-back">Back</a>
                    <button type="submit" class="btn btn-success mt-4">Bayar</button>
                </div>
            </form>
        </div>
    </div>
</body>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#province').on('change', function() {
            let provinceId = $(this).val();
            if (provinceId) {
                $.ajax({
                    url: "{{ url('get-cities') }}/" + provinceId,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $('#city').empty();
                        $('#city').append('<option value="">Select City</option>');
                        $.each(data, function(key, value) {
                            $('#city').append('<option value="' + value.city_id + '">' + value.city_name + '</option>');
                        });
                    }
                });
            } else {
                $('#city').empty();
            }
        });

        // Fungsi untuk menghapus format Rp dan tanda pemisah ribuan
        function cleanCurrency(input) {
            return parseInt(input.replace(/[^,\d]/g, '')); // Hapus simbol non-numerik
        }

        // Fungsi untuk memformat angka kembali menjadi Rupiah
        function formatCurrency(amount) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(amount);
        }

        // Ketika kota dipilih, kita hitung ongkos kirim
        $('#city').on('change', function() {
            let cityId = $(this).val();
            let totalWeight = "{{ $totalWeight }}";
            let subtotalText = $('#total-cost').text(); // Ambil teks subtotal
            let subtotal = cleanCurrency(subtotalText);

            if (cityId) {
                $.ajax({
                    url: "{{ url('get-shipping-cost') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        destination: cityId,
                        weight: totalWeight
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.success) {
                            let shippingCost = response.cost;

                            // Update tampilan biaya ongkos kirim dan total biaya
                            $('#shipping-cost').text(formatCurrency(shippingCost));
                            $('#shipping_cost').val(shippingCost); // Set nilai hidden input

                            let totalCost = subtotal + shippingCost;
                            $('#total-cost').text(formatCurrency(totalCost));
                        }
                    }
                });
            }
        });
    });
</script>

</html>