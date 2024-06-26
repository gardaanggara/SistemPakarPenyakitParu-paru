const mix = require('laravel-mix');
const BrowserSyncPlugin = require('browser-sync-webpack-plugin');

mix.js('resources/js/app.js', 'public/js')
   .sass('resources/sass/app.scss', 'public/css')
   .options({
       processCssUrls: false
   });

mix.webpackConfig({
    plugins: [
        new BrowserSyncPlugin({
            proxy: 'localhost:8000', // Ganti dengan URL pengembangan lokal Anda
            files: [
                'app/**/*.php',
                'resources/views/**/*.blade.php',
                'public/js/**/*.js',
                'public/css/**/*.css'
            ],
            notify: false
        })
    ]
});

if (mix.inProduction()) {
    mix.version();
}
