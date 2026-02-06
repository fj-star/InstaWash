<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InstaWash - Solusi Kebersihan Pakaian Anda</title>
    <link rel="icon" href="{{ asset('assets/img/logo.jpg') }}" type="image/png">

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .glass-nav { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(12px); }
        .hero-gradient { background: radial-gradient(circle at top right, #eff6ff 0%, #ffffff 100%); }
    </style>
</head>
<body class="bg-white text-slate-900 overflow-x-hidden">

    <nav class="fixed w-full z-[100] glass-nav border-b border-slate-100 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-6 h-20 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <img src="{{ asset('assets/img/logo.jpg') }}" alt="InstaWash Logo" class="w-10 h-10 rounded-full shadow-lg border-2 border-blue-500">
                <span class="text-2xl font-extrabold bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-blue-400 tracking-tight">InstaWash</span>
            </div>
            
            <div class="hidden md:flex items-center space-x-10">
                <a href="#about" class="text-sm font-semibold hover:text-blue-600 transition-colors">Tentang Kami</a>
                <a href="#layanan" class="text-sm font-semibold hover:text-blue-600 transition-colors">Layanan</a>
                <a href="#testimonials" class="text-sm font-semibold hover:text-blue-600 transition-colors">Testimoni</a>
                <a href="{{ route('login') }}" class="bg-blue-600 text-white px-7 py-2.5 rounded-full text-sm font-bold hover:bg-blue-700 hover:shadow-lg hover:shadow-blue-200 transition-all active:scale-95">Login</a>
            </div>
        </div>
    </nav>

    <section class="relative min-h-screen hero-gradient flex items-center pt-20 overflow-hidden">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-2 gap-16 items-center">
            <div data-aos="fade-right" data-aos-delay="100">
                <span class="inline-block px-4 py-1.5 rounded-full bg-blue-50 text-blue-600 text-xs font-bold uppercase tracking-widest mb-6">Fresh and Clean Experience</span>
                <h1 class="text-5xl md:text-7xl font-extrabold text-slate-900 mb-6 leading-[1.1]">
                    INSTAWASH <br>
                    <span class="text-blue-600">— SERVICES —</span>
                </h1>
                <p class="text-slate-500 text-lg mb-10 max-w-lg leading-relaxed">
                    Solusi laundry profesional yang menjamin pakaian Anda bersih kilat, harum, dan tampak seperti baru setiap hari.
                </p>
                <div class="flex flex-col sm:flex-row gap-5">
                    <a href="{{ route('register') }}" class="bg-orange-500 text-white px-10 py-4 rounded-full font-bold text-lg hover:bg-orange-600 shadow-xl shadow-orange-100 transition-all text-center">Daftar Sekarang</a>
                    <a href="#layanan" class="bg-white text-slate-700 px-10 py-4 rounded-full font-bold text-lg hover:bg-slate-50 border border-slate-200 transition-all text-center">Lihat Layanan</a>
                </div>
            </div>
            <div class="relative" data-aos="zoom-in" data-aos-delay="300">
                <div class="absolute -top-10 -right-10 w-64 h-64 bg-blue-100 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-pulse"></div>
                <div class="relative rounded-[2.5rem] overflow-hidden shadow-2xl border-[12px] border-white rotate-2 hover:rotate-0 transition-transform duration-500">
                    <img src="{{ asset('assets/img/slide5.jpeg') }}" alt="Laundry Day" class="w-full h-auto">
                </div>
                <div class="absolute -bottom-6 -left-6 bg-white p-5 rounded-3xl shadow-2xl flex items-center gap-4 animate-bounce">
                    <div class="bg-green-500 w-12 h-12 rounded-2xl flex items-center justify-center text-white shadow-lg">
                        <i class="fas fa-check"></i>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 font-bold uppercase tracking-tighter">Hasil Cucian</p>
                        <p class="text-sm font-extrabold text-slate-800">100% Higienis</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="about" class="py-24 bg-blue-600 relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-6 relative z-10">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-3xl font-bold text-white mb-4">Mengapa Pakaian Anda Aman di InstaWash?</h2>
                <p class="text-blue-100 text-sm italic">Proses terbaik untuk hasil yang maksimal di workshop Ciranjang.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-16">
                <div class="text-center group" data-aos="fade-up" data-aos-delay="100">
                    <div class="w-20 h-20 bg-white/10 backdrop-blur-md rounded-3xl flex items-center justify-center mx-auto mb-8 border border-white/20 group-hover:bg-white transition-all">
                        <i class="fas fa-hand-sparkles text-2xl text-white group-hover:text-blue-600"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-4">Satu Mesin Satu Pelanggan</h3>
                    <p class="text-blue-100 text-sm">Pakaian Anda tidak akan dicampur untuk menjaga kebersihan maksimal.</p>
                </div>
                <div class="text-center group" data-aos="fade-up" data-aos-delay="300">
                    <div class="w-20 h-20 bg-white/10 backdrop-blur-md rounded-3xl flex items-center justify-center mx-auto mb-8 border border-white/20 group-hover:bg-white transition-all">
                        <i class="fas fa-bolt text-2xl text-white group-hover:text-blue-600"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-4">Proses Kilat & Tepat</h3>
                    <p class="text-blue-100 text-sm">Diproses tim ahli (Olot dkk) dengan pengering modern tanpa jemur matahari.</p>
                </div>
                <div class="text-center group" data-aos="fade-up" data-aos-delay="500">
                    <div class="w-20 h-20 bg-white/10 backdrop-blur-md rounded-3xl flex items-center justify-center mx-auto mb-8 border border-white/20 group-hover:bg-white transition-all">
                        <i class="fas fa-wind text-2xl text-white group-hover:text-blue-600"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-4">Parfum Premium Eksklusif</h3>
                    <p class="text-blue-100 text-sm">Kembali dalam keadaan rapi dan wangi segar tahan lama setiap hari.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="layanan" class="py-24 bg-slate-50">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <h2 class="text-3xl font-extrabold mb-4" data-aos="fade-up">Layanan Spesialis Kami</h2>
            <p class="text-slate-500 mb-16 max-w-2xl mx-auto">Dirawat dengan sepenuh hati menggunakan deterjen ramah lingkungan.</p>
            <div class="grid grid-cols-2 lg:grid-cols-5 gap-6">
                @php
                    $services = [
                        ['Kiloan Daily', 'https://i.pinimg.com/736x/aa/b7/a5/aab7a5e2b80aa7c87938035a099f7099.jpg'],
                        ['Cuci Setrika', 'https://i.pinimg.com/736x/f8/9e/3c/f89e3c377b84900bfbb63c7c341215b4.jpg'],
                        ['Deep Clean Sepatu', 'https://i.pinimg.com/736x/bf/6c/43/bf6c435e7201c6207e8579172dd6bcbb.jpg'],
                        ['Laundry Boneka', 'https://i.pinimg.com/736x/1d/c0/40/1dc04048976cfa6a13ce3d72bdd7677a.jpg'],
                        ['Bed Cover', 'https://i.pinimg.com/736x/f6/fa/4e/f6fa4e9e47cffbb4f98dfbb676030a50.jpg']
                    ];
                @endphp
                @foreach($services as $s)
                <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100 hover:shadow-xl transition-all group" data-aos="zoom-in">
                    <div class="w-20 h-20 mx-auto mb-6 rounded-2xl overflow-hidden border-4 border-blue-50">
                        <img src="{{ $s[1] }}" alt="{{ $s[0] }}" class="w-full h-full object-cover">
                    </div>
                    <h4 class="font-bold text-sm text-slate-800 group-hover:text-blue-600">{{ $s[0] }}</h4>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <section id="testimonials" class="py-24 bg-white overflow-hidden">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-20" data-aos="fade-up">
                <h2 class="text-3xl font-extrabold text-slate-900 mb-4">Apa Kata Warga Ciranjang?</h2>
                <p class="text-slate-500 italic">Bukti kepuasan pelanggan setia workshop kami.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                {{-- Dandun --}}
                <div class="bg-slate-50 p-8 rounded-[2.5rem] border border-slate-100 shadow-sm" data-aos="fade-up" data-aos-delay="100">
                    <div class="flex items-center gap-1 text-orange-400 mb-6"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
                    <p class="text-slate-600 italic mb-8">"Higienis banget karena satu mesin satu pelanggan. Berlangganan di sini sangat tenang."</p>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-blue-600 rounded-2xl flex items-center justify-center text-white font-bold">D</div>
                        <div><h4 class="font-bold text-slate-900 text-sm">Dandun</h4><span class="text-[10px] font-bold text-blue-500 uppercase">Verified Member</span></div>
                    </div>
                </div>
                {{-- Adit --}}
                <div class="bg-slate-50 p-8 rounded-[2.5rem] border border-slate-100 shadow-sm" data-aos="fade-up" data-aos-delay="300">
                    <div class="flex items-center gap-1 text-orange-400 mb-6"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
                    <p class="text-slate-600 italic mb-8">"Wanginya awet banget. Pelayanan Iki dan tim sangat membantu kebutuhan saya."</p>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-orange-500 rounded-2xl flex items-center justify-center text-white font-bold">A</div>
                        <div><h4 class="font-bold text-slate-900 text-sm">Adit</h4><span class="text-[10px] font-bold text-blue-500 uppercase">Pelanggan Setia</span></div>
                    </div>
                </div>
                {{-- Ido --}}
                <div class="bg-slate-50 p-8 rounded-[2.5rem] border border-slate-100 shadow-sm" data-aos="fade-up" data-aos-delay="500">
                    <div class="flex items-center gap-1 text-orange-400 mb-6"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
                    <p class="text-slate-600 italic mb-8">"Cuci sepatu dekil jadi kayak baru lagi. Gak nyesel langganan di workshop ini."</p>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-green-600 rounded-2xl flex items-center justify-center text-white font-bold">I</div>
                        <div><h4 class="font-bold text-slate-900 text-sm">Ido</h4><span class="text-[10px] font-bold text-blue-500 uppercase">Verified Member</span></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <a href="https://wa.me/6283873304630" target="_blank" class="fixed bottom-8 right-8 z-[200] group flex items-center">
        <div class="bg-white px-5 py-2.5 rounded-2xl shadow-2xl mr-4 opacity-0 group-hover:opacity-100 transition-all text-sm font-bold text-green-600 translate-x-10 group-hover:translate-x-0">Ada pertanyaan, anda?</div>
        <div class="bg-green-500 text-white w-16 h-16 rounded-[2rem] flex items-center justify-center shadow-2xl hover:scale-110 transition-all"><i class="fab fa-whatsapp text-3xl"></i></div>
    </a>

    <footer id="contact" class="bg-slate-900 text-slate-400 pt-24 pb-12">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-3 gap-20 mb-20">
            <div>
                <img src="{{ asset('assets/img/logo.jpg') }}" alt="InstaWash" class="w-16 h-16 rounded-2xl mb-8 border-2 border-blue-500/20">
                <p class="text-sm">Workshop perawatan pakaian premium di Ciranjang, Kab. Cianjur.</p>
            </div>
            <div>
                <h3 class="text-white font-bold mb-8">Tim Profesional</h3>
                <ul class="space-y-4 text-xs">
                    <li><i class="fas fa-headset mr-3 text-blue-500"></i> Muhamad Fazril & M Rifqy</li>
                    <li><i class="fas fa-user mr-3 text-blue-500"></i> M Ridho & Aldira Firdaus</li>
                    <li><i class="fas fa-shield-alt mr-3 text-blue-500"></i> Fachri Rido & M Fiki Jamal</li>
                </ul>
            </div>
            <div>
                <h3 class="text-white font-bold mb-8">Lokasi Workshop</h3>
                <div class="rounded-3xl overflow-hidden border border-slate-800">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15843.483935275815!2d107.2608447!3d-6.812328!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6853754e38c7f9%3A0xc6c766e4a66a152e!2sCiranjang%2C%20Cianjur%20Regency%2C%20West%20Java!5e0!3m2!1sen!2sid!4v1707100000000!5m2!1sen!2sid" width="100%" height="150" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
                <p class="mt-4 text-[10px] italic">📍 Jl. Raya Bandung No.117, Ciranjang, Cianjur</p>
            </div>
        </div>
        <div class="text-center border-t border-slate-800 pt-10">
            <p class="text-[10px] uppercase tracking-widest font-bold">© 2026 InstaWash Laundry. All Rights Reserved.</p>
        </div>
    </footer>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ duration: 1000, once: true });
        window.onscroll = function() {
            const nav = document.querySelector('nav');
            if (window.pageYOffset > 50) {
                nav.classList.add('h-16', 'shadow-xl');
                nav.classList.remove('h-20');
            } else {
                nav.classList.remove('h-16', 'shadow-xl');
                nav.classList.add('h-20');
            }
        };
    </script>
</body>
</html>