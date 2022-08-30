<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <table class="table table-stripped" id="tabel" style="width: 100%">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama Obat</th>
                                <th>Harga Beli</th>
                                <th>Harga Jual</th>
                                <th>Stock</th>
                                <th>Keterangan</th>
                                <th>Update Terakhir</th>
                                <th>Admin</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <button type="button" class="btn btn-info" id="btn-tambah" data-toggle="modal" data-target="#modal-info">
                Tambah
            </button>
        </div>

        <div class="modal fade" id="modal-info">
            <div class="modal-dialog">
                <div class="modal-content bg-info">
                    <div class="modal-header">
                        <h4 class="modal-title">Info Modal</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        {{-- Form Isian --}}
                        <form action="{{ route('stocks.store') }}" method="post" id="forms">
                            @csrf
                            {{-- {{ csrf_field() }} --}}
                            <div class="form-group">
                                <label for="exampleInputPassword1">Nama Obat</label>
                                <select autocomplete="off" name="obat_id" id="obat" class="form-control">
                                    <option value="">Pilih Obat</option>
                                    @foreach ($obat as $item)
                                        <option value="{{ $item->id }}">{{ $item->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                STOCK OBAT
                                <hr style="border: 1px solid red">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Stock Awal</label>
                                <input type="text" class="form-control" id="stockLama"
                                    onkeypress="return number(event)" readonly autocomplete="off" name="stocklama"
                                    value="">
                                <input type="text" hidden class="form-control" id="id" autocomplete="off"
                                    name="id" placeholder="0">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Masuk</label>
                                <input type="text" class="form-control" onkeypress="return number(event)"
                                    autocomplete="off" id="masuk" name="masuk" value="0">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Keluar</label>
                                <input type="text" class="form-control" onkeypress="return number(event)"
                                    autocomplete="off" id="keluar" name="keluar" value="0">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Stock Akhir</label>
                                <input type="text" class="form-control" readonly onkeypress="return number(event)"
                                    autocomplete="off" id="stock" name="stock" value="0">
                            </div>
                            <div>
                                STOCK OBAT
                                <hr style="border: 1px solid rgb(180, 1, 1)">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Harga Beli</label>
                                <input type="text" class="form-control" onkeypress="return number(event)"
                                    autocomplete="off" id="beli" maxlength="12" name="beli"
                                    data-inputmask="'alias': 'numeric', 'digits': 2, 'prefix': 'Rp. ', groupSeparator': ',', 'autoGroup' : true,
                                    'digitsOptional' :false">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Harga Jual</label>
                                <input type="text" class="form-control" onkeypress="return number(event)"
                                    autocomplete="off" id="jual" maxlength="12" name="jual"
                                    data-inputmask="'alias': 'numeric', 'digits': 2, 'prefix': 'Rp. ', groupSeparator': ',', 'autoGroup' : true,
                                    'digitsOptional' :false">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Tanggal Expired</label>
                                <input type="text" class="datepicker-here form-control" autocomplete="off"
                                    name="expired" id="expired" data-position="top left" data-language='en'
                                    data-date-format="yyyy-mm-dd">
                                {{-- <input type="text" class="datepicker-here form-control" data-language='en'
                                    name="expired" id="expired" data-multiple-dates="3"
                                    data-multiple-dates-separator=", " data-position='top left' /> --}}
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Keterangan</label>
                                <input type="text" class="form-control" id="keterangan" autocomplete="off"
                                    name="keterangan" placeholder="Kurang, Lebih, Rusak">
                            </div>
                            <button type="submit" id="simpan"
                                class="btn btn-outline-light btn-success btn-block">Simpan</button>
                        </form>
                        <button type="button" name="batal" id="btn-tutup" hidden class="btn btn-outline-light"
                            data-dismiss="modal">Close</button>
                    </div>

                    <meta name="csrf-token" content="{{ csrf_token() }}">
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
    $(document).ready(function() {
        loaddata()
        // $('#obats').hide();
        // $('#obat').select2({});
        // $(':input').inputmask({
        //     removMaskOnSubmit: true,
        //     rightAlign: true,
        // })
        // $('#beli').inputMask({
        //     alias: 'numeric',
        //     digits: 2,
        //     prefix: 'Rp. ',
        //     groupSeparator: ',',
        //     autoGroup: true,
        //     digitsOptional: false
        // });
        // Swal.fire(
        //     'Good job!',
        //     'You clicked the button!',
        //     'success'
        // )
        // toastr.info('Are you the 6 fingered man?')
    })

    function loaddata() {
        $('#tabel').DataTable({
            serverSide: true,
            processing: true,
            ajax: {
                url: "{{ route('stocks.index') }}"
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'obat_id',
                    name: 'obat_id.nama'
                },
                {
                    data: 'beli',
                    name: 'beli'
                },
                {
                    data: 'jual',
                    name: 'jual'
                },
                {
                    data: 'stock',
                    name: 'stock'
                },
                {
                    data: 'keterangan',
                    name: 'keterangan'
                },
                {
                    data: 'updated_at',
                    name: 'updated_at'
                },
                {
                    data: 'admin',
                    name: 'admin.name'
                },
                {
                    data: 'aksi',
                    name: 'aksi',
                    orderable: false
                },
            ]
        })
    }

    // Fungsi Tambah Data
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
                $('#btn-tutup').click()
                $('#tabel').DataTable().ajax.reload()
                // alert(res.text)
                toastr.success(res.text, 'Sukses')
                $('#forms')[0].reset();
            },
            error: function(xhr) {
                // console.log(xhr);
                toastr.error(xhr.responseJSON.text, 'Gagal')
            }
        })
    })

    // Input Harus Angka
    function number(evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    }

    $(document).on('change', '#obat', function() {
        let id = $(this).val()
        $.ajax({
            url: "{{ route('getObat') }}",
            type: 'post',
            data: {
                id: id,
                _token: "{{ csrf_token() }}"
            },
            success: function(res) {
                console.log(res).val(res.data.stock);
            },
            error: function(xhr) {
                console.log(xhr);
            }
        })
    })

    $(document).on('blur', '#masuk', function() {
        let awal = $('#stockLama').val() //parseInt digunakan jika string
        let masuk = $('#masuk').val()
        let keluar = $('#keluar').val()
        // let akhir = (Number(awal) + Number(masuk)) - Number(keluar)
        let akhir = (parseInt(awal) + parseInt(masuk)) - parseInt(keluar)
        // if (!isNaN(awal) && !isNaN(masuk) && !isNaN(keluar)) {
        //     $('#stock').val(awal + masuk - keluar);
        // } else {
        //     alert('Please enter numbers only!');
        // }
        $('#stock').val(akhir)
    })

    $(document).on('blur', '#keluar', function() {
        let awal = $('#stockLama').val()
        let masuk = $('#masuk').val()
        let keluar = $('#keluar').val()
        let akhir = (Number(awal) + Number(masuk)) - Number(keluar)
        // let akhir = (parseInt(awal) + parseInt(masuk)) - parseInt(keluar)
        $('#stock').val(akhir)
        // if (!isNaN(awal) && !isNaN(masuk) && !isNaN(keluar)) {
        //     $('#stock').val(awal + masuk - keluar);
        // } else {
        //     alert('Please enter numbers only!');
        // }
    })

    // $.ajaxSetup({
    //     headers: {
    //         'X-CSRF-TOKEN': $('input[name="_token"]').value()
    //     }
    // });

    $(document).on('click', '.edit', function() {
        // e.preventDefault();
        // var tes = 'Tes';
        // console.log(tes);

        $('#forms').attr('action', "{{ route('stocks.updates') }}")
        $('#btn-tambah').click()
        let id = $(this).attr('id')

        $.ajax({
            url: "{{ route('stocks.edits') }}",
            type: 'POST',
            data: {
                id: id,
                // _token: "{{ 'csrf_token' }}",
                _token: "{{ csrf_token() }}"
            },
            success: function(res) {
                // console.log(res);
                // let newOption = new Option(res.obat_id.nama, res.obat_id, true, true);
                //fungsi untuk melihat data obat yang sudah dipilih
                let newOption = new Option(res.obats.nama, res.obat_id, true, true);
                $('#id').val(res.id)
                // $('#obat').val(res.obat_id)
                $('#obat').append(newOption).trigger(
                    'change') //fungsi untuk menambahkan data obat yang sudah dipilih
                $('#obat').prop('disabled', true) // disable combobox
                $('#beli').val(parseInt(res.beli) - '00')
                $('#jual').val(parseInt(res.jual) - '00')
                // $('#beli').val(res.beli)
                // $('#jual').val(res.jual)
                $('#stockLama').val(res.stock)
                $('#keterangan').val(res.keterangan)
                $('#expired').val(res.expired)
                // $('#btn-tambah').click()
                console.log(res);
            },
            error: function(xhr) {
                console.log(xhr);
            }
        })
    })

    $(document).ready(function() {
        $('#modal-info').on("hidden.bs.modal", function(e) {
            $('#forms').trigger("reset");
            $('#forms').attr('action', "{{ route('stocks.store') }}")
        });
    });

    // HAPUS
    $(document).on('click', '.hapus', function() {
        let id = $(this).attr('id')

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('stocks.hapus') }}",
                    type: 'POST',
                    data: {
                        id: id,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(res, status) {
                        if (status = '200') {
                            setTimeout(() => {
                                Swal.fire({
                                    position: 'top-end',
                                    icon: 'success',
                                    title: 'Data Berhasil Dihapus',
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then((res) => {
                                    $('#tabel').DataTable().ajax
                                        .reload()
                                })
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Gagal Dihapus!',
                        })
                    }
                })
            }
        })

        // $.ajax({
        //     url: "{{ route('stocks.hapus') }}",
        //     type: 'POST',
        //     data: {
        //         id: id,
        //         // _token: "{{ 'csrf_token' }}",
        //         _token: "{{ csrf_token() }}"
        //     },
        //     success: function(res) {
        //         console.log(res);
        //         $('#tabel').DataTable().ajax.reload()
        //         alert(res.text)
        //     }
        // })
    })
</script>
