@extends('layout')
@section('style')
    <style>
        .hero {
            min-height: 90vh;
            min-height: 90svh;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            gap: .5rem;
            padding-top: 6rem;
            padding-bottom: 3rem;
            background: linear-gradient(0deg, rgba(14, 19, 13, 0.9), rgba(58, 132, 56, 0.3)), url({{ asset('/img/heroimg.png') }});
            background-size: cover;
            background-position: center;
        }

        .hero p {
            max-width: 640px;
        }

        .sdg-grid img{
            display: flex;
            justify-content: center;
            margin: auto;
        }

        .btn-hero {
            background: #e8a93b;
            color: #1d2b20;
            width: fit-content;
            margin-top: .5rem;
            text-align: center;
        }

        .section {
            min-height: 90vh;
            min-height: 90svh;
            padding: 3rem 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .split {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            align-items: center;
        }

        .stack {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .split-img {
            width: 100%;
            height: auto;
            aspect-ratio: 4 / 3;
            max-height: 25rem;
            object-fit: cover;
            border-radius: 1.5rem;
        }

        .sdg-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1rem;
        }

        @media (max-width: 768px) {
            .section {
                min-height: auto;
                padding: 2rem 0;
            }

            .split {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }

            .split-img {
                max-height: 16rem;
            }

            .hero {
                min-height: 75svh;
                padding-top: 4rem;
            }

            .btn-hero {
                width: 100%;
            }
        }
    </style>
@endsection

@section('hero')
    <div class="hero">
        <h1>Satu bibit hari ini, bumi lebih sejuk esok hari.</h1>
        <p>Pemanasan global memicu suhu ekstrem, banjir rob, dan kerusakan pesisir. Pohon dan mangrove menyerap karbon serta
            melindungi kita.</p>
        <a class="btn btn-hero" href="/produk">Mulai Menanam</a>
    </div>
@endsection

@section('c')
    <div class="section">
        <div class="split">
            <div class="stack">
                <h2>Isu Global: Pemanasan Global</h2>
                <div class="c"><b>Penyebab</b><br>Emisi CO₂ dari bahan bakar fosil dan deforestasi.</div>
                <div class="c"><b>Solusi alami</b><br>Pohon menyerap CO₂ lewat fotosintesis.</div>
                <div class="c"><b>Mangrove</b><br>Menyimpan karbon di tanah pesisir dan meredam abrasi.</div>
            </div>
            <img class="split-img" loading="lazy" alt="Lanskap hijau"
                src="https://images.squarespace-cdn.com/content/v1/5feb5db26957d76ea855afa7/1738524709016-9ZHKZ8UBZ0IXWEY2NEVU/Scotland-Itineraries-For-First-Time-Travellers-Wander-Somewhere-Skye.jpg?format=1500w">
        </div>
    </div>

    <div class="section">
        <h2>Kaitan dengan SDGs</h2>
        <div class="sdg-grid">
            <div class="c">
                <img src="https://sdgsuniversities.org/wp-content/uploads/2023/06/SDG2.png" alt="SDG 2"
                    style="height: 225px;" />
                <br>
                <b>SDG 2 &amp; 11</b>
                <br>Pangan dan kota hijau: pohon buah dan peneduh.
            </div>
            <div class="c">
                <img src="https://www.karex.com.my/img/icons/icon-13climate-action.webp" alt="SDG 13"
                    style="height: 225px;" />
                <br>
                <b>SDG 13</b>
                <br>Penanganan Perubahan Iklim: penyerapan karbon.
            </div>
            <div class="c">
                <img src="https://goumbook.com/wp-content/uploads/2020/09/sdg-14-icon.png" alt="SDG 14"
                    style="height: 225px;" />
                <br>
                <b>SDG 14</b>
                <br>Ekosistem Lautan: mangrove sebagai tempat berkembang biak biota laut.
            </div>
            <div class="c">
                <img src="https://www.nrcmec.org/NRCM-SDG/SDG_15_Life_on_Land.png" alt="SDG 15" style="height: 225px;" />
                <br>
                <b>SDG 15</b>
                <br>Ekosistem Daratan: reboisasi dan keanekaragaman hayati.
            </div>
        </div>
    </div>

    <div class="section">
        <h2>Bibit Pilihan</h2>
        <div class="g">
            @foreach ($featured as $p)
                @include('_card')
            @endforeach
        </div>
    </div>
@endsection
