<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel - Ekspor Impor</title>
    <link rel="icon" type="image/png" href="{{ asset('images/icondata.png') }}">
    @vite(['resources/css/app.css'])
</head>

<script>
    function confirmLogout() {
        return confirm("Yakin ingin logout dari Admin Panel?");
    }
</script>

<body class="bg-gray-100 h-screen overflow-hidden">

<div class="flex h-full">

    <!-- SIDEBAR -->
    <aside class="w-64 bg-blue-900 text-white h-screen fixed left-0 top-0 flex flex-col shadow-xl">

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
    <div class="flex-1 flex flex-col ml-64 h-screen">

        <!-- HEADER -->
        <header class="bg-white shadow px-6 py-4">
            <h1 class="text-2xl font-bold text-gray-800">
                @yield('title', 'Dashboard Admin')
            </h1>
        </header>

        <!-- CONTENT -->
        <main class="p-6 overflow-y-auto flex-1">
            @yield('content')
        </main>

    </div>

</div>

</body>
</html>
