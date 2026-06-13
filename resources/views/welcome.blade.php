<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Visualisasi Ekspor Impor</title>
    <link rel="icon" type="image/png" href="{{ asset('images/home.png') }}">

    @vite(['resources/css/app.css'])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    
    <style>
html {
    scroll-behavior: smooth;
}
        @keyframes gradient {
            0% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0% 50%;
            }
        }
        
        @keyframes pulse {
            0%, 100% {
                opacity: 0.4;
                transform: scale(1);
            }
            50% {
                opacity: 0.6;
                transform: scale(1.05);
            }
        }
        
        @keyframes float {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-15px);
            }
        }
        
        @keyframes spin {
            from {
                transform: rotate(0deg);
            }
            to {
                transform: rotate(360deg);
            }
        }
        
        .bg-gradient-animated {
            background: linear-gradient(-45deg, #2f6690, #3a7ca5, #16425b, #81c3d7);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
        }
        
        .floating-shape {
            position: fixed;
            border-radius: 50%;
            opacity: 0.5;
            filter: blur(80px);
            z-index: 0;
        }
        
        .animate-pulse-slow {
            animation: pulse 4s ease-in-out infinite;
        }
        
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
        
        .animate-spin-slow {
            animation: spin 20s linear infinite;
        }

       @keyframes zoomFade {
    0% {
        opacity: 0;
        transform: scale(0.9);
    }
    100% {
        opacity: 1;
        transform: scale(1);
    }
}
    .animate-zoom {
    opacity: 0;
    animation: zoomFade 2s ease-out forwards;
    }

    @keyframes slideText {
    0% { transform: translateX(100%); }
    100% { transform: translateX(-100%); }
}

a {
    text-decoration: none !important;
}

a:hover {
    text-decoration: none !important;
}

.hero-section {
    min-height: calc(100vh - 90px);
    padding-top: 1rem;
    padding-bottom: 1rem;
    align-items: center;
}

.hero-heading {
    font-size: clamp(4.5rem, 5vw, 8rem);
    line-height: 1.05;
    max-width: 42rem;
    margin-bottom: 1rem;
}

.hero-copy {
    font-size: clamp(1rem, 1.3vw, 1.3rem);
    max-width: 36rem;
    margin-bottom: 1.5rem;
}

.hero-btn {
    padding: 0.85rem 2.2rem;
    font-size: 1.2rem;
}

@media (max-width: 1024px) {
    .floating-shape {
        display: none;
    }
    .hero-section {
        padding-left: 1rem;
        padding-right: 1rem;
    }
    .hero-heading {
        font-size: clamp(3rem, 6vw, 6rem);
        max-width: 100%;
    }
    .hero-copy {
        font-size: 1rem;
        max-width: 100%;
    }
    .hero-btn {
        width: auto;
        justify-content: center;
    }
}

@media (max-width: 768px) {
    .hero-section {
        align-items: center;
        justify-items: center;
        text-align: center;
        height: 100vh;
        gap: 1rem;
    }
    .hero-heading {
        font-size: 2.2rem;
        margin-bottom: 0.6rem;
    }
    .hero-copy {
        font-size: 0.9rem;
        margin-bottom: 0.8rem;
    }
    .hero-btn {
        width: 100%;
        padding: 0.7rem 1.5rem;
        font-size: 0.9rem;
    }
    .hero-section img {
        max-width: 80% !important;
        height: auto;
    }
}

@media (max-width: 640px) {
    .hero-section {
        height: 100vh;
        padding-top: 0.25rem;
    }
    .hero-heading {
        font-size: 1.95rem;
        margin-bottom: 0.5rem;
    }
    .hero-copy {
        font-size: 0.85rem;
        margin-bottom: 0.7rem;
    }
    .hero-btn {
        padding: 0.6rem 1.4rem;
        font-size: 0.85rem;
    }
    nav {
        padding-left: 1rem;
        padding-right: 1rem;
    }
}
a:focus, a:active {
    outline: none;
    box-shadow: none;
    text-decoration: none !important;
}
button, a {
    -webkit-tap-highlight-color: transparent;
}
    </style>
</head>

<script>
function scrollToDashboard(e) {
    e.preventDefault();

    const target = document.getElementById("dashboard");

    target.scrollIntoView({
        behavior: "smooth",
        block: "start"
    });
}
</script>

<body class="min-h-screen bg-gradient-animated text-white relative overflow-x-hidden">

    <!-- Floating Shapes Background -->
    <div class="floating-shape w-96 h-96 bg-blue-400 -top-20 -left-20 animate-pulse-slow"></div>
    <div class="floating-shape w-80 h-80 bg-blue-400 -bottom-20 -right-20 animate-pulse-slow" style="animation-delay: 2s;"></div>
    <div class="floating-shape w-72 h-72 bg-blue-400 top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 animate-pulse-slow" style="animation-delay: 4s;"></div>
    
    <!-- Content Wrapper -->
    <div class="relative z-10">
    
    <!-- NAVBAR -->
    <div class="container mx-auto px-5 sm:px-8 md:px-12 pt-3 md:pt-4">
        <nav class="flex justify-end items-center">
            <a href="{{ route('login') }}" 
               class="text-white border border-white px-4 py-1.5 rounded-full hover:bg-white hover:!text-blue-700 transition duration-300 font-semibold text-sm md:text-base">
                Login Admin
            </a>
        </nav>
    </div>

        <!-- HERO SECTION -->
        <section class="hero-section container mx-auto px-5 sm:px-8 md:px-12 grid gap-6 lg:gap-10 lg:grid-cols-[1.2fr_0.8fr] items-center justify-center" style="max-width: 1250px;">

            <!-- TEXT -->
            <div>
                <h1 class="hero-heading text-4xl md:text-5xl lg:text-6xl font-serif leading-tight mb-6 animate-zoom">
                    Analisis, Visualisasi, & Prediksi Tren Ekspor-Impor Nasional
                </h1>

                <p class="hero-copy italic opacity-90 mb-8 drop-shadow-lg">
                    Berbasis data resmi dari Badan Pusat Statistik (BPS) Indonesia menggunakan metode ARIMA
                </p>

                <a href="#dashboard" onclick="scrollToDashboard(event)"
                   class="hero-btn no-underline inline-flex items-center gap-4 bg-white text-blue-700 px-6 py-3 rounded-full text-lg font-semibold shadow-xl hover:scale-110 transition">
                    Lihat Dashboard ↓
                </a>
            </div>

            <!-- ILUSTRASI -->
            <div class="w-full max-w-lg mx-auto">
                <img src="{{ asset('images/data.svg') }}" 
                     alt="Ilustrasi" 
                     class="w-full max-w-full drop-shadow-2xl mx-auto md:mx-0">
            </div>

        </section>
    </div>

    @include('partials.dashboard-public')

</body>
</html>