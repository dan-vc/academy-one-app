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
            fontFamily: {
                sans: ['Outfit', ...defaultTheme.fontFamily.sans],
            },
            // Aquí añades tus colores personalizados
            colors: {
                primary: {
                    DEFAULT: '#165EFB', // El color base (100% opacidad)
                    '50': 'rgba(22, 94, 251, 0.05)',  // 5% opacidad
                    '100': 'rgba(22, 94, 251, 0.1)',  // 10% opacidad
                    '200': 'rgba(22, 94, 251, 0.2)',  // 20% opacidad
                    '300': 'rgba(22, 94, 251, 0.3)',  // 30% opacidad
                    '400': 'rgba(22, 94, 251, 0.4)',  // 40% opacidad
                    '500': 'rgba(22, 94, 251, 0.5)',  // 50% opacidad
                    '600': 'rgba(22, 94, 251, 0.6)',  // 60% opacidad
                    '700': 'rgba(22, 94, 251, 0.7)',  // 70% opacidad
                    '800': 'rgba(22, 94, 251, 0.8)',  // 80% opacidad
                    '900': 'rgba(22, 94, 251, 0.9)',  // 90% opacidad
                    '950': 'rgba(22, 94, 251, 0.95)', // 95% opacidad
                    // Si quieres, puedes definir el 100% como una clave específica también
                    // '1000': '#165EFB',
                },
                // Si quieres, también puedes añadir tu otro color aquí como un secundario
                // secondary: '#141E30',
            },
        },
    },

    plugins: [forms],
};