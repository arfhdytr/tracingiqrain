import confetti from 'canvas-confetti';

var poinBenar = 0;
var pasanganDitemukan = 0;
var totalPasangan = 6; 

var gameStaticId = typeof GAME_STATIC_ID !== 'undefined' ? GAME_STATIC_ID : null;
var jenisGameId = typeof JENIS_GAME_ID !== 'undefined' ? JENIS_GAME_ID : null;
var poinMaksimal = typeof POIN_MAKSIMAL !== 'undefined' ? POIN_MAKSIMAL : 100;
var POIN_PER_MATCH = poinMaksimal / totalPasangan;

var cardMasterList = [
    { id: "ain", latin: "Ain" },
    { id: "alif", latin: "Alif" },
    { id: "ba", latin: "Ba" },
    { id: "dal", latin: "Dal" },
    { id: "Dhad", latin: "Dhad" },
    { id: "dzal", latin: "Dzal" },
    { id: "fa", latin: "Fa" },
    { id: "Ghain", latin: "Ghain" },
    { id: "Ha", latin: "Ha" },
    { id: "hamzah", latin: "Hamzah" },

    { id: "jim", latin: "Jim" },
    { id: "kaf", latin: "Kaf" },
    { id: "kha", latin: "Kha" },
    { id: "kho", latin: "Kho" },
    { id: "lam", latin: "Lam" },
    { id: "Lamalif", latin: "Lam Alif" },
    { id: "mim", latin: "Mim" },
    { id: "nun", latin: "Nun" },
    { id: "Qaf", latin: "Qaf" },
    { id: "ra", latin: "Ra" },

    { id: "Sad", latin: "Sad" },
    { id: "sin", latin: "Sin" },
    { id: "syin", latin: "Syin" },
    { id: "ta", latin: "Ta" },
    { id: "Tha", latin: "Tha" },
    { id: "tsa", latin: "Tsa" },
    { id: "Waw", latin: "Waw" },
    { id: "ya", latin: "Ya" },
    { id: "Zayn", latin: "Zain" },
    { id: "Zha", latin: "Zha" }
];

var cardSet; 

var card1Selected = null;
var card2Selected = null;
var lockBoard = false; 

window.onload = function () {
    shuffleCards();
    startGame();
    
    document.getElementById("current-matches").innerText = pasanganDitemukan;
    
    // Untuk mengatur murid pas mau restart
    document.getElementById("reset-button").addEventListener("click", () => {
        shuffleCards();
        startGame();
    });

    // Welcome message
    const welcomeBackdrop = document.getElementById("welcome-backdrop");
    const welcomeMessage = document.getElementById("welcome-message");

    if (welcomeBackdrop && welcomeMessage) {
        // 1. Tampilkan teks (fade in)
        // Kita beri sedikit delay biar CSS awal opacity-0 kebaca dulu
        setTimeout(() => {
            welcomeMessage.classList.remove("opacity-0"); // Tampilkan teks
            welcomeMessage.classList.add("opacity-100"); // Pastikan opacity penuh
        }, 100); // Delay kecil agar transisi opacity-0 -> opacity-100 bekerja

        // 2. Setel alarm untuk menyembunyikan (fade out)
        setTimeout(() => {
            welcomeMessage.classList.remove("opacity-100"); // Mulai fade out teks
            welcomeMessage.classList.add("opacity-0"); // Pastikan opacity nol
            
            welcomeBackdrop.classList.remove("opacity-100"); // Mulai fade out backdrop
            welcomeBackdrop.classList.add("opacity-0"); // Pastikan opacity nol

            // 3. Setelah animasi fade out selesai, baru sembunyikan sepenuhnya (display: none)
            setTimeout(() => {
                welcomeBackdrop.classList.add("hidden");
                welcomeMessage.classList.add("hidden");
            }, 1000); // Tunggu selama durasi animasi (duration-1000ms = 1 detik)
            
        }, 2000); // Alarm utama: mulai fade out setelah 2 detik
    }
};

function shuffleCards() {

    // Mengacak kartu
    cardMasterList.sort(() => 0.5 - Math.random());

    // 2. Ambil 6 kartu pertama
    let gameCards = cardMasterList.slice(0, totalPasangan); 
    
    // 3. Buat "cardSet" (isi 12 kartu)
    cardSet = [];
    let basePath = (typeof ASSET_BASE !== "undefined" ? ASSET_BASE : "");

    gameCards.forEach((kartu) => {
        // Tambah kartu Tipe HIJAIYAH (Gambar)
        cardSet.push({
            id: kartu.id,
            type: "hijaiyah",
            content: `<img src="${basePath}images/hijaiyah/${kartu.id}.webp" alt="${kartu.id}">`
        });
        
        // Tambah kartu Tipe LATIN (Teks)
        cardSet.push({
            id: kartu.id,
            type: "latin",
            content: `<span class="font-tegak text-4xl font-bold text-pink-500">${kartu.latin}</span>`
        });
    });

    // Acak 12 kartu yang akan dimainkan
    for (let i = cardSet.length - 1; i > 0; i--) {
        let j = Math.floor(Math.random() * (i + 1));
        [cardSet[i], cardSet[j]] = [cardSet[j], cardSet[i]];
    }
}

function startGame() {
    // Reset papan & skor
    pasanganDitemukan = 0;
    poinBenar = 0;
    lockBoard = true; 
        
    document.getElementById("current-matches").innerText = pasanganDitemukan;

    const boardEl = document.getElementById("board");
    boardEl.innerHTML = ""; // Kosongkan papan

    // Loop untuk 12 kartu
    for (let cardData of cardSet) {
        
        // --- Bikin Kartu ---
        let card = document.createElement("div");
        card.classList.add("card");
        
        // ▼▼▼ TAMBAHAN BARU ▼▼▼
        card.classList.add("is-flipped"); // <-- 2. KARTU LANGSUNG KEBUKA
        
        card.dataset.id = cardData.id;
        card.dataset.type = cardData.type;

        let inner = document.createElement("div");
        inner.classList.add("card-inner");

        let front = document.createElement("div");
        front.classList.add("card-front");
        front.innerHTML = '❓';

        let back = document.createElement("div");
        back.classList.add("card-back");
        back.innerHTML = cardData.content; 

        // Rakit
        inner.appendChild(front);
        inner.appendChild(back);
        card.appendChild(inner);
        
        card.addEventListener("click", selectCard);
        boardEl.append(card);
    }

    // Ngintip 2 detik
    setTimeout(() => {
                        
        let allCards = document.querySelectorAll('#board .card'); 
        
        allCards.forEach(card => {        
            card.classList.remove("is-flipped");
        });

        // 5. BUKA KUNCI PAPAN, game siap dimainkan!
        lockBoard = false; 
        
    }, 2000); 
} 

function selectCard() {
    // 'this' sekarang adalah <div class="card">
    
    // Pengecekan baru: Jangan klik jika papan dikunci ATAU kartu sudah kebuka
    if (lockBoard || this.classList.contains("is-flipped")) {
        return;
    }

    // BALIK KARTU (secara visual)
    this.classList.add("is-flipped");

    if (!card1Selected) {
        // Ini klik pertama
        card1Selected = this;
    } else {
        // Ini klik kedua
        card2Selected = this;
        lockBoard = true; // Kunci papan
        setTimeout(update, 1000); // Cek kecocokan
    }
}

// Fungsi update
async function update() {
        
    let isMatch = false;
    
    // Cek: Apakah ID-nya sama? (misal: 'alif' === 'alif')
    if (card1Selected.dataset.id === card2Selected.dataset.id) {
        // Cek: Apakah tipenya BEDA? (misal: 'hijaiyah' !== 'latin')
        if (card1Selected.dataset.type !== card2Selected.dataset.type) {
            isMatch = true;
        }
    }

    if (!isMatch) { 
        // Jika kedua kartu tidak cocok
        card1Selected.classList.remove("is-flipped");
        card2Selected.classList.remove("is-flipped");               
        
    } else { 
        // --- JIKA COCOK! ---
        // "Matikan" kartu biar nggak bisa diklik lagi
        card1Selected.removeEventListener("click", selectCard);
        card2Selected.removeEventListener("click", selectCard);
        
        // Update skor
        pasanganDitemukan += 1;
        poinBenar += POIN_PER_MATCH; // (Nanti bisa diubah skornya, misal +10)
        
        document.getElementById("current-matches").innerText = pasanganDitemukan;

        // Cek Menang
        if (pasanganDitemukan === totalPasangan) {
            
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

            const response = await fetch('/murid/game/save-score', { 
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    jenis_game_id: jenisGameId, 
                    game_static_id: gameStaticId,
                    skor: pasanganDitemukan,
                    total_poin: Math.round(poinBenar)
                })
            });

                const data = await response.json();

           if (data.success) {
                    confetti({
                        particleCount: 150,
                        spread: 70,
                        origin: { y: 0.6 }
                    });

                    setTimeout(() => {
                        alert("Selamat! Kamu Menang! Skor tersimpan.");
                        shuffleCards();
                        startGame();
                    }, 500);
                
                } else {
                    // Tampilkan error jika server bilang gagal (tapi koneksi sukses)
                    alert('Wah, menang! Tapi skor gagal disimpan. (Server Error)');
                    shuffleCards();
                    startGame();
                }
        }
    }

    // Reset untuk giliran berikutnya
    card1Selected = null;
    card2Selected = null;
    lockBoard = false; // Buka kunci papan
}