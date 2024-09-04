import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./app/Http/Controllers/**/*.php",
        "./lang/**/*.{php,json}",
        "./node_modules/tw-elements/dist/js/**/*.js",
        "./node_modules/showdown/dist/**/*.js",
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
    ],

    theme: {
        extend: {},
    },

    darkMode: "class",

    plugins: [
        require("tw-elements/dist/plugin.cjs"),
        require("tailwindcss-ripple"),
        forms,
    ],
};
