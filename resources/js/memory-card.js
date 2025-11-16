import confetti from 'canvas-confetti';

var poinBenar = 0;
var pasanganDitemukan = 0;
var totalPasangan = 6; 

var cardMasterList = [
    { id: "alif", latin: "Alif" },
    { id: "ba", latin: "Ba" },
    { id: "ta", latin: "Ta" },
    { id: "tsa", latin: "Tsa" },
    { id: "jim", latin: "Jim" },
    { id: "kha", latin: "Kha" },
    { id: "kho", latin: "Kho" },
    { id: "dal", latin: "Dal" },
    { id: "dzal", latin: "Dzal" },
    { id: "ra", latin: "Ra" },
    { id: "za", latin: "Za" },
    { id: "sin", latin: "Sin" },
    { id: "syin", latin: "Syin" },
    { id: "shod", latin: "Shod" },
    { id: "dhod", latin: "Dhod" },
    { id: "tho", latin: "Tho" },
    { id: "dhlo", latin: "Dhlo" },
    { id: "ain", latin: "Ain" },
    { id: "ghoin", latin: "Ghoin" },
    { id: "fa", latin: "Fa" },
    { id: "qof", latin: "Qof" },
    { id: "kaf", latin: "Kaf" },
    { id: "lam", latin: "Lam" },
    { id: "mim", latin: "Mim" },
    { id: "nun", latin: "Nun" },
    { id: "wawu", latin: "Wawu" },
    { id: "hamzah", latin: "Hamzah" },
    { id: "ya", latin: "Ya" }
];

var cardSet; 
// var board = [];
// var rows = 3;
// var columns = 4;

var card1Selected = null;
var card2Selected = null;
var lockBoard = false; 

window.onload = function () {
    shuffleCards();
    startGame();

    document.getElementById("poin-benar").innerText = poinBenar;
    document.getElementById("current-matches").innerText = pasanganDitemukan;

    // Listener tombol reset
    document.getElementById("reset-button").addEventListener("click", () => {
        shuffleCards();
        startGame();
    });

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
    
   // 1. Acak dulu "Master Database"
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
            content: `<span>${kartu.latin}</span>`
        });
    });

    // 4. Acak 12 kartu yang akan dimainkan
    for (let i = cardSet.length - 1; i > 0; i--) {
        let j = Math.floor(Math.random() * (i + 1));
        [cardSet[i], cardSet[j]] = [cardSet[j], cardSet[i]];
    }
}

function startGame() {
    // Reset papan & skor
    pasanganDitemukan = 0;
    poinBenar = 0;
    lockBoard = true; // <-- 1. KUNCI PAPAN DARI AWAL
    
    document.getElementById("poin-benar").innerText = poinBenar;
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

    // --- LOGIKA "INTIP" 2 DETIK ---
    
    // 3. Setel "Alarm" 2 detik
    setTimeout(() => {
        
        // Ambil SEMUA kartu yang ada di papan
        let allCards = document.querySelectorAll('#board .card'); 
        
        allCards.forEach(card => {
            // 4. BALIKKAN SEMUA KARTU (Tutup)
            card.classList.remove("is-flipped");
        });

        // 5. BUKA KUNCI PAPAN, game siap dimainkan!
        lockBoard = false; 
        
    }, 2000); // <-- Waktu "intip" (2000ms = 2 detik)
} 

// --- BEDAH #4: Fungsi SelectCard (Pakai kelas .is-flipped) ---
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

// --- BEDAH #5: Fungsi Update (Logika Baru yang Keren) ---
function update() {
    
    // --- INI LOGIKA BARUNYA ---
    let isMatch = false;
    
    // Cek: Apakah ID-nya sama? (misal: 'alif' === 'alif')
    if (card1Selected.dataset.id === card2Selected.dataset.id) {
        // Cek: Apakah tipenya BEDA? (misal: 'hijaiyah' !== 'latin')
        if (card1Selected.dataset.type !== card2Selected.dataset.type) {
            isMatch = true;
        }
    }

    if (!isMatch) { 
        // --- JIKA TIDAK COCOK ---
        // Balikkan kartu (secara visual)
        card1Selected.classList.remove("is-flipped");
        card2Selected.classList.remove("is-flipped");
        
        // (Kita hapus poinSalah, sesuaikan dengan HTML)
        
    } else { 
        // --- JIKA COCOK! ---
        // "Matikan" kartu biar nggak bisa diklik lagi
        card1Selected.removeEventListener("click", selectCard);
        card2Selected.removeEventListener("click", selectCard);
        
        // Update skor
        poinBenar += 1; // (Nanti bisa diubah skornya, misal +10)
        pasanganDitemukan += 1;
        document.getElementById("poin-benar").innerText = poinBenar;
        document.getElementById("current-matches").innerText = pasanganDitemukan;

        // Cek Menang
        if (pasanganDitemukan === totalPasangan) {
            
            // Tembak Confetti!
            confetti({
                particleCount: 150,
                spread: 70,
                origin: { y: 0.6 }
            });

            setTimeout(() => {
                alert("Selamat! Kamu Menang!");
                shuffleCards();
                startGame();
            }, 500);
        }
    }

    // Reset untuk giliran berikutnya
    card1Selected = null;
    card2Selected = null;
    lockBoard = false; // Buka kunci papan
}