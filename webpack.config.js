var Encore = require('@symfony/webpack-encore');

Encore
	// directory where compiled assets will be stored
	.setOutputPath('public/build/')
	// public path used by the web server to access the output path
	.setPublicPath('/build')
	.cleanupOutputBeforeBuild()
	.autoProvidejQuery()

	.autoProvideVariables({
	 	$: 'jquery',
	 	jQuery: 'jquery',
	 	'window.jQuery': 'jquery',
	 	'window.$': 'jquery'
	 })


	// enabling .scss and .sass support
	.enableSassLoader()
	// enable hashed filenames
	.enableVersioning(Encore.isProduction())

	// main app asset files
	.addEntry('js/app', './assets/js/app.js')
	.addEntry('app', './assets/js/app.js')
	.addEntry('attack_detail', './assets/js/attack_detail.js')
	.addEntry('attack_list', './assets/js/attack_list.js')
	.addEntry('home', './assets/js/home.js')
	.addEntry('pokemon_detail', './assets/js/pokemon_detail.js')
	.addEntry('pokemon_grid', './assets/js/pokemon_grid.js')
	.addEntry('admin_pokemon', './assets/js/admin_pokemon.js')
	.addEntry('admin_attack', './assets/js/admin_attack.js')
	.addEntry('admin_pokemon_edit', './assets/js/admin_pokemon_edit.js')
	.addEntry('admin_attack_edit', './assets/js/admin_attack_edit.js')
	.addEntry('contact', './assets/js/contact.js')
	.addStyleEntry('css/app', './assets/css/global.scss')

	// will require an extra script tag for runtime.js
	// but, you probably want this, unless you're building a single-page app
	.enableSingleRuntimeChunk()
	.enableBuildNotifications()
	.enableSourceMaps(!Encore.isProduction())
	// enables hashed filenames (e.g. app.abc123.css)
	
	// Babel custom configuration
	.configureBabel(function(babelConfig) {
		// presets and plugins
	},{
		// modules and files whitelist
	})

	.configureFilenames({
		images: '[path][name].[hash:8].[ext]'
	})
;

// import webpack config
var config = Encore.getWebpackConfig();

// disable AMD loader
config.module.rules.unshift({
	parser: {
		amd: false,
	}
});

config.watchOptions = { poll: true, ignored: /node_modules/ };

module.exports = config;
