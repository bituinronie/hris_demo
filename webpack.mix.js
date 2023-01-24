const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */


mix.js(['resources/js/src/main.js', 'resources/js/src/material-dashboard.js', 'resources/js/src/store.js', 'resources/js/src/globalComponents.js', 'resources/js/src/globalDirectives.js'], 'public/js')
    .sass('resources/js/src/assets/scss/material-dashboard.scss', 'public/css', {
    	implementation: require('node-sass')
    }).vue(
    	{
    		version: 2,
    		test: /\.scss$/,
		    use: [
		       'vue-style-loader',
		       'css-loader',
		       'sass-loader'
		    ]
    	}
);


// mix.js('resources/js/src/main.js', 'public/js')
//     // .postCss('resources/js/src/assets/scss/material-dashboard.scss', 'public/css', [
//     // ])
//     .vue({
//     		version: 2,
//     		extractStyles: true,
//     		globalStyles: true
//     });

// mix.js(['resources/js/src/main.js', 'resources/js/src/material-dashboard.js', 'resources/js/src/store.js', 'resources/js/src/globalComponents.js', 'resources/js/src/globalDirectives.js', 'resources/js/src/routes/router.js'], 'public/js')
//    .sass('resources/js/src/assets/scss/material-dashboard.scss', 'public/css')
//   //  .styles('resources/css/styles.css', 'public/css')
//    .vue({
//     		version: 2,
//     		extractStyles: true,
//     		globalStyles: true
//     });