<tbody>
    @foreach ($asets as $aset)
        @if ($aset instanceof \App\Models\Aset && $aset->depreciations) 
            <tr>
                <td>Rp {{ number_format($aset->harga_per_bulan ?? 0, 0, ',', '.') }}</td>
                <td>{{ $aset->bulan_pemakaian ?? 'Tidak ada data' }}</td>

                @foreach ($years as $year)
                    @php
                        $depreciation = optional($aset->depreciations->where('depreciation_year', $year)->first());
                    @endphp
                    <td>Rp {{ number_format($depreciation->nilai_penyusutan ?? 0, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($depreciation->nilai_sisa ?? 0, 0, ',', '.') }}</td>
                @endforeach

                <td>Rp {{ number_format($aset->depreciations->sum('nilai_penyusutan') ?? 0, 0, ',', '.') }}</td>
            </tr>
        @else
            <tr>
                <td colspan="{{ count($years) + 3 }}">Data tidak tersedia</td>
            </tr>
        @endif
    @endforeach
</tbody>
