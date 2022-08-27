<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 60%;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1 style="text-align: center">Apotik Sumber Brantas</h1>
        <p style="font-size: 10px; text-align:center">Jl. Mojowarno No.63, Mojorejo, Kec. Junrejo, Kota Batu, Jawa Timur
            65322 <br>
            Telp. 0343) 6666666, E-Mail, Slanker85@gmail.com, Fax. (0343) 6666666</p>
        <hr style="border: 1px solid rgb(7, 17, 105);">

        <div class="row">
            <div>
                <table style="width: 40%">
                    <tr>
                        <td>No. Nota</td>
                        <td>:</td>
                        <td>{{ $data[0]->nota }}</td>
                    </tr>
                    <tr>
                        <td>Customer</td>
                        <td>:</td>
                        <td>{{ $data[0]->customer }}</td>
                    </tr>
                    <tr>
                        <td>Telp</td>
                        <td>:</td>
                        <td>{{ $data[0]->telp }}</td>
                    </tr>
                    <tr>
                        <td>Kasir</td>
                        <td>:</td>
                        <td>{{ $data[0]->name }}</td>
                    </tr>
                </table>
            </div>
        </div>
        {{-- @php
            dd($data);
        @endphp --}}
        <hr style="border: 1px solid red">
        <div>
            <table style="width: 100%; border: 1em;">
                <tr>
                    <td>Kode</td>
                    <td>Nama Barang</td>
                    <td>QTY</td>
                    <td>Kemasan</td>
                    <td>Harga</td>
                    <td>Jumlah</td>
                </tr>
                <tr>
                    {{-- Data --}}
                    @foreach ($data as $item)
                <tr>
                    <td>{{ $item->kode }}</td>
                    <td>{{ $item->nama_obat }}</td>
                    <td>{{ $item->qty }}</td>
                    {{-- <td>{{ $item->satuan }}</td> --}}
                    <td>{{ $item->jual }}</td>
                    <td>{{ $item->subTotal }}</td>
                </tr>
                @endforeach
                </tr>
            </table>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <hr style="border: 1px solid red">
        </div>
        <div>
            <table style="border:1em; width:100%; table-layout:fixed;">
                <tr>
                    <th width="40%"></th>
                    <th width="20%"></th>
                    <th width="15%"></th>
                    <th width="10%"></th>
                    <th width="15%"></th>
                </tr>
                {{-- <tr>
                    <td></td>
                    <td></td>
                    <td>Total </td>
                    <td>: Rp. </td>
                    <td style="text-align: right">{{ number_format($bruto[0]->bruto, 2) }}</td>
                </tr> --}}
                <tr>
                    <td></td>
                    <td></td>
                    <td>Discount </td>
                    <td>: Rp. </td>
                    <td style="text-align: right">{{ number_format($data[0]->diskon, 2) }}</td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td>Besar Uang </td>
                    <td>: Rp. </td>
                    <td style="text-align: right">{{ number_format($data[0]->dibayar, 2) }}</td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td>Pengembalian </td>
                    <td>: Rp. </td>
                    <td style="text-align: right">{{ number_format($data[0]->kembali, 2) }}</td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td>Total Bersih </td>
                    <td>: Rp. </td>
                    <td style="text-align: right">{{ number_format($data[0]->total, 2) }}</td>
                </tr>
                {{-- <tr>
                    <td colspan="5">
                        <p style="background: grey; text-align:center"> <b> Terbilang : {{ $terbilang }} </b></p>
                    </td>
                </tr> --}}
            </table>
        </div>
    </div>
</body>

</html>
