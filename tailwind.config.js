/** @type {import('tailwindcss').Config} */

const defaultTheme = require("tailwindcss/defaultTheme"); // Import tema default buat fallback

module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./app/Http/Livewire/**/*.php",
    ],
    theme: {
        fontFamily: {
            sans: [
                "Mooli",
                ...defaultTheme.fontFamily.sans, // Fallback kalo gaada Mooli
            ],
            'titan': ['Titan One', 'cursive'],
            // 'cursive-iwk': ['Tegak Bersambung IWK', 'cursive'],
            'tegak': ['"TegakBersambung"', 'sans-serif'],
        },
        extend: {
            colors: {
                "iqrain-pink": "#F387A9",
                "iqrain-yellow": "#FFC801",
                "iqrain-blue": "#56B1F3",
                "iqrain-dark-blue": "#234275",
            },
        },
    },
    plugins: [],
};
