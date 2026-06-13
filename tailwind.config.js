import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            colors: {
            'ngo-blue': '#0A2540',   // Dark Blue: Trust, stability (Headers, Sidebar)
            'ngo-orange': '#FF6B35', // Orange: Urgency, action (Donate buttons, alerts)
            'ngo-green': '#28A745',  // Green: Impact, growth, success (Progress bars, success toasts)
            'ngo-black': '#1A1A1A',  // Black: Text, deep footers
        },
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};
