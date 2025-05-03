/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/views/AdminPannel.blade.php",
        "./resources/views/AdminPannel/AddData.blade.php",
        "./resources/views/EditData/EditCategories.blade.php",
        "./resources/views/Global/HomePage.blade.php",
        "./resources/views/Global/SideBar.blade.php",
        "./resources/views/Global/TopBar.blade.php",
        "./resources/views/Global/Search.blade.php",
        "./resources/views/Global/SearchResults.blade.php",
        "./resources/views/Global/Footer.blade.php",
        "./resources/views/Global/ContactUs.blade.php",
        "./resources/views/Global/QuickView.blade.php",
        "./resources/views/Global/Products.blade.php",
        "./resources/views/HomePageSections/Categories.blade.php",
        "./resources/views/HomePageSections/OurProducts.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            fontFamily: {
                arima: ["Arima", "sans-serif"],
            },
            keyframes: {
                BorderB: {
                    "0%": { right: "5rem" },
                    "100%": { right: "0rem" },
                },
            },
            animation: {
                BorderB: "BorderB 0.3s ease-in-out",
            },
        },
        colors: {
            Main: "rgba(255, 247, 247, 0.5);",
            White: "#ffffff",
            Black35: "rgba(0, 0, 0, 0.35);",
            White50: "rgba(255, 255, 255, 0.5);",
            Brown: "rgb(140 140 140);",
            Border: "#BCBCBC",
            LightGrey: "#B0B0B0",
            LightGrey60: "rgba(176, 176, 176, 0.6);",
        },
        minHeight: {
            96: "24rem",
        },
        maxWidth: {
            80: "80%",
            40: "40%",
        },
        width: {
            75: "75%",
            30: "20%",
        },
        letterSpacing: {
            widest: "4rem",
            wide: "2rem",
        },
    },
    plugins: [],
};
