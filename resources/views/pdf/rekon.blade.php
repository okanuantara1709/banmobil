<h4 style="text-align:center">HASIL REKONSILIASI</h4>
<table >
    <thead style="background-color:aqua">
        <tr>
            <th>LPJ No : {{$lpj->no_dokumen}}</th>
            <th>Hasil Transaksi</th>
            <th>Hasil LPJ</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($kategori as $item)
            <tr>
                <td>{{$item['name']}}</td>
                <td>Rp. {{number_format($data[$item['name']]['hasil_transaksi'],2,',','.')}}</td>
                <td>Rp. {{number_format($data[$item['name']]['hasil_lpj'],2,',','.')}}</td>
                <td>{{$data[$item['name']]['status']}}</td>
            </tr>
        @endforeach                                               
    </tbody>
</table>