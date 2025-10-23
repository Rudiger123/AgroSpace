import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            colors: {
                'agro-green': '#2E7D32',
                'agro-beige': '#F5F5DC',
                'agro-white': '#FFFFFF',
                'agro-gray': '#37474F',
                'agro-yellow': '#FFB300',
            },
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                inter: ['Inter', 'sans-serif'],
                poppins: ['Poppins', 'sans-serif'],
            },
        },
    },

    plugins: [forms],
};