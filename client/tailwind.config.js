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
        // Light theme colors (default)
        light: {
          primary: '#ffffff', // White background
          secondary: '#f8f8f8', // Light gray background
          accent: '#f79c42', // Orange accent color
          link: '#3498db', // Blue link color
        },
        // Dark theme colors (updated to a nice gray palette)
        dark: {
          primary: '#1e1e1e', // Dark gray background
          secondary: '#2a2a2a', // Slightly lighter gray
          accent: '#f79c42', // Keep the orange accent for contrast
          link: '#4aa3f0', // Softer blue for links
        },
      },
      fontFamily: {
        sans: ['Inter', 'sans-serif'], // Clean and modern font
      },
    },
  },
  plugins: [],
}
