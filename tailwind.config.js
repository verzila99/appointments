module.exports = {
    purge: [
        './resources/**/*.blade.php',

        './resources/**/*.js',

        './resources/**/*.vue',
    ],
    darkMode: false, // or 'media' or 'class'
    theme: {
        extend: {
            colors: {
                white: '#FFFFFF',
                grey: '#EBEBEB',
                primary: '#48CAE4',
                link: '#0096c7',
                hover: '#0077b6',
                success: '#A2D729',
                danger: 'rgb(242, 19, 93)',
                warning: 'rgb(255, 130, 0)',
                dark: '#293241'
            }
        },
    },
    variants: {
        extend: {},
    },
    plugins: [],
}
