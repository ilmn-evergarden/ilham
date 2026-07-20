import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    darkMode: 'class',

    theme: {
        extend: {
            colors: {
                primary: {
                    DEFAULT: '#2ba283',
                    dark: '#059669',
                }
            },
            fontFamily: {
                sans: ['Raleway', ...defaultTheme.fontFamily.sans],
                serif: ['"Merriweather Sans"', ...defaultTheme.fontFamily.serif],
            },
        },
    },

    plugins: [forms],
};
