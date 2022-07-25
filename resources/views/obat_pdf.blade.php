<!DOCTYPE html>
<html>
<head>
	<title>LAPORAN OBAT</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
	<style type="text/css">
		table tr td,
		table tr th{
			font-size: 9pt;
		}
	</style>

<center>
	<h5>LAPORAN OBAT KLINIK UTAMA HALMAHERA MEDIKA</h5>
</center>
 
	<table class='table table-bordered'>
		<thead>
			<tr>
				<th>No</th>
				<th>Nama Obat</th>
				<th>Sediaan</th>
				<th>Dosis</th>
				<th>Satuan</th>
				<th>Stok</th>
				<th>Harga</th>
			</tr>
		</thead>
		<tbody>
			@php $i=1 @endphp
			@foreach($obat as $o)
			<tr>
				<td>{{ $i++ }}</td>
				<td>{{$o->nama_obat}}</td>
				<td>{{$o->sediaan}}</td>
				<td>{{$o->dosis}}</td>
				<td>{{$o->satuan}}</td>
				<td>{{$o->stok}}</td>
				<td>{{$o->harga}}</td>
			</tr>
			@endforeach
		</tbody>
	</table>
 
</body>
</html>