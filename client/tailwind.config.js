module.exports = {
  content: [
    './pages/**/*.{vue,js}',
    './components/**/*.{vue,js}',
    './layouts/**/*.{vue,js}'
  ],
  darkMode: 'class', // Enable class-based dark mode
  theme: {
    extend: {
      colors: {
        // Light theme colors
        light: {
          primary: '#ffffff', // Light background (white)
          secondary: '#f8f8f8', // Light background (light gray)
          accent: '#f79c42', // ShadCN accent color (you can adjust this to match)
          link: '#3498db', // Blue link color
        },
        // Dark theme colors
        dark: {
          primary: '#000000', // Dark background
          secondary: '#000000', // Dark secondary color
          accent: '#000000', // ShadCN accent color (you can adjust this)
          link: '#000000', // Blue link color
        },
      },
      fontFamily: {
        sans: ['Inter', 'sans-serif'], // Similar to ShadCN's typography
      },
    },
  },
  plugins: [],
}
