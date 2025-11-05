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
                primary: '#1B5E20',
                secondary: '#81C784 ',
                accent: '#F5F5DC',

                primary: {
                    50: '#f0fdf4',
                    100: '#dcfce7',
                    200: '#bbf7d0',
                    300: '#86efac',
                    400: '#4ade80',
                    500: '#22c55e',
                    600: '#16a34a',
                    700: '#15803d',
                    800: '#166534',
                    900: '#14532d',
                },
                earth: {
                    50: '#fef3e2',
                    100: '#fde6c6',
                    200: '#fbd08d',
                    300: '#f9b854',
                    400: '#f7a01b',
                    500: '#d88715',
                    600: '#b06d11',
                    700: '#88530d',
                    800: '#603a09',
                    900: '#382105',
                }
            },
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                inter: ['Inter', 'sans-serif'],
                poppins: ['Poppins', 'sans-serif'],
            },
            animation: {
                'bounce-slow': 'bounce 2s infinite',
            }
        },
    },

    plugins: [forms],
};