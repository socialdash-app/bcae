/** @type {import('tailwindcss').Config} */
export default {
  content: ['resources/views/*.blade.php','resources/js/components/**/*.vue'],
  theme: {
    extend: {
        fontFamily:{
            poppins: ['Poppins']
        }
    },
  },
  plugins: [],
}

