import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/js/**/*.js",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
            },

            colors: {
                brand: {
                    25: "#FFECEF",
                    50: "#FFE5ED", // muy claro (fondos sutiles)
                    100: "#FFCED1", // claro
                    200: "#F8A3AA", // tono medio claro
                    500: "#D42340", // saturado (hover)
                    600:"#D9324D",
                    700: "#A32033", // más oscuro (texto, énfasis)
                    800: "#72101F", // muy oscuro
                    DEFAULT: "#D82F4B",
                },

                neutral: {
                    25: "#FFFEFE",
                    50: "#FAFAFA",
                    100: "#F5F5F5",
                    200: "#eeeded",
                    300: "#E0E0E0",
                    400: "#BFBFBF",
                    600: "#393939",
                    800: "#1B1919",
                },
            },
        },
    },

    plugins: [forms],
};
