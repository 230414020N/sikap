<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Hubungi Kami - SIKAP</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Google Font --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    {{-- Icons --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: #fff;
            color: #111;
        }

        /* ================= HEADER ================= */
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 18px 60px;
        }

        .logo {
            font-weight: 700;
            font-size: 26px;
            letter-spacing: 1px;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 24px;
            font-size: 14px;
        }

        .btn-company {
            background: #e5e5e5;
            padding: 10px 18px;
            border-radius: 20px;
            font-weight: 500;
        }

        /* ================= HERO ================= */
        .hero {
            background: #4a4a4a;
            color: white;
            text-align: center;
            padding: 80px 20px 120px;
            position: relative;
        }

        .hero h1 {
            font-size: 48px;
            font-weight: 700;
            letter-spacing: 2px;
        }

        .hero p {
            margin-top: 12px;
            font-size: 16px;
            font-weight: 300;
        }

        /* Wave */
        .wave {
            position: absolute;
            bottom: -1px;
            left: 0;
            width: 100%;
        }

        /* ================= CONTENT ================= */
        .content {
            display: flex;
            justify-content: space-between;
            padding: 80px 100px;
            gap: 60px;
        }

        .info {
            flex: 1;
        }

        .info-item {
            display: flex;
            gap: 16px;
            margin-bottom: 32px;
        }

        .info-item i {
            font-size: 22px;
            margin-top: 4px;
        }

        .info-item h4 {
            font-size: 18px;
            font-weight: 600;
        }

        .info-item p {
            font-size: 15px;
            margin-top: 4px;
        }

        /* ================= IMAGE ================= */
        .image-box {
            flex: 1;
            display: flex;
            justify-content: center;
        }

        .image-box img {
            max-width: 420px;
        }

        /* ================= LOCATION ================= */
        .location {
            margin: 0 100px 80px;
            background: #e5e5e5;
            border-radius: 14px;
            padding: 26px 30px;
            display: flex;
            gap: 16px;
            align-items: flex-start;
        }

        .location i {
            font-size: 22px;
            margin-top: 3px;
        }

        .location h4 {
            font-size: 18px;
            font-weight: 600;
        }

        .location p {
            font-size: 15px;
            margin-top: 6px;
        }

        /* ================= FOOTER ================= */
        footer {
            text-align: center;
            font-size: 13px;
            padding-bottom: 30px;
        }

        /* ================= RESPONSIVE ================= */
        @media (max-width: 900px) {
            .content {
                flex-direction: column;
                padding: 60px 30px;
            }

            .location {
                margin: 0 30px 60px;
            }

            header {
                padding: 18px 30px;
            }

            .hero h1 {
                font-size: 36px;
            }
        }
    </style>
</head>
<body>

{{-- HEADER --}}
<header>
    <div class="logo">SIKAP.</div>
    <div class="header-right">
        <a href="{{ route('home') }}">Beranda</a>
        <a href="{{ route('login') }}"><span><i class="fa-solid fa-circle-question"></i> Registrasi / Masuk</span></a>
        <a href="{{ route('perusahaan.register') }}"><div class="btn-company">Untuk Perusahaan</div></a>
    </div>
</header>

{{-- HERO --}}
<section class="hero">
    <h1>HUBUNGI KAMI</h1>
    <p>Kami hadir untuk membantu Anda</p>
</section>

{{-- CONTENT --}}
<section class="content">
    <div class="info">

        <div class="info-item">
            <i class="fa-regular fa-envelope"></i>
            <div>
                <h4>E-mail</h4>
                <p>sikap123@gmail.com</p>
            </div>
        </div>

        <div class="info-item">
            <i class="fa-brands fa-whatsapp"></i>
            <div>
                <h4>WhatsApp</h4>
                <p>PM : 1234567890<br>SA : 1234567890</p>
            </div>
        </div>

        <div class="info-item">
            <i class="fa-regular fa-clock"></i>
            <div>
                <h4>Operasional</h4>
                <p>Setiap Hari<br>08.00 - 17.00 WIB</p>
            </div>
        </div>

    </div>

    <div class="image-box">
        {{-- Ganti path image sesuai folder public --}}
        <img src="{{ asset('images/hero-img.png') }}" alt="Customer Service">
    </div>
</section>

{{-- LOCATION --}}
<section class="location">
    <i class="fa-solid fa-location-dot"></i>
    <div>
        <h4>Bandung</h4>
        <p>Jl. Soekarno Hatta no. 456. Bandung 40266 , Jawa Barat</p>
    </div>
</section>

{{-- FOOTER --}}
<footer>
    © 2025, Sistem Informasi Karier dan Portofolio
</footer>

</body>
</html>
