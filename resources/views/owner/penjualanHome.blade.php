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
                        <form action="" method="POST" id="sample_form">
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
                                    {{-- @foreach ($obat as $item)
                                        <option value="{{ $item->id }}">{{ $item->namaObat }}</option>
                                    @endforeach --}}
                                </select>
                            </div>
                            <div class="form-group col-3">
                                <label>Stock Tersedia</label>
                                <input type="text" class="stock form-control" readonly name="stock" id="stock">
                            </div>
                            <div class="form-group col-3">
                                <label>No Kwitansi</label>
                                <input type="text" class="form-control" readonly name="no" id="no"
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
                                    maxlength="3" name="diskon" id="diskon">
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
                            <table class="table table-bordered table-striped table-sm" id="tabel1">
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
                                {{-- <form action="" method="post">
                                    @csrf
                                    <input type="text" aria-label="telp" autocomplete="off" onkeypress="return number(event)" maxlength="12" name="kwitansi" hidden id="kwitansi" class="form-control" value="nomer">

                                    <button id="cetak" name="cetak" class="btn btn-danger float-left"><i class="far fa-file-pdf"></i>$nbsp: Cetak Slip</button>
                                </form> --}}
                                <button type="button" id="btn-bayar" name="btn-bayar" data-toggle="modal"
                                    id="btn-modal" data-target="#modal-secondary" class="btn btn-danger"><i
                                        class="fas fa-money-bill-wave"></i>Proses</button>
                                {{-- Midtrans --}}
                                {{-- <button type="button" id="btn-checkOut" name="btn-check" data-toggle="modal" id="btn-modal2" data-target="#modal" class="btn btn-warning"><i class="fas fa-money-bill-wave"></i>Checkout</button>

                                <button class="transaksiBaru btn btn-warning" id="transaksiBaru">Transaksi Baru</button> --}}
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
    </div>
    </div>
</x-app-layout>
@stack('js')
<script src="{{ asset('plugins/datatables/jquery.dataTables.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.26/dist/sweetalert2.all.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="{{ asset('dist/air-datepicker/dist/js/datepicker.js') }}"></script>
<script src="{{ asset('dist/air-datepicker/dist/js/i18n/datepicker.en.js') }}"></script>
<script src="{{ asset('dist/jquery.inputmask.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.7-beta.23/jquery.inputmask.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<script>
    // $(document).ready(function() {
    //     $('#obat').select2()
    // })

    function number(evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    }
</script>
