<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>HijauBumi – Toko Bibit Pohon</title>
    <style>
        :root {
            --bg: #f6f8f1;
            --cd: #fff;
            --tx: #1d2b20;
            --mu: #5d6b5f;
            --g: #2f7d4f;
            --bd: #dfe6d6
        }

        @media(prefers-color-scheme:dark) {
            :root {
                --bg: #121a14;
                --cd: #1b261e;
                --tx: #e8efe6;
                --mu: #a2b3a5;
                --g: #58b47c;
                --bd: #2c3b30
            }
        }

        * {
            box-sizing: border-box
        }

        body {
            margin: 0;
            font-family: system-ui, sans-serif;
            background: var(--bg);
            color: var(--tx);
            line-height: 1.5
        }

        a {
            color: var(--g);
            text-decoration: none;
        }

        main {
            padding: 28px 5%;
            max-width: 1200px;
            margin: auto
        }

        .hero {
            background: linear-gradient(135deg, #1f5a37, #2f7d4f);
            color: #fff;
            padding: 48px 5%
        }

        .hero h1 {
            margin: 0 0 8px;
            font-size: clamp(1.8rem, 4vw, 2.8rem)
        }

        .g {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(210px, 1fr));
            gap: 14px
        }

        .c {
            background: var(--cd);
            border: 1px solid var(--bd);
            border-radius: 14px;
            padding: 16px
        }

        .c .e {
            font-size: 3rem;
            text-align: center
        }

        .e img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 10px
        }

        .btn,
        button {
            background: var(--g);
            color: #fff;
            border: 0;
            border-radius: 10px;
            padding: 9px 14px;
            font: inherit;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-block
        }

        input,
        textarea {
            width: 100%;
            padding: 9px;
            margin: 4px 0 10px;
            border-radius: 8px;
            border: 1px solid var(--bd);
            background: var(--bg);
            color: var(--tx);
            font: inherit
        }

        table {
            width: 100%;
            border-collapse: collapse
        }

        td,
        th {
            padding: 8px;
            border-bottom: 1px solid var(--bd);
            text-align: left
        }

        .tag {
            font-size: .75rem;
            border: 1px solid var(--bd);
            border-radius: 99px;
            padding: 2px 8px;
            margin-right: 4px
        }

        .err {
            color: #c0392b
        }

        footer {
            padding: 24px 5%;
            color: var(--mu);
            font-size: .85rem;
            border-top: 1px solid var(--bd)
        }

        /* ---------- NAV ---------- */
        nav {
            position: sticky;
            top: 0;
            z-index: 20;
            background: var(--bg);
            display: flex;
            align-items: center;
            gap: 18px;
            padding: 14px 5%;
            border-bottom: 1px solid var(--bd)
        }

        nav .brand {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--g);
            margin-right: auto;
            text-decoration: none
        }

        .links {
            display: flex;
            align-items: center;
            gap: 20px
        }

        .links a {
            color: var(--tx);
            text-decoration: none
        }

        .links a:hover,
        .links a.on {
            color: var(--g);
            font-weight: 700
        }

        .burger,
        .close {
            display: none;
            background: none;
            color: var(--tx);
            border: 1px solid var(--bd);
            padding: 6px 11px;
            font-size: 1.3rem;
            line-height: 1
        }

        .scrim {
            display: none
        }

        @media(max-width:768px) {
            .burger {
                display: block
            }

            .links {
                position: fixed;
                top: 0;
                right: 0;
                height: 100vh;
                height: 100dvh;
                width: min(280px, 82%);
                background: var(--cd);
                flex-direction: column;
                align-items: stretch;
                gap: 0;
                padding: 72px 20px 20px;
                border-left: 1px solid var(--bd);
                box-shadow: -8px 0 24px rgba(0, 0, 0, .18);
                transform: translateX(105%);
                transition: transform .25s ease;
                z-index: 30;
                overflow-y: auto
            }

            .links a {
                padding: 15px 4px;
                border-bottom: 1px solid var(--bd);
                font-size: 1.05rem
            }

            .close {
                display: block;
                position: absolute;
                top: 14px;
                right: 14px
            }

            .scrim {
                display: block;
                position: fixed;
                inset: 0;
                background: rgba(0, 0, 0, .45);
                opacity: 0;
                pointer-events: none;
                transition: opacity .25s;
                z-index: 25
            }

            body.menu .links {
                transform: none
            }

            body.menu .scrim {
                opacity: 1;
                pointer-events: auto
            }

            body.menu {
                overflow: hidden
            }
        }
    </style>
    @yield('style')
</head>

<body>
    <nav>
        <a class="brand" href="/">🌱 HijauBumi</a>
        <button class="burger" id="burger" aria-label="Buka menu" aria-controls="links" aria-expanded="false">☰</button>
        <div class="scrim"></div>
        <div class="links" id="links">
            <button class="close" aria-label="Tutup menu">✕</button>
            <a href="/" class="{{ request()->is('/') ? 'on' : '' }}">Beranda</a>
            <a href="/produk" class="{{ request()->is('produk*') ? 'on' : '' }}">Produk</a>
            <a href="/sdg" class="{{ request()->is('sdg') ? 'on' : '' }}">Dampak &amp; SDGs</a>
            <a href="/keranjang" class="{{ request()->is('keranjang') ? 'on' : '' }}">Keranjang
                ({{ array_sum(session('cart', [])) }})</a>
            <a href="/masuk" class="{{ request()->is('masuk') ? 'on' : '' }}">Login</a>
        </div>
    </nav>
    @yield('hero')<main>@yield('c')</main>
    <footer>© 2026 HijauBumi · Pembayaran via Midtrans · Angka serapan CO₂ adalah estimasi edukatif.</footer>
    <script>
        (() => {
            const b = document.body,
                t = document.getElementById('burger');
            const set = o => {
                b.classList.toggle('menu', o);
                t.setAttribute('aria-expanded', o)
            };
            t.onclick = () => set(!b.classList.contains('menu'));
            document.querySelectorAll('.scrim,.close,.links a').forEach(e => e.onclick = () => set(false));
            addEventListener('keydown', e => e.key === 'Escape' && set(false));
            matchMedia('(min-width:769px)').onchange = e => e.matches && set(false);
        })();
    </script>
</body>

</html>
