import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            backgroundSize: {
                'full': '100% 100%',
            },
            fontFamily: {
                sans: ['Irish Grover', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'grn': '#00992C',
                'biege-dark': '#9D904C',
                'biege': '#F7EDBD;',
                'biege-light': '#FFF8D2',
                'brwn': '#40341D',
                'ylw': '#E8FF5B',
                'upld': '#DED295'
            }
        },
    },

    plugins: [forms],
};
