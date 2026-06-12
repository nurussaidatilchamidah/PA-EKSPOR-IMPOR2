<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Dashboard Kelola Data Ekspor-Impor</title>
    <link rel="icon" type="image/png" href="{{ asset('images/user.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        @keyframes float {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-15px);
            }
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
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
        
        @keyframes spin {
            from {
                transform: rotate(0deg);
            }
            to {
                transform: rotate(360deg);
            }
        }
        
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
        
        .animate-fade-in-up {
            animation: fadeInUp 0.6s ease-out;
        }
        
        .animate-pulse-slow {
            animation: pulse 4s ease-in-out infinite;
        }
        
        .animate-spin-slow {
            animation: spin 20s linear infinite;
        }
        
        .bg-gradient-animated {
            background: linear-gradient(-45deg, #2f6690, #3a7ca5, #16425b, #81c3d7);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
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
        
        .glass-card {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.4);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
        }
        
        .input-focus {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .input-focus:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            transform: translateY(-1px);
        }
        
        .btn-gradient {
            background: linear-gradient(135deg, #4A6FA5 0%, #166088 100%);
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        
        .btn-gradient::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
            transition: left 0.5s;
        }
        
        .btn-gradient:hover::before {
            left: 100%;
        }
        
        .btn-gradient:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 30px rgba(102, 126, 234, 0.4);
        }
        
        .floating-shape {
            position: fixed;
            border-radius: 50%;
            opacity: 0.5;
            filter: blur(80px);
        }
    </style>
</head>
<body class="bg-gradient-animated min-h-screen flex items-center justify-center p-4 relative overflow-hidden">

    <!-- Floating Shapes Background -->
    <div class="floating-shape w-80 h-80 bg-blue-400 -bottom-20 -right-20 animate-pulse-slow" style="animation-delay: 2s;"></div>
    <div class="floating-shape w-72 h-72 bg-blue-400 top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 animate-pulse-slow" style="animation-delay: 4s;"></div>

    <!-- Main Container -->
    <div class="w-full max-w-md relative z-10 animate-fade-in-up">
        
        <!-- Welcome Text -->
        <div class="text-center mb-6">
            <h1 class="text-3xl sm:text-4xl font-bold text-white mb-2 drop-shadow-2xl">
                Selamat Datang Admin! 
            </h1>
            <p class="text-sm sm:text-base text-white text-opacity-90 drop-shadow-lg">
                Masukkan Email dan Password untuk Kelola Data Ekspor Impor
            </p>
        </div>

        <!-- Login Card -->
        <div class="glass-card rounded-2xl shadow-2xl p-6 sm:p-8">
            
            <!-- Alert Messages -->
            @if (session('status'))
                <div class="mb-5 p-3 bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 rounded-lg">
                    <div class="flex items-center text-green-700">
                        <svg class="w-5 h-5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span class="font-semibold text-sm">{{ session('status') }}</span>
                    </div>
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-5 p-3 bg-gradient-to-r from-red-50 to-pink-50 border-l-4 border-red-500 rounded-lg">
                    <div class="flex items-center text-red-700">
                        <svg class="w-5 h-5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        <span class="font-semibold text-sm">Username atau password salah!</span>
                    </div>
                </div>
            @endif

            <h2 class="text-3xl font-bold text-gray-800 mb-5 text-center">Login</h2>

            <!-- Login Form -->
            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                <!-- Email -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Email</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-blue-400 group-focus-within:text-blue-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <input 
                            type="email" 
                            name="email"
                            class="input-focus w-full pl-11 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none text-gray-700 font-medium bg-white"
                            placeholder="admin@gmail.com"
                            value="{{ old('email') }}"
                            required 
                            autofocus>
                    </div>
                </div>

                <!-- Password -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Password</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-blue-400 group-focus-within:text-blue-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <input 
                            type="password" 
                            name="password"
                            id="password"
                            class="input-focus w-full pl-11 pr-11 py-3 border-2 border-gray-200 rounded-xl focus:outline-none text-gray-700 font-medium bg-white"
                            placeholder="••••••••"
                            required>
                        <button 
                            type="button"
                            onclick="togglePassword()"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-blue-600 transition-colors">
                            <svg id="eye-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Submit Button -->
                <button
                    type="submit"
                    class="btn-gradient w-full py-3 text-white font-bold rounded-xl shadow-xl mt-6">
                    <span class="relative z-10 flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                        </svg>
                        Masuk ke Dashboard
                    </span>
                </button>
            </form>

        <!-- Footer -->
        <div class="text-center mt-5">
            <p class="text-blue-800 text-opacity-90 text-sm drop-shadow-lg">
                <span class="font-bold">Powered by BPS</span> • 
                <a href="/" class="font-semibold hover:underline transition-all">Kembali ke Homepage</a>
            </p>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />';
            } else {
                passwordInput.type = 'password';
                eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />';
            }
        }
    </script>

</body>
</html>