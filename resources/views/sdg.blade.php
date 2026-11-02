@extends('layout')
@php(
    $info = [
        13 => ['Penanganan Perubahan Iklim', 'Pemanasan global terutama dipicu emisi gas rumah kaca. Pohon menyerap CO₂ saat tumbuh dan menyimpannya sebagai biomassa. Menanam dan merawat pohon adalah salah satu aksi iklim yang bisa dilakukan siapa saja.'],
        14 => ['Ekosistem Lautan', 'Mangrove melindungi garis pantai dari abrasi, menjadi tempat berkembang biak ikan, udang, dan kepiting, serta menyimpan karbon di tanah pesisir ("karbon biru"). Tanaman pesisir lain membantu menahan angin dan erosi.'],
        15 => ['Ekosistem Daratan', 'Reboisasi memulihkan lahan kritis, menahan erosi, menjaga sumber air, dan memberi habitat bagi satwa. Memilih jenis lokal dan beragam menjaga keanekaragaman hayati.'],
        2 => ['Tanpa Kelaparan', 'Pohon buah memberi pangan dan tambahan penghasilan bagi keluarga dan petani, sambil tetap menyerap karbon.'],
        11 => ['Kota dan Permukiman Berkelanjutan', 'Pohon peneduh dan tanaman hias menurunkan suhu lingkungan sekitar, menyaring debu, dan membuat kota lebih nyaman dihuni.']
    ]
)
@section('hero')
    <div class="hero">
        <h1>Dampak &amp; SDGs</h1>
        <p>Setiap bibit di HijauBumi terkait dengan tujuan pembangunan berkelanjutan (SDGs) PBB.</p>
    </div>
@endsection
@section('c')
    @foreach ($info as $n => [$t, $d])
        <h2>SDG {{ $n }} – {{ $t }}</h2>
        <p>{{ $d }}</p>
        <div class="g">
            @foreach (($groups[$n] ?? collect())->take(4) as $p)
                @include('_card')
            @endforeach
        </div>
    @endforeach
    <p style="color:var(--mu);margin-top:28px">Catatan: estimasi serapan CO₂ per bibit bersifat edukatif dan bergantung pada
        lokasi, iklim, dan perawatan.</p>
@endsection
