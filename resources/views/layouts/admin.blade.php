<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel - Ekspor Impor</title>
    <link rel="icon" type="image/png" href="{{ asset('images/icondata.png') }}">
    @vite(['resources/css/app.css'])
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        html, body {
            width: 100%;
            height: 100%;
        }

        /* Desktop - sidebar fixed di kiri */
        .admin-layout {
            display: flex;
            height: 100vh;
            width: 100%;
        }
        
        aside {
            width: 16rem;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 50;
            overflow-y: auto;
            flex-shrink: 0;
        }
        
        .admin-main {
            display: flex;
            flex-direction: column;
            margin-left: 16rem;
            flex: 1;
            height: 100vh;
            width: calc(100% - 16rem);
        }
        
        .admin-header {
            flex-shrink: 0;
            position: sticky;
            top: 0;
            z-index: 40;
        }
        
        main {
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
        }

        /* Mobile & Tablet - sidebar hidden, fullwidth content scrollable */
        @media (max-width: 1024px) {
            .admin-layout {
                display: flex;
                flex-direction: column;
                height: auto;
                min-height: 100vh;
            }
            
            aside {
                display: none;
                position: relative;
                width: 100%;
                height: auto;
                margin-left: 0;
                z-index: 0;
            }
            
            .admin-main {
                display: flex;
                flex-direction: column;
                margin-left: 0;
                width: 100%;
                height: auto;
                min-height: 100vh;
            }
            
            .admin-header {
                flex-shrink: 0;
                position: sticky;
                top: 0;
                z-index: 40;
            }
            
            main {
                flex: 1;
                overflow-y: auto;
                min-height: auto;
            }
        }
        
        @media (max-width: 768px) {
            .admin-header h1 {
                font-size: 1.1rem;
            }
        }
        
        @media (max-width: 640px) {
            .admin-header h1 {
                font-size: 1rem;
            }
        }
    </style>
</head>

<script>
    function confirmLogout() {
        return confirm("Yakin ingin logout dari Admin Panel?");
    }
</script>

<body class="bg-gray-100">

<div class="admin-layout">

    <!-- SIDEBAR -->
    <aside class="bg-blue-900 text-white flex flex-col shadow-xl">

        <div class="p-6 border-b border-blue-700">
            <h2 class="text-2xl font-bold">Admin Panel</h2>
            <p class="text-lg text-blue-200">
                {{ auth()->user()->name }}
            </p>
        </div>

        <nav class="flex-1 p-4 space-y-2">

    <!-- Dashboard -->
    <a href="{{ route('dashboard') }}"
       class="flex items-center gap-2 px-4 py-2 rounded 
       {{ request()->routeIs('dashboard') ? 'bg-white text-blue-700 font-semibold' : 'text-white hover:bg-blue-700' }}">
        📊 Dashboard
    </a>

    <!-- Data Bulanan -->
    <a href="{{ route('admin.data') }}"
       class="flex items-center gap-2 px-4 py-2 rounded 
       {{ request()->routeIs('admin.data') ? 'bg-white text-blue-700 font-semibold' : 'text-white hover:bg-blue-700' }}">
        📅 Data Bulanan
    </a>

    <!-- Data HS -->
    <a href="{{ route('admin.data.hs') }}"
       class="flex items-center gap-2 px-4 py-2 rounded 
       {{ request()->routeIs('admin.data.hs') ? 'bg-white text-blue-700 font-semibold' : 'text-white hover:bg-blue-700' }}">
        📦 Data HS
    </a>

    <!-- Prediksi -->
    <a href="{{ route('prediksi.arima') }}"
       class="flex items-center gap-2 px-4 py-2 rounded 
       {{ request()->routeIs('prediksi.arima') ? 'bg-white text-blue-700 font-semibold' : 'text-white hover:bg-blue-700' }}">
        📈 Prediksi ARIMA
    </a>

    <!-- Evaluasi -->
    <a href="{{ route('evaluasi.model') }}"
       class="flex items-center gap-2 px-4 py-2 rounded 
       {{ request()->routeIs('evaluasi.model') ? 'bg-white text-blue-700 font-semibold' : 'text-white hover:bg-blue-700' }}">
        📑 Evaluasi Model
    </a>

        </nav>

        <div class="p-4 border-t border-blue-700">
            <form method="POST" action="{{ route('logout') }}" 
                  onsubmit="return confirmLogout()">
                @csrf
                <button type="submit"
                    class="w-full flex items-center justify-center gap-2
                           bg-red-700 hover:bg-red-500
                           text-white text-lg font-bold
                           py-2 rounded-lg
                           shadow-md hover:shadow-lg
                           transition duration-200">
                    Logout
                </button>
            </form>
        </div>

    </aside>

    <!-- MAIN CONTENT -->
    <div class="admin-main">

        <!-- HEADER -->
        <header class="bg-white shadow px-4 md:px-6 py-3 md:py-4 flex items-center justify-between admin-header">
                    <h1 class="text-lg md:text-2xl font-bold text-gray-800">
                        @yield('title', 'Dashboard Admin')
                    </h1>
                </header>

        <!-- CONTENT -->
        <main class="p-4 md:p-6">
            @yield('content')
        </main>

    </div>

</div>

</body>
</html>
