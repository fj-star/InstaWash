<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - InstaWash</title>
    <link rel="icon" href="{{ asset('assets/img/logo.jpg') }}" type="image/png">
 
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-100 flex justify-center items-center min-h-screen">
    <div class="bg-white rounded-xl shadow-lg w-[800px] grid grid-cols-2 overflow-hidden">
        
        <div class="p-10">
            {{-- Rebrand Silit -> InstaWash --}}
            <h2 class="text-2xl font-semibold mb-2">Masuk Ke Akun InstaWash</h2>
            <p class="text-gray-500 mb-6">
                Ga Punya Akun?
                <a href="{{ route('register') }}" class="text-blue-500 font-semibold">Daftar sini</a>
            </p>
            
            <form method="POST" action="{{ route('login') }}">
                @csrf
                
                <div class="mb-4">
                    <label for="email" class="block text-gray-700 font-medium">Email</label>
                    {{-- Logika Border Merah jika Error --}}
                    <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="masukan email"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400 outline-none @error('email') border-red-500 @enderror">
                    @error('email')
                        <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-2">
                    <label for="password" class="block text-gray-700 font-medium">Password</label>
                    <div class="relative">
                        {{-- Logika Border Merah jika Error --}}
                        <input type="password" name="password" id="password" placeholder="Masukan Password"
                            class="w-full px-4 py-2 pr-10 border rounded-lg focus:ring-2 focus:ring-blue-400 outline-none @error('password') border-red-500 @enderror">
                        <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <i id="passwordIcon" class="fas fa-eye-slash text-gray-500 hover:text-gray-700"></i>
                        </button>
                    </div>
                    @error('password')
                        <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div class="text-right mb-6">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-sm text-blue-500 hover:underline">
                            Lupa password?
                        </a>
                    @endif
                </div>

                <button type="submit"
                    class="w-full bg-blue-500 text-white py-2 rounded-full hover:bg-blue-600 transition font-bold shadow-md">
                    LOGIN
                </button>

                 <div class="block mt-4">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                        <span class="ms-2 text-sm text-gray-600">Ingat Saya</span>
                    </label>
                </div>
            </form>
        </div>

        <div class="bg-blue-500 relative">
            <img src="{{ asset('assets/img/logo.jpg') }}" alt="Logo InstaWash Laundry" 
                 class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-blue-900 bg-opacity-20"></div>
        </div>
    </div>

    {{-- SCRIPTS --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Toggle password visibility
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const passwordIcon = document.getElementById('passwordIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                passwordIcon.classList.remove('fa-eye-slash');
                passwordIcon.classList.add('fa-eye');
            } else {
                passwordInput.type = 'password';
                passwordIcon.classList.remove('fa-eye');
                passwordIcon.classList.add('fa-eye-slash');
            }
        });
    </script>

    {{-- Logika Error SweetAlert jika Login Gagal --}}
    @if($errors->any())
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Login Gagal',
            text: 'Email atau password yang kamu masukkan salah.',
            confirmButtonColor: '#3b82f6'
        });
    </script>
    @endif

    @if(session('logout_success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil Logout',
            text: '{{ session('logout_success') }}',
            showConfirmButton: false,
            timer: 2000
        });
    </script>
    @endif
</body>
</html>