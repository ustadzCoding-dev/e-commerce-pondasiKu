import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    // darkMode: 'class',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
        './node_modules/flowbite/**/*.js',
        './node_modules/flowbite-vue/**/*.{js,jsx,ts,tsx}',
        './node_modules/flowbite/**/*.{js,jsx,ts,tsx}'
    ],
    theme: {
        extend: {
            spacing: {
                'xs': '4px',
                'sm': '8px',
                'md': '16px',
                'lg': '24px',
                'xl': '32px',
                '2xl': '48px',
                '3xl': '64px',
                'header': '80px',
                'margin-desktop': '48px',
                'margin-mobile': '16px',
                'container-max': '1440px',
                'gutter': '24px',
                'base': '4px',
            },
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
                display: ['Inter', ...defaultTheme.fontFamily.sans],
                body: ['Inter', ...defaultTheme.fontFamily.sans],
            },
            borderRadius: {
                'none': '0',
                'sm': '0.125rem', // 2px
                'DEFAULT': '0.25rem', // 4px
                'md': '0.375rem', // 6px
                'lg': '0.5rem', // 8px
                'xl': '0.75rem', // 12px
                '2xl': '1rem',
                '3xl': '1.5rem',
                'full': '9999px',
            },
            boxShadow: {
                'none': 'none',
                'sm': '0 1px 2px rgba(0, 0, 0, 0.05)',
                'DEFAULT': '0px 4px 6px -1px rgba(0, 0, 0, 0.1), 0px 2px 4px -1px rgba(0, 0, 0, 0.06)',
                'md': '0px 4px 6px -1px rgba(0, 0, 0, 0.1), 0px 2px 4px -1px rgba(0, 0, 0, 0.06)',
                'lg': '0 10px 15px rgba(0, 0, 0, 0.1), 0 4px 6px rgba(0, 0, 0, 0.05)',
                'xl': '0 20px 25px rgba(0, 0, 0, 0.1), 0 10px 10px rgba(0, 0, 0, 0.04)',
                'inner': 'inset 0 2px 4px 0 rgba(0, 0, 0, 0.06)',
            },
            colors: {
                surface: '#fafaf9',
                'surface-dim': '#e7e5e4',
                'surface-bright': '#ffffff',
                'surface-container-lowest': '#ffffff',
                'surface-container-low': '#f5f5f4',
                'surface-container': '#e7e5e4',
                'surface-container-high': '#d6d3d1',
                'surface-container-highest': '#a8a29e',
                'on-surface': '#1c1917',
                'on-surface-variant': '#57534e',
                'on-primary': '#ffffff',
                'inverse-surface': '#292524',
                'inverse-on-surface': '#fafaf9',
                outline: '#a8a29e',
                'outline-variant': '#d6d3d1',
                'surface-tint': '#ea580c',
                construction: '#ea580c',
                ink: '#1c1917',
                primary: {
                    DEFAULT: '#ea580c',
                    50: '#fff7ed',
                    100: '#ffedd5',
                    200: '#fed7aa',
                    300: '#fdba74',
                    400: '#fb923c',
                    500: '#f97316',
                    600: '#ea580c',
                    700: '#c2410c',
                    800: '#9a3412',
                    900: '#7c2d12'
                },
                secondary: {
                    DEFAULT: '#78716c',
                    50: '#fafaf9',
                    100: '#f5f5f4',
                    200: '#e7e5e4',
                    300: '#d6d3d1',
                    400: '#a8a29e',
                    500: '#78716c',
                    600: '#57534e',
                    700: '#44403c',
                    800: '#292524',
                    900: '#1c1917'
                },
                tertiary: {
                    DEFAULT: '#565e74',
                    container: '#929ab2',
                },
                error: {
                    DEFAULT: '#ba1a1a',
                    container: '#ffdad6',
                },
                slate: {
                    150: '#E8EEF4',
                    350: '#AFBFCD',
                    450: '#7B8CA2',
                    550: '#55667A',
                    650: '#3B4B5F',
                    750: '#283449',
                    850: '#172036',
                },
                amber: {
                    550: '#E58709',
                },
                red: {
                    50: '#fef2f2',
                    100: '#fee2e2',
                    200: '#fecaca',
                    300: '#fca5a5',
                    400: '#f87171',
                    500: '#ef4444',
                    600: '#dc2626',
                    650: '#c81f1f',
                    700: '#b91c1c',
                    800: '#991b1b',
                    900: '#7f1d1d',
                },
                accent: {
                    50: '#fffbeb',
                    100: '#fef3c7',
                    200: '#fde68a',
                    300: '#fcd34d',
                    400: '#fbbf24',
                    500: '#f59e0b',
                    600: '#d97706',
                    700: '#b45309',
                    800: '#92400e',
                    900: '#78350f',
                }
            },
            screens: {
                'mobile': {'max': '639px'},
                'tablet': {'min': '640px', 'max': '1023px'},
                'desktop': {'min': '1024px'},
                // Aliases for common breakpoints
                'sm': '640px',
                'md': '768px',
                'lg': '1024px',
                'xl': '1280px',
                '2xl': '1536px',
            },
            keyframes: {
                float: {
                    '0%, 100%': { transform: 'translateY(0)' },
                    '50%': { transform: 'translateY(-10px)' },
                },
                'fade-in-up': {
                    '0%': { opacity: '0', transform: 'translateY(20px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
                'pulse-slow': {
                    '0%, 100%': { opacity: '1' },
                    '50%': { opacity: '.8' },
                }
            },
            animation: {
                'float': 'float 3s ease-in-out infinite',
                'fade-in-up': 'fade-in-up 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards',
                'pulse-slow': 'pulse-slow 4s cubic-bezier(0.4, 0, 0.6, 1) infinite',
            }
        },
    },

    plugins: [forms, require('flowbite/plugin')],
};
