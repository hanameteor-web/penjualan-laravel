<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Penjualan</title>
    <style>
        body {
            font-family: "Poppins", sans-serif;
            background: linear-gradient(to bottom right, #ffe6f2, #e6f3ff);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            animation: fadeInBody 0.8s ease;
        }

        h1 {
            color: #ff66a3;
            font-weight: 700;
            font-size: 26px;
            margin-bottom: 20px;
            animation: fadeIn 1s ease forwards;
        }

        form {
            background: #ffffff;
            padding: 25px 30px;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            width: 340px;
            display: flex;
            flex-direction: column;
            gap: 12px;
            opacity: 0;
            animation: formSlideUp 0.9s ease forwards;
            animation-delay: 0.3s;
        }

        label {
            font-weight: 500;
            color: #333;
        }

        input[type="text"],
        input[type="number"] {
            padding: 8px 10px;
            border-radius: 8px;
            border: 1px solid #ccc;
            outline: none;
            transition: 0.3s;
        }

        input:focus {
            border-color: #ff66a3;
            box-shadow: 0 0 6px #ffb3d9;
        }

        button {
            background-color: #3399ff;
            color: white;
            border: none;
            padding: 10px 16px;
            border-radius: 8px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 0 3px 6px rgba(0,0,0,0.1);
        }

        /* ✨ Efek hover dan klik lembut */
        button:hover {
            background-color: #007acc;
            transform: translateY(-2px);
            box-shadow: 0 5px 10px rgba(0,0,0,0.15);
        }

        button:active {
            transform: scale(0.96);
            background-color: #006bb3;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }

        a {
            display: inline-block;
            text-decoration: none;
            color: #555;
            margin-top: 12px;
            font-size: 14px;
            transition: 0.3s;
        }

        a:hover {
            color: #ff66a3;
        }

        /* 🌿 ALERT sukses & error */
        .alert {
            padding: 12px 20px;
            border-radius: 8px;
            margin-bottom: 15px;
            font-weight: 500;
            text-align: center;
            opacity: 0;
            transform: translateY(-10px);
            transition: all 0.6s ease;
            width: 70%;
            animation: fadeIn 0.8s ease forwards;
        }

        .alert.success {
            background-color: #d4edda; /* hijau lembut */
            color: #155724;
            border: 1px solid #c3e6cb;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .alert.error {
            background-color: #ffe6e6;
            color: #a33a3a;
            border: 1px solid #f5b5b5;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .alert.show {
            opacity: 1;
            transform: translateY(0);
        }

        /* 🌸 Animasi fade-in & slide */
        @keyframes fadeIn {
            0% { opacity: 0; transform: translateY(20px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        @keyframes formSlideUp {
            0% { opacity: 0; transform: translateY(30px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeInBody {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }
    </style>
</head>
<body>
    @if (session('success'))
        <div class="alert success show">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert error show">
            {{ session('error') }}
        </div>
    @endif

    <h1>📝 Edit Data Penjualan</h1>

    <form action="{{ route('penjualan.update', $penjualan->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label>Nama Produk</label>
        <input type="text" name="nama_produk" value="{{ $penjualan->nama_produk }}" required>

        <label>Jumlah</label>
        <input type="number" name="jumlah" value="{{ $penjualan->jumlah }}" required>

        <label>Harga</label>
        <input type="number" name="harga" value="{{ $penjualan->harga }}" required>

        <button type="submit">💾 Simpan Perubahan</button>
    </form>

    <a href="{{ route('penjualan.index') }}">⬅️ Kembali ke Daftar Penjualan</a>
</body>
</html>
