<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pasangkan Huruf - Drag & Drop</title>

    {{-- 1. Memuat Asset CSS & JS Utama Laravel --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Menggunakan Font Mooli */
        @import url('https://fonts.googleapis.com/css2?family=Mooli&display=swap');

        /* Definisi Font Tegak Bersambung */
        @font-face {
            font-family: 'Tegak Bersambung_IWK';
            src: url("{{ asset('fonts/TegakBersambung_IWK.ttf') }}") format('truetype');
        }

        .font-mooli {
            font-family: 'Mooli', sans-serif;
        }

        .font-cursive {
            font-family: 'Tegak Bersambung_IWK', cursive;
        }

        /* Fallback untuk class Tailwind arbitrary value jika JIT tidak jalan */
        .font-\[\'TegakBersambung\'\] {
            font-family: 'Tegak Bersambung_IWK', cursive !important;
        }

        body {
            user-select: none;
            overflow-x: hidden;
            /* Mencegah scroll horizontal */
        }

        /* ANIMASI SALAH (Getar) */
        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            25% {
                transform: translateX(-5px);
            }

            75% {
                transform: translateX(5px);
            }
        }

        .animate-shake {
            animation: shake 0.3s ease-in-out;
        }

        /* ANIMASI FLOATING (Untuk Icon Rocket & Quran) */
        @keyframes float {

            0%,
            100% {
                transform: translateY(0) rotate(0deg);
            }

            50% {
                transform: translateY(-20px) rotate(2deg);
            }
        }

        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        .animate-float-delayed {
            animation: float 7s ease-in-out infinite 1s;
            /* Delay biar ga barengan */
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: #F472B6;
            border-radius: 10px;
        }
    </style>
</head>

<body
    class="min-h-screen flex flex-col items-center justify-center p-4 bg-gradient-to-b from-[#56B1F3] to-[#D3F2FF] relative">

    {{-- Balon kiri --}}
    <div class="fixed left-0 top-1/3 w-40 md:w-50 h-auto animate-bounce-slow z-0 pointer-events-none">
        <img src="{{ asset('images/icon/balon.webp') }}" alt="Balon Kiri" class="w-full h-auto drop-shadow-lg">
    </div>

    {{-- HEADER BUTTONS (Absolute Position) --}}
    <div class="absolute top-6 left-6 z-20">
        <a href="{{ route('murid.games.index', $tingkatan->tingkatan_id) }}"
            class="relative flex items-center justify-center w-[140px] h-[45px] rounded-full bg-pink-400 shadow-md transition-transform hover:scale-105">
            <div class="absolute left-4 flex items-center">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="3"
                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"></path>
                </svg>
            </div>
            <span class="font-mooli font-semibold text-white text-[18px] font-normal leading-none pl-4">
                Kembali
            </span>
        </a>
    </div>

    <div class="absolute top-6 right-6 z-20 flex items-center gap-4">
        <button onclick="initGame()"
            class="font-mooli font-semibold flex items-center gap-2 bg-yellow-400 hover:bg-yellow-500 text-white text-xl px-6 py-2 rounded-full shadow-md transition-all hover:scale-105 active:scale-95 border-2 border-yellow-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
            </svg>
            Ulang
        </button>

        <div class="bg-white border-2 border-pink-200 rounded-full px-6 py-2 shadow-sm flex items-center gap-2">
            <span class="font-mooli font-semibold text-pink-400 text-xl">Skor:</span>
            <span id="scoreDisplay" class="font-mooli text-2xl font-bold text-pink-500">0</span>
        </div>
    </div>

    <div class="w-full max-w-6xl mx-auto relative z-10 pt-24 px-4">



        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-12 items-start">

            <div class="order-2 md:order-1">
                <div
                    class="bg-white/90 backdrop-blur-sm rounded-[2rem] p-6 shadow-xl border-4 border-pink-100 min-h-[450px] relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-2 bg-pink-200"></div>
                    <h3 class="text-center text-pink-400 font-bold mb-6 text-3xl font-cursive">
                        <span class="phrase-pink">Pilih </span>
                        <span class="phrase-pink"> Huruf </span>
                    </h3>
                    <div id="draggableContainer" class="grid grid-cols-3 sm:grid-cols-4 gap-4 justify-items-center">
                    </div>
                </div>
            </div>

            <div class="order-1 md:order-2">
                <div class="bg-white rounded-[2rem] p-6 shadow-xl border-4 border-pink-50 min-h-[450px]">
                    <h3 class="text-center text-gray-400 font-bold mb-6 text-3xl font-cursive">
                        <span class="phrase-abu">Tempel </span>
                        <span class="phrase-abu">Disini</span>
                    </h3>
                    <div id="dropzoneContainer" class="grid grid-cols-2 gap-4"></div>
                </div>
            </div>
        </div>

    </div>

    {{-- Balon kanan --}}
    <div class="fixed right-0 top-1/4 w-40 md:w-50 h-auto animate-bounce-slow z-0 pointer-events-none">
        <img src="{{ asset('images/icon/balon.webp') }}" alt="Balon Kanan"
            class="w-full h-auto drop-shadow-lg transform scale-x-[-1]">
    </div>

    {{-- POP UP SELESAI BERMAIN --}}
    <div id="success-modal" class="fixed inset-0 z-50 flex items-center justify-center hidden">
        <div class="absolute inset-0 transition-opacity duration-300" style="background-color: rgba(0, 0, 0, 0.6);">
        </div>

        <div
            class="relative bg-white rounded-3xl p-8 max-w-sm w-full mx-4 shadow-2xl transform  scale-90 transition-transform duration-300 border-4 border-pink-300 text-center">
            <div class=" mb-4 animate-bounce">
                <img src="{{ asset('images/icon/piala.webp') }}" alt="Piala" class="w-24 h-auto mx-auto">
            </div>

            <h2 class="font-['TegakBersambung'] text-4xl text-pink-500 font-bold mb-2">
                <span class="phrase-pink-kontras">Luar </span>
                <span class="phrase-pink-kontras">Biasa!</span>
            </h2>

            <p class="font-['TegakBersambung'] text-[gray-600] mb-6 text-2xl">
                <span class="phrase-hitam">Kamu </span>
                <span class="phrase-hitam">berhasil </span>
                <span class="phrase-hitam">menyelesaikan </span>
                <span class="phrase-hitam">permainan! </span>
            </p>

            <div class="bg-pink-50 rounded-xl p-4 mb-6 border border-pink-100">
                <p class="text-gray-500 text-sm font-bold uppercase">Total Poin</p>
                <p class="text-4xl font-bold text-pink-600" id="modal-score">0</p>
            </div>

            <div class="flex flex-col gap-3">
                <button onclick="initGame()"
                    class="w-full py-3 bg-gradient-to-r from-pink-400 to-pink-500 text-white rounded-xl font-bold text-xl shadow-lg hover:scale-105 transition-transform font-mooli font-semibold text-base">
                    Main Lagi ↻
                </button>

                <a href="{{ route('murid.games.index', $tingkatan->tingkatan_id) }}"
                    class="w-full py-3 bg-white border-2 border-gray-200 text-gray-500 rounded-xl font-bold text-lg hover:bg-gray-50 transition-colors  font-mooli font-semibold text-base">
                    Kembali ke Menu </a>
            </div>
        </div>
    </div>

    <script>
        // --- DATA & CONFIG ---
        const allHijaiyahData = @json($hijaiyahData);
        const QUESTIONS_PER_SESSION = 10;
        const MAX_SCORE = 100;

        let currentScore = 0;
        let matchedCount = 0;
        let currentSessionData = [];

        // DOM Elements
        const draggableContainer = document.getElementById('draggableContainer');
        const dropzoneContainer = document.getElementById('dropzoneContainer');
        const scoreDisplay = document.getElementById('scoreDisplay');
        const successModal = document.getElementById('success-modal');
        const modalScore = document.getElementById('modal-score');

        document.addEventListener('DOMContentLoaded', () => {
            initGame();
        });

        function initGame() {
            currentScore = 0;
            matchedCount = 0;
            updateScoreUI();
            closeModal();

            const shuffled = [...allHijaiyahData].sort(() => 0.5 - Math.random());
            currentSessionData = shuffled.slice(0, QUESTIONS_PER_SESSION);

            renderDropzones(currentSessionData);
            renderDraggables(currentSessionData);
        }

        // --- RENDERING ---
        function renderDraggables(data) {
            draggableContainer.innerHTML = '';
            const shuffledForDrag = [...data].sort(() => 0.5 - Math.random());

            shuffledForDrag.forEach(item => {
                const div = document.createElement('div');
                div.className = `
                    draggable-item cursor-grab active:cursor-grabbing 
                    bg-white rounded-2xl p-2 w-20 h-20 md:w-24 md:h-24
                    shadow-[0_4px_0_rgb(0,0,0,0.05)] border-2 border-pink-100 
                    hover:border-pink-300 hover:-translate-y-1 transition-all duration-200
                    flex items-center justify-center
                `;
                div.setAttribute('draggable', 'true');
                div.setAttribute('data-id', item.file);

                const img = document.createElement('img');
                img.src = `/images/hijaiyah/${item.file}.webp`;
                img.alt = item.latin;
                img.className = "w-full h-full object-contain pointer-events-none drop-shadow-sm";

                div.appendChild(img);

                // Events
                div.addEventListener('dragstart', handleDragStart);
                div.addEventListener('dragend', handleDragEnd);
                div.addEventListener('touchstart', handleTouchStart, {
                    passive: false
                });
                div.addEventListener('touchmove', handleTouchMove, {
                    passive: false
                });
                div.addEventListener('touchend', handleTouchEnd);

                draggableContainer.appendChild(div);
            });
        }

        function renderDropzones(data) {
            dropzoneContainer.innerHTML = '';
            data.forEach(item => {
                const div = document.createElement('div');
                div.className = `
                    dropzone-item bg-white rounded-2xl p-3 md:p-4 
                    border-2 border-dashed border-gray-300 
                    flex items-center justify-between
                    transition-all duration-300 h-20 md:h-24 shadow-sm
                `;
                div.setAttribute('data-target', item.file);

                const text = document.createElement('span');
                text.className =
                    "font-cursive text-2xl md:text-3xl font-bold text-gray-400 phrase-abu select-none ml-2";
                text.textContent = item.latin;

                const slot = document.createElement('div');
                slot.className =
                    "w-12 h-12 md:w-16 md:h-16 bg-gray-100 rounded-xl flex items-center justify-center border border-gray-200";
                slot.innerHTML = '<span class="font-mooli text-2xl opacity-20">?</span>';

                div.appendChild(text);
                div.appendChild(slot);

                div.addEventListener('dragover', handleDragOver);
                div.addEventListener('dragleave', handleDragLeave);
                div.addEventListener('drop', handleDrop);

                dropzoneContainer.appendChild(div);
            });
        }

        // --- GAME LOGIC ---
        // (Logic Drag/Drop sama persis, saya persingkat di sini agar fokus ke fitur baru)
        let draggedElement = null;

        function handleDragStart(e) {
            draggedElement = this;
            setTimeout(() => this.classList.add('opacity-50', 'scale-95', 'grayscale'), 0);
            e.dataTransfer.effectAllowed = 'move';
            e.dataTransfer.setData('text/plain', this.getAttribute('data-id'));
        }

        function handleDragEnd(e) {
            this.classList.remove('opacity-50', 'scale-95', 'grayscale');
            draggedElement = null;
        }

        function handleDragOver(e) {
            e.preventDefault();
            if (this.classList.contains('locked')) return;
            e.dataTransfer.dropEffect = 'move';
            this.classList.add('bg-pink-50', 'border-pink-300', 'scale-[1.02]');
            this.classList.remove('border-dashed');
        }

        function handleDragLeave(e) {
            if (this.classList.contains('locked')) return;
            this.classList.remove('bg-pink-50', 'border-pink-300', 'scale-[1.02]');
            this.classList.add('border-dashed');
        }

        function handleDrop(e) {
            e.preventDefault();
            if (this.classList.contains('locked')) return;
            this.classList.remove('bg-pink-50', 'border-pink-300', 'scale-[1.02]');
            const draggedId = e.dataTransfer.getData('text/plain');
            const targetId = this.getAttribute('data-target');
            checkMatch(draggedId, targetId, this);
        }

        function checkMatch(draggedId, targetId, dropzoneElement) {
            if (draggedId === targetId) {
                handleCorrectMatch(dropzoneElement, draggedId);
            } else {
                handleWrongMatch(dropzoneElement);
            }
        }

        function handleCorrectMatch(dropzone, id) {
            dropzone.classList.remove('bg-white', 'border-gray-300', 'border-dashed');
            dropzone.classList.add('bg-green-50', 'border-green-400', 'border-solid', 'locked', 'shadow-md');

            const slot = dropzone.querySelector('div');
            if (slot) {
                slot.innerHTML = `<span class="text-3xl animate-bounce">✅</span>`;
                slot.className = "w-12 h-12 md:w-16 md:h-16 flex items-center justify-center";
            }

            const text = dropzone.querySelector('span');
            if (text) {
                text.classList.remove('text-gray-400');
                text.classList.add('text-green-600');
            }

            const draggable = document.querySelector(`.draggable-item[data-id="${id}"]`);
            if (draggable) {
                draggable.style.transform = "scale(0) rotate(360deg)";
                draggable.style.opacity = "0";
                setTimeout(() => {
                    draggable.style.display = 'none';
                }, 300);
            }

            currentScore += (MAX_SCORE / QUESTIONS_PER_SESSION);
            matchedCount++;
            updateScoreUI();
            playSound('correct');

            if (matchedCount === QUESTIONS_PER_SESSION) {
                setTimeout(finishGame, 800);
            }
        }

        function handleWrongMatch(dropzone) {
            dropzone.classList.add('animate-shake', 'bg-red-50', 'border-red-300');
            const originalBorder = dropzone.classList.contains('border-dashed');
            dropzone.classList.remove('border-dashed');
            playSound('wrong');
            setTimeout(() => {
                dropzone.classList.remove('animate-shake', 'bg-red-50', 'border-red-300');
                if (originalBorder) dropzone.classList.add('border-dashed');
            }, 500);
        }

        // --- 5. LOGIKA FINISH GAME & CONFETTI ---
        function finishGame() {
            const score = Math.round(currentScore);
            if (modalScore) modalScore.innerText = score;
            saveScoreToServer(score);

            // Tampilkan Modal
            successModal.classList.remove('hidden');
            successModal.classList.add('flex');

            // Animasi Masuk
            const modalBox = successModal.querySelector('div.relative');
            setTimeout(() => {
                modalBox.classList.remove('scale-90');
                modalBox.classList.add('scale-100');
            }, 10);

            // Panggil Confetti
            triggerWinConfetti();
        }

        function triggerWinConfetti() {
            var duration = 3 * 1000;
            var animationEnd = Date.now() + duration;
            var defaults = {
                startVelocity: 30,
                spread: 360,
                ticks: 60,
                zIndex: 9999
            };

            var random = function(min, max) {
                return Math.random() * (max - min) + min;
            }

            var interval = setInterval(function() {
                var timeLeft = animationEnd - Date.now();
                if (timeLeft <= 0) return clearInterval(interval);

                var particleCount = 50 * (timeLeft / duration);
                confetti(Object.assign({}, defaults, {
                    particleCount,
                    origin: {
                        x: random(0.1, 0.3),
                        y: Math.random() - 0.2
                    }
                }));
                confetti(Object.assign({}, defaults, {
                    particleCount,
                    origin: {
                        x: random(0.7, 0.9),
                        y: Math.random() - 0.2
                    }
                }));
            }, 250);
        }

        function closeModal() {
            successModal.classList.add('hidden');
            successModal.classList.remove('flex');
            const modalBox = successModal.querySelector('div.relative');
            modalBox.classList.remove('scale-100');
            modalBox.classList.add('scale-90');
        }

        function updateScoreUI() {
            scoreDisplay.textContent = Math.round(currentScore);
        }

        async function saveScoreToServer(score) {
            const url = "{{ route('murid.game.saveScore') }}";
            const jenisGameId = "{{ $jenisGame ? $jenisGame->jenis_game_id : 1 }}";
            try {
                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        jenis_game_id: jenisGameId,
                        skor: score
                    })
                });
            } catch (error) {
                console.error('Failed to save score:', error);
            }
        }

        // Mobile Touch Logic (Singkat)
        let touchEl = null;
        let touchStartX = 0;
        let touchStartY = 0;

        function handleTouchStart(e) {
            e.preventDefault();
            touchEl = this;
            const touch = e.touches[0];
            touchStartX = touch.clientX;
            touchStartY = touch.clientY;
            this.style.zIndex = 1000;
            this.style.position = 'relative';
            this.classList.add('scale-110', 'shadow-2xl');
        }

        function handleTouchMove(e) {
            e.preventDefault();
            if (!touchEl) return;
            const touch = e.touches[0];
            const deltaX = touch.clientX - touchStartX;
            const deltaY = touch.clientY - touchStartY;
            touchEl.style.transform = `translate(${deltaX}px, ${deltaY}px) scale(1.1)`;
        }

        function handleTouchEnd(e) {
            if (!touchEl) return;
            touchEl.style.display = 'none';
            const touch = e.changedTouches[0];
            const elementBelow = document.elementFromPoint(touch.clientX, touch.clientY);
            touchEl.style.display = 'flex';
            const dropzone = elementBelow ? elementBelow.closest('.dropzone-item') : null;
            const draggedId = touchEl.getAttribute('data-id');
            if (dropzone && !dropzone.classList.contains('locked')) {
                const targetId = dropzone.getAttribute('data-target');
                if (draggedId === targetId) {
                    checkMatch(draggedId, targetId, dropzone);
                } else {
                    returnToOrigin(touchEl);
                    handleWrongMatch(dropzone);
                }
            } else {
                returnToOrigin(touchEl);
            }
            touchEl = null;
        }

        function returnToOrigin(el) {
            el.style.transition = 'transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275)';
            el.style.transform = 'translate(0, 0)';
            el.classList.remove('scale-110', 'shadow-2xl');
            el.style.zIndex = '';
            setTimeout(() => {
                el.style.transition = '';
            }, 300);
        }

        function playSound(type) {}
    </script>
</body>

</html>
