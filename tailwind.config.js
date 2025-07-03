const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    purge: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        screens: {
            'xs': {'max': '639px'},
            'sm': {'min': '640px',},
            'md': {'min': '768px',},
            'lg': {'min': '1024px',},
            'xl': {'min': '1280px',},
            '2xl': {'min': '1536px'},
        },
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
                handwriting: ['Handlee', 'Annie Use Your Telescope', 'Architects Daughter', 'Shadows Into Light', 'cursive'],
            },
        },
    },

    variants: {
        extend: {
            opacity: ['disabled'],
        },
    },

    plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography')],
};
