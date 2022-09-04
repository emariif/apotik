<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="row">
                    <div class="col-md-4 card card-danger">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-user-edit"></i>Data Customer</h3>
                        </div>
                        <hr style="border: 1px solid red;">
                        <form action="{{ route('penjualan.store') }}" method="POST" id="sample_form">
                            @csrf
                            <div class="form-group">
                                <label for="FormGroupExampleInput">Nama Pasien</label>
                                <input type="text" class="form-control" id="nama" name="nama"
                                    autocomplete="off" placeholder="Nama Lengkap">
                                <input type="text" class="form-control" name="id" id="id" hidden>
                            </div>
                            <div class="form-group">
                                <label for="inlineFormCustomSelect" class="mr-sm-2">Nomor Telp.</label>
                                <input type="text" class="form-control" autocomplete="off" maxlength="12"
                                    onkeypress="return number(event)" id="telp" name="telp"
                                    placeholder="No. Telp">
                            </div>
                            <div class="form-group">
                                <label for="FormGroupExampleInput">Alamat</label>
                                <textarea class="form-control" id="alamat" name="alamat" rows="5" cols="30" placeholder="Alamat Lengkap"></textarea>
                            </div>
                            <hr style="border: 1px solid red;">
                            <div class="col-12">
                                <div class="row">
                                    <div class="form-group col-6">
                                        <label for="FormGroupExampleInput">Nomor Resep</label>
                                        <input type="text" class="form-control" id="no_resep" name="no_resep"
                                            autocomplete="off" placeholder="Isi Jika Ada Resep">
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="FormGroupExampleInput">Pengirim</label>
                                        <input type="text" class="form-control" id="pengirim" name="pengirim"
                                            autocomplete="off" placeholder="Isi Jika Ada Pengirim">
                                    </div>
                                </div>
                            </div>
                            <hr style="border: 1px solid red;">
                    </div>
                    <div class="col-md-8 card card-danger">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-shopping-cart">&nbsp;</i>Data Pembelian</h3>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group col-3">
                                <label>Obat</label>
                                <select name="obat" id="obat"
                                    class="custom-select mr-sm-2 js-example-basic-single form-control">
                                    <option value="">Pilih ...</option>
                                    @foreach ($obat as $item)
                                        <option value="{{ $item->obat_id }}">{{ $item->obats->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-3">
                                <label>Stock Tersedia</label>
                                <input type="text" class="stock form-control" readonly name="stock" id="stock">
                            </div>
                            <div class="form-group col-3">
                                <label>No Kwitansi</label>
                                <input type="text" class="form-control" readonly name="nota" id="nota"
                                    value="{{ $nomer }}">
                            </div>
                            <div class="form-group col-3">
                                <label>Tanggal</label>
                                <input type="text" class="form-control" readonly name="tanggal" id="tggl"
                                    value="{{ $tanggals }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-3">
                                <label>Jumlah Pembelian</label>
                                <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                    <button type="button" class="btn btn-danger btn-sm">-</button>
                                    <input type="text" id="qty" name="qty" class="form-control-sm">
                                    <button type="button" class="btn btn-success btn-sm">+</button>
                                </div>
                            </div>
                            <div class="form-group col-3">
                                <label>Harga @satuan</label>
                                <input type="text" class="form-control" onkeypress="return number(event)"
                                    maxlength="3" name="harga" id="harga" disabled>
                            </div>
                            <div class="form-group col-3">
                                <label>Diskon</label>
                                <input type="text" class="form-control" onkeypress="return number(event)"
                                    maxlength="3" name=" diskon" id="diskon">
                            </div>
                            <div class="form-group col-3">
                                <label>Total Harga</label>
                                <input type="text" class="form-control" onkeypress="return number(event)"
                                    name="total" id="total" readonly>
                            </div>
                        </div>
                        <hr style="border: 2px solid red;">
                        <div>
                            <button type="submit" id="tambah" name="tambah" class="btn btn-success"><i
                                    class="far fa-save"></i> Simpan</button>
                            </form>
                            <button type="submit" id="buka" name="buka" class="btn btn-primary"><i
                                    class="fas fa-plus"></i> Tambah Obat</button>
                        </div>
                        <div>
                        </div>
                        <br><br>
                        <div class="card card-danger table-responsive">
                            <table class="table table-bordered table-striped table-sm" id="tabel">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama Obat</th>
                                        <th>QTY</th>
                                        <th>Harga</th>
                                        <th>Total Harga</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-3">

                            </div>
                            <div class="col-3">

                            </div>
                            <div class="col-3">

                            </div>
                            <div class="col-3">
                                {{-- <a href="{{ url('penjualan.cetak') }}">
                                    <button class="btn btn-success float-left"><i class="far fa-file-pdf"></i>&nbsp;
                                        Cetak Slip</button>
                                </a> --}}
                                <form action="{{ route('cetakNota') }}" method="get">
                                    @csrf
                                    <input type="text" aria-label="telp" autocomplete="off"
                                        onkeypress="return number(event)" maxlength="12" name="kwitansi" hidden
                                        id="kwitansi" class="form-control" value="{{ $nomer }}">

                                    <button id="cetak" name="cetak" class="btn btn-danger float-left"><i
                                            class="far fa-file-pdf"></i>&nbsp; Cetak Slip</button>
                                </form>
                                <button type="button" id="btn-bayar" name="btn-bayar" data-toggle="modal"
                                    id="btn-modal" data-target="#modal-secondary" class="btn btn-danger"><i
                                        class="fas fa-money-bill-wave"></i>Proses</button>
                                {{-- Midtrans --}}
                                {{-- <button type="button" id="btn-checkOut" name="btn-check" data-toggle="modal" id="btn-modal2" data-target="#modal" class="btn btn-warning"><i class="fas fa-money-bill-wave"></i>Checkout</button> --}}

                                <button class="transaksiBaru btn btn-warning" id="transaksiBaru">Transaksi
                                    Baru</button>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Kolom Kanan --}}
            </div>
        </div>
        {{-- <button type="button" class="btn btn-info" id="btn-tambah" data-toggle="modal"
                data-target="#modal-info">
                Tambah
            </button> --}}
        <div class="modal fade" id="modal-secondary">
            <div class="modal-dialog">
                <div class="modal-content bg-secondary">
                    <div class="modal-header">
                        <h4 class="modal-title">Transaksi Pembayaran</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('simpanPenjualan') }}" id="pembayaran" method="POST">
                            @csrf
                            <div>
                                FORM PEMBAYARAN
                                <hr style="border: 1px solid rgb(180, 1, 1);">
                                <div class="row">
                                    <div class="col-6">
                                        <label for="formGroupExampleInput2">Nota Penjualan</label>
                                        <input type="text" aria-label="telp" autocomplete="off"
                                            onkeypress="return number(event)" maxlength="12" name="nota" readonly
                                            id="no" class="form-control">
                                    </div>
                                    <div class="col-6">
                                        <label for="label-warning">Kasir {{ Auth::user()->name }}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inlineFormCustomSelect" class="mr-sm-2">Total Harga</label>
                                <input type="text" aria-label="total" autocomplete="off"
                                    onkeypress="return number(event)" maxlength="12" name="totalharga" readonly
                                    id="totalharga" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="formGroupExampleInput2">Diskon</label>
                                <input type="text" aria-label="diskon" autocomplete="off"
                                    onkeypress="return number(event)" maxlength="3" name="modalDiskon" readonly
                                    id="modalDiskon" class="form-control" value="0">
                            </div>
                            <div class="form-group">
                                <label for="inlineFormCustomSelect" class="mr-sm-2">Harga Yang Harus Dibayar</label>
                                <input type="text" aria-label="bayar" autocomplete="off"
                                    onkeypress="return number(event)" maxlength="10" name="yangHarus" readonly
                                    id="yangHarus" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="formGroupExampleInput2" class="mr-sm-2">Yang Dibayar</label>
                                <input type="text" autocomplete="off" name="yangDibayar" id="yangDibayar"
                                    class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="formGroupExampleInput2">Uang Kembalian</label>
                                <input type="text" aria-label="kembali" autocomplete="off"
                                    onkeypress="return number(event)" maxlength="12" name="modalPengembalian"
                                    readonly id="kembali" disabled class="form-control">
                            </div>
                            <button type="button" id="simpanBayar"
                                class="btn btn-outline-light btn-success btn-block">Bayar</button>
                        </form>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-outline-light" data-dismiss="modal"
                            id="tutup">Batal</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
@stack('js')
<script src="{{ asset('plugins/datatables/jquery.dataTables.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.26/dist/sweetalert2.all.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.7-beta.23/jquery.inputmask.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        // $('#obat').select2()
        // $('#cetak').hide()
        $('#transaksiBaru').hide()
    })

    function number(evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    }

    $('#obat').change(function() {
        let id = $(this).val()
        $.ajax({
            url: "{{ route('getDataObat') }}",
            type: 'post',
            data: {
                id: id,
                _token: "{{ csrf_token() }}"
            },
            success: function(res) {
                console.log(res);
                $('#harga').val(res.jual)
                $('#stock').val(res.stock)
            }
        })
    })

    $(document).on('blur', '#qty', function() {
        // let qty = $(this).val()
        // let harga = $('#harga').val()
        // let diskon = $('#diskon').val()
        // let total = qty * harga
        // let diskon_total = total * diskon / 100
        // let total_akhir = total - diskon_total
        // $('#total').val(total_akhir)

        let qty = $(this).val()
        let harga = $('#harga').val()
        let stock = $('#stock').val() - qty
        let total = qty * harga
        $('#total').val(total)
        $('#stock').val(stock)
    })

    // Tambah Data
    $(document).on('submit', 'form', function(event) {
        event.preventDefault();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: $(this).attr('action'),
            type: $(this).attr('method'),
            typeData: "JSON",
            data: new FormData(this),
            processData: false,
            contentType: false,
            success: function(res) {
                console.log(res);
                // $('#btn-tutup').click()
                $('#obat').prop('disabled', true)
                $('#qty').attr('disabled', true)
                $('#diskon').attr('disabled', true)
                $('#tambah').hide()
                $('#tabel').DataTable().ajax.reload()
                // $('#tabel').DataTable().draw();
                // alert(res.text)
                toastr.success(res.text, 'Sukses')
                // $('#forms')[0].reset();
            },
            error: function(xhr) {
                // console.log(xhr);
                toastr.error(xhr.responseJSON.text, 'Gagal')
            }
        })
    })

    $('#tabel').DataTable({
        serverSide: true,
        processing: true,
        responsive: true,
        ajax: {
            url: "{{ route('dataTable') }}",
            data: {
                id: $('#nota').val()
            }
        },
        columns: [{
                data: null,
                "sortable": false,
                render: function(data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                } //Auto Numbering
            },
            // {
            //     data: 'id',
            //     name: 'id',
            // },
            {
                data: 'item',
                name: 'item'
            },
            {
                data: 'qty',
                name: 'qty'
            },
            {
                data: 'jual',
                name: 'jual',
                // render: function(data, type, row) {
                //     return 'Rp. ' + data.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                // }
                render: $.fn.dataTable.render.number('.', ',', 2, 'Rp. ')
            },
            {
                data: 'subTotal',
                name: 'subTotal',
                // render: function(data, type, row) {
                //     return 'Rp. ' + data.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                // }
                render: $.fn.dataTable.render.number('.', ',', 2, 'Rp. ')
            },
            // {
            //     data: 'keterangan',
            //     name: 'keterangan'
            // },
            // {
            //     data: 'updated_at',
            //     name: 'updated_at'
            // },
            // {
            //     data: 'admin',
            //     name: 'admin.name'
            // },
            {
                data: 'aksi',
                name: 'aksi',
                orderable: false
            },
        ]
    })

    $(document).on('click', '.hapus', function() {
        let id = $(this).attr('id')
        $.ajax({
            url: "{{ route('hapusOrder') }}",
            type: 'post',
            data: {
                id: id,
                _token: "{{ csrf_token() }}"
            },
            success: function(res) {
                // console.log(res);
                toastr.success(res.text, 'Sukses')
                $('#tabel').DataTable().ajax.reload()
            },
            error: function(xhr) {
                toastr.error(xhr.responseJSON.text, 'Gagal')
            }
        })
    })

    $('#buka').click(function() {
        $('#tambah').show()
        $('#obat').prop('disabled', false)
        $('#qty').attr('disabled', false)
        $('#qty').val(null)
        $('#diskon').val(null)
        $('#diskon').attr('disabled', false)
    })

    // Cari Total Pembayaran
    $('#btn-bayar').click(function() {
        let id = $('#nota').val()
        $.ajax({
            url: "{{ route('hitung') }}",
            type: 'post',
            data: {
                id: id,
                _token: "{{ csrf_token() }}"
            },
            success: function(res) {
                console.log(res);
                $('#totalharga').val(res.data[0].totalHarga)
                $('#yangHarus').val(parseInt(res.data[0].totalHarga) - parseInt(res.diskon))
                $('#modalDiskon').val(res.diskon)
                $('#no').val(res.data[0].nota)
            }
        })
    })

    $(document).on('blur', '#yangDibayar', function() {
        $('#yangDibayar').blur(function() {
            let a = parseInt($('#yangHarus').val())
            let b = $(this).val()
            let c = b - a

            if (c < 0) {
                toastr.info('periksa Inputan', 'info')
                $('#simpanBayar').hide()
            } else {
                $('#kembali').val(c)
                $('#simpanBayar').show()
            }
        })
    })

    $('#simpanBayar').click(function() {
        $.ajax({
            url: "{{ route('simpanPenjualan') }}",
            type: 'post',

            data: {
                kembali: $('#kembali').val(),
                total: $('#yangHarus').val(),
                diskon: $('#modalDiskon').val(),
                dibayar: $('#yangDibayar').val(),
                nota: $('#nota').val(),
                _token: "{{ csrf_token() }}"
            },
            success: function(res) {
                toastr.success(res.text, 'Sukses')
                $('#tutup').click()
                $('#tambah').hide()
                $('#cetak').show()
                $('#transaksiBaru').show()
            },
            error: function(xhr) {
                toastr.error(xhr.responseJSON.text, 'Gagal')
            }
        })
    })
</script>
