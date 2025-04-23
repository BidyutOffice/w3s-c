import defaultTheme from "tailwindcss/defaultTheme";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
            },
            width: {
                "layout-width": "min(90%,1240px)",
                "responsive-card": "min(90%,400px)",
            }, gridTemplateColumns: {
                "fixed-two": "1fr 4fr"
            }, height: {
                "pannel-fixed": "calc(100svh - 156px)"
            }
        },
    },
    plugins: [],
};
