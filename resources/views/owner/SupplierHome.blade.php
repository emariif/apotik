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
                                <th>Nama</th>
                                <th>Telpon</th>
                                <th>Email</th>
                                <th>Rekening</th>
                                <th>Alamat</th>
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
                        <form action="{{ route('supplier.store') }}" method="post" id="forms">
                            @csrf
                            {{-- {{ csrf_field() }} --}}
                            <div class="form-group">
                                <label for="exampleInputPassword1">Nama Supplier</label>
                                <input type="text" class="form-control" id="nama" name="nama"
                                    placeholder="Nama Supplier">
                                <input type="text" hidden class="form-control" id="id" name="id"
                                    placeholder="Nama Supplier">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Telpon</label>
                                <input type="text" class="form-control" maxlength="12"
                                    onkeypress="return number(event)" id="telp" name="telp"
                                    placeholder="No. Telp">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">E-Mail</label>
                                <input type="text" class="form-control" id="email" name="email"
                                    placeholder="Alamat Email">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">No. Rekening</label>
                                <input type="text" class="form-control" onkeypress="return number(event)"
                                    id="rekening" name="rekening" placeholder="Rekening">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Alamat</label>
                                <textarea class="form-control" id="alamat" name="alamat" cols="30" rows="10"></textarea>
                            </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" name="batal" id="btn-tutup" class="btn btn-outline-light"
                            data-dismiss="modal">Close</button>
                        <button type="submit" id="simpan" class="btn btn-outline-light">Save</button>
                    </div>
                    </form>
                </div>

                <meta name="csrf-token" content="{{ csrf_token() }}">
            </div>
        </div>
</x-app-layout>
@stack('js')
<script src="{{ asset('plugins/datatables/jquery.dataTables.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.26/dist/sweetalert2.all.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    $(document).ready(function() {
        loaddata()
        // Swal.fire(
        //     'Good job!',
        //     'You clicked the button!',
        //     'success'
        // )
        toastr.info('Are you the 6 fingered man?')
    })

    function loaddata() {
        $('#tabel').DataTable({
            serverSide: true,
            processing: true,
            ajax: {
                url: "{{ route('supplier.index') }}"
            },
            columns: [{
                    data: 'nama',
                    name: 'nama'
                },
                {
                    data: 'telp',
                    name: 'telp'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'rekening',
                    name: 'rekening'
                },
                {
                    data: 'alamat',
                    name: 'alamat'
                },
                {
                    data: 'aksi',
                    name: 'aksi',
                    orderable: false
                },
            ]
        })
    }

    function number(evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    }

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
                $('#forms')[0].reset();
                // alert(res.text)
                toastr.success(res.text, 'Success')
            },
            error: function(xhr) {
                // console.log(xhr);
                toastr.error(xhr.responseJSON.text, 'Gagal')
            }
        })
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

        $('#forms').attr('action', "{{ route('supplier.updates') }}")
        let id = $(this).attr('id')

        $.ajax({
            url: "{{ route('supplier.edits') }}",
            type: 'POST',
            data: {
                id: id,
                // _token: "{{ 'csrf_token' }}",
                _token: "{{ csrf_token() }}"
            },
            success: function(res) {
                console.log(res);
                $('#id').val(res.id)
                $('#nama').val(res.nama)
                $('#telp').val(res.telp)
                $('#alamat').val(res.alamat)
                $('#rekening').val(res.rekening)
                $('#email').val(res.email)
                $('#btn-tambah').click()
            },
            error: function(xhr) {
                console.log(xhr);
            }
        })
    })

    $(document).ready(function() {
        $('#modal-info').on("hidden.bs.modal", function(e) {
            $('#forms').trigger("reset");
            $('#forms').attr('action', "{{ route('supplier.store') }}")
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
                    url: "{{ route('supplier.hapus') }}",
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
                                    $('#tabel').DataTable().ajax.reload()
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
        //     url: "{{ route('supplier.hapus') }}",
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
