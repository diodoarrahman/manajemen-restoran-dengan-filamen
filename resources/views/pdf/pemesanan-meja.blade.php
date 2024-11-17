<!-- resources/views/pdf/pemesanan-meja.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pemesanan Meja</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Pemesanan Meja #{{ $record->id }}</h2>

    <p><strong>Nomor Meja:</strong> {{ $record->meja->nomor_meja }}</p>
    <p><strong>Kapasitas Meja:</strong> {{ $record->meja->kapasitas }}</p>
    <p><strong>Status:</strong> {{ $record->status }}</p>
    <p><strong>Total Harga:</strong> Rp {{ number_format($record->total_harga, 0, ',', '.') }}</p>

    <h3>Detail Menu yang Dipesan</h3>
    <table>
        <thead>
            <tr>
                <th>Nama Menu</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($record->pemesananMenu as $menu)
                <tr>
                    <td>{{ $menu->menu->nama_menu }}</td>
                    <td>Rp {{ number_format($menu->harga, 0, ',', '.') }}</td>
                    <td>{{ $menu->jumlah }}</td>
                    <td>Rp {{ number_format($menu->harga * $menu->jumlah, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p><strong>Grand Total:</strong> Rp {{ number_format($record->total_harga, 0, ',', '.') }}</p>
</body>
</html>
