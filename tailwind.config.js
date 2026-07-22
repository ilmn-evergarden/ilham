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
                },
                gray: {
                    50: '#fafafa',
                    100: '#f2f2f2',
                    200: '#e1e1e1',
                    300: '#d1d1d1',
                    400: '#a4a4a4',
                    500: '#777777',
                    600: '#555555',
                    700: '#383848',
                    800: '#111111',
                    900: '#222222',
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
