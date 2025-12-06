<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web Game IQRAIN</title>
    <link href="https://fonts.googleapis.com/css2?family=Titan+One&family=Mooli&display=swap" rel="stylesheet">

    <style>
        * {
            scroll-behavior: smooth;
        }

        /* =========================================
           1. VARIABEL & GLOBAL STYLES
           ========================================= */
        :root {
            --color-blue-dark: #234275;
            --color-blue-primary: #4a94d9;
            --color-pink-accent: #F387A9;
            --color-yellow-button: #FFEB3B;
            --color-red-button: #FF6B6B;
            --color-white: #FFFFFF;
            --color-text-dark: #2F2F2F;
            --color-text-light: #555555;
            --color-background-main: #F4F6F9;
            --color-card-light-blue: #E4F2FF;
        }

        body {
            font-family: 'Titan One', 'Mooli', sans-serif;
            margin: 0;
            background-color: var(--color-background-main);
            color: var(--color-blue-dark);
            overflow-x: hidden;
            scroll-behavior: smooth;
        }

        p,
        .navbar-links a,
        .navbar-login,
        .hero-button,
        .cta-button,
        .footer-info,
        .intro-text-content,
        .goal-list,
        .card-description {
            font-family: 'Mooli', sans-serif;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 50px;
            position: relative;
        }

        /* =========================================
           2. HEADER & NAVBAR
           ========================================= */
        .navbar-hero {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 30px 0;
            position: relative;
            z-index: 100;
            pointer-events: none;
        }

        .navbar-logo,
        .navbar-login,
        .navbar-box-wrapper {
            pointer-events: auto;
        }

        .logo-image {
            height: 40px;
            width: auto;
        }

        .navbar-box-wrapper {
            background-color: var(--color-white);
            padding: 5px 5px;
            border-radius: 100px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            position: fixed;
            top: 30px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 1000;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .navbar-links {
            display: flex;
            align-items: center;
            margin: 0;
            padding: 0;
        }

        .navbar-links a {
            padding: 10px 25px;
            text-decoration: none;
            color: var(--color-blue-dark);
            font-weight: 700;
            font-size: 16px;
            border-radius: 100px;
            transition: all 0.3s ease;
        }

        .navbar-links a.active-nav {
            background-color: var(--color-blue-dark);
            color: var(--color-white);
            box-shadow: 0 2px 5px rgba(35, 66, 117, 0.3);
        }

        .navbar-links a:hover:not(.active-nav) {
            background-color: #f0f0f0;
        }

        .navbar-login {
            background: #F387A9;
            border-radius: 100px;
            color: #FFF;
            padding: 10px 30px;
            text-decoration: none;
            font-weight: 700;
            box-shadow: 0 4px 4px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
        }

        .navbar-login:hover {
            transform: scale(1.05);
        }

        /* =========================================
           3. HERO SECTION
           ========================================= */
        .hero-section {
            background-image: url("{{ asset('images/landing/landing-background.webp') }}");
            background-size: 100% 100%;
            background-position: top center;
            background-repeat: no-repeat;
            padding-bottom: 350px;
            color: var(--color-white);
            position: relative;
            border-radius: 0;
        }

        .hero-content-wrapper {
            display: flex;
            padding-top: 80px;
            align-items: center;
        }

        .hero-content {
            max-width: 50%;
            z-index: 10;
        }

        .hero-content h1 {
            font-size: 70px;
            line-height: 1.1;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
        }

        .hero-content p {
            font-size: 18px;
            margin-bottom: 30px;
            max-width: 90%;
            line-height: 1.6;
        }

        .hero-button {
            background: #F387A9;
            border-radius: 100px;
            color: var(--color-white);
            padding: 15px 40px;
            text-decoration: none;
            font-weight: 700;
            font-size: 20px;
            display: inline-block;
            box-shadow: 0 4px 4px rgba(0, 0, 0, 0.1);
        }

        .hero-image {
            position: absolute;
            right: 0;
            top: 50%;
            transform: translateY(-40%);
            width: 50%;
            max-width: 600px;
            z-index: 5;
        }

        .hero-image img {
            width: 100%;
            height: auto;
        }

        /* =========================================
           4. INTRO SECTION (YUK KENALAN & TUJUAN QIRA)
           ========================================= */
        .intro-section-wrapper {
            position: relative;
            margin-top: -180px;
            z-index: 20;
            display: flex;
            justify-content: center;
            padding-bottom: 50px;
            scroll-margin-top: 120px;
        }

        .intro-flex-container {
            display: flex;
            justify-content: center;
            /* Kunci agar konten ada di tengah horizontal */
            align-items: center;
            /* Agar sejajar secara vertikal */
            gap: 50px;
            /* Jarak antar kartu (White & Pink) */
            position: relative;
            /* Penting: Agar hiasan absolute mengacu ke kotak ini */
            max-width: 1000px;
            /* Batasi lebar agar tidak terlalu melebar */
            margin: 0 auto;
            /* Pastikan container itu sendiri ada di tengah halaman */
            padding: 40px 20px;
        }

        .decor-top-left {
            position: absolute;
            top: -30px;
            left: -40px;
            width: 120px;
            z-index: 25;
        }

        .decor-bottom-right {
            position: absolute;
            bottom: -30px;
            right: -30px;
            width: 100px;
            z-index: 25;
        }

        .card-white-wrapper {
            position: relative;
            width: 700px;
            z-index: 10;
            margin-right: -80px;
        }

        .bg-img-white {
            width: 105%;
            height: auto;
            display: block;
            filter: drop-shadow(6px 0 10px rgba(0, 0, 0, 0.15));
        }

        .content-white {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            padding: 20px 40px;
            box-sizing: border-box;
            gap: 30px;
        }

        .mascot-intro {
            width: 40%;
            height: auto;
            flex-shrink: 0;
            margin-left: -10px;
            margin-right: 10px;
            transform: scale(1.5) translateY(-25px);
            position: relative;
            z-index: 50;
        }

        .text-intro-white {
            width: 55%;
            flex: 1;
            padding-right: 5px;
        }

        .text-intro-white h2 {
            font-family: 'Titan One';
            color: var(--color-blue-dark);
            font-size: 28px;
            font-weight: 400;
            margin-bottom: 10px;
            margin-top: 0;
            line-height: 1.1;
        }

        .qira-highlight {
            font-size: 50px;
            display: block;
            line-height: 1;
        }

        .text-intro-white p {
            font-family: 'Mooli', sans-serif;
            font-size: 18px;
            color: var(--color-blue-dark);
            line-height: 28px;
            margin: 0;
            font-weight: 400;
        }

        .card-pink-wrapper {
            position: relative;
            width: 580px;
            z-index: 5;
            margin-top: 20px;
        }

        .bg-img-pink {
            width: 100%;
            height: auto;
            display: block;
            filter: drop-shadow(6px 0 10px rgba(0, 0, 0, 0.15));
        }

        .content-pink {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            padding: 40px 40px 40px 90px;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .content-pink h2 {
            font-family: 'Titan One';
            color: var(--color-white);
            font-size: 36px;
            font-weight: 400;
            margin-bottom: 20px;
            margin-top: 0;
        }

        .goal-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .goal-list li {
            display: flex;
            align-items: flex-start;
            margin-bottom: 20px;
            color: var(--color-white);
            font-family: 'Mooli', sans-serif;
            font-size: 18px;
            font-weight: 400;
            line-height: 28px;
        }

        .check-icon {
            width: 24px;
            height: auto;
            margin-right: 15px;
            flex-shrink: 0;
            margin-top: 2px;
        }

        /* =========================================
           SECTION BARU: TUJUAN PEMBELAJARAN
           ========================================= */
        .learning-goals-section {
            padding: 40px 0 80px 0;
            position: relative;
            background-color: transparent;
        }

        .learning-flex-container {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            gap: 60px;
        }

        .goals-card {
            flex: 1;
            max-width: 650px;
            background-color: #E4F2FF;
            border-radius: 20px;
            padding: 10px 0;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        .goal-item {
            background-color: transparent;
            border-bottom: 1px solid rgba(35, 66, 117, 0.1);
            margin: 0;
            border-radius: 0;
            box-shadow: none;
            transition: background-color 0.3s ease;
        }

        .goal-item:last-child {
            border-bottom: none;
        }

        .goal-item.active {
            background-color: rgba(255, 255, 255, 0.5);
        }

        .goal-header {
            padding: 20px 30px;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-family: 'Titan One', cursive;
            color: var(--color-blue-dark);
            font-size: 18px;
            user-select: none;
        }

        .goal-header:hover {
            color: var(--color-pink-accent);
        }

        .goal-header .icon {
            font-size: 20px;
            margin-left: 10px;
            color: var(--color-pink-accent);
            transition: transform 0.3s;
        }

        .goal-header .icon {
            font-size: 24px;
            font-weight: bold;
            color: var(--color-pink-accent);
            transition: transform 0.3s ease;
        }

        .goal-item.active .goal-header .icon {
            transform: rotate(45deg);
            color: var(--color-red-button);
        }

        .goal-description {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.4s ease-out, padding 0.4s ease;
            padding: 0 30px;
        }

        .goal-item.active .goal-description {
            max-height: 200px;
            padding: 0 30px 20px 30px;
        }

        .goal-description p {
            font-family: 'Mooli', sans-serif;
            color: var(--color-text-light);
            font-size: 15px;
            line-height: 1.6;
            margin: 0;
        }

        .learning-title-wrapper {
            flex: 0 0 350px;
            padding-top: 20px;
            text-align: left;
        }

        .goals-static-title {
            font-family: 'Titan One', cursive;
            color: var(--color-blue-dark);
            font-size: 48px;
            line-height: 1.2;
            margin: 0;
            text-shadow: 2px 2px 0px rgba(255, 255, 255, 0.5);
        }

        /* =========================================
           5. FITUR SECTION
           ========================================= */
        .features-section {
            padding: 80px 0;
            text-align: center;
            position: relative;
            scroll-margin-top: 100px;
            padding-bottom: 50px;
            /* Tambahan padding dalam */
            margin-bottom: 80px;
            /* Tambahan jarak luar ke section berikutnya */
        }

        .features-section h2 {
            font-size: 48px;
            color: var(--color-text-dark);
            position: relative;
            z-index: 5;
            margin: 0;
            display: inline-block;
        }

        .seru-highlight {
            position: relative;
            display: inline-block;
            z-index: 5;
        }

        .seru-highlight::after {
            content: '';
            position: absolute;
            bottom: 8px;
            left: -5px;
            right: -5px;
            height: 20px;
            background: var(--color-pink-accent);
            opacity: 0.5;
            z-index: -1;
            border-radius: 5px;
        }

        .lampu-icon {
            position: absolute;
            top: -50px;
            right: -50px;
            width: 70px;
            height: auto;
            z-index: 10;
            transform: rotate(10deg);
        }

        .feature-cards {
            display: flex;
            justify-content: center;
            gap: 110px;
            margin-top: 60px;
            flex-wrap: wrap;
        }

        .card {
            background: #E4F2FF;
            border-radius: 26px;
            box-shadow: 0 4px 10px 0 rgba(0, 0, 0, 0.40);
            width: 320px;
            min-height: 140px;
            height: 140px;
            position: relative;
            overflow: visible;
            transition: height 0.4s ease;
            display: flex;
            flex-direction: row;
            align-items: flex-start;
            justify-content: space-between;
            padding: 30px 10px 0px 30px;
            box-sizing: border-box;
        }

        .card.active {
            height: auto;
            padding-bottom: 70px;
        }

        .card-text {
            position: relative;
            z-index: 10;
            text-align: left;
            flex: 1;
            padding-right: 10px;
            max-width: 50%;
        }

        .card h3 {
            color: var(--color-text-dark);
            margin: 0;
            font-size: 32px;
            font-family: 'Titan One';
            margin-bottom: 5px;
        }

        .card-description {
            font-size: 16px;
            color: #555;
            line-height: 1.4;
            display: none;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .card.active .card-description {
            display: block;
            opacity: 1;
        }

        .card-img {
            width: 260px;
            height: auto;
            z-index: 15;
            position: absolute;
            right: -70px;
            bottom: -50px;
            pointer-events: none;
        }

        .btn-plus {
            position: absolute;
            bottom: 10px;
            left: 20px;
            width: 40px;
            height: 40px;
            background: var(--color-red-button);
            border-radius: 50%;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            text-decoration: none;
            z-index: 20;
            font-family: 'Titan One';
            border: none;
            cursor: pointer;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        .btn-plus:hover {
            background: #e05e5e;
        }

        /* Opsi 1: Memberi jarak di bawah section Fitur */
        #fitur {
            margin-bottom: 100px;
            /* Sesuaikan nilai 100px sesuai keinginan */
        }

        /* ATAU Opsi 2: Memberi jarak di atas section Panduan */
        #panduan {
            margin-top: 100px;
            /* Sesuaikan nilai 100px sesuai keinginan */
        }

        /* =========================================
           6. PANDUAN SECTION
           ========================================= */
        .guide-section {
            background-color: #56B1F3;
            padding: 80px 0;
            position: relative;
            color: var(--color-white);
            overflow: hidden;
            scroll-margin-top: 100px;
        }

        .guide-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url("{{ asset('images/games/game-pattern.webp') }}");
            background-repeat: repeat;
            background-size: 1200px;
            opacity: 0.1;
            z-index: 0;
            pointer-events: none;
        }

        .guide-section .container {
            position: relative;
            z-index: 1;
        }

        .guide-header {
            margin-bottom: 40px;
            text-align: left;
        }

        .guide-header h2 {
            font-size: 48px;
            margin-bottom: 10px;
            font-family: 'Titan One';
        }

        .guide-header p {
            font-size: 18px;
            opacity: 0.9;
        }

        .guide-container {
            display: flex;
            border-radius: 30px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            background: var(--color-white);
            min-height: 320px;
            width: 100%;
        }

        .guide-nav {
            width: 260px;
            background-color: var(--color-pink-accent);
            padding: 30px 20px;
            display: flex;
            flex-direction: column;
            gap: 15px;
            flex-shrink: 0;
            justify-content: center;
        }

        .guide-btn {
            background-color: #4a94d9;
            color: var(--color-white);
            border: none;
            padding: 15px 20px;
            border-radius: 50px;
            font-family: 'Titan One';
            font-size: 18px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
            position: relative;
            outline: none;
            overflow: hidden;
        }

        .guide-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url("{{ asset('images/games/game-pattern.webp') }}");
            background-size: 400px;
            background-blend-mode: soft-light;
            opacity: 0.1;
            z-index: 0;
            pointer-events: none;
        }

        .guide-btn span {
            position: relative;
            z-index: 1;
        }

        .guide-btn:hover {
            transform: scale(1.05);
            background-color: #4285c4;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }

        .guide-btn.active {
            background-color: var(--color-yellow-button);
            color: var(--color-white);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .guide-btn.active::after {
            content: '▶';
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 14px;
            color: var(--color-white);
            z-index: 2;
        }

        .guide-content-area {
            flex: 1;
            background-color: var(--color-white);
            padding: 30px 40px;
            display: flex;
            align-items: center;
            position: relative;
        }

        .guide-step {
            display: none;
            width: 100%;
            animation: fadeIn 0.5s ease;
        }

        .guide-step.active {
            display: block;
        }

        .step-layout {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 30px;
        }

        .step-info {
            flex: 1;
            color: var(--color-text-dark);
        }

        .step-title-row {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
        }

        .step-number {
            background-color: var(--color-yellow-button);
            color: var(--color-white);
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Titan One';
            font-size: 24px;
            flex-shrink: 0;
        }

        .step-info h3 {
            font-family: 'Titan One';
            font-size: 28px;
            color: var(--color-blue-dark);
            margin: 0;
        }

        .step-info p {
            font-size: 16px;
            line-height: 1.6;
            color: #555;
        }

        .step-image img {
            width: 320px;
            height: auto;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* =========================================
           7. FOOTER & CTA SECTION
           ========================================= */
        .footer-cta {
            background-image: url("{{ asset('images/landing/landing-footer.webp') }}");
            background-repeat: no-repeat;
            background-position: center 40%;
            background-size: 100% auto;
            width: 100%;
            padding-bottom: 54%;
            position: relative;
            margin-top: 50px;
            height: 0;
            overflow: hidden;
        }

        .footer-content-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
        }

        .footer-top-content {
            text-align: left;
            padding-top: 6vw;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            width: 100%;
            padding-left: 15vw;
            box-sizing: border-box;
        }

        .footer-cta h2 {
            font-family: 'Titan One', cursive;
            font-size: 4vw;
            color: var(--color-blue-dark);
            margin-bottom: 1vw;
            margin-top: 0;
        }

        .footer-cta p {
            font-family: 'Mooli', sans-serif;
            font-size: 1.5vw;
            color: #6c757d;
            margin-bottom: 2.5vw;
        }

        .btn-yellow-cta {
            background-color: var(--color-yellow-button);
            color: var(--color-white);
            padding: 1vw 3.5vw;
            font-size: 1.5vw;
            border-radius: 50px;
            font-family: 'Mooli', sans-serif;
            font-weight: 700;
            text-decoration: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
            display: inline-block;
        }

        .btn-yellow-cta:hover {
            transform: scale(1.05);
            background-color: #fdd835;
        }

        /* --- FOOTER BOTTOM AREA (MODIFIKASI USER) --- */
        .footer-bottom-content {
            text-align: center;
            padding-bottom: 2vw;
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* 1. Indikator Garis & Titik */
        .footer-indicator {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-bottom: 15px;
        }

        .line {
            height: 4px;
            width: 40px;
            background: white;
            border-radius: 4px;
        }

        .line.yellow {
            background: #FFEB3B;
        }

        .dot {
            width: 16px;
            height: 16px;
            background: #4a94d9;
            border-radius: 50%;
        }

        /* 2. Social Media Icons */
        .footer-social {
            display: flex;
            gap: 15px;
            margin-bottom: 15px;
        }

        .social-icon {
            display: flex;
            width: 36px;
            height: 36px;
            background-color: white;
            border-radius: 50%;
            align-items: center;
            justify-content: center;
            color: var(--color-blue-dark);
            transition: transform 0.2s;
        }

        .social-icon img {
            width: 20px;
            height: auto;
        }

        .social-icon:hover {
            transform: scale(1.1);
            color: var(--color-pink-accent);
        }

        .social-icon svg {
            width: 20px;
            height: 20px;
            fill: currentColor;
        }

        /* 3. Copyright */
        .footer-info {
            color: var(--color-white);
            font-family: 'Mooli', sans-serif;
            font-size: 14px;
            margin: 0;
            line-height: 1.6;
        }

        .dark-text {
            font-weight: bold;
            color: #234275;
        }

        /* Responsive Styles Global */
        @media (max-width: 992px) {
            .container {
                padding: 0 20px;
            }

            .hero-content-wrapper {
                flex-direction: column;
                text-align: center;
            }

            .hero-content {
                max-width: 100%;
                margin-bottom: 40px;
            }

            .hero-image {
                position: relative;
                width: 80%;
                transform: none;
            }

            .intro-flex-container {
                flex-direction: column;
            }

            .card-white-wrapper {
                width: 100%;
                margin-right: 0;
                margin-bottom: -50px;
            }

            .content-white {
                flex-direction: column;
                text-align: center;
                padding: 40px 20px;
            }

            .mascot-intro {
                width: 250px;
                /* Reset size for mobile */
                margin-left: 0;
                transform: none;
            }

            .text-intro-white {
                width: 100%;
                padding-right: 0;
            }

            .text-intro-white h2 {
                font-size: 28px;
            }

            .qira-highlight {
                font-size: 48px;
            }

            .text-intro-white p {
                font-size: 16px;
            }

            .card-pink-wrapper {
                width: 90%;
                margin-top: 0;
            }

            .content-pink {
                padding: 80px 40px 40px 40px;
            }

            .decor-top-left {
                left: 0;
            }

            .decor-bottom-right {
                right: 0;
            }

            .navbar-box-wrapper {
                bottom: 20px;
                top: auto;
                padding: 5px 10px;
            }

            .feature-cards {
                gap: 60px;
            }

            .card {
                width: 90%;
                max-width: 350px;
                overflow: visible;
                padding-bottom: 0;
                height: 140px;
            }

            .card.active {
                padding-bottom: 70px;
            }

            .card-img {
                width: 200px;
                right: -30px;
                bottom: -20px;
            }

            .card-text {
                max-width: 60%;
            }

            .btn-plus {
                left: 20px;
                bottom: 10px;
            }

            .guide-container {
                flex-direction: column;
            }

            .guide-nav {
                width: 100%;
                flex-direction: row;
                overflow-x: auto;
                padding: 20px;
                box-sizing: border-box;
                justify-content: flex-start;
            }

            .guide-btn {
                flex: 1;
                min-width: 120px;
                font-size: 16px;
            }

            .guide-btn.active::after {
                content: none;
            }

            .step-layout {
                flex-direction: column-reverse;
                text-align: center;
            }

            .step-title-row {
                justify-content: center;
            }

            .step-image img {
                width: 250px;
                margin-bottom: 20px;
            }

            .learning-flex-container {
                flex-direction: column-reverse;
                align-items: center;
                gap: 30px;
            }

            .learning-title-wrapper {
                width: 100%;
                text-align: center;
            }

            .goals-card {
                width: 100%;
            }

            .footer-top-content {
                padding-left: 10vw;
            }

            .footer-info {
                font-size: 12px;
            }
        }
    </style>
</head>

<body>

    <main>
        <section id="beranda" class="hero-section">
            <div class="navbar-hero container">
                <div class="navbar-logo">
                    {{-- LOGO DUMMY --}}
                    <img src="{{ asset('images/asset/logo.webp') }}" style="height: 50px; width: auto; object-fit: contain;"
                        alt="IQRAIN Logo">
                </div>
                <div class="navbar-box-wrapper">
                    <nav class="navbar-links">
                        <a href="#beranda" class="active-nav">Beranda</a>
                        <a href="#tujuan">Tujuan</a>
                        <a href="#fitur">Fitur</a>
                        <a href="#panduan">Panduan</a>
                    </nav>
                </div>
                <a href="{{ route('login') }}" class="navbar-login">Login</a>
            </div>

            <div class="hero-content-wrapper container">
                <div class="hero-content">
                    <h1>Web Game<br>IQRAIN</h1>
                    <p>Belajar bareng Qira lewat permainan interaktif, video seru, dan kartu visual yang mudah dipahami
                        semua anak!</p>
                    <a href="{{ route('login') }}" class="hero-button">Mulai Bermain</a>
                </div>
                <div class="hero-image">
                    <img src="{{ asset('images/maskot/naik-mobil.webp') }}" alt="Mascot">
                </div>
            </div>
        </section>

        <div id="tujuan" class="intro-section-wrapper container">
            <div class="intro-flex-container">
                <img src="{{ asset('images/landing/tujuan-atas.webp') }}" alt="Decor" class="decor-top-left">
                <div class="card-white-wrapper">
                    <img src="{{ asset('images/landing/yuk-kenalan.webp') }}" alt="Background White"
                        class="bg-img-white">
                    <div class="content-white">
                        <img src="{{ asset('images/maskot/qira-happy.webp') }}" alt="Qira Mascot" class="mascot-intro"
                            onerror="this.src='{{ asset('gambar_rpl/Group 7.webp') }}'">
                        <div class="text-intro-white">
                            <h2>Yuk, kenalan sama <br><span class="qira-highlight">QIRA!</span></h2>
                            <p>QIRA adalah maskot dari website Iqrain, tempat belajar Iqra untuk teman-teman tuna rungu.
                                Ia ramah, ceria, dan selalu semangat menemani belajar agar makin seru dan berwarna!</p>
                        </div>
                    </div>
                </div>
                <div class="card-pink-wrapper">
                    <img src="{{ asset('images/landing/tujuan-qira.webp') }}" alt="Background Pink"
                        class="bg-img-pink">
                    <div class="content-pink">
                        <h2>Tujuan QIRA</h2>
                        <ul class="goal-list">
                            <li>
                                <img src="{{ asset('images/landing/centang.webp') }}" alt="Check"
                                    class="check-icon">
                                <span>Membuat belajar Iqra mudah dipahami semua anak</span>
                            </li>
                            <li style="padding-left: 10px;">
                                <img src="{{ asset('images/landing/centang.webp') }}" alt="Check"
                                    class="check-icon">
                                <span>Menemani belajar dengan cara yang seru dan ramah</span>
                            </li>
                            <li>
                                <img src="{{ asset('images/landing/centang.webp') }}" alt="Check"
                                    class="check-icon">
                                <span>Menumbuhkan semangat dan rasa percaya diri</span>
                            </li>
                        </ul>
                    </div>
                    <img src="{{ asset('images/landing/tujuan-bawah.webp') }}" alt="Decor"
                        class="decor-bottom-right">
                </div>
            </div>
        </div>

        <section class="learning-goals-section container">
            <div class="learning-flex-container">

                <div class="goals-card">

                    <div class="goal-item">
                        <div class="goal-header">
                            1. Menguasai Isyarat Tangan (Kinestetik)
                            <span class="icon">+</span>
                        </div>
                        <div class="goal-description">
                            <p>Setelah modul ini, anak mampu mengaitkan setiap huruf hijaiyah dengan gerakan isyarat
                                tangan yang benar, memperkuat memori melalui gerakan fisik.</p>
                        </div>
                    </div>

                    <div class="goal-item">
                        <div class="goal-header">
                            2. Pengenalan Huruf Hijaiyah (Visual & Auditorial)
                            <span class="icon">+</span>
                        </div>
                        <div class="goal-description">
                            <p>Peserta didik dapat mengenali bentuk visual dan melafalkan suara setiap huruf
                                hijaiyah dengan tepat, sesuai kaidah tajwid dasar.</p>
                        </div>
                    </div>

                    <div class="goal-item">
                        <div class="goal-header">
                            3. Penerapan dalam Permainan (Interaktif)
                            <span class="icon">+</span>
                        </div>
                        <div class="goal-description">
                            <p>Meningkatkan kemampuan pemecahan masalah dan kecepatan respons anak melalui permainan
                                yang melibatkan identifikasi dan pengucapan huruf.</p>
                        </div>
                    </div>

                    <div class="goal-item">
                        <div class="goal-header">
                            4. Membangun Percaya Diri (Afektif)
                            <span class="icon">+</span>
                        </div>
                        <div class="goal-description">
                            <p>Melalui sistem peringkat dan umpan balik positif, anak termotivasi dan merasa bangga
                                atas pencapaiannya dalam belajar Al-Qur'an.</p>
                        </div>
                    </div>

                </div>

                <div class="learning-title-wrapper">
                    <h3 class="goals-static-title">Tujuan<br>Pembelajaran</h3>
                </div>

            </div>
        </section>


        <section id="fitur" class="features-section container">

            <div class="features-header-wrapper">
                <h2>
                    Fitur
                    <span class="seru-highlight">
                        Seru
                        <img src="{{ asset('images/landing/lampu.webp') }}" alt="Idea Lamp" class="lampu-icon">
                    </span>
                </h2>
            </div>

            <p>Yuk kenali fitur-fitur seru yang bisa kamu coba</p>

            <div class="feature-cards">

                <div class="card" id="card-modul">
                    <div class="card-text">
                        <h3>Modul</h3>
                        <p class="card-description">Belajar Iqra jadi lebih seru dan interaktif!</p>
                    </div>
                    <img src="{{ asset('images/maskot/ngaji-bareng.webp') }}" class="card-img">
                    <button class="btn-plus" onclick="toggleCard('card-modul')">+</button>
                </div>

                <div class="card" id="card-game">
                    <div class="card-text">
                        <h3>Game</h3>
                        <p class="card-description">Asah kemampuan lewat permainan yang seru!</p>
                    </div>
                    <img src="{{ asset('images/maskot/susun-balok.webp') }}" class="card-img">
                    <button class="btn-plus" onclick="toggleCard('card-game')">+</button>
                </div>

                <div class="card" id="card-rank">
                    <div class="card-text">
                        <h3>Rank</h3>
                        <p class="card-description">Main bareng teman dan lihat siapa yang jadi juara!</p>
                    </div>
                    <img src="{{ asset('images/maskot/bawa-hp.webp') }}" class="card-img">
                    <button class="btn-plus" onclick="toggleCard('card-rank')">+</button>
                </div>

            </div>
        </section>

        <section id="panduan" class="guide-section">
            <div class="container">

                <div class="guide-header">
                    <h2>Panduan Bermain</h2>
                    <p>Ikuti langkah di bawah ini untuk bermain</p>
                </div>

                <div class="guide-container">
                    <div class="guide-nav">
                        <button class="guide-btn active" onclick="showStep('login', this)"><span>Login</span></button>
                        <button class="guide-btn" onclick="showStep('belajar', this)"><span>Belajar</span></button>
                        <button class="guide-btn" onclick="showStep('games', this)"><span>Games</span></button>
                        <button class="guide-btn"
                            onclick="showStep('peringkat', this)"><span>Peringkat</span></button>
                    </div>

                    <div class="guide-content-area">

                        <div id="step-login" class="guide-step active">
                            <div class="step-layout">
                                <div class="step-info">
                                    <div class="step-title-row">
                                        <div class="step-number">1</div>
                                        <h3>Login Atau Daftar Dulu</h3>
                                    </div>
                                    <p>Gunakan akun dari mentor atau buat akun sendiri biar bisa mulai belajar.</p>
                                </div>
                                <div class="step-image">
                                    <img src="{{ asset('images/maskot/main-drum.webp') }}" alt="Mascot Drum">
                                </div>
                            </div>
                        </div>

                        <div id="step-belajar" class="guide-step">
                            <div class="step-layout">
                                <div class="step-info">
                                    <div class="step-title-row">
                                        <div class="step-number">2</div>
                                        <h3>Belajar Huruf Hijaiyah</h3>
                                    </div>
                                    <p>Tonton video seru dengan panduan isyarat tangan supaya makin mudah dipahami.</p>
                                </div>
                                <div class="step-image">
                                    <img src="{{ asset('images/maskot/main-drum.webp') }}" alt="Mascot Drum">
                                </div>
                            </div>
                        </div>

                        <div id="step-games" class="guide-step">
                            <div class="step-layout">
                                <div class="step-info">
                                    <div class="step-title-row">
                                        <div class="step-number">3</div>
                                        <h3>Mainkan Gamenya</h3>
                                    </div>
                                    <p>Latih hafalan huruf lewat banyak permainan interaktif dan menyenangkan bersama
                                        Qira.</p>
                                </div>
                                <div class="step-image">
                                    <img src="{{ asset('images/maskot/main-drum.webp') }}" alt="Mascot Drum">
                                </div>
                            </div>
                        </div>

                        <div id="step-peringkat" class="guide-step">
                            <div class="step-layout">
                                <div class="step-info">
                                    <div class="step-title-row">
                                        <div class="step-number">4</div>
                                        <h3>Lihat Peringkatmu</h3>
                                    </div>
                                    <p>Yuk, cek skor kamu dan bandingkan dengan teman-teman lainnya.</p>
                                </div>
                                <div class="step-image">
                                    <img src="{{ asset('images/maskot/main-drum.webp') }}" alt="Mascot Drum">
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </section>

        <footer class="footer-cta">
            <div class="footer-content-overlay">

                <div class="footer-top-content">
                    <h2>Tunggu apalagi?</h2>
                    <p>Qira siap menemani belajarmu</p>
                    <a href="{{ route('login') }}" class="btn-yellow-cta">
                        Mulai Bermain
                    </a>
                </div>

                <div class="footer-bottom-content">
                    {{-- 1. Hiasan Garis dan Lingkaran --}}
                    <div class="footer-indicator">
                        <div class="line"></div>
                        <div class="line yellow"></div>
                        <div class="dot"></div>
                        <div class="line yellow"></div>
                        <div class="line"></div>
                    </div>

                    {{-- 2. Social Media Icons (Langsung di bawah garis) --}}
                    <div class="footer-social">
                        <a href="https://instagram.com" target="_blank" class="social-icon ig">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                <path
                                    d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z" />
                            </svg>
                        </a>
                        <a href="https://youtube.com" target="_blank" class="social-icon video">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                <path
                                    d="M549.655 124.083c-6.281-23.65-24.787-42.276-48.284-48.597C458.781 64 288 64 288 64S117.22 64 74.629 75.486c-23.497 6.322-42.003 24.947-48.284 48.597-11.412 42.867-11.412 132.305-11.412 132.305s0 89.438 11.412 132.305c6.281 23.65 24.787 41.5 48.284 47.821C117.22 448 288 448 288 448s170.78 0 213.371-11.486c23.497-6.321 42.003-24.171 48.284-47.821 11.412-42.867 11.412-132.305 11.412-132.305s0-89.438-11.412-132.305zm-317.51 213.508V175.185l142.739 81.205-142.739 81.201z" />
                            </svg>
                        </a>
                    </div>

                    {{-- 4. Copyright Info --}}
                    <p class="footer-info">
                        © 2025 <span class="dark-text">IQRAIN</span>. All Rights Reserved. <br>
                        Template by <span class="dark-text">Freepik - Flaticon</span>
                    </p>
                </div>

            </div>
        </footer>

    </main>

    <script>
        // SCRIPT SCROLL SPY
        window.addEventListener('scroll', () => {
            const sections = document.querySelectorAll('section, div.intro-section-wrapper');
            const navLinks = document.querySelectorAll('.navbar-links a');

            let current = '';
            sections.forEach(section => {
                const sectionTop = section.offsetTop;
                if (scrollY >= (sectionTop - 300)) {
                    current = section.getAttribute('id') || 'tujuan';
                }
            });

            navLinks.forEach(li => {
                li.classList.remove('active-nav');
                if (li.getAttribute('href').includes(current)) {
                    li.classList.add('active-nav');
                }
            });

            if (scrollY < 100) {
                navLinks.forEach(li => li.classList.remove('active-nav'));
                document.querySelector('.navbar-links a[href="#beranda"]').classList.add('active-nav');
            }
        });

        // SCRIPT TOGGLE KARTU
        function toggleCard(cardId) {
            const card = document.getElementById(cardId);
            const btn = card.querySelector('.btn-plus');

            card.classList.toggle('active');

            if (card.classList.contains('active')) {
                btn.textContent = '-';
            } else {
                btn.textContent = '+';
            }
        }

        // SCRIPT PANDUAN BERMAIN (TAB SWITCHER)
        function showStep(stepId, btnElement) {
            // 1. Hapus class active dari semua tombol nav
            const buttons = document.querySelectorAll('.guide-btn');
            buttons.forEach(btn => btn.classList.remove('active'));

            // 2. Tambahkan class active ke tombol yang diklik
            btnElement.classList.add('active');

            // 3. Sembunyikan semua konten step
            const steps = document.querySelectorAll('.guide-step');
            steps.forEach(step => step.classList.remove('active'));

            // 4. Tampilkan konten step yang dipilih
            const targetStep = document.getElementById('step-' + stepId);
            if (targetStep) {
                targetStep.classList.add('active');
            }
        }

        // SCRIPT ACCORDION TUJUAN PEMBELAJARAN
        const goalHeaders = document.querySelectorAll('.goal-header');

        goalHeaders.forEach(header => {
            header.addEventListener('click', () => {
                const item = header.parentElement;

                // (Opsional) Jika ingin hanya satu yang terbuka dalam satu waktu:
                // document.querySelectorAll('.goal-item').forEach(i => {
                //     if (i !== item) i.classList.remove('active');
                // });

                item.classList.toggle('active');
            });
        });
    </script>
</body>

</html>
