import { defineConfig } from '@mazui/cli'

export default defineConfig({
  outputCssFilePath: './resources/css/maz-ui-variables.css',
  theme: {
    colors: {
      primary: '#0C3B2E',  // Dark green
      secondary: '#BB8A52', // Brownish color
      info: '#6D9773',      // Soft green
      success: '#FFBA00',   // Yellow
      warning: '#FFBA00',   // Yellow
      danger: '#BB8A52',    // Brownish color
      bgOverlay: 'hsl(0, 0%, 0% / 30%)',
      lightTheme: {
        textColor: 'hsl(0, 0%, 85%)',
        colorMuted: 'hsla(0, 0%, 0%, 0.54)',
        bgColor: '#FFF5E6', // Light background
      },
      darkTheme: {
        textColor: '#0C3B2E',
        colorMuted: '#BB8A52',
        bgColor: '#6D9773',
      },
    },
    borderColor: '#BB8A52',
    borderWidth: '0.125rem',
    borderRadius: '0.25rem',
    fontFamily: `system-ui, -apple-system, blinkmacsystemfont, 'Segoe UI', roboto, oxygen,
    ubuntu, cantarell, 'Fira Sans', 'Droid Sans', 'Helvetica Neue', sans-serif`,
  },
})
