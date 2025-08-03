const defaultTheme = require('tailwindcss/defaultTheme');
const forms = require('@tailwindcss/forms');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                'yu-gothic': ['"游ゴシック体"', 'Yu Gothic', 'sans-serif'],
                'noto-sans-jp': ['"Noto Sans JP"', 'sans-serif'],
            },
            colors: {
                'smarthr-blue': '#00c4cc',
                'smarthr-black': '#23221f',
                'smarthr-orange': '#ff9900',
                'smarthr-white': '#ffffff',
            },

            backgroundImage: {
                'login-bg' : "url('/images/Gemini_Generated_Image_yb4qfpyb4qfpyb4q.jpeg')",
                'main-bg' : "url('/images/Gemini_Generated_Image_yb4qfpyb4qfpyb4q.jpeg')"
            }
        
        },
    },

    plugins: [forms],



};

