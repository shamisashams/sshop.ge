const { colors: defaultColors } = require("tailwindcss/defaultTheme");

const colors = {
    ...defaultColors,
    ...{
        "custom-dark": "#434343",
        "custom-blue": "#4FA9D2",
        "custom-red": "#DF6756",
        "custom-yellow": "#F0DD5D",
        "custom-zinc": {
            100: "#FBFBFB",
            200: "#F8F8F9",
            300: "#EFEFEF",
        },
    },
};

module.exports = {
    content: ["./resources/**/*.{html,js,jsx}"],
    theme: {
        extend: {
            colors: colors,
        },
    },
    plugins: [],
};
