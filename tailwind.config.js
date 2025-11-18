import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
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
                    600: "#A32033", // más oscuro (texto, énfasis)
                    700: "#72101F", // muy oscuro
                    DEFAULT: "#D82F4B",
                },

                neutral: {
                    25: "#FFFEFE",
                    50: "#FAFAFA",
                    100: "#F5F5F5",
                    200: "#E6E6E6",
                    400: "#D9D9D9",
                    600: "#393939",
                    800: "#1B1919",
                },
            },
        },
    },

    plugins: [forms],
};
