// ========================================
// WELCOME ANIMATION
// ========================================
window.addEventListener("DOMContentLoaded", function () {
    const welcomeBackdrop = document.getElementById("welcome-backdrop");
    const welcomeContainer = document.getElementById("welcome-message-container");
    const welcomeMessage = document.getElementById("welcome-message");

    if (welcomeBackdrop && welcomeContainer && welcomeMessage) {
        // Step 1: Fade in backdrop (100ms)
        setTimeout(() => {
            welcomeBackdrop.classList.remove("opacity-0");
            welcomeBackdrop.classList.add("opacity-100");
        }, 100);

        // Step 2: Show message with scale animation (200ms)
        setTimeout(() => {
            welcomeContainer.classList.remove("opacity-0");
            welcomeContainer.classList.add("opacity-100");

            welcomeMessage.classList.remove("scale-75");
            welcomeMessage.classList.add("scale-100");
        }, 200);

        // Step 3: Start fade out (2.5s)
        setTimeout(() => {
            welcomeMessage.classList.remove("scale-100");
            welcomeMessage.classList.add("scale-110");
            welcomeContainer.classList.remove("opacity-100");
            welcomeContainer.classList.add("opacity-0");

            welcomeBackdrop.classList.remove("opacity-100");
            welcomeBackdrop.classList.add("opacity-0");
        }, 2500);

        // Step 4: Hide completely and initialize game (3.5s total)
        setTimeout(() => {
            welcomeBackdrop.classList.add("hidden");
            welcomeContainer.classList.add("hidden");
            initGame();
        }, 3500);
    }
});

// ========================================
// DATA GAME - HURUF HIJAIYAH (MULTI-STROKE + CIRCLE)
// ========================================
const defaultHijaiyahData = [
    {
        id: 1,
        arabic: "ا",
        name: "Alif",
        difficulty: "easy",
        image_path: "/images/hijaiyah/alif.webp",
        strokes: [
            {
                type: "line",
                points: [
                    { x: 200, y: 80 },
                    { x: 200, y: 220 },
                ],
            },
        ],
    },
    {
        id: 2,
        arabic: "ب",
        name: "Ba",
        difficulty: "easy",
        image_path: "/images/hijaiyah/ba.webp",
        strokes: [
            {
                type: "line",
                points: [
                    { x: 290, y: 140 },
                    { x: 270, y: 200 },
                    { x: 200, y: 220 },
                    { x: 130, y: 200 },
                    { x: 100, y: 140 },
                ],
            },
            {
                type: "circle",
                center: { x: 200, y: 240 },
                radius: 10,
            },
        ],
    },
    {
        id: 3,
        arabic: "ت",
        name: "Ta",
        difficulty: "easy",
        image_path: "/images/hijaiyah/ta.webp",
        strokes: [
            {
                type: "line",
                points: [
                    { x: 290, y: 140 },
                    { x: 270, y: 200 },
                    { x: 200, y: 220 },
                    { x: 130, y: 200 },
                    { x: 100, y: 140 },
                ],
            },
            {
                type: "circle",
                center: { x: 180, y: 120 },
                radius: 8,
            },
            {
                type: "circle",
                center: { x: 220, y: 120 },
                radius: 8,
            },
        ],
    },
    {
        id: 4,
        arabic: "ث",
        name: "Tsa",
        difficulty: "easy",
        image_path: "/images/hijaiyah/tsa.webp",
        strokes: [
            {
                type: "line",
                points: [
                    { x: 280, y: 140 },
                    { x: 250, y: 190 },
                    { x: 200, y: 210 },
                    { x: 150, y: 190 },
                    { x: 120, y: 140 },
                ],
            },
            {
                type: "circle",
                center: { x: 180, y: 120 },
                radius: 8,
            },
            {
                type: "circle",
                center: { x: 200, y: 105 },
                radius: 8,
            },
            {
                type: "circle",
                center: { x: 220, y: 120 },
                radius: 8,
            },
        ],
    },
    {
        id: 5,
        arabic: "ج",
        name: "Jim",
        difficulty: "medium",
        image_path: "/images/hijaiyah/jim.webp",
        strokes: [
            {
                type: "line",
                points: [
                    { x: 139, y: 97 },
                    { x: 166, y: 83 },
                    { x: 196, y: 86 },
                    { x: 226, y: 90 },
                    { x: 257, y: 85 },
                    { x: 228, y: 95 },
                    { x: 199, y: 102 },
                    { x: 171, y: 113 },
                    { x: 147, y: 131 },
                    { x: 141, y: 161 },
                    { x: 152, y: 189 },
                    { x: 181, y: 202 },
                    { x: 211, y: 208 },
                    { x: 241, y: 211 },
                ],
            },
            {
                type: "circle",
                center: { x: 200, y: 150 },
                radius: 8,
            },
        ],
    },
    {
        id: 6,
        arabic: "ح",
        name: "Ha",
        difficulty: "medium",
        image_path: "/images/hijaiyah/ha.webp",
        strokes: [
            {
                type: "line",
                points: [
                    { x: 139, y: 97 },
                    { x: 166, y: 83 },
                    { x: 196, y: 86 },
                    { x: 226, y: 90 },
                    { x: 257, y: 85 },
                    { x: 228, y: 95 },
                    { x: 199, y: 102 },
                    { x: 171, y: 113 },
                    { x: 147, y: 131 },
                    { x: 141, y: 161 },
                    { x: 152, y: 189 },
                    { x: 181, y: 202 },
                    { x: 211, y: 208 },
                    { x: 241, y: 211 },
                ],
            },
        ],
    },
    {
        id: 7,
        arabic: "خ",
        name: "Kha",
        difficulty: "medium",
        image_path: "/images/hijaiyah/kha.webp",
        strokes: [
            {
                type: "line",
                points: [
                    { x: 139, y: 97 },
                    { x: 166, y: 83 },
                    { x: 196, y: 86 },
                    { x: 226, y: 90 },
                    { x: 257, y: 85 },
                    { x: 228, y: 95 },
                    { x: 199, y: 102 },
                    { x: 171, y: 113 },
                    { x: 147, y: 131 },
                    { x: 141, y: 161 },
                    { x: 152, y: 189 },
                    { x: 181, y: 202 },
                    { x: 211, y: 208 },
                    { x: 241, y: 211 },
                ],
            },
            {
                type: "circle",
                center: { x: 190, y: 65 },
                radius: 8,
            },
        ],
    },
    {
        id: 8,
        arabic: "د",
        name: "Dal",
        difficulty: "easy",
        image_path: "/images/hijaiyah/dal.webp",
        strokes: [
            {
                type: "line",
                points: [
                    { x: 192, y: 98 },
                    { x: 216, y: 117 },
                    { x: 239, y: 139 },
                    { x: 253, y: 166 },
                    { x: 255, y: 198 },
                    { x: 236, y: 223 },
                    { x: 206, y: 225 },
                    { x: 176, y: 225 },
                    { x: 150, y: 208 },
                    { x: 150, y: 178 },
                ],
            },
        ],
    },
    {
        id: 9,
        arabic: "ذ",
        name: "Dzal",
        difficulty: "easy",
        image_path: "/images/hijaiyah/dzal.webp",
        strokes: [
            {
                type: "line",
                points: [
                    { x: 192, y: 98 },
                    { x: 216, y: 117 },
                    { x: 239, y: 139 },
                    { x: 253, y: 166 },
                    { x: 255, y: 198 },
                    { x: 236, y: 223 },
                    { x: 206, y: 225 },
                    { x: 176, y: 225 },
                    { x: 150, y: 208 },
                    { x: 150, y: 178 },
                ],
            },
            {
                type: "circle",
                center: { x: 190, y: 75 },
                radius: 8,
            },
        ],
    },
    {
        id: 10,
        arabic: "ر",
        name: "Ra",
        difficulty: "easy",
        image_path: "/images/hijaiyah/ra.webp",
        strokes: [
            {
                type: "line",
                points: [
                    { x: 241, y: 68 },
                    { x: 261, y: 91 },
                    { x: 272, y: 120 },
                    { x: 277, y: 150 },
                    { x: 261, y: 177 },
                    { x: 236, y: 200 },
                    { x: 212, y: 218 },
                    { x: 181, y: 220 },
                    { x: 151, y: 214 },
                    { x: 122, y: 205 },
                ],
            },
        ],
    },
    {
        id: 11,
        arabic: "ز",
        name: "Zai",
        difficulty: "easy",
        image_path: "/images/hijaiyah/zai.webp",
        strokes: [
            {
                type: "line",
                points: [
                    { x: 241, y: 68 },
                    { x: 261, y: 91 },
                    { x: 272, y: 120 },
                    { x: 277, y: 150 },
                    { x: 261, y: 177 },
                    { x: 236, y: 200 },
                    { x: 212, y: 218 },
                    { x: 181, y: 220 },
                    { x: 151, y: 214 },
                    { x: 122, y: 205 },
                ],
            },
            {
                type: "circle",
                center: { x: 243, y: 50 },
                radius: 7,
            },
        ],
    },
    {
        id: 12,
        arabic: "س",
        name: "Sin",
        difficulty: "medium",
        image_path: "/images/hijaiyah/sin.webp",
        strokes: [
            {
                type: "line",
                points: [
                    { x: 280, y: 140 },
                    { x: 280, y: 150 },
                    { x: 260, y: 160 },
                    { x: 240, y: 150 },
                    { x: 240, y: 140 },
                    { x: 240, y: 150 },
                    { x: 220, y: 160 },
                    { x: 200, y: 150 },
                    { x: 200, y: 140 },
                    { x: 200, y: 150 },
                    { x: 190, y: 160 },
                    { x: 180, y: 170 },
                    { x: 170, y: 180 },
                    { x: 150, y: 190 },
                    { x: 120, y: 180 },
                    { x: 110, y: 170 },
                    { x: 110, y: 160 },
                ],
            },
        ],
    },
    {
        id: 13,
        arabic: "ش",
        name: "Syin",
        difficulty: "medium",
        image_path: "/images/hijaiyah/syin.webp",
        strokes: [
            {
                type: "line",
                points: [
                    { x: 280, y: 140 },
                    { x: 280, y: 150 },
                    { x: 260, y: 160 },
                    { x: 240, y: 150 },
                    { x: 240, y: 140 },
                    { x: 240, y: 150 },
                    { x: 220, y: 160 },
                    { x: 200, y: 150 },
                    { x: 200, y: 140 },
                    { x: 200, y: 150 },
                    { x: 190, y: 160 },
                    { x: 180, y: 170 },
                    { x: 170, y: 180 },
                    { x: 150, y: 190 },
                    { x: 120, y: 180 },
                    { x: 110, y: 170 },
                    { x: 110, y: 160 },
                ],
            },
            {
                type: "circle",
                center: { x: 220, y: 105 },
                radius: 6,
            },
            {
                type: "circle",
                center: { x: 240, y: 90 },
                radius: 6,
            },
            {
                type: "circle",
                center: { x: 260, y: 105 },
                radius: 6,
            },
        ],
    },
    {
        id: 14,
        arabic: "ص",
        name: "Shad",
        difficulty: "medium",
        image_path: "/images/hijaiyah/shad.webp",
        strokes: [
            {
                type: "line",
                points: [
                    { x: 200, y: 140 },
                    { x: 210, y: 130 },
                    { x: 240, y: 120 },
                    { x: 270, y: 130 },
                    { x: 280, y: 140 },
                    { x: 270, y: 150 },
                    { x: 240, y: 160 },
                    { x: 200, y: 150 },
                    { x: 200, y: 140 },
                    { x: 200, y: 120 },
                    { x: 200, y: 140 },
                    { x: 200, y: 150 },
                    { x: 200, y: 150 },
                    { x: 190, y: 160 },
                    { x: 180, y: 170 },
                    { x: 170, y: 180 },
                    { x: 150, y: 190 },
                    { x: 120, y: 180 },
                    { x: 110, y: 170 },
                    { x: 110, y: 160 },
                ],
            },
        ],
    },
    {
        id: 15,
        arabic: "ض",
        name: "Dhad",
        difficulty: "medium",
        image_path: "/images/hijaiyah/dhad.webp",
        strokes: [
            {
                type: "line",
                points: [
                    { x: 200, y: 140 },
                    { x: 210, y: 130 },
                    { x: 240, y: 120 },
                    { x: 270, y: 130 },
                    { x: 280, y: 140 },
                    { x: 270, y: 150 },
                    { x: 240, y: 160 },
                    { x: 200, y: 150 },
                    { x: 200, y: 140 },
                    { x: 200, y: 120 },
                    { x: 200, y: 140 },
                    { x: 200, y: 150 },
                    { x: 200, y: 150 },
                    { x: 190, y: 160 },
                    { x: 180, y: 170 },
                    { x: 170, y: 180 },
                    { x: 150, y: 190 },
                    { x: 120, y: 180 },
                    { x: 110, y: 170 },
                    { x: 110, y: 160 },
                ],
            },
            {
                type: "circle",
                center: { x: 240, y: 100 },
                radius: 6,
            },
        ],
    },
    {
        id: 16,
        arabic: "ط",
        name: "Tha",
        difficulty: "medium",
        image_path: "/images/hijaiyah/tha.webp",
        strokes: [
            {
                type: "line",
                points: [
                    { x: 190, y: 80 },
                    { x: 190, y: 160 },
                    { x: 190, y: 150 },
                    { x: 200, y: 140 },
                    { x: 230, y: 130 },
                    { x: 260, y: 140 },
                    { x: 270, y: 150 },
                    { x: 260, y: 160 },
                    { x: 230, y: 160 },
                    { x: 190, y: 160 },
                    // { x: 190, y: 150 },
                    { x: 170, y: 160 },
                ],
            },
        ],
    },
    {
        id: 17,
        arabic: "ظ",
        name: "Dza",
        difficulty: "medium",
        image_path: "/images/hijaiyah/dza.webp",
        strokes: [
            {
                type: "line",
                points: [
                    { x: 190, y: 80 },
                    { x: 190, y: 160 },
                    { x: 190, y: 150 },
                    { x: 200, y: 140 },
                    { x: 230, y: 130 },
                    { x: 260, y: 140 },
                    { x: 270, y: 150 },
                    { x: 260, y: 160 },
                    { x: 230, y: 160 },
                    { x: 190, y: 160 },
                    // { x: 190, y: 150 },
                    { x: 170, y: 160 },
                ],
            },
            {
                type: "circle",
                center: { x: 230, y: 110 },
                radius: 6,
            },
        ],
    },
    {
        id: 18,
        arabic: "ع",
        name: "Ain",
        difficulty: "hard",
        image_path: "/images/hijaiyah/ain.webp",
        strokes: [
            {
                type: "line",
                points: [
                    { x: 190, y: 115 },
                    { x: 170, y: 105 }, // MELENGKUNG KIRI ATAS
                    { x: 150, y: 100 },
                    { x: 140, y: 120 },
                    { x: 150, y: 140 },
                    { x: 190, y: 125 }, // BALIK KE TENGAH
                    { x: 150, y: 140 }, // MELENGKUNG KANAN BAWAH
                    { x: 140, y: 160 },
                    { x: 132, y: 180 },
                    { x: 130, y: 180 },
                    { x: 140, y: 185 },
                    { x: 150, y: 195 },
                    { x: 160, y: 200 },
                    { x: 180, y: 210 },
                    { x: 200, y: 200 },
                ],
            },
        ],
    },
    {
        id: 19,
        arabic: "غ",
        name: "Ghain",
        difficulty: "hard",
        image_path: "/images/hijaiyah/ghain.webp",
        strokes: [
            {
                type: "line",
                points: [
                    { x: 190, y: 115 },
                    { x: 170, y: 105 }, // MELENGKUNG KIRI ATAS
                    { x: 150, y: 100 },
                    { x: 140, y: 120 },
                    { x: 150, y: 140 },
                    { x: 190, y: 125 }, // BALIK KE TENGAH
                    { x: 150, y: 140 }, // MELENGKUNG KANAN BAWAH
                    { x: 140, y: 160 },
                    { x: 132, y: 180 },
                    { x: 130, y: 180 },
                    { x: 140, y: 185 },
                    { x: 150, y: 195 },
                    { x: 160, y: 200 },
                    { x: 180, y: 210 },
                    { x: 200, y: 200 },
                ],
            },
            {
                type: "circle",
                center: { x: 160, y: 70 },
                radius: 6,
            },
        ],
    },
    {
        id: 20,
        arabic: "ف",
        name: "Fa",
        difficulty: "medium",
        image_path: "/images/hijaiyah/fa.webp",
        strokes: [
            {
                type: "line",
                points: [
                    { x: 250, y: 150 },
                    { x: 230, y: 155 },
                    { x: 205, y: 150 },
                    { x: 210, y: 120 },
                    { x: 230, y: 110 },
                    { x: 250, y: 110 },
                    { x: 250, y: 150 },
                    { x: 230, y: 180 },
                    { x: 200, y: 190 },
                    { x: 170, y: 185 },
                    { x: 150, y: 175 },
                    { x: 140, y: 170 },
                    { x: 130, y: 165 },
                    { x: 120, y: 160 },
                ],
            },
            {
                type: "circle",
                center: { x: 230, y: 85 },
                radius: 8,
            },
        ],
    },
    {
        id: 21,
        arabic: "ق",
        name: "Qaf",
        difficulty: "medium",
        image_path: "/images/hijaiyah/qaf.webp",
        strokes: [
            {
                type: "line",
                points: [
                    { x: 250, y: 150 },
                    { x: 230, y: 155 },
                    { x: 205, y: 150 },
                    { x: 210, y: 120 },
                    { x: 230, y: 110 },
                    { x: 250, y: 110 },
                    { x: 250, y: 150 },
                    { x: 230, y: 180 },
                    { x: 200, y: 190 },
                    { x: 170, y: 185 },
                    { x: 150, y: 175 },
                    { x: 140, y: 170 },
                    { x: 130, y: 165 },
                    { x: 120, y: 160 },
                ],
            },
            {
                type: "circle",
                center: { x: 240, y: 85 },
                radius: 6,
            },
            {
                type: "circle",
                center: { x: 215, y: 85 },
                radius: 6,
            },
        ],
    },
    {
        id: 22,
        arabic: "ك",
        name: "Kaf",
        difficulty: "medium",
        image_path: "/images/hijaiyah/kaf.webp",
        strokes: [
            {
                type: "line",
                points: [
                    { x: 240, y: 80 },
                    { x: 240, y: 210 },
                    { x: 235, y: 212 },
                    { x: 230, y: 220 },
                    { x: 150, y: 220 },
                    { x: 145, y: 210 },
                ],
            },
            {
                type: "line",
                points: [
                    { x: 200, y: 150 },
                    { x: 180, y: 160 },
                    { x: 195, y: 165 },
                    { x: 180, y: 170 },
                ],
            },
        ],
    },
    {
        id: 23,
        arabic: "ل",
        name: "Lam",
        difficulty: "easy",
        image_path: "/images/hijaiyah/lam.webp",
        strokes: [
            {
                type: "line",
                points: [
                    { x: 240, y: 120 },
                    { x: 240, y: 200 },
                    { x: 230, y: 210 },
                    { x: 210, y: 214 },
                    { x: 200, y: 212 },
                    { x: 190, y: 212 },
                    { x: 160, y: 210 },
                    { x: 160, y: 200 },
                ],
            },
        ],
    },
    {
        id: 24,
        arabic: "م",
        name: "Mim",
        difficulty: "medium",
        image_path: "/images/hijaiyah/mim.webp",
        strokes: [
            {
                type: "line",
                points: [
                    { x: 180, y: 105 },
                    { x: 190, y: 100 },
                    { x: 205, y: 90 },
                    { x: 210, y: 95 },
                    { x: 230, y: 100 },
                    { x: 230, y: 105 },
                    { x: 200, y: 110 },
                    { x: 180, y: 115 },
                    { x: 190, y: 180 },
                ],
            },
        ],
    },
    {
        id: 25,
        arabic: "ن",
        name: "Nun",
        difficulty: "medium",
        image_path: "/images/hijaiyah/nun.webp",
        strokes: [
            {
                type: "line",
                points: [
                    { x: 290, y: 140 },
                    { x: 270, y: 200 },
                    { x: 200, y: 220 },
                    { x: 130, y: 200 },
                    { x: 100, y: 140 },
                ],
            },
            {
                type: "circle",
                center: { x: 200, y: 150 },
                radius: 8,
            },
        ],
    },
    {
        id: 26,
        arabic: "و",
        name: "Wau",
        difficulty: "easy",
        image_path: "/images/hijaiyah/wau.webp",
        strokes: [
            {
                type: "line",
                points: [
                    { x: 220, y: 130 },
                    { x: 200, y: 140 },
                    { x: 180, y: 120 },
                    { x: 180, y: 100 },
                    { x: 200, y: 90 },
                    { x: 220, y: 100 },
                    { x: 220, y: 140 },
                    { x: 210, y: 160 },
                    { x: 185, y: 185 },
                    { x: 155, y: 175 },
                    { x: 135, y: 155 },
                ],
            },
        ],
    },
    {
        id: 27,
        arabic: "ه",
        name: "Ha",
        difficulty: "medium",
        image_path: "/images/hijaiyah/haa.webp",
        strokes: [
            {
                type: "line",
                points: [
                    { x: 200, y: 100 },
                    { x: 220, y: 120 },
                    { x: 230, y: 150 },
                    { x: 220, y: 180 },
                    { x: 200, y: 185 },
                    { x: 180, y: 180 },
                    { x: 170, y: 150 },
                    { x: 180, y: 120 },
                    { x: 200, y: 100 },
                ],
            },
        ],
    },
    {
        id: 28,
        arabic: "لا",
        name: "Lamalif",
        difficulty: "medium",
        image_path: "/images/hijaiyah/Lamalif.webp",
        strokes: [
            {
                type: "line",
                points: [
                    { x: 240, y: 120 },
                    { x: 200, y: 170 },
                    { x: 160, y: 200 },
                    { x: 160, y: 205 },
                    { x: 180, y: 210 },
                    { x: 230, y: 200 },
                    { x: 230, y: 195 },
                    { x: 200, y: 170 },
                    { x: 160, y: 140 },
                ],
            },
            {
                type: "line",
                center: { x: 190, y: 195 },
                radius: 8,
            },
        ],
    },
    {
        id: 29,
        arabic: "ء",
        name: "Hamzah",
        difficulty: "easy",
        image_path: "/images/hijaiyah/hamzah.webp",
        strokes: [
            {
                type: "line",
                points: [
                    { x: 232, y: 101 },
                    { x: 204, y: 91 },
                    { x: 173, y: 91 },
                    { x: 154, y: 114 },
                    { x: 156, y: 144 },
                    { x: 182, y: 160 },
                    { x: 213, y: 161 },
                    { x: 242, y: 154 },
                    { x: 271, y: 145 },
                    { x: 243, y: 159 },
                    { x: 218, y: 176 },
                    { x: 191, y: 190 },
                    { x: 167, y: 209 },
                ],
            },
        ],
    },
    {
        arabic: "ي",
        name: "Ya",
        difficulty: "medium",
        image_path: "/images/hijaiyah/ya.webp",
        strokes: [
            {
                type: "line",
                points: [
                    { x: 270, y: 120 },
                    { x: 250, y: 125 },
                    { x: 215, y: 140 },
                    { x: 210, y: 152 },
                    { x: 220, y: 155 },
                    { x: 260, y: 175 },
                    { x: 255, y: 180 },
                    { x: 250, y: 200 },
                    { x: 200, y: 210 },
                    { x: 175, y: 205 },
                    { x: 150, y: 205 },
                    { x: 140, y: 195 },
                ],
            },
            {
                type: "circle",
                center: { x: 180, y: 225 },
                radius: 7,
            },
            {
                type: "circle",
                center: { x: 215, y: 225 },
                radius: 7,
            },
        ],
    },
];

let allHijaiyahData = defaultHijaiyahData;

// ========================================
// GAME SETTINGS
// ========================================
const settings = {
    canvasWidth: 400,
    canvasHeight: 300,
    lineWidth: 5,
    tolerance: 15, // Diperketat dari 30 ke 15
    colors: {
        correct: "#4CAF50",
        incorrect: "#F44336",
        guide: "#E0E0E0",
        guideCircle: "#CCE5FF",
        stroke: "#2196F3",
        background: "white",
        completed: "#9E9E9E",
    },
    scoring: {
        threeStars: 90,
        twoStars: 70,
        oneStar: 50,
    },
    // hai
};

// ========================================
// GAME STATE
// ========================================
let currentHurufIndex = 0;
let currentStrokeIndex = 0;
let gameState = {
    isDrawing: false,
    completedStrokes: [],
    currentStrokeProgress: 0,
    currentStrokeAccuracy: 0,
    tracedPoints: [],
    totalPoints: 0,
    correctPoints: 0,
    circleClicked: false,
    totalGamePoints: 0,
    totalGameCorrectPoints: 0,
};

let totalSessionScore = 0;

let guideCanvas, guideCtx;
let tracingCanvas, tracingCtx;
let animationCanvas, animationCtx;

// --- TAMBAHAN BARU ---
let currentAnimationFrameID = null; // Menyimpan ID requestAnimationFrame
let currentAnimationTimeoutID = null; // Menyimpan ID setTimeout (jeda antar stroke)

// ========================================
// INITIALIZE GAME
// ========================================
// ========================================
// INITIALIZE GAME
// ========================================
function initGame() {
    guideCanvas = document.getElementById("guideCanvas");
    guideCtx = guideCanvas.getContext("2d");
    tracingCanvas = document.getElementById("tracingCanvas");
    tracingCtx = tracingCanvas.getContext("2d");
    animationCanvas = document.getElementById("animationCanvas");
    animationCtx = animationCanvas.getContext("2d");

    setupEventListeners();
    renderMenu(); // Render menu on load
    // loadGame(currentHurufIndex); // Don't load game immediately
}

// ========================================
// MENU & NAVIGATION FUNCTIONS
// ========================================
const cardColors = [
    'bg-blue-100 border-blue-300 text-blue-800',
    'bg-green-100 border-green-300 text-green-800',
    'bg-yellow-100 border-yellow-300 text-yellow-800',
    'bg-purple-100 border-purple-300 text-purple-800',
    'bg-pink-100 border-pink-300 text-pink-800',
    'bg-indigo-100 border-indigo-300 text-indigo-800',
    'bg-red-100 border-red-300 text-red-800',
    'bg-teal-100 border-teal-300 text-teal-800',
];

function renderMenu() {
    const grid = document.getElementById('letter-grid');
    if (!grid) return;

    grid.innerHTML = '';

    allHijaiyahData.forEach((letter, index) => {
        const colorClass = cardColors[index % cardColors.length];

        const card = document.createElement('div');
        card.className = `
            ${colorClass} border-b-4 rounded-xl p-4 flex flex-col items-center justify-center 
            cursor-pointer transform transition-all duration-200 hover:-translate-y-1 hover:shadow-lg active:translate-y-0
            aspect-[3/4] shadow-sm
        `;

        card.innerHTML = `
            <div class="flex-1 flex items-center justify-center">
                <span class="text-6xl font-bold font-['Amiri']">${letter.arabic}</span>
            </div>
            <div class="w-full border-t border-black/10 mt-2 pt-2 text-center">
                <span class="text-sm font-bold uppercase tracking-wider opacity-80">${letter.name}</span>
            </div>
        `;

        card.onclick = () => startGame(index);
        grid.appendChild(card);
    });
}

function startGame(index) {
    document.getElementById('letter-menu-container').style.display = 'none';
    document.getElementById('game-container').style.display = 'block';

    // Trigger resize event to fix canvas scaling if needed
    window.dispatchEvent(new Event('resize'));

    loadGame(index);
}

function showMenu() {
    stopAnimation();
    document.getElementById('game-container').style.display = 'none';
    document.getElementById('letter-menu-container').style.display = 'flex';
}

// Expose functions to window for onclick events
window.startGame = startGame;
window.showMenu = showMenu;
// 🔵 FINAL RECORDER: GESER HALUS & IRIT
// ==========================================
// function initGame() {
//     // 1. Setup Canvas
//     guideCanvas = document.getElementById('guideCanvas');
//     guideCtx = guideCanvas.getContext('2d');
//     tracingCanvas = document.getElementById('tracingCanvas');
//     tracingCtx = tracingCanvas.getContext('2d');

//     // GANTI INDEX SESUAI HURUF (Misal 4 = JIM)
//     const targetIndex = 28;
//     const dataSumber = (typeof allHijaiyahData !== 'undefined') ? allHijaiyahData : defaultHijaiyahData;
//     const letter = dataSumber[targetIndex];

//     // Load Gambar Background
//     const img = new Image();
//     let cleanAssetBase = (typeof ASSET_BASE !== 'undefined') ? ASSET_BASE : '';
//     if (cleanAssetBase.endsWith('/')) cleanAssetBase = cleanAssetBase.slice(0, -1);
//     img.src = cleanAssetBase + letter.image_path;

//     img.onload = function() {
//         // 1. Bersihkan Canvas
//         guideCtx.clearRect(0,0, 400, 300);

//         // 2. Setting Transparansi
//         guideCtx.globalAlpha = 0.4;

//         // ==========================================
//         // 📐 RUMUS AUTO-FIT (ANTI KEBESARAN)
//         // ==========================================
//         const canvasWidth = 400;
//         const canvasHeight = 300;
//         const padding = 50; // Jarak aman dari pinggir (biar gak nempel banget)

//         // Hitung skala biar gambar muat di canvas tapi proporsinya tetap
//         const scale = Math.min(
//             (canvasWidth - (padding * 2)) / img.width,
//             (canvasHeight - (padding * 2)) / img.height
//         );

//         const newWidth = img.width * scale;
//         const newHeight = img.height * scale;

//         // Hitung posisi biar pas di tengah-tengah (Center)
//         const x = (canvasWidth - newWidth) / 2;
//         const y = (canvasHeight - newHeight) / 2;

//         // Gambar dengan ukuran baru yang sudah dihitung
//         guideCtx.drawImage(img, x, y, newWidth, newHeight);
//         // ==========================================

//         guideCtx.globalAlpha = 1.0;

//         guideCtx.fillStyle = "blue";
//         guideCtx.font = "16px Arial";
//         guideCtx.fillText(`RECORDER: Jiplak Huruf ${letter.name}`, 10, 20);
//         guideCtx.font = "12px Arial";
//         guideCtx.fillText("Tarik garis pelan-pelan. Garis merah = Hasil Jadi.", 10, 40);
//     };

//     let isRecording = false;
//     let recordedPoints = [];
//     let lastRecordedPos = null;

//     tracingCanvas.onmousedown = (e) => {
//         isRecording = true;
//         recordedPoints = [];
//         tracingCtx.clearRect(0, 0, 400, 300); // Bersihkan kanvas tracing

//         const pos = getMousePos(e);
//         savePoint(pos);
//     };

//     tracingCanvas.onmousemove = (e) => {
//         if (!isRecording) return;
//         const pos = getMousePos(e);

//         // --- FILTER JARAK KETAT (30px) ---
//         // Biar titiknya sedikit (irit), tapi karena mouse digeser, posisinya akurat.
//         if (lastRecordedPos) {
//             const dist = Math.hypot(pos.x - lastRecordedPos.x, pos.y - lastRecordedPos.y);
//             if (dist < 30) return; // Kalau gesernya dikit, abaikan
//         }

//         savePoint(pos);

//         // --- VISUALISASI LIVE LENGKUNG (PREVIEW) ---
//         // Ini biar sampeyan tau bentuk aslinya bakal kayak gimana
//         drawLivePreview();
//     };

//     tracingCanvas.onmouseup = () => {
//         isRecording = false;

//         // Ambil titik terakhir pas lepas mouse biar garisnya nyambung sampai ujung
//         // (Kecuali kalau pas lepas mouse posisinya sama persis kayak terakhir)
//         // const pos = getMousePos(event); // event ga kedetek di sini, skip aja aman.

//         console.log(`✅ DATA HURUF ${letter.name} (${recordedPoints.length} titik):`);

//         let jsonOutput = "points: [\n";
//         recordedPoints.forEach(p => {
//             jsonOutput += `    { x: ${p.x}, y: ${p.y} },\n`;
//         });
//         jsonOutput += "]";

//         console.log(jsonOutput);
//         alert(`Selesai! Tercatat ${recordedPoints.length} titik. Copy dari Console.`);
//     };

//     function savePoint(pos) {
//         const newPoint = { x: Math.round(pos.x), y: Math.round(pos.y) };
//         recordedPoints.push(newPoint);
//         lastRecordedPos = newPoint;
//     }

//     // Fungsi Menggambar Preview Melengkung (Sama persis kayak logika drawGuide)
//     function drawLivePreview() {
//         tracingCtx.clearRect(0, 0, 400, 300);

//         if (recordedPoints.length < 2) return;

//         tracingCtx.beginPath();
//         tracingCtx.strokeStyle = 'red';
//         tracingCtx.lineWidth = 4;
//         tracingCtx.lineCap = 'round';
//         tracingCtx.lineJoin = 'round';

//         tracingCtx.moveTo(recordedPoints[0].x, recordedPoints[0].y);

//         // Logika Smoothing
//         for (let i = 1; i < recordedPoints.length - 2; i++) {
//             const xc = (recordedPoints[i].x + recordedPoints[i + 1].x) / 2;
//             const yc = (recordedPoints[i].y + recordedPoints[i + 1].y) / 2;
//             tracingCtx.quadraticCurveTo(recordedPoints[i].x, recordedPoints[i].y, xc, yc);
//         }

//         // Curve ke titik terakhir
//         if (recordedPoints.length > 2) {
//              const last = recordedPoints[recordedPoints.length - 1];
//              const secondLast = recordedPoints[recordedPoints.length - 2];
//              tracingCtx.quadraticCurveTo(secondLast.x, secondLast.y, last.x, last.y);
//         } else {
//              // Kalau cuma 2 titik, garis lurus
//              tracingCtx.lineTo(recordedPoints[1].x, recordedPoints[1].y);
//         }

//         tracingCtx.stroke();

//         // Gambar titik-titik aslinya (biru kecil) biar tau simpulnya dimana
//         tracingCtx.fillStyle = 'blue';
//         recordedPoints.forEach(p => {
//             tracingCtx.beginPath();
//             tracingCtx.arc(p.x, p.y, 3, 0, Math.PI*2);
//             tracingCtx.fill();
//         });
//     }
// }

// ========================================
// SETUP EVENT LISTENERS
// ========================================
function setupEventListeners() {
    tracingCanvas.addEventListener("mousedown", startDrawing);
    tracingCanvas.addEventListener("mousemove", draw);
    tracingCanvas.addEventListener("mouseup", stopDrawing);
    tracingCanvas.addEventListener("mouseleave", stopDrawing);
    tracingCanvas.addEventListener("click", handleCanvasClick);

    tracingCanvas.addEventListener("touchstart", handleTouchStart);
    tracingCanvas.addEventListener("touchmove", handleTouchMove);
    tracingCanvas.addEventListener("touchend", stopDrawing);

    document
        .getElementById("clear-button")
        .addEventListener("click", clearCanvas);
    document
        .getElementById("replay-button")
        .addEventListener("click", playAnimation);

    // UDAH ADA DI BLADE
    document
        .getElementById("prev-button")
        .addEventListener("click", loadPreviousLetter);
    document
        .getElementById("next-button")
        .addEventListener("click", loadNextLetter);

    // document.getElementById('try-again-button').addEventListener('click', restartCurrentLetter);
    //document.getElementById('next-letter-button').addEventListener('click', loadNextLetter);
}

// ========================================
// LOAD GAME WITH SPECIFIC LETTER
// ========================================
function loadGame(index) {
    if (index < 0 || index >= allHijaiyahData.length) return;

    stopAnimation();

    currentHurufIndex = index;
    currentStrokeIndex = 0;
    const letter = allHijaiyahData[index];

    document.getElementById("current-letter-arabic").textContent =
        letter.arabic;
    document.getElementById("current-letter-name").textContent = letter.name;
    document.getElementById("letter-display").textContent = letter.arabic;

    gameState = {
        isDrawing: false,
        completedStrokes: [],
        currentStrokeProgress: 0,
        currentStrokeAccuracy: 0,
        tracedPoints: [],
        totalPoints: 0,
        correctPoints: 0,
        circleClicked: false,
        totalGamePoints: 0,
        totalGameCorrectPoints: 0,
    };

    drawGuide(letter);
    clearCanvas();
    playAnimation();
    updateProgress();
    updateNavigationButtons();
}

// ========================================
// DRAW GUIDE PATH (DENGAN SMOOTHING)
// ========================================
function drawGuide(letter) {
    guideCtx.clearRect(0, 0, guideCanvas.width, guideCanvas.height);
    guideCtx.fillStyle = settings.colors.background;
    guideCtx.fillRect(0, 0, guideCanvas.width, guideCanvas.height);

    if (!letter.strokes || letter.strokes.length === 0) {
        guideCtx.fillStyle = "#666";
        guideCtx.font = "16px Arial";
        guideCtx.textAlign = "center";
        guideCtx.fillText("Strokes belum didefinisikan", 200, 150);
        return;
    }

    letter.strokes.forEach((stroke, index) => {
        const isCompleted = gameState.completedStrokes.includes(index);
        const isCurrent = index === currentStrokeIndex;

        if (stroke.type === "line") {
            guideCtx.strokeStyle = isCompleted
                ? settings.colors.completed
                : isCurrent
                    ? settings.colors.guide
                    : "#F0F0F0";
            guideCtx.lineWidth = settings.lineWidth;
            guideCtx.lineCap = "round";
            guideCtx.lineJoin = "round";
            guideCtx.setLineDash(isCurrent ? [10, 10] : []);

            guideCtx.beginPath();
            guideCtx.moveTo(stroke.points[0].x, stroke.points[0].y);

            // === [MODIFIKASI: LOGIKA SMOOTHING] ===
            // Jika titik lebih dari 2, kita pakai kurva biar melengkung
            if (stroke.points.length > 2) {
                for (let i = 1; i < stroke.points.length - 2; i++) {
                    // Cari titik tengah antara poin saat ini dan poin berikutnya
                    const xc =
                        (stroke.points[i].x + stroke.points[i + 1].x) / 2;
                    const yc =
                        (stroke.points[i].y + stroke.points[i + 1].y) / 2;
                    // Gambar kurva menuju titik tengah tersebut
                    guideCtx.quadraticCurveTo(
                        stroke.points[i].x,
                        stroke.points[i].y,
                        xc,
                        yc
                    );
                }
                // Sambungkan lengkungan terakhir ke titik ujung
                guideCtx.quadraticCurveTo(
                    stroke.points[stroke.points.length - 2].x,
                    stroke.points[stroke.points.length - 2].y,
                    stroke.points[stroke.points.length - 1].x,
                    stroke.points[stroke.points.length - 1].y
                );
            } else {
                // Jika titik cuma 2 (garis lurus biasa), pakai cara lama
                for (let i = 1; i < stroke.points.length; i++) {
                    guideCtx.lineTo(stroke.points[i].x, stroke.points[i].y);
                }
            }
            // === [AKHIR MODIFIKASI] ===

            guideCtx.stroke();

            // Gambar titik start (Hijau) & end (Merah) hanya untuk stroke aktif
            if (isCurrent) {
                guideCtx.fillStyle = "#4CAF50";
                guideCtx.beginPath();
                guideCtx.arc(
                    stroke.points[0].x,
                    stroke.points[0].y,
                    8,
                    0,
                    Math.PI * 2
                );
                guideCtx.fill();

                guideCtx.fillStyle = "#F44336";
                guideCtx.beginPath();
                guideCtx.arc(
                    stroke.points[stroke.points.length - 1].x,
                    stroke.points[stroke.points.length - 1].y,
                    8,
                    0,
                    Math.PI * 2
                );
                guideCtx.fill();
            }
        } else if (stroke.type === "circle") {
            guideCtx.strokeStyle = isCompleted
                ? settings.colors.completed
                : isCurrent
                    ? settings.colors.guide
                    : "#F0F0F0";
            guideCtx.lineWidth = 3;
            guideCtx.fillStyle = isCurrent
                ? settings.colors.guideCircle
                : "#F5F5F5";

            guideCtx.beginPath();
            guideCtx.arc(
                stroke.center.x,
                stroke.center.y,
                stroke.radius,
                0,
                Math.PI * 2
            );
            guideCtx.fill();
            guideCtx.stroke();
        }
    });

    guideCtx.setLineDash([]);
}

// ========================================
// STOP ANIMATION (PENTING BUAT FIX BUG)
// ========================================
function stopAnimation() {
    if (currentAnimationFrameID) {
        cancelAnimationFrame(currentAnimationFrameID);
        currentAnimationFrameID = null;
    }
    if (currentAnimationTimeoutID) {
        clearTimeout(currentAnimationTimeoutID);
        currentAnimationTimeoutID = null;
    }
}

// ========================================
// PLAY ANIMATION (REVISI ANTI-BUG)
// ========================================
function playAnimation() {
    // 1. MATIKAN animasi sebelumnya (kalau ada)
    stopAnimation();

    const letter = allHijaiyahData[currentHurufIndex];
    if (!letter || !letter.strokes || letter.strokes.length === 0) return;

    animationCtx.clearRect(0, 0, animationCanvas.width, animationCanvas.height);
    const scaleX = animationCanvas.width / guideCanvas.width;
    const scaleY = animationCanvas.height / guideCanvas.height;

    let strokeIndex = 0;
    let pointIndex = 0;
    let progress = 0;

    function animate() {
        if (strokeIndex >= letter.strokes.length) {
            currentAnimationFrameID = null; // Selesai
            return;
        }

        const stroke = letter.strokes[strokeIndex];

        // --- LOGIKA CIRCLE ---
        if (stroke.type === "circle") {
            animationCtx.strokeStyle = settings.colors.stroke;
            animationCtx.lineWidth = settings.lineWidth;
            animationCtx.beginPath();
            animationCtx.arc(
                stroke.center.x * scaleX,
                stroke.center.y * scaleY,
                stroke.radius,
                0,
                Math.PI * 2
            );
            animationCtx.stroke();

            strokeIndex++;
            // Gunakan variabel global Timeout biar bisa dicancel
            currentAnimationTimeoutID = setTimeout(() => {
                currentAnimationFrameID = requestAnimationFrame(animate);
            }, 300);
            return;
        }

        // --- LOGIKA LINE ---
        if (pointIndex >= stroke.points.length - 1) {
            strokeIndex++;
            pointIndex = 0;
            progress = 0;
            if (strokeIndex < letter.strokes.length) {
                // Jeda antar stroke
                currentAnimationTimeoutID = setTimeout(() => {
                    currentAnimationFrameID = requestAnimationFrame(animate);
                }, 300);
            }
            return;
        }

        // --- GAMBAR ANIMASI ---
        const start = stroke.points[pointIndex];
        const end = stroke.points[pointIndex + 1];

        // Interpolasi posisi (pergerakan titik)
        const x = start.x + (end.x - start.x) * progress;
        const y = start.y + (end.y - start.y) * progress;

        animationCtx.strokeStyle = settings.colors.stroke;
        animationCtx.lineWidth = settings.lineWidth;
        animationCtx.lineCap = "round";
        animationCtx.lineJoin = "round";

        // Mulai path baru setiap frame agar tidak ada garis nyasar
        animationCtx.beginPath();

        // Trik agar garis tidak putus-putus:
        // Kita gambar dari titik start segmen ini ke titik progress saat ini
        animationCtx.moveTo(start.x * scaleX, start.y * scaleY);
        animationCtx.lineTo(x * scaleX, y * scaleY);
        animationCtx.stroke();

        // Simpan "jejak" permanen di canvas biar garisnya gak hilang
        // (Opsional: Kalau mau animasi 'ular' yang buntutnya hilang, hapus bagian ini)
        // Tapi untuk tracing huruf, buntut harus tetap ada.
        // Triknya: Kita tidak clearRect per frame, jadi tinta lama tetap ada.

        progress += 0.05; // Kecepatan animasi (makin besar makin cepat)

        if (progress >= 1) {
            progress = 0;
            pointIndex++;
            // Gambar garis full segmen ini biar rapi sebelum pindah
            animationCtx.beginPath();
            animationCtx.moveTo(start.x * scaleX, start.y * scaleY);
            animationCtx.lineTo(end.x * scaleX, end.y * scaleY);
            animationCtx.stroke();
        }

        // Request frame berikutnya & simpan ID-nya
        currentAnimationFrameID = requestAnimationFrame(animate);
    }

    // Mulai animasi
    animate();
}

// ========================================
// HANDLE CANVAS CLICK (UNTUK CIRCLE)
// ========================================
function handleCanvasClick(e) {
    const letter = allHijaiyahData[currentHurufIndex];
    if (!letter || !letter.strokes) return;

    const stroke = letter.strokes[currentStrokeIndex];
    if (!stroke || stroke.type !== "circle") return;

    const pos = getMousePos(e);
    const dx = pos.x - stroke.center.x;
    const dy = pos.y - stroke.center.y;
    const distance = Math.sqrt(dx * dx + dy * dy);

    if (distance <= stroke.radius + 10) {
        // Circle clicked successfully
        gameState.circleClicked = true;

        // Draw filled circle on canvas
        tracingCtx.fillStyle = settings.colors.correct;
        tracingCtx.beginPath();
        tracingCtx.arc(
            stroke.center.x,
            stroke.center.y,
            stroke.radius,
            0,
            Math.PI * 2
        );
        tracingCtx.fill();

        gameState.currentStrokeProgress = 100;
        updateProgress();

        setTimeout(() => {
            advanceToNextStroke();
        }, 300);
    }
}

// ========================================
// DRAWING FUNCTIONS
// ========================================
function startDrawing(e) {
    const letter = allHijaiyahData[currentHurufIndex];
    if (!letter || !letter.strokes) return;

    const stroke = letter.strokes[currentStrokeIndex];
    if (stroke && stroke.type === "circle") {
        // Jangan allow drawing untuk circle stroke
        return;
    }

    gameState.isDrawing = true;
    const pos = getMousePos(e);
    tracingCtx.beginPath();
    tracingCtx.moveTo(pos.x, pos.y);
}

function draw(e) {
    if (!gameState.isDrawing) return;

    const letter = allHijaiyahData[currentHurufIndex];
    if (!letter || !letter.strokes) return;

    const stroke = letter.strokes[currentStrokeIndex];
    if (stroke && stroke.type === "circle") return;

    const pos = getMousePos(e);

    // Cek akurasi dengan sistem bobot
    const accuracyResult = checkAccuracy(pos);
    const isCorrect = accuracyResult.isCorrect;
    const score = accuracyResult.score;

    gameState.totalPoints++;

    // Akumulasi skor kualitas (bukan cuma hitung jumlah titik benar)
    // Kita anggap max skor per titik adalah 100
    // Jadi nanti rata-ratanya: (totalSkor / (totalPoints * 100)) * 100
    gameState.correctPoints += score;

    tracingCtx.strokeStyle = isCorrect
        ? settings.colors.correct
        : settings.colors.incorrect;
    tracingCtx.lineWidth = settings.lineWidth;
    tracingCtx.lineCap = "round";
    tracingCtx.lineJoin = "round";
    tracingCtx.lineTo(pos.x, pos.y);
    tracingCtx.stroke();

    tracingCtx.beginPath();
    tracingCtx.moveTo(pos.x, pos.y);

    gameState.tracedPoints.push({ x: pos.x, y: pos.y, correct: isCorrect });

    calculateProgress();
    updateProgress();
}

function stopDrawing() {
    if (!gameState.isDrawing) return;
    gameState.isDrawing = false;
    tracingCtx.beginPath();

    if (gameState.currentStrokeProgress >= 80) {
        setTimeout(() => {
            advanceToNextStroke();
        }, 300);
    }
}

function handleTouchStart(e) {
    e.preventDefault();
    const touch = e.touches[0];
    const mouseEvent = new MouseEvent("mousedown", {
        clientX: touch.clientX,
        clientY: touch.clientY,
    });
    tracingCanvas.dispatchEvent(mouseEvent);
}

function handleTouchMove(e) {
    e.preventDefault();
    const touch = e.touches[0];
    const mouseEvent = new MouseEvent("mousemove", {
        clientX: touch.clientX,
        clientY: touch.clientY,
    });
    tracingCanvas.dispatchEvent(mouseEvent);
}

// ========================================
// ADVANCE TO NEXT STROKE
// ========================================
function advanceToNextStroke() {
    const letter = allHijaiyahData[currentHurufIndex];

    // 1. Akumulasi skor dari goresan garis
    gameState.totalGamePoints += gameState.totalPoints;
    gameState.totalGameCorrectPoints += gameState.correctPoints;

    // 2. Jika stroke adalah circle, kita tambahkan skor tetap (misalnya 10 poin)
    if (letter.strokes[currentStrokeIndex].type === "circle") {
        // Asumsi: Circle selalu benar dan bernilai 100 poin (karena cuma 1 klik)
        gameState.totalGamePoints += 1; // Anggap 1 titik
        gameState.totalGameCorrectPoints += 100; // Skor sempurna
    }

    gameState.completedStrokes.push(currentStrokeIndex);

    if (gameState.completedStrokes.length >= letter.strokes.length) {
        // Hitung akurasi total game (Weighted Average)
        let finalAccuracy = 0;
        if (gameState.totalGamePoints > 0) {
            // totalGameCorrectPoints sekarang adalah akumulasi skor (bukan count)
            // totalGamePoints adalah jumlah titik yang digambar
            // Jadi rata-ratanya: totalSkor / jumlahTitik
            finalAccuracy = Math.round(gameState.totalGameCorrectPoints / gameState.totalGamePoints);
        }
        showSuccessModal(finalAccuracy);
    } else {
        currentStrokeIndex++;
        gameState.tracedPoints = [];
        gameState.totalPoints = 0;
        gameState.correctPoints = 0;
        gameState.currentStrokeProgress = 0;
        gameState.circleClicked = false;
        drawGuide(letter);
        updateProgress();
    }
}

// ========================================
// GET MOUSE POSITION
// ========================================
function getMousePos(e) {
    const rect = tracingCanvas.getBoundingClientRect();
    const scaleX = tracingCanvas.width / rect.width;
    const scaleY = tracingCanvas.height / rect.height;

    return {
        x: (e.clientX - rect.left) * scaleX,
        y: (e.clientY - rect.top) * scaleY,
    };
}

// ========================================
// CHECK ACCURACY (CURRENT STROKE ONLY)
// ========================================
// ========================================
// CHECK ACCURACY (WEIGHTED SCORING)
// ========================================
function checkAccuracy(point) {
    const letter = allHijaiyahData[currentHurufIndex];
    if (
        !letter ||
        !letter.strokes ||
        currentStrokeIndex >= letter.strokes.length
    )
        return { isCorrect: false, score: 0 };

    const stroke = letter.strokes[currentStrokeIndex];
    if (stroke.type !== "line") return { isCorrect: false, score: 0 };

    let minDistance = Infinity;

    // Cari jarak terdekat ke segmen manapun di stroke ini
    for (let i = 0; i < stroke.points.length - 1; i++) {
        const start = stroke.points[i];
        const end = stroke.points[i + 1];
        const distance = distanceToLineSegment(point, start, end);
        if (distance < minDistance) {
            minDistance = distance;
        }
    }

    // Hitung Skor Berdasarkan Jarak
    if (minDistance <= 5) {
        return { isCorrect: true, score: 100 }; // Sempurna
    } else if (minDistance <= 10) {
        return { isCorrect: true, score: 80 }; // Bagus
    } else if (minDistance <= settings.tolerance) { // <= 15
        return { isCorrect: true, score: 50 }; // Cukup
    } else {
        return { isCorrect: false, score: 0 }; // Salah
    }
}

// ========================================
// DISTANCE TO LINE SEGMENT
// ========================================
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

// ========================================
// CALCULATE PROGRESS
// ========================================
function calculateProgress() {
    const letter = allHijaiyahData[currentHurufIndex];
    if (
        !letter ||
        !letter.strokes ||
        currentStrokeIndex >= letter.strokes.length
    )
        return;

    const stroke = letter.strokes[currentStrokeIndex];
    if (stroke.type !== "line") return;

    const pathLength = calculatePathLength(stroke.points);

    let coveredLength = 0;
    const tracedPoints = gameState.tracedPoints;
    for (let i = 0; i < tracedPoints.length - 1; i++) {
        const p1 = tracedPoints[i];
        const p2 = tracedPoints[i + 1];
        const dist = Math.sqrt((p2.x - p1.x) ** 2 + (p2.y - p1.y) ** 2);
        coveredLength += dist;
    }

    gameState.currentStrokeProgress = Math.min(
        100,
        (coveredLength / pathLength) * 100
    );

    if (gameState.totalPoints > 0) {
        // Rata-rata skor per titik (0-100)
        gameState.currentStrokeAccuracy = Math.round(
            gameState.correctPoints / gameState.totalPoints
        );
    }
}

// ========================================
// CALCULATE PATH LENGTH
// ========================================
function calculatePathLength(path) {
    let length = 0;
    for (let i = 0; i < path.length - 1; i++) {
        const p1 = path[i];
        const p2 = path[i + 1];
        length += Math.sqrt((p2.x - p1.x) ** 2 + (p2.y - p1.y) ** 2);
    }
    return length;
}

// ========================================
// UPDATE PROGRESS UI
// ========================================
function updateProgress() {
    const letter = allHijaiyahData[currentHurufIndex];
    const totalStrokes = letter.strokes ? letter.strokes.length : 1;
    const completedStrokes = gameState.completedStrokes.length;

    const overallProgress =
        ((completedStrokes + gameState.currentStrokeProgress / 100) /
            totalStrokes) *
        100;

    const progressFill = document.getElementById("progress-fill");
    const progressText = document.getElementById("progress-text");
    const scoreDisplay = document.getElementById("score-display");
    const starsDisplay = document.getElementById("stars-display");

    progressFill.style.width = overallProgress + "%";
    progressText.textContent = Math.round(overallProgress) + "%";
    scoreDisplay.textContent = gameState.currentStrokeAccuracy + "%";

    const stars = getStars(gameState.currentStrokeAccuracy);
    starsDisplay.innerHTML = "⭐".repeat(stars) + "☆".repeat(3 - stars);
}

// ========================================
// GET STARS BASED ON ACCURACY
// ========================================
function getStars(accuracy) {
    if (accuracy >= settings.scoring.threeStars) return 3;
    if (accuracy >= settings.scoring.twoStars) return 2;
    if (accuracy >= settings.scoring.oneStar) return 1;
    return 0;
}

// ========================================
// CLEAR CANVAS
// ========================================
function clearCanvas() {
    tracingCtx.clearRect(0, 0, tracingCanvas.width, tracingCanvas.height);
    gameState.tracedPoints = [];
    gameState.currentStrokeProgress = 0;
    gameState.totalPoints = 0;
    gameState.correctPoints = 0;
    gameState.circleClicked = false;
    updateProgress();
}

// ========================================
// NAVIGATION FUNCTIONS
// ========================================
function loadPreviousLetter() {
    if (currentHurufIndex > 0) {
        loadGame(currentHurufIndex - 1);
    }
}

function loadNextLetter() {
    if (currentHurufIndex < allHijaiyahData.length - 1) {
        hideSuccessModal();
        loadGame(currentHurufIndex + 1);
    }
}

function hideSuccessModal() {
    const modal = document.getElementById('success-modal');
    if (modal) modal.classList.remove('show');
}

function updateNavigationButtons() {
    const prevBtn = document.getElementById("prev-button");
    const nextBtn = document.getElementById("next-button");

    if (currentHurufIndex === 0) {
        prevBtn.disabled = true;
        prevBtn.style.opacity = "0.5";
    } else {
        prevBtn.disabled = false;
        prevBtn.style.opacity = "1";
    }

    if (currentHurufIndex === allHijaiyahData.length - 1) {
        nextBtn.disabled = true;
        nextBtn.style.opacity = "0.5";
    } else {
        nextBtn.disabled = false;
        nextBtn.style.opacity = "1";
    }
}


// ========================================
// SHOW SUCCESS MODAL (VANILLA JS VERSION)
// ========================================
function showSuccessModal(skorAkhir) {
    const modal = document.getElementById('success-modal');
    const scoreText = document.getElementById('modal-score');
    const starsContainer = document.getElementById('final-stars');
    const nextButton = document.getElementById('btn-next-letter'); // Ambil tombol next

    // 1. Update Teks Skor
    if (scoreText) scoreText.innerText = skorAkhir + "%";

    // 2. Logika Bintang (HARUS DI DALAM FUNGSI)
    let starCount = 1;
    if (skorAkhir >= 85) starCount = 3;
    else if (skorAkhir >= 60) starCount = 2;

    let starsHTML = '';
    for (let i = 1; i <= 3; i++) {
        if (i <= starCount) {
            // Bintang Emas (Muncul satu-satu)
            const delay = i * 0.2;
            starsHTML += `<span class="star-gold star-animate" style="animation-delay: ${delay}s">★</span>`;
        } else {
            // Bintang Abu
            starsHTML += `<span class="star-gray">★</span>`;
        }
    }

    if (starsContainer) {
        starsContainer.innerHTML = starsHTML;
    }

    // 3. Cek Tombol Next (Sembunyikan jika huruf terakhir)
    if (nextButton) {
        // Cek apakah ini huruf terakhir di array
        if (currentHurufIndex >= allHijaiyahData.length - 1) {
            nextButton.style.display = 'none'; // Sembunyikan
        } else {
            nextButton.style.display = 'block'; // Tampilkan
        }
    }

    // 4. Tampilkan Modal
    if (modal) {
        modal.classList.add('show');
    }

    // 5. Efek Confetti
    launchConfetti();

    // 6. Simpan Skor ke Database (Otomatis saat selesai)
    // Konversi: 100% akurasi = 10 poin
    const poinDidapat = Math.round(skorAkhir / 10);
    totalSessionScore += poinDidapat;
    saveTracingScore(totalSessionScore);
}

// ========================================
// TOMBOL AKSI MODAL
// ========================================

// 1. Fungsi Restart Huruf Ini (Ulangi)
function restartCurrentLetter() {
    hideSuccessModal();

    // Reset Canvas & Game State untuk huruf yang sama
    loadGame(currentHurufIndex);
}

// 2. Fungsi Tombol Main Lagi (Reset Total)
function restartGame() {
    hideSuccessModal();

    // Reset ke huruf pertama
    currentHurufIndex = 0;
    initGame();
}

// ========================================
// CONFETTI EFFECT
// ========================================
function launchConfetti() {
    if (typeof confetti === 'undefined') return; // Cek library ada/nggak

    var duration = 3 * 1000;
    var animationEnd = Date.now() + duration;
    var defaults = { startVelocity: 30, spread: 360, ticks: 60, zIndex: 60 };

    function randomInOut(min, max) {
        return Math.random() * (max - min) + min;
    }

    var interval = setInterval(function () {
        var timeLeft = animationEnd - Date.now();

        if (timeLeft <= 0) {
            return clearInterval(interval);
        }

        var particleCount = 50 * (timeLeft / duration);
        confetti({ ...defaults, particleCount, origin: { x: randomInOut(0.1, 0.3), y: Math.random() - 0.2 } });
        confetti({ ...defaults, particleCount, origin: { x: randomInOut(0.7, 0.9), y: Math.random() - 0.2 } });
    }, 250);
}


// ========================================
// SUBMIT SCORE TO SERVER
// ========================================

function calculateAccuracy(strokesDone, totalStrokes) {
    return Math.round((strokesDone / totalStrokes) * 100);
}

// Tambahkan fungsi ini di dalam script di tracing.blade.php atau di public/js/game-tracing.js

// --- 1. AMBIL DATA SUNTIKAN ---
// Kalau gak ada suntikan (misal test lokal), pakai default null/array kosong
const jenisGameId = typeof JENIS_GAME_ID !== "undefined" ? JENIS_GAME_ID : null;
const tingkatanId = typeof TINGKATAN_ID !== "undefined" ? TINGKATAN_ID : null;
const hasilGameId = typeof HASIL_GAME_ID !== "undefined" ? HASIL_GAME_ID : null;
const saveScoreUrl =
    typeof SAVE_SCORE_URL !== "undefined" ? SAVE_SCORE_URL : "/game/save-score";
const redirectUrl = typeof REDIRECT_URL !== "undefined" ? REDIRECT_URL : "/";

// ... (Kode inisialisasi game, variabel gameState, dll TETAP SAMA) ...

// --- 2. UPDATE FUNGSI SAVE SCORE ---
async function saveTracingScore(scoreInput) {
    // Ambil skor dari parameter, atau fallback ke 0
    const skor = (typeof scoreInput !== 'undefined') ? scoreInput : 0;
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    const saveStatusElement = document.getElementById("save-status");
    const backButton = document.getElementById("back-to-menu-button");

    // Update UI
    if (saveStatusElement) {
        saveStatusElement.innerText = "Menyimpan skor...";
        saveStatusElement.classList.remove("text-green-600", "text-red-600");
        saveStatusElement.classList.add("text-yellow-600");
    }
    if (backButton) backButton.disabled = true;

    try {
        // Fetch ke URL yang benar
        const response = await fetch("/murid/game/save-score", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": csrfToken,
            },
            body: JSON.stringify({
                hasil_game_id: hasilGameId,
                skor: skor,
                total_poin: skor,
            }),
        });

        const data = await response.json();

        if (data.success) {
            if (saveStatusElement) {
                saveStatusElement.innerText = `Skor ${skor}% berhasil disimpan!`;
                saveStatusElement.classList.remove("text-yellow-600");
                saveStatusElement.classList.add("text-green-600");
            }
            // Redirect setelah sukses (opsional, atau biarkan user klik tombol kembali)
            // window.location.href = redirectUrl;
        } else {
            throw new Error("Gagal menyimpan data.");
        }
    } catch (error) {
        console.error("Error:", error);
        if (saveStatusElement) {
            saveStatusElement.innerText = "Gagal menyimpan skor.";
            saveStatusElement.classList.remove("text-yellow-600");
            saveStatusElement.classList.add("text-red-600");
        }
    } finally {
        if (backButton) backButton.disabled = false;
    }
}
