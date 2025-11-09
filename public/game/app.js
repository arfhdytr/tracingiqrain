// Hijaiyah Letters Data
const letters = [
  {
    id: 1,
    arabic: 'ا',
    name: 'Alif',
    difficulty: 'easy',
    pathCoordinates: [
      { x: 50, y: 50 },
      { x: 50, y: 200 }
    ],
    strokeCount: 1
  },
  {
    id: 2,
    arabic: 'و',
    name: 'Waw',
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
    id: 3,
    arabic: 'ر',
    name: 'Ra',
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
    id: 4,
    arabic: 'د',
    name: 'Dal',
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
    id: 5,
    arabic: 'ذ',
    name: 'Dhal',
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
  }
];

// Game Settings
const settings = {
  canvasWidth: 400,
  canvasHeight: 300,
  lineWidth: 5,
  tolerance: 25,
  colors: {
    correct: '#4CAF50',
    incorrect: '#F44336',
    guide: '#E0E0E0',
    stroke: '#2196F3',
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

// Canvas References
let guideCanvas, guideCtx;
let tracingCanvas, tracingCtx;
let animationCanvas, animationCtx;

// Initialize the game
function init() {
  // Setup canvases
  guideCanvas = document.getElementById('guideCanvas');
  guideCtx = guideCanvas.getContext('2d');
  tracingCanvas = document.getElementById('tracingCanvas');
  tracingCtx = tracingCanvas.getContext('2d');
  animationCanvas = document.getElementById('animationCanvas');
  animationCtx = animationCanvas.getContext('2d');

  // Setup event listeners
  setupEventListeners();

  // Generate letter menu
  generateLetterMenu();

  // Show menu screen
  showScreen('menu');
}

// Setup Event Listeners
function setupEventListeners() {
  // Mouse events
  tracingCanvas.addEventListener('mousedown', startDrawing);
  tracingCanvas.addEventListener('mousemove', draw);
  tracingCanvas.addEventListener('mouseup', stopDrawing);
  tracingCanvas.addEventListener('mouseleave', stopDrawing);

  // Touch events
  tracingCanvas.addEventListener('touchstart', handleTouchStart);
  tracingCanvas.addEventListener('touchmove', handleTouchMove);
  tracingCanvas.addEventListener('touchend', stopDrawing);

  // Button events
  document.getElementById('clearBtn').addEventListener('click', clearCanvas);
  document.getElementById('replayBtn').addEventListener('click', playAnimation);
  document.getElementById('backBtn').addEventListener('click', () => showScreen('menu'));
  document.getElementById('tryAgainBtn').addEventListener('click', restartLetter);
  document.getElementById('nextLetterBtn').addEventListener('click', () => showScreen('menu'));
}

// Generate Letter Menu
function generateLetterMenu() {
  const letterGrid = document.getElementById('letterGrid');
  letterGrid.innerHTML = '';

  letters.forEach(letter => {
    const card = document.createElement('button');
    card.className = 'letter-card';
    card.innerHTML = `
      <span class="letter-card-arabic">${letter.arabic}</span>
      <span class="letter-card-name">${letter.name}</span>
    `;
    card.addEventListener('click', () => selectLetter(letter));
    letterGrid.appendChild(card);
  });
}

// Select Letter and Start Game
function selectLetter(letter) {
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

// Draw Guide Path
function drawGuide(letter) {
  guideCtx.clearRect(0, 0, guideCanvas.width, guideCanvas.height);
  guideCtx.fillStyle = settings.colors.background;
  guideCtx.fillRect(0, 0, guideCanvas.width, guideCanvas.height);

  const path = letter.pathCoordinates;

  // Draw dotted guide line
  guideCtx.strokeStyle = settings.colors.guide;
  guideCtx.lineWidth = settings.lineWidth;
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
  if (!letter) return;

  animationCtx.clearRect(0, 0, animationCanvas.width, animationCanvas.height);

  const path = letter.pathCoordinates;
  let currentPoint = 0;
  let progress = 0;

  // Scale coordinates to fit animation canvas
  const scaleX = animationCanvas.width / guideCanvas.width;
  const scaleY = animationCanvas.height / guideCanvas.height;

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

    progress += 0.02;
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
  if (!letter) return false;

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
  if (!letter) return;

  const path = letter.pathCoordinates;
  const pathLength = calculatePathLength(path);

  // Calculate covered path length
  let coveredLength = 0;
  const tracedPoints = gameState.tracedPoints;

  for (let i = 0; i < tracedPoints.length - 1; i++) {
    const p1 = tracedPoints[i];
    const p2 = tracedPoints[i + 1];
    const dist = Math.sqrt((p2.x - p1.x) ** 2 + (p2.y - p1.y) ** 2);
    coveredLength += dist;
  }

  gameState.progress = Math.min(100, (coveredLength / pathLength) * 100);

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

// Update Progress UI
function updateProgress() {
  const progressFill = document.getElementById('progressFill');
  const progressText = document.getElementById('progressText');
  const scoreDisplay = document.getElementById('scoreDisplay');
  const starsDisplay = document.getElementById('starsDisplay');

  progressFill.style.width = gameState.progress + '%';
  progressText.textContent = Math.round(gameState.progress) + '%';
  scoreDisplay.textContent = gameState.accuracy + '%';

  // Update stars
  const stars = getStars(gameState.accuracy);
  starsDisplay.innerHTML = '⭐'.repeat(stars) + '☆'.repeat(3 - stars);
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
  } else if (screenName === 'game') {
    document.getElementById('gameScreen').classList.add('active');
  } else if (screenName === 'success') {
    document.getElementById('successScreen').classList.add('active');
  }
}

// Initialize game when DOM is loaded
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', init);
} else {
  init();
}