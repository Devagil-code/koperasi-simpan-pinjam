<table class="table">
    <thead>
        <tr>
            <th>#</th>
            <th>Tgl</th>
            <th>Keterangan</th>
            <th>Debit</th>
            <th>Kredit</th>
            <th>Saldo</th>
        </tr>
    </thead>
    @if (!empty($transaksi_harian))
        <tbody>
            @php
                $no = 1;
                $saldo = 0;
                $i = 0;
            @endphp
            <tr>
                <td scope="row"></td>
                <td></td>
                <td><strong>Saldo Mutasi</strong></td>
                <td>{{ Money::stringToRupiah($saldo_debit) }}</td>
                <td>{{ Money::stringToRupiah($saldo_kredit) }}</td>
                <td>{{ Money::stringToRupiah($saldo_debit - $saldo_kredit) }}</td>
            </tr>
            @php
                $saldo = $saldo_debit - $saldo_kredit;
            @endphp
            @foreach ($transaksi_harian as $row)
                @php
                $saldo += $row->sumDebitAll->sum('nominal') - $row->sumKreditAll->sum('nominal');
                @endphp
                <tr>
                    <td scope="row">{{ $no }}</td>
                    <td>{{ Tanggal::tanggal_id($row->tgl )}}</td>
                    <td>{{ $row->keterangan }}</td>
                    <td>{{ Money::stringToRupiah($row->sumDebitAll->sum('nominal')) }}</td>
                    <td>{{ Money::stringToRupiah($row->sumKreditAll->sum('nominal')) }}</td>
                    <td>{{ Money::stringToRupiah($saldo) }}</td>
                </tr>
                @php
                    $no++;
                @endphp
            @endforeach                    
        </tbody>
    @endif
</table>