/** @type {import('tailwindcss').Config} */
export default {
  content: ["./*.{html,php}","./partials/**/*.{html,php}"],
  theme: {
    extend: {
      fontFamily: {
        autography: ["Autography", "serif"],
        cc: ["cc", "serif"],
        bettergrade: ["bettergrade", "serif"],
      },
    },
  },
  plugins: [],
};
