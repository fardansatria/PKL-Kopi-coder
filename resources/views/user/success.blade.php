<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout Berhasil</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5 text-center">
        <h2>Terima Kasih!</h2>
        <p>Pesanan Anda telah berhasil diproses.</p>

        @if(session('bankDetails'))
        <h3>Silahkan Transfer Ke Rekening Berikut</h3>
        <p>Bank : {{ session('bankDetails')['bank_name'] }}</p>
        <p>Nomor Rekening : {{ session('bankDetails')['bank_number'] }}</p>
        <p>Nama Pemilik Rekening : {{ session('bankDetails')['bank_username'] }}</p>
        @endif

        <a href="{{ url('/dashboard') }}" class="btn btn-primary">Kembali ke Beranda</a>
    </div>

</body>

</html>