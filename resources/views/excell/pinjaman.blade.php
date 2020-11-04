<table class="table">
    <thead>
        <tr>
            <th>#</th>
            <th>Tgl</th>
            <th>No Anggota</th>
            <th>Keterangan</th>
            <th>Pinjaman</th>
            <th>Cicilan Pinjaman</th>
            <th>Akumulasi Bunga</th>
            <th>Saldo</th>
        </tr>
    </thead>
    @if (!empty($transaksi_harian))
        <tbody>
            @php
                $no = 1;
                $saldo = 0;
                $cicilan = 0;
                $sumKredit = 0;
                $sumCicilan = 0;
                $i = 0;
            @endphp
            @php
                $saldo =  $sum_kredit_pinjaman - $sum_cicilan;
            @endphp
            <tr>
                <th scope="row"></th>
                <td></td>
                <td>{{ $nik }}</td>
                <td><strong>Saldo Mutasi</strong></td>
                <td>{{ Money::stringToRupiah($sum_kredit_pinjaman) }}</td>
                <td>{{ Money::stringToRupiah($sum_cicilan) }}</td>
                <td>{{ Money::stringToRupiah($sum_bunga) }}</td>
                <td>{{ Money::stringToRupiah($saldo) }}</td>
            </tr>
            @foreach ($transaksi_harian as $row)
                @php
                    $saldo +=  $row->sumKreditPinjaman->sum('nominal') - $row->sumCicilan->sum('nominal');
                @endphp
                <tr>
                    <th scope="row">{{ $no }}</th>
                    <td>{{ Tanggal::tanggal_id($row->tgl) }}</td>
                    <th>{{ $nik }}</th>
                    <td>{{ $row->keterangan }}</td>
                    <td>{{ Money::stringToRupiah($row->sumKreditPinjaman->sum('nominal')) }}</td>
                    <td>{{ Money::stringToRupiah($row->sumCicilan->sum('nominal')) }}</td>
                    <td>{{ Money::stringToRupiah($row->sumBunga->sum('nominal')) }}</td>
                    <td>{{ Money::stringToRupiah($saldo) }}</td>
                </tr>
                @php
                    $no++;
                @endphp
            @endforeach
        </tbody>
    @endif
</table>
