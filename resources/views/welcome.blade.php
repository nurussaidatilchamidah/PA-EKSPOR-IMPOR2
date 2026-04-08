<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Visualisasi Ekspor Impor</title>
    <link rel="icon" type="image/png" href="{{ asset('images/home.png') }}">

    @vite(['resources/css/app.css'])
    
    <style>
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

    </style>
</head>

<body class="min-h-screen bg-gradient-animated text-white relative overflow-x-hidden">

    <!-- Floating Shapes Background -->
    <div class="floating-shape w-96 h-96 bg-blue-400 -top-20 -left-20 animate-pulse-slow"></div>
    <div class="floating-shape w-80 h-80 bg-blue-400 -bottom-20 -right-20 animate-pulse-slow" style="animation-delay: 2s;"></div>
    <div class="floating-shape w-72 h-72 bg-blue-400 top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 animate-pulse-slow" style="animation-delay: 4s;"></div>
    
    <!-- Content Wrapper -->
    <div class="relative z-10">
    
    <!-- NAVBAR -->
    <nav class="flex justify-between items-center px-5 sm:px-8 md:px-12 py-4 md:py-6 max-w-7xl mx-auto">
    <div class="flex items-center gap-3">
    </div>

    <div class="flex items-center gap-6 sm:gap-8 md:gap-14 font-semibold text-sm sm:text-base md:text-lg">
    <a href="/" class="border-b-2 border-white pb-1 whitespace-nowrap">
        Home
    </a>
    <a href="/dashboard-public" class="hover:opacity-80 whitespace-nowrap">
        Dashboard
    </a>
    </div>
            <a href="{{ route('login') }}" 
            class="text-white border border-white px-5 py-2 rounded-full hover:bg-white hover:text-blue-700 transition font-semibold">
            Login
            </a>

    </nav>

        <!-- HERO SECTION -->
        <section class="px-10 md:px-20 mt-10 flex flex-col md:flex-row items-center justify-between">

            <!-- TEXT -->
            <div class="max-w-2xl">
                <h1 class="text-6xl md:text-7xl font-serif leading-tight mb-6 animate-zoom">
                    Analisis, Visualisasi, & Prediksi Tren Ekspor-Impor Nasional
                </h1>

                <p class="text-xl italic opacity-90 mb-10 drop-shadow-lg">
                    Berbasis data resmi dari Badan Pusat Statistik (BPS) Indonesia <br>
                    menggunakan metode ARIMA
                </p>

                <a href="/dashboard-public"
                 class="inline-flex items-center gap-4 bg-white text-blue-700 px-6 py-3 rounded-full text-lg font-semibold shadow-xl hover:scale-110 transition">
                  Lihat Dashboard →
                </a>

            </div>

            <!-- ILUSTRASI -->
            <div class="mt-12 md:mt-0">
                <img src="{{ asset('images/data.svg') }}" 
                     alt="Ilustrasi" 
                     class="w-[400px] md:w-[500px] drop-shadow-2xl">
            </div>

        </section>
    </div>

</body>
</html>