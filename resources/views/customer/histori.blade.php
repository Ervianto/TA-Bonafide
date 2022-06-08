@extends('layouts.landing')
@section('content')
    <div class="breadcrumb-section breadcrumb-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 text-center">
                    <div class="breadcrumb-text">
                        <h1>Riwayat Transaksi</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="checkout-section mt-5 mb-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card card-body">
                        <ul class="nav nav-pills nav-justified mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="pills-belum-terbayar-tab" data-toggle="pill"
                                    href="#pills-belum-terbayar" role="tab" aria-controls="pills-belum-terbayar"
                                    aria-selected="true">
                                    Belum Terbayar
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-pengiriman-tab" data-toggle="pill"
                                    href="#pills-pengiriman" role="tab" aria-controls="pills-pengiriman"
                                    aria-selected="true">
                                    Pengiriman
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-selesai-tab" data-toggle="pill" href="#pills-selesai"
                                    role="tab" aria-controls="pills-selesai" aria-selected="false">
                                    Selesai
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-belum-terbayar" role="tabpanel"
                                aria-labelledby="pills-belum-terbayar-tab">
                                <table class="table" id="belumTerbayar" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <td>No</td>
                                            <td>Tanggal</td>
                                            <td>Kode Transaksi</td>
                                            <td>Payment</td>
                                            <td>Va Number</td>
                                            <td>Total Pembelian</td>
                                            <td>Total Ongkir</td>
                                            <td>Total Keseluruhan</td>
                                            <td>Status</td>
                                            <td>Detail</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no = 0; @endphp
                                        @foreach ($transaksiBlmSelesaipembayaran as $item)
                                            @php $no++; @endphp
                                            <tr>
                                                <td>{{ $no }}</td>
                                                <td>{{ $item->created_at }}</td>
                                                <td>{{ $item->kode_tr }}</td>
                                                <td>
                                                    @if ($item->payment_type == 'credit_card')
                                                        Credit Card
                                                    @elseif($item->payment_type == 'gopay')
                                                        Gopay
                                                    @elseif($item->payment_type == 'qris')
                                                        QRIS
                                                    @elseif($item->payment_type == 'shopeepay')
                                                        Shopeepay
                                                    @elseif($item->payment_type == 'bank_transfer')
                                                        Bank Transfer
                                                    @elseif($item->payment_type == 'echannel')
                                                        Mandiri Bill
                                                    @elseif($item->payment_type == 'bca_klikpay')
                                                        BCA Klikpay
                                                    @elseif($item->payment_type == 'bca_klikbca')
                                                        Klik BCA
                                                    @elseif($item->payment_type == 'cimb_clicks')
                                                        CIMB Clicks
                                                    @elseif($item->payment_type == 'danamon_online')
                                                        Danamon Online Banking
                                                    @elseif($item->payment_type == 'cstore')
                                                        Indomaret / Alfamart
                                                    @elseif($item->payment_type == 'akulaku')
                                                        Akulaku
                                                    @elseif($item->payment_type == 'bri_epay')
                                                        BRImo
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($item->va_number != null)
                                                        @php $va = json_decode($item->va_number) @endphp
                                                        <?= 'Bank : ' . $va[0]->bank . '<br/>' . 'VA:' . $va[0]->va_number ?>
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td>{{ rupiah($item->total_transaksi - $item->jasa_ongkir) }}</td>
                                                <td>{{ rupiah($item->jasa_ongkir) }}</td>
                                                <td>{{ rupiah($item->total_transaksi) }}</td>
                                                <td>{{ $item->status == 'pending' ? 'Belum Terbayar' : 'Terbayar' }}</td>
                                                <td>
                                                    <a href="{{ url('customer-transaksi/' . $item->kode) }}"
                                                        class="btn btn-primary">
                                                        Detail
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane fade" id="pills-pengiriman" role="tabpanel"
                                aria-labelledby="pills-pengiriman-tab">
                                <table class="table" id="pengirimanBarang" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <td>No</td>
                                            <td>Tanggal</td>
                                            <td>Kode Transaksi</td>
                                            <td>Kurir</td>
                                            <td>Estimasi Sampai</td>
                                            <td>Total Pembelian</td>
                                            <td>Total Ongkir</td>
                                            <td>Total Keseluruhan</td>
                                            <td>Status Pengiriman</td>
                                            <td>Detail</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no = 0; @endphp
                                        @foreach ($transaksiPengiriman as $item)
                                            @php $no++; @endphp
                                            <tr>
                                                <td>{{ $no }}</td>
                                                <td>{{ $item->created_at }}</td>
                                                <td>{{ $item->kode_tr }}</td>
                                                <td>{{ $item->kurir }}</td>
                                                <td>{{ $item->lama_sampai }}</td>
                                                <td>{{ rupiah($item->jasa_ongkir) }}</td>
                                                <td>{{ rupiah($item->total_transaksi - $item->jasa_ongkir) }}</td>
                                                <td>{{ rupiah($item->total_transaksi) }}</td>
                                                <td>{{ ($item->status_dikirim == 0 ? 'Belum Dikirim' : $item->status_sampai == 0) ? 'Sedang Perjalanan' : 'Sampai' }}
                                                </td>
                                                <td>
                                                    <a href="{{ url('konfirmasi-barang-sampai/' . $item->kode) }}"
                                                        class="btn btn-primary">
                                                        Konfirmasi
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane fade" id="pills-selesai" role="tabpanel"
                                aria-labelledby="pills-selesai-tab">
                                <table class="table" id="transaksiSelesai" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <td>No</td>
                                            <td>Tanggal</td>
                                            <td>Kode Transaksi</td>
                                            <td>Payment</td>
                                            <td>Va Number</td>
                                            <td>Total Pembelian</td>
                                            <td>Total Ongkir</td>
                                            <td>Total Keseluruhan</td>
                                            <td>Status</td>
                                            <td>Detail</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no = 0; @endphp
                                        @foreach ($transaksiSelesai as $item)
                                            @php $no++; @endphp
                                            <tr>
                                                <td>{{ $no }}</td>
                                                <td>{{ $item->created_at }}</td>
                                                <td>{{ $item->kode_tr }}</td>
                                                <td>
                                                    @if ($item->payment_type == 'credit_card')
                                                        Credit Card
                                                    @elseif($item->payment_type == 'gopay')
                                                        Gopay
                                                    @elseif($item->payment_type == 'qris')
                                                        QRIS
                                                    @elseif($item->payment_type == 'shopeepay')
                                                        Shopeepay
                                                    @elseif($item->payment_type == 'bank_transfer')
                                                        Bank Transfer
                                                    @elseif($item->payment_type == 'echannel')
                                                        Mandiri Bill
                                                    @elseif($item->payment_type == 'bca_klikpay')
                                                        BCA Klikpay
                                                    @elseif($item->payment_type == 'bca_klikbca')
                                                        Klik BCA
                                                    @elseif($item->payment_type == 'cimb_clicks')
                                                        CIMB Clicks
                                                    @elseif($item->payment_type == 'danamon_online')
                                                        Danamon Online Banking
                                                    @elseif($item->payment_type == 'cstore')
                                                        Indomaret / Alfamart
                                                    @elseif($item->payment_type == 'akulaku')
                                                        Akulaku
                                                    @elseif($item->payment_type == 'bri_epay')
                                                        BRImo
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($item->va_number != null)
                                                        @php $va = json_decode($item->va_number) @endphp
                                                        <?= 'Bank : ' . $va[0]->bank . '<br/>' . 'VA:' . $va[0]->va_number ?>
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td>{{ rupiah($item->total_transaksi - $item->jasa_ongkir) }}</td>
                                                <td>{{ rupiah($item->jasa_ongkir) }}</td>
                                                <td>{{ rupiah($item->total_transaksi) }}</td>
                                                <td>{{ $item->status == 'pending' ? 'Belum Terbayar' : 'Terbayar' }}</td>
                                                <td>
                                                    <a href="{{ url('customer-transaksi/' . $item->kode) }}"
                                                        class="btn btn-primary">
                                                        Detail
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $("#belumTerbayar").DataTable();
        $("#pengirimanBarang").DataTable();
        $("#transaksiSelesai").DataTable();
    </script>
@endpush
