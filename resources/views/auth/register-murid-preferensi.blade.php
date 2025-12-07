<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Isi Pertanyaan Dulu Yuk - IQRAIN</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Font Mooli & Fredoka */
        @import url('https://fonts.googleapis.com/css2?family=Mooli&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Fredoka:wght@400;600;700&display=swap');

        /* Definisi Font Tegak Bersambung */
        @font-face {
            font-family: 'Tegak Bersambung_IWK';
            src: url("{{ asset('fonts/TegakBersambung_IWK.ttf') }}") format('truetype');
        }

        .font-fredoka { font-family: 'Fredoka', sans-serif; }
        .font-mooli { font-family: 'Mooli', sans-serif; }
        .font-cursive { font-family: 'Tegak Bersambung_IWK', cursive; }

        @keyframes popIn {
            0% {
                opacity: 0;
                transform: scale(0.5);
            }
            100% {
                opacity: 1;
                transform: scale(1);
            }
        }

        .modal-content {
            animation: popIn 0.3s ease-out;
        }

        ::-webkit-scrollbar {
            display: none;
        }

        html, body {
            -ms-overflow-style: none;  
            scrollbar-width: none;  
        }

        .pattern-bg {
            background-image: url("{{ asset('images/pattern/pattern1.webp') }}");
            background-size: 500px;
            background-repeat: repeat;
        }
    </style>
</head>

<body class="min-h-screen bg-[var(--color-iqrain-blue)]">

    <div class="max-w-7xl mx-auto py-10 px-6 relative">
        <div class="lg:w-[calc(100%-300px)] lg:pr-10">

        <h1 class="text-4xl lg:text-5xl font-fredoka font-bold text-white mb-4"
            style="text-shadow: 2px 2px 4px rgba(0,0,0,0.1);">
            Isi Pertanyaan Dulu Yuk !
        </h1>

        <p class="font-fredoka text-white text-base mb-3 opacity-90">
            Pertanyaan keamanan kalau kamu lupa password
        </p>

        <div class="flex items-center justify-center mb-6 space-x-3">
            <div class="w-3 h-3 rounded-full bg-white opacity-60"></div>
            <div class="w-8 h-8 rounded-full bg-yellow-400 text-white flex items-center justify-center font-bold">2</div>
        </div>

        {{-- Mengubah tampilan error agar lebih informatif --}}
        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-100 border-l-4 border-red-600 text-red-700 rounded-lg">
                <p class="font-fredoka font-bold mb-2">Terjadi Kesalahan! Mohon periksa kembali isian Anda:</p>
                <ul class="list-disc ml-5 text-xs">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ $actionRoute ?? route('register.murid.post') }}" id="preferensiForm">
            @csrf
            @if(!isset($actionRoute))
            <input type="hidden" name="step" value="2">
            @endif

            <div class="bg-white rounded-2xl p-5 shadow-lg border-2 border-white">

                <label class="text-xl font-fredoka text-iqrain-pink font-semibold block mb-4">
                    Apa warna kesukaanmu?
                </label>

                <input type="hidden" name="pertanyaan" value="Apa warna kesukaanmu?">
                <input type="hidden" name="jawaban" id="hidden_jawaban" value="{{ old('jawaban') }}">

                @php
                    $list_warna = [
                        'Merah' => 'bg-red-500',
                        'Biru' => 'bg-blue-500',
                        'Hijau' => 'bg-green-500',
                        'Kuning' => 'bg-yellow-400',
                        'Ungu' => 'bg-purple-500',
                        'Pink' => 'bg-pink-500',
                        'Oranye' => 'bg-orange-500',
                        'Hitam' => 'bg-gray-800',
                    ];
                @endphp

                {{-- Color Grid --}}
                <div class="grid grid-cols-4 gap-2">
                    @foreach($list_warna as $nama_warna => $color_class)
                        <button
                            type="button"
                            onclick="selectColor('{{ $nama_warna }}')"
                            id="color-{{ $nama_warna }}"
                            class="color-card cursor-pointer relative p-2 rounded-xl border-2 transition-all duration-200 hover:scale-105 hover:shadow-lg
                                {{ old('jawaban') === $nama_warna ? 'border-iqrain-pink bg-pink-50 ring-2 ring-pink-300' : 'border-gray-300 bg-white hover:border-pink-300' }}"
                        >
                            {{-- Checkmark --}}
                            <div class="checkmark absolute -top-1.5 -right-1.5 bg-iqrain-pink text-white rounded-full w-5 h-5 items-center justify-center shadow-lg {{ old('jawaban') === $nama_warna ? 'flex' : 'hidden' }}">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </div>

                            {{-- Color Box --}}
                            <div class="w-full h-10 rounded-lg mb-1.5 shadow-md {{ $color_class }}"></div>

                            {{-- Label --}}
                            <p class="text-xs font-fredoka font-semibold text-gray-700">{{ $nama_warna }}</p>
                        </button>
                    @endforeach
                </div>

                {{-- Pesan Error Validasi Spesifik --}}
                @error('jawaban')
                    <p class="text-red-600 text-xs mt-2 font-semibold">
                        ⚠️ {{ $message }}
                    </p>
                @enderror

            </div>

            <div class="mt-4 flex space-x-3">
                @if(!isset($actionRoute))
                {{-- Tombol Kembali hanya untuk registrasi baru --}}
                <a href="{{ route('register.murid') }}"
                    class="bg-white font-fredoka text-iqrain-pink font-bold py-2.5 px-8 rounded-xl shadow-lg
                             transition text-center flex-1">
                    Kembali
                </a>
                @endif

                <button type="submit" id="submitBtn"
                    class="@if(isset($actionRoute)) w-full @else flex-1 @endif bg-iqrain-pink cursor-pointer text-white font-fredoka font-bold py-2.5 px-8 rounded-xl shadow-lg
                            hover:opacity-90 transition">
                    {{ isset($actionRoute) ? 'Simpan' : 'Daftar' }}
                </button>
            </div>
        </form>

        @if(!isset($actionRoute))
        {{-- Link login hanya untuk registrasi baru --}}
        <div class="border-t border-white mt-6 pt-3">
            <p class="font-fredoka text-white text-base">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="font-fredoka text-yellow-300">Klik untuk login</a>
            </p>
        </div>
        @endif
    </div>
</div>

    <div class="absolute top-0 right-0 w-[500px] h-full hidden lg:block overflow-hidden">
        <img src="{{ asset('images/pattern/wafe-regist.webp') }}" 
            class="h-full object-fill"
            style="width: 700px; position: absolute; left: 0px;" alt="Background Pattern">
        <img src="{{ asset('images/maskot/ceria.webp') }}" 
            class="absolute bottom-0 right-0 w-[450px]" alt="Maskot Ceria">
    </div>

    <div id="successModal" class="hidden fixed inset-0 z-50" style="display: none;">

        <!-- Background overlay dengan transparansi gelap -->
        <div class="absolute inset-0 bg-white bg-opacity-50"></div>

        <!-- Modal content -->
        <div class="relative z-10 flex items-center justify-center min-h-screen p-4">
            <div class="modal-content bg-gradient-to-br from-blue-400 to-iqrain-blue rounded-3xl p-10 max-w-md w-full text-center shadow-2xl">
                <div class="mb-6">
                    <div class="w-24 h-24 mx-auto bg-green-400 rounded-full flex items-center justify-center shadow-lg">
                        <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                </div>
                <h2 class="text-4xl font-fredoka font-bold text-white mb-4">Selamat Datang!</h2>
                <p class="font-fredoka text-white text-lg mb-8 opacity-90">
                    Akun kamu sudah berhasil dibuat dan siap digunakan!
                </p>
                <button onclick="redirectToPilihIqra()" class="bg-iqrain-pink text-white font-fredoka font-bold py-3 px-12 rounded-full shadow-lg hover:opacity-90 transition transform hover:scale-105">
                    Yuk Mulai Belajar!
                </button>
            </div>
        </div>
    </div>

    <script>
    let redirectUrl = '';
    let isSubmitting = false;

    function selectColor(colorName) {
        // Update hidden input
        document.getElementById('hidden_jawaban').value = colorName;

        // Remove active state from all cards
        document.querySelectorAll('.color-card').forEach(card => {
            card.classList.remove('border-iqrain-pink', 'bg-pink-50', 'ring-2', 'ring-pink-300');
            card.classList.add('border-gray-300', 'bg-white');

            // Hide checkmark
            const checkmark = card.querySelector('.checkmark');
            if (checkmark) {
                checkmark.classList.add('hidden');
                checkmark.classList.remove('flex');
            }
        });

        // Add active state to selected card
        const selectedCard = document.getElementById('color-' + colorName);
        if (selectedCard) {
            selectedCard.classList.remove('border-gray-300', 'bg-white');
            selectedCard.classList.add('border-iqrain-pink', 'bg-pink-50', 'ring-2', 'ring-pink-300');

            // Show checkmark
            const checkmark = selectedCard.querySelector('.checkmark');
            if (checkmark) {
                checkmark.classList.remove('hidden');
                checkmark.classList.add('flex');
            }
        }
    }

    // Handle form submit dengan AJAX
    document.getElementById('preferensiForm').addEventListener('submit', function(e) {
        @if(!isset($actionRoute))
        // Cegah double submission
        if (isSubmitting) {
            e.preventDefault();
            return false;
        }

        e.preventDefault();
        isSubmitting = true;

        const submitBtn = document.getElementById('submitBtn');
        submitBtn.disabled = true;
        submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
        submitBtn.textContent = 'Memproses...';

        const formData = new FormData(this);

        fetch(this.action, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                redirectUrl = data.redirect;
                const modal = document.getElementById('successModal');
                
                // Tampilkan Modal
                modal.style.display = 'block';
                modal.classList.remove('hidden');

                // Kunci scroll pada body agar tidak bisa discroll saat modal muncul
                document.body.classList.add('overflow-hidden');
            } else {
                // Jika validasi error, lakukan submit normal (fall back)
                isSubmitting = false;
                submitBtn.disabled = false;
                submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                submitBtn.textContent = '{{ isset($actionRoute) ? 'Simpan' : 'Daftar' }}';
                this.submit();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            isSubmitting = false;
            submitBtn.disabled = false;
            submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            submitBtn.textContent = '{{ isset($actionRoute) ? 'Simpan' : 'Daftar' }}';
            this.submit(); // Fallback ke submit biasa jika ada error fetch
        });
        @else
        // Untuk actionRoute (simpan preferensi), cegah double submission
        if (isSubmitting) {
            e.preventDefault();
            return false;
        }

        isSubmitting = true;
        const submitBtn = document.getElementById('submitBtn');
        submitBtn.disabled = true;
        submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
        submitBtn.textContent = 'Memproses...';
        @endif
    });

    function redirectToPilihIqra() {
        // Kembalikan scroll body (opsional, karena akan pindah halaman)
        document.body.classList.remove('overflow-hidden');
        window.location.href = redirectUrl;
    }
</script>

</body>
</html>