<!DOCTYPE html>
<html>
<head>
    <title>Pesanan Dibatalkan</title>
</head>
<body>
    <h1>Pesanan Anda Telah Dibatalkan</h1>
    <p>Halo {{ $order->user->name }},</p>
    <p>Pesanan Anda dengan ID: {{ $order->id }} telah berhasil dibatalkan.</p>
    <p>Terima kasih telah menggunakan layanan kami!</p>
</body>
</html>
