// ===================================================================
// KODE FINAL UNTUK 'public/game/app.js'
// ===================================================================

// Hijaiyah Letters Data
// 5 huruf pertama punya pathCoordinates, sisanya kosong (disabled)
const letters = [
  {
    id: 'alif', // ID unik untuk LocalStorage
    arabic: 'ا',
    name: 'Alif',
    image: 'alif.png',
    difficulty: 'easy',
    pathCoordinates: [
      { x: 50, y: 50 },
      { x: 50, y: 200 }
    ],
    strokeCount: 1
  },
  {
    id: 'ba',
    arabic: 'ب',
    name: 'Ba',
    image: 'ba.png',
    pathCoordinates: [] // Kosong = Disabled
  },
  {
    id: 'ta',
    arabic: 'ت',
    name: 'Ta',
    image: 'ta.png',
    pathCoordinates: []
  },
  {
    id: 'tsa',
    arabic: 'ث',
    name: 'Tsa',
    image: 'tsa.png',
    pathCoordinates: []
  },
  {
    id: 'jim',
    arabic: 'ج',
    name: 'Jim',
    image: 'jim.png',
    pathCoordinates: []
  },
  {
    id: 'ha', // kha.png
    arabic: 'ح',
    name: 'Ha',
    image: 'kha.png',
    pathCoordinates: []
  },
  {
    id: 'kho', // kho.png
    arabic: 'خ',
    name: 'Kha',
    image: 'kho.png',
    pathCoordinates: []
  },
  {
    id: 'dal',
    arabic: 'د',
    name: 'Dal',
    image: 'dal.png',
    difficulty: 'easy',
    pathCoordinates: [
      { x: 30, y: 140 },
      { x: 50, y: 130 },
      { x: 80, y: 130 },
      { x: 90, y: 140 },
      { x: 90, y: 180 },
      { x: 30, y: 180 }
    ],
    strokeCount: 1
  },
  {
    id: 'dzal',
    arabic: 'ذ',
    name: 'Dhal',
    image: 'dzal.png',
    difficulty: 'medium',
    pathCoordinates: [
      { x: 30, y: 140 },
      { x: 50, y: 130 },
      { x: 80, y: 130 },
      { x: 90, y: 140 },
      { x: 90, y: 180 },
      { x: 30, y: 180 }
    ],
    strokeCount: 2,
    dotPosition: { x: 70, y: 110 }
  },
  {
    id: 'ra',
    arabic: 'ر',
    name: 'Ra',
    image: 'ra.png',
    difficulty: 'easy',
    pathCoordinates: [
      { x: 30, y: 160 },
      { x: 50, y: 150 },
      { x: 70, y: 160 },
      { x: 80, y: 180 }
    ],
    strokeCount: 1
  },
  {
    id: 'za',
    arabic: 'ز',
    name: 'Za',
    image: 'za.png',
    pathCoordinates: []
  },
  {
    id: 'sin',
    arabic: 'س',
    name: 'Sin',
    image: 'sin.png',
    pathCoordinates: []
  },
  {
    id: 'syin',
    arabic: 'ش',
    name: 'Syin',
    image: 'syin.png',
    pathCoordinates: []
  },
  {
    id: 'shod',
    arabic: 'ص',
    name: 'Shod',
    image: 'shod.png',
    pathCoordinates: []
  },
  {
    id: 'dhod',
    arabic: 'ض',
    name: 'Dhod',
    image: 'dhod.png',
    pathCoordinates: []
  },
  {
    id: 'tho',
    arabic: 'ط',
    name: 'Tho',
    image: 'tho.png',
    pathCoordinates: []
  },
  {
    id: 'dhlo',
    arabic: 'ظ',
    name: 'Dhlo',
    image: 'dhlo.png',
    pathCoordinates: []
  },
  {
    id: 'ain',
    arabic: 'ع',
    name: 'Ain',
    image: 'ain.png',
    pathCoordinates: []
  },
  {
    id: 'ghoin',
    arabic: 'غ',
    name: 'Ghoin',
    image: 'ghoin.png',
    pathCoordinates: []
  },
  {
    id: 'fa',
    arabic: 'ف',
    name: 'Fa',
    image: 'fa.png',
    pathCoordinates: []
  },
  {
    id: 'qof',
    arabic: 'ق',
    name: 'Qof',
    image: 'qof.png',
    pathCoordinates: []
  },
  {
    id: 'kaf',
    arabic: 'ك',
    name: 'Kaf',
    image: 'kaf.png',
    pathCoordinates: []
  },
  {
    id: 'lam',
    arabic: 'ل',
    name: 'Lam',
    image: 'lam.png',
    pathCoordinates: []
  },
  {
    id: 'mim',
    arabic: 'م',
    name: 'Mim',
    image: 'mim.png',
    pathCoordinates: []
  },
  {
    id: 'nun',
    arabic: 'ن',
    name: 'Nun',
    image: 'nun.png',
    pathCoordinates: []
  },
  {
    id: 'wawu',
    arabic: 'و',
    name: 'Waw',
    image: 'wawu.png',
    difficulty: 'easy',
    pathCoordinates: [
      { x: 80, y: 150 },
      { x: 60, y: 180 },
      { x: 40, y: 190 },
      { x: 30, y: 180 },
      { x: 40, y: 160 },
      { x: 60, y: 150 }
    ],
    strokeCount: 1
  },
  {
    id: 'ha_bulat', // hamzah.png
    arabic: 'ه',
    name: 'Ha',
    image: 'hamzah.png',
    pathCoordinates: []
  },
  {
    id: 'ya',
    arabic: 'ي',
    name: 'Ya',
    image: 'ya.png',
    pathCoordinates: []
  }
];


// Game Settings
const settings = {
  canvasWidth: 400,
  canvasHeight: 300,
  lineWidth: 5,
  tolerance: 25,
  colors: {
    correct: '#22c55e', // Green
    incorrect: '#ef4444', // Red
    guide: '#E0E0E0',
    stroke: '#3b82f6', // Blue
    background: '#F8F9FA'
  },
  scoring: {
    threeStars: 90,
    twoStars: 70,
    oneStar: 50
  }
};

// Game State
let gameState = {
  currentScreen: 'menu',
  currentLetter: null,
  isDrawing: false,
  progress: 0,
  accuracy: 0,
  tracedPoints: [],
  totalPoints: 0,
  correctPoints: 0
};

// Canvas References (dibuat null dulu)
let guideCanvas = null, guideCtx = null;
let tracingCanvas = null, tracingCtx = null;
let animationCanvas = null, animationCtx = null;

// Initialize the game
function init() {
  // Setup event listeners (HANYA listener yang aman)
  setupSafeEventListeners();

  // Generate letter menu
  generateLetterMenu();

  // Show menu screen
  showScreen('menu');
}

// Setup Event Listeners (HANYA untuk tombol/navigasi)
function setupSafeEventListeners() {
  // Tombol "Back" di layar game
  document.getElementById('backBtn').addEventListener('click', () => {
    window.location.href = '/murid/games';
  });

  // Tombol di layar Sukses
  document.getElementById('tryAgainBtn').addEventListener('click', restartLetter);
  
  // Tombol "Huruf Lain" (Next) di layar sukses
  document.getElementById('nextLetterBtn').addEventListener('click', selectNextLetter);
}

// FUNGSI BARU: untuk listener khusus game screen
function setupGameEventListeners() {
    // Mouse events
    tracingCanvas.addEventListener('mousedown', startDrawing);
    tracingCanvas.addEventListener('mousemove', draw);
    tracingCanvas.addEventListener('mouseup', stopDrawing);
    tracingCanvas.addEventListener('mouseleave', stopDrawing);

    // Touch events
    tracingCanvas.addEventListener('touchstart', handleTouchStart);
    tracingCanvas.addEventListener('touchmove', handleTouchMove);
    tracingCanvas.addEventListener('touchend', stopDrawing);

    // Button events di game screen
    document.getElementById('clearBtn').addEventListener('click', clearCanvas);
    document.getElementById('replayBtn').addEventListener('click', playAnimation);
    document.getElementById('nextBtn').addEventListener('click', selectNextLetter);
}


// Generate Letter Menu
function generateLetterMenu() {
  const letterGrid = document.getElementById('letterGrid');
  letterGrid.innerHTML = '';

  letters.forEach(letter => {
    const card = document.createElement('button');
    card.className = 'letter-card';

    // Cek status dari LocalStorage
    const isCompleted = localStorage.getItem('trace_' + letter.id) === 'true';
    const isPlayable = letter.pathCoordinates.length > 0;

    // Tampilkan gambar (icon)
    card.innerHTML = `
      <img src="/images/hijaiyah/${letter.image}" alt="${letter.name}" class="letter-card-image">
      <span class="letter-card-name">${letter.name}</span>
    `;

    // Tambahkan class CSS berdasarkan status
    if (isCompleted) {
      card.classList.add('completed');
    }

    if (!isPlayable) {
      card.classList.add('disabled');
    }

    // Hanya tambahkan event listener jika huruf bisa dimainkan
    if (isPlayable) {
      card.addEventListener('click', () => selectLetter(letter));
    }
    
    letterGrid.appendChild(card);
  });
}

// Select Letter and Start Game
function selectLetter(letter) {
  // Cek lagi, jangan sampai huruf disabled terpilih
  if (!letter || letter.pathCoordinates.length === 0) {
    console.warn('Attempted to select a non-playable letter.');
    return;
  }
  
  // ==========================================================
  // SETUP CANVAS DAN LISTENER (PINDAHKAN KE SINI)
  // Cek apakah sudah di-setup, jika belum, setup sekarang
  if (!guideCtx) {
    guideCanvas = document.getElementById('guideCanvas');
    guideCtx = guideCanvas.getContext('2d');
    tracingCanvas = document.getElementById('tracingCanvas');
    tracingCtx = tracingCanvas.getContext('2d');
    animationCanvas = document.getElementById('animationCanvas');
    animationCtx = animationCanvas.getContext('2d');

    // Panggil listener game HANYA SEKALI, saat pertama kali
    setupGameEventListeners();
  }
  // ==========================================================
    
  gameState.currentLetter = letter;
  gameState.progress = 0;
  gameState.accuracy = 0;
  gameState.tracedPoints = [];
  gameState.totalPoints = 0;
  gameState.correctPoints = 0;

  // Update UI
  document.getElementById('letterName').textContent = letter.name;
  document.getElementById('letterArabic').textContent = letter.arabic;
  document.getElementById('letterTransliteration').textContent = letter.name;
  document.getElementById('letterDisplay').textContent = letter.arabic;

  // Draw guide
  drawGuide(letter);

  // Clear tracing canvas
  clearCanvas();

  // Play animation
  playAnimation();

  // Update progress
  updateProgress();

  // Show game screen
  showScreen('game');
}

// FUNGSI BARU: untuk memilih huruf selanjutnya
function selectNextLetter() {
    const currentId = gameState.currentLetter.id;
    const currentIndex = letters.findIndex(l => l.id === currentId);

    let nextIndex = (currentIndex + 1);

    // Loop untuk mencari huruf BERIKUTNYA yang bisa dimainkan (playable)
    for (let i = 0; i < letters.length; i++) {
        let testIndex = (nextIndex + i) % letters.length;
        let nextLetter = letters[testIndex];

        if (nextLetter.pathCoordinates.length > 0) {
            // Temukan huruf!
            selectLetter(nextLetter);
            return;
        }
    }

    // Jika tidak ada huruf lain yang bisa dimainkan, kembali ke menu
    showScreen('menu');
}


// Draw Guide Path
function drawGuide(letter) {
  guideCtx.clearRect(0, 0, guideCanvas.width, guideCanvas.height);
  guideCtx.fillStyle = settings.colors.background;
  guideCtx.fillRect(0, 0, guideCanvas.width, guideCanvas.height);

  // Periksa apakah pathCoordinates ada dan tidak kosong
  if (!letter.pathCoordinates || letter.pathCoordinates.length === 0) {
      return; // Jangan gambar guide jika tidak ada path
  }

  const path = letter.pathCoordinates;

  // Draw dotted guide line
  guideCtx.strokeStyle = settings.colors.guide;
  guideCtx.lineWidth = settings.lineWidth * 2; // Buat guide lebih tebal
  guideCtx.lineCap = 'round';
  guideCtx.lineJoin = 'round';
  guideCtx.setLineDash([10, 10]);

  guideCtx.beginPath();
  guideCtx.moveTo(path[0].x, path[0].y);
  for (let i = 1; i < path.length; i++) {
    guideCtx.lineTo(path[i].x, path[i].y);
  }
  guideCtx.stroke();
  guideCtx.setLineDash([]);

  // Draw start point
  guideCtx.fillStyle = '#4CAF50';
  guideCtx.beginPath();
  guideCtx.arc(path[0].x, path[0].y, 8, 0, Math.PI * 2);
  guideCtx.fill();

  // Draw end point
  guideCtx.fillStyle = '#F44336';
  guideCtx.beginPath();
  guideCtx.arc(path[path.length - 1].x, path[path.length - 1].y, 8, 0, Math.PI * 2);
  guideCtx.fill();

  // Draw dot if exists (for Dhal)
  if (letter.dotPosition) {
    guideCtx.fillStyle = '#000';
    guideCtx.beginPath();
    guideCtx.arc(letter.dotPosition.x, letter.dotPosition.y, 5, 0, Math.PI * 2);
    guideCtx.fill();
  }
}

// Play Animation
function playAnimation() {
  const letter = gameState.currentLetter;
  if (!letter || !letter.pathCoordinates || letter.pathCoordinates.length === 0) return;

  animationCtx.clearRect(0, 0, animationCanvas.width, animationCanvas.height);

  const path = letter.pathCoordinates;
  let currentPoint = 0;
  let progress = 0;

  // Scale coordinates to fit animation canvas
  const scaleX = animationCanvas.width / settings.canvasWidth;
  const scaleY = animationCanvas.height / settings.canvasHeight;

  function animate() {
    if (currentPoint >= path.length - 1) {
      // Animation complete, draw dot if exists
      if (letter.dotPosition) {
        animationCtx.fillStyle = '#000';
        animationCtx.beginPath();
        animationCtx.arc(
          letter.dotPosition.x * scaleX,
          letter.dotPosition.y * scaleY,
          5,
          0,
          Math.PI * 2
        );
        animationCtx.fill();
      }
      return;
    }

    const start = path[currentPoint];
    const end = path[currentPoint + 1];

    const x = start.x + (end.x - start.x) * progress;
    const y = start.y + (end.y - start.y) * progress;

    animationCtx.strokeStyle = settings.colors.stroke;
    animationCtx.lineWidth = settings.lineWidth;
    animationCtx.lineCap = 'round';
    animationCtx.lineJoin = 'round';

    if (progress === 0) {
      animationCtx.beginPath();
      animationCtx.moveTo(start.x * scaleX, start.y * scaleY);
    }

    animationCtx.lineTo(x * scaleX, y * scaleY);
    animationCtx.stroke();

    progress += 0.05; // Sedikit lebih cepat
    if (progress >= 1) {
      progress = 0;
      currentPoint++;
    }

    requestAnimationFrame(animate);
  }

  animate();
}

// Drawing Functions
function startDrawing(e) {
  gameState.isDrawing = true;
  const pos = getMousePos(e);
  tracingCtx.beginPath();
  tracingCtx.moveTo(pos.x, pos.y);
}

function draw(e) {
  if (!gameState.isDrawing) return;

  const pos = getMousePos(e);
  const isCorrect = checkAccuracy(pos);

  // Update statistics
  gameState.totalPoints++;
  if (isCorrect) {
    gameState.correctPoints++;
  }

  // Draw with color feedback
  tracingCtx.strokeStyle = isCorrect ? settings.colors.correct : settings.colors.incorrect;
  tracingCtx.lineWidth = settings.lineWidth;
  tracingCtx.lineCap = 'round';
  tracingCtx.lineJoin = 'round';
  tracingCtx.lineTo(pos.x, pos.y);
  tracingCtx.stroke();
  tracingCtx.beginPath();
  tracingCtx.moveTo(pos.x, pos.y);

  gameState.tracedPoints.push({ x: pos.x, y: pos.y, correct: isCorrect });

  // Update progress and accuracy
  calculateProgress();
  updateProgress();
}

function stopDrawing() {
  if (!gameState.isDrawing) return;
  gameState.isDrawing = false;
  tracingCtx.beginPath();

  // Check if letter is complete
  if (gameState.progress >= 80) {
    setTimeout(() => {
      showSuccessScreen();
    }, 500);
  }
}

function handleTouchStart(e) {
  e.preventDefault();
  const touch = e.touches[0];
  const mouseEvent = new MouseEvent('mousedown', {
    clientX: touch.clientX,
    clientY: touch.clientY
  });
  tracingCanvas.dispatchEvent(mouseEvent);
}

function handleTouchMove(e) {
  e.preventDefault();
  const touch = e.touches[0];
  const mouseEvent = new MouseEvent('mousemove', {
    clientX: touch.clientX,
    clientY: touch.clientY
  });
  tracingCanvas.dispatchEvent(mouseEvent);
}

// Get Mouse Position
function getMousePos(e) {
  const rect = tracingCanvas.getBoundingClientRect();
  const scaleX = tracingCanvas.width / rect.width;
  const scaleY = tracingCanvas.height / rect.height;

  return {
    x: (e.clientX - rect.left) * scaleX,
    y: (e.clientY - rect.top) * scaleY
  };
}

// Check Accuracy
function checkAccuracy(point) {
  const letter = gameState.currentLetter;
  if (!letter || !letter.pathCoordinates || letter.pathCoordinates.length === 0) return false;

  const path = letter.pathCoordinates;

  // Check distance to any point on the path
  for (let i = 0; i < path.length - 1; i++) {
    const start = path[i];
    const end = path[i + 1];

    // Check distance to line segment
    const distance = distanceToLineSegment(point, start, end);
    if (distance <= settings.tolerance) {
      return true;
    }
  }

  return false;
}

// Distance to Line Segment
function distanceToLineSegment(point, start, end) {
  const A = point.x - start.x;
  const B = point.y - start.y;
  const C = end.x - start.x;
  const D = end.y - start.y;

  const dot = A * C + B * D;
  const lenSq = C * C + D * D;
  let param = -1;

  if (lenSq !== 0) {
    param = dot / lenSq;
  }

  let xx, yy;

  if (param < 0) {
    xx = start.x;
    yy = start.y;
  } else if (param > 1) {
    xx = end.x;
    yy = end.y;
  } else {
    xx = start.x + param * C;
    yy = start.y + param * D;
  }

  const dx = point.x - xx;
  const dy = point.y - yy;

  return Math.sqrt(dx * dx + dy * dy);
}

// Calculate Progress
function calculateProgress() {
  const letter = gameState.currentLetter;
  if (!letter || !letter.pathCoordinates || letter.pathCoordinates.length === 0) return;

  const path = letter.pathCoordinates;
  const pathLength = calculatePathLength(path);

  // Calculate covered path length
  let coveredLength = 0;
  const tracedPoints = gameState.tracedPoints;

  // Hitung jarak yang sudah ditempuh di dalam path
  let tracedPathLength = 0;
  let lastValidPoint = null;

  for (const point of tracedPoints) {
    if (checkAccuracy(point)) {
        if (lastValidPoint) {
            const dist = Math.sqrt((point.x - lastValidPoint.x) ** 2 + (point.y - lastValidPoint.y) ** 2);
            tracedPathLength += dist;
        }
        lastValidPoint = point;
    }
  }

  gameState.progress = Math.min(100, (tracedPathLength / pathLength) * 100);

  // Calculate accuracy
  if (gameState.totalPoints > 0) {
    gameState.accuracy = Math.round((gameState.correctPoints / gameState.totalPoints) * 100);
  }
}

// Calculate Path Length
function calculatePathLength(path) {
  let length = 0;
  for (let i = 0; i < path.length - 1; i++) {
    const p1 = path[i];
    const p2 = path[i + 1];
    length += Math.sqrt((p2.x - p1.x) ** 2 + (p2.y - p1.y) ** 2);
  }
  return length;
}

// Update Progress UI (Dihilangkan, karena kita pakai UI minimalis)
function updateProgress() {
  // const progressFill = document.getElementById('progressFill');
  // const progressText = document.getElementById('progressText');
  // const scoreDisplay = document.getElementById('scoreDisplay');
  // const starsDisplay = document.getElementById('starsDisplay');
  // progressFill.style.width = gameState.progress + '%';
  // progressText.textContent = Math.round(gameState.progress) + '%';
  // scoreDisplay.textContent = gameState.accuracy + '%';
  // const stars = getStars(gameState.accuracy);
  // starsDisplay.innerHTML = '⭐'.repeat(stars) + '☆'.repeat(3 - stars);
}

// Get Stars Based on Accuracy
function getStars(accuracy) {
  if (accuracy >= settings.scoring.threeStars) return 3;
  if (accuracy >= settings.scoring.twoStars) return 2;
  if (accuracy >= settings.scoring.oneStar) return 1;
  return 0;
}

// Clear Canvas
function clearCanvas() {
  tracingCtx.clearRect(0, 0, tracingCanvas.width, tracingCanvas.height);
  gameState.tracedPoints = [];
  gameState.progress = 0;
  gameState.accuracy = 0;
  gameState.totalPoints = 0;
  gameState.correctPoints = 0;
  updateProgress();
}

// Restart Letter
function restartLetter() {
  clearCanvas();
  playAnimation();
  showScreen('game');
}

// Show Success Screen
function showSuccessScreen() {
  const finalStars = document.getElementById('finalStars');
  const finalScore = document.getElementById('finalScore');
  const successMessage = document.getElementById('successMessage');

  // SIMPAN PROGRESS KE LOCALSTORAGE
  if (gameState.currentLetter) {
    localStorage.setItem('trace_' + gameState.currentLetter.id, 'true');
    // Perbarui menu di background agar saat 'next' statusnya sudah update
    generateLetterMenu(); 
  }

  const stars = getStars(gameState.accuracy);
  finalStars.innerHTML = '⭐'.repeat(stars) + '☆'.repeat(3 - stars);
  finalScore.textContent = `Akurasi: ${gameState.accuracy}%`;

  if (stars === 3) {
    successMessage.textContent = 'Sempurna! Kamu menulis huruf dengan sangat baik!';
  } else if (stars === 2) {
    successMessage.textContent = 'Bagus! Terus berlatih untuk hasil yang lebih baik!';
  } else if (stars === 1) {
    successMessage.textContent = 'Cukup baik! Coba lagi untuk meningkatkan akurasi!';
  } else {
    successMessage.textContent = 'Terus berlatih! Kamu pasti bisa lebih baik!';
  }

  showScreen('success');
}

// Show Screen
function showScreen(screenName) {
  gameState.currentScreen = screenName;

  document.getElementById('menuScreen').classList.remove('active');
  document.getElementById('gameScreen').classList.remove('active');
  document.getElementById('successScreen').classList.remove('active');

  if (screenName === 'menu') {
    document.getElementById('menuScreen').classList.add('active');
    // Generate ulang menu setiap kembali ke menu, untuk update status 'completed'
    generateLetterMenu();
  } else if (screenName === 'game') {
    document.getElementById('gameScreen').classList.add('active');
  } else if (screenName === 'success') {
    document.getElementById('successScreen').classList.add('active');
  }
}

// Panggil init() secara langsung di akhir file
init();