var Encore = require('@symfony/webpack-encore');

Encore
// directory where compiled assets will be stored
	.setOutputPath('public/build/')
	// public path used by the web server to access the output path
	.setPublicPath('/build')
	// only needed for CDN's or sub-directory deploy
	//.setManifestKeyPrefix('build/')

	/*
     * ENTRY CONFIG
     *
     * Add 1 entry for each "page" of your app
     * (including one that's included on every page - e.g. "app")
     *
     * Each entry will result in one JavaScript file (e.g. app.js)
     * and one CSS file (e.g. app.css) if you JavaScript imports CSS.
     */

	// main app asset files
	.addEntry('js/app', './assets/js/app.js')
	.addStyleEntry('css/app', './assets/css/global.scss')

	.addEntry('app', './assets/js/app.js')
	.addEntry('attack_detail', './assets/js/attack_detail.js')
	.addEntry('attack_list', './assets/js/attack_list.js')
	.addEntry('create_resource', './assets/js/create_resource.js')
	.addEntry('home', './assets/js/home.js')
	.addEntry('pokemon_detail', './assets/js/pokemon_detail.js')
	.addEntry('pokemon_grid', './assets/js/pokemon_grid.js')


	// will require an extra script tag for runtime.js
	// but, you probably want this, unless you're building a single-page app
	.enableSingleRuntimeChunk()

	/*
     * FEATURE CONFIG
     *
     * Enable & configure other features below. For a full
     * list of features, see:
     * https://symfony.com/doc/current/frontend.html#adding-more-features
     */
	.cleanupOutputBeforeBuild()
	.enableBuildNotifications()
	.enableSourceMaps(!Encore.isProduction())
	// enables hashed filenames (e.g. app.abc123.css)
	.enableVersioning(Encore.isProduction())

	// enables Sass/SCSS support
	//.enableSassLoader()

	// uncomment if you use TypeScript
	//.enableTypeScriptLoader()

	// uncomment if you're having problems with a jQuery plugin
	// .autoProvidejQuery()

	.autoProvideVariables({ Popper: ['popper.js', 'default'] })

	// uncomment if you use API Platform Admin (composer req api-admin)
	//.enableReactPreset()
	//.addEntry('admin', './assets/js/admin.js')

	// Babel custom configuration
	.configureBabel(function(babelConfig) {
		// presets and plugins
	},{
		// modules and files whitelist
	})

	.configureFilenames({
		images: '[path][name].[hash:8].[ext]',
	})

	// enabling .scss and .sass support
	.enableSassLoader()
;

module.exports = Encore.getWebpackConfig();
