<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Penjualan</title>
    <style>
        body {
            font-family: "Poppins", sans-serif;
            background: linear-gradient(to bottom right, #ffe6f2, #e6f3ff);
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-top: 40px;
            min-height: 100vh;
            margin: 0;
        }
        h1 { color: #ff66a3; font-weight: 700; font-size: 28px; animation: fadeIn 1s ease forwards; }
        form { margin-bottom: 25px; display: flex; gap: 10px; }
        input[type="text"], input[type="number"] {
            padding: 8px 10px; border-radius: 8px; border: 1px solid #ccc; width: 150px; transition: 0.3s;
        }
        input:focus { border-color: #ff66a3; box-shadow: 0 0 5px #ffb3d9; }
        button, .btn-edit, .btn-hapus, .btn-detail {
            border: none; border-radius: 6px; padding: 6px 14px; color: white; font-weight: 500; cursor: pointer; transition: 0.3s;
        }
        button { background-color: #3399ff; }
        button:hover { background-color: #007acc; transform: translateY(-2px); }
        .btn-edit { background-color: #ffcc00; color: #333; }
        .btn-edit:hover { background-color: #ffdb4d; transform: scale(1.05); }
        .btn-hapus { background-color: #ff4d4d; }
        .btn-hapus:hover { background-color: #ff1a1a; transform: scale(1.05); }
        .btn-detail { background-color: #33cc99; }
        .btn-detail:hover { background-color: #00b377; transform: scale(1.05); }
        table {
            border-collapse: collapse; width: 75%; background: white; border-radius: 12px;
            overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        th, td { padding: 10px 12px; text-align: center; }
        th { background-color: #ffb3d9; color: #333; }
        tr:nth-child(even) { background-color: #fff5fa; }
        tr:hover { background-color: #ffe6f2; transform: scale(1.01); }
        .alert {
            background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; padding: 10px 15px;
            border-radius: 8px; margin-bottom: 15px; text-align: center; width: 70%; display: none;
        }
        .modal {
            display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.4); justify-content: center; align-items: center;
        }
        .modal-content {
            background: white; padding: 20px; border-radius: 12px; width: 300px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.2); text-align: center;
        }
        .close { float: right; font-size: 18px; cursor: pointer; color: #ff4d4d; }
    </style>
</head>
<body>
    <h1>📦 Daftar Penjualan</h1>

    <div id="alertBox" class="alert"></div>

    <form id="formTambah">
        @csrf
        <input type="text" id="nama_produk" name="nama_produk" placeholder="Nama Produk" required>
        <input type="number" id="jumlah" name="jumlah" placeholder="Jumlah" required>
        <input type="text" id="harga" name="harga" placeholder="Harga" required>
        <button type="submit">Tambah</button>
    </form>

    <div style="margin-bottom: 10px;">
        <input type="text" id="search" placeholder="🔍 Cari produk..." 
               style="padding: 8px; width: 250px; border-radius: 8px; border: 1px solid #ccc;">
    </div>

    <table id="data-penjualan">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th>Jumlah</th>
                <th>Harga</th>
                <th>📅 Tanggal Penjualan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($penjualan as $p)
            <tr data-id="{{ $p->id }}">
                <td>{{ $loop->iteration }}</td>
                <td class="nama_produk">{{ $p->nama_produk }}</td>
                <td class="jumlah">{{ $p->jumlah }}</td>
                <td class="harga">{{ number_format($p->harga, 2, ',', '.') }}</td>
                <td class="tanggal_penjualan">{{ \Carbon\Carbon::parse($p->tanggal_penjualan)->format('d-m-Y') }}</td>
                <td>
                    <button class="btn-detail" data-id="{{ $p->id }}">Detail</button>
                    <button class="btn-edit" data-id="{{ $p->id }}">Edit</button>
                    <button class="btn-hapus" data-id="{{ $p->id }}">Hapus</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Modal Detail -->
    <div class="modal" id="modalDetail">
        <div class="modal-content">
            <span class="close" id="closeDetail">&times;</span>
            <h3>Detail Penjualan</h3>
            <p><strong>Nama Produk:</strong> <span id="detail_nama"></span></p>
            <p><strong>Jumlah:</strong> <span id="detail_jumlah"></span></p>
            <p><strong>Harga:</strong> <span id="detail_harga"></span></p>
            <p><strong>Tanggal:</strong> <span id="detail_tanggal"></span></p> <!-- ✅ tambahkan tanggal -->
        </div>
    </div>

    <!-- Modal Edit -->
    <div class="modal" id="modalEdit">
        <div class="modal-content">
            <span class="close" id="closeModal">&times;</span>
            <h3>Edit Data</h3>
            <form id="formEdit">
                @csrf
                <input type="hidden" id="edit_id">
                <input type="text" id="edit_nama_produk" placeholder="Nama Produk" required><br><br>
                <input type="number" id="edit_jumlah" placeholder="Jumlah" required><br><br>
                <input type="text" id="edit_harga" placeholder="Harga" required>
                <button type="submit">Simpan</button>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(function() {

        function showAlert(message) {
            $('#alertBox').text(message).fadeIn().delay(2000).fadeOut();
        }

        // ✅ Tambah Data
        $('#formTambah').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: '{{ route("penjualan.store") }}',
                method: 'POST',
                data: $(this).serialize(),
                success: function(p) {
                    let no = $('#data-penjualan tbody tr').length + 1;
                    $('#data-penjualan tbody').append(`
                        <tr data-id="${p.id}">
                            <td>${no}</td>
                            <td class="nama_produk">${p.nama_produk}</td>
                            <td class="jumlah">${p.jumlah}</td>
                            <td class="harga">${parseFloat(p.harga).toLocaleString('id-ID',{style:'currency',currency:'IDR'})}</td>
                            <td class="tanggal_penjualan">${new Date().toLocaleDateString('id-ID')}</td>
                            <td>
                                <button class="btn-detail" data-id="${p.id}">Detail</button>
                                <button class="btn-edit" data-id="${p.id}">Edit</button>
                                <button class="btn-hapus" data-id="${p.id}">Hapus</button>
                            </td>
                        </tr>
                    `);
                    $('#formTambah')[0].reset();
                    showAlert('✅ Data berhasil ditambahkan!');
                }
            });
        });

        // 🔍 Search
        $('#search').on('keyup', function() {
            let keyword = $(this).val().toLowerCase();
            $("#data-penjualan tbody tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(keyword) > -1);
            });
        });

        // 🗑️ Hapus
        $(document).on('click', '.btn-hapus', function() {
            let id = $(this).data('id');
            if(confirm('Yakin hapus data ini?')) {
                $.ajax({
                    url: `/penjualan/${id}`,
                    method: 'DELETE',
                    data: {_token:'{{ csrf_token() }}'},
                    success: function() {
                        $(`tr[data-id="${id}"]`).fadeOut(400, function(){ $(this).remove(); });
                        showAlert('🗑️ Data berhasil dihapus!');
                    }
                });
            }
        });

        // 👁️ Detail
        $(document).on('click', '.btn-detail', function(){
            $.get(`/penjualan/${$(this).data('id')}`, function(p){
                $('#detail_nama').text(p.nama_produk);
                $('#detail_jumlah').text(p.jumlah);
                $('#detail_harga').text(parseFloat(p.harga).toLocaleString('id-ID',{style:'currency',currency:'IDR'}));
                $('#detail_tanggal').text(new Date(p.tanggal_penjualan).toLocaleDateString('id-ID'));
                $('#modalDetail').fadeIn();
            });
        });

        $('#closeDetail').click(()=>$('#modalDetail').fadeOut());
    // 💰 Format Rupiah otomatis saat mengetik di input harga
function formatRupiah(angka, prefix){
    let number_string = angka.replace(/[^,\d]/g, '').toString(),
        split   	 = number_string.split(','),
        sisa     	 = split[0].length % 3,
        rupiah     	 = split[0].substr(0, sisa),
        ribuan     	 = split[0].substr(sisa).match(/\d{3}/gi);

    if(ribuan){
        let separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }

    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
    return prefix == undefined ? rupiah : (rupiah ? 'Rp' + rupiah : '');
}

// ✨ Event untuk input harga di form tambah
$('#harga').on('keyup', function() {
    $(this).val(formatRupiah(this.value, 'Rp'));
});

// ✨ Event untuk input harga di form edit
$('#edit_harga').on('keyup', function() {
    $(this).val(formatRupiah(this.value, 'Rp'));
});

// ⚠️ Saat dikirim ke server, hapus huruf "Rp" dan titik
$('#formTambah, #formEdit').on('submit', function() {
    $(this).find('input[name="harga"], #edit_harga').each(function() {
        this.value = this.value.replace(/[^0-9]/g, '');
    });
});

    });
    </script>
</body>
</html>

