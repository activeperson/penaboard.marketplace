var gulp            = require( 'gulp' );
var template        = require( 'gulp-template' );
var fs              = require( 'fs' );
var concat          = require( 'gulp-concat' );
var pump            = require( 'pump' );
var pkg             = JSON.parse( fs.readFileSync( './package.json' ) );

var cleanCss        = require( 'gulp-clean-css' );
var scsslint        = require( 'gulp-csslint' );

var wpPot           = require( 'gulp-wp-pot' );
var checktextdomain = require( 'gulp-checktextdomain' );

var zip             = require( 'gulp-zip' );
var clean           = require( 'gulp-clean' );

var uglify          = require( 'gulp-uglify' );
var jshint          = require( 'gulp-jshint' );

var sourcemaps      = require( 'gulp-sourcemaps' );

var watch           = require( 'gulp-watch' );

var phpcs           = require( 'gulp-phpcs' );

/**
 * JS Hint
 * 
 * @since 1.0.0
 */
gulp.task( 'js:hint', function( cb ) {
	pump( [
		gulp.src( [
			'resources/assets/**/*.js',
		]),
		jshint( '.jshintrc' ),
		jshint.reporter( 'default' ),
		jshint.reporter( 'fail' )
	], cb );
} );

/**
 * JS Minify
 * 
 * @since 1.0.0
 */
gulp.task( 'js:minify', function() {

	// Events: Product Data (Admin).
	gulp.src( [
		'resources/assets/js/product-data.js',
		'resources/assets/js/product-data-attendees.js',
		'resources/assets/js/product-data-lineup.js',
		'resources/assets/js/product-data-sponsors.js',
		'resources/assets/js/product-data-schedule.js',
		'resources/assets/js/product-data-location.js',
	] )
		.pipe( sourcemaps.init() )
		.pipe( concat( 'product-data.min.js' ) )
		.pipe( uglify() )
		.pipe( sourcemaps.mapSources( function( sourcePath, file ) {
			return 'public/assets/js/' + sourcePath;
		}))
		.pipe( sourcemaps.write( './' ) )
		.pipe( gulp.dest( 'public/assets/js' ) );

	// Events: Filters.
	gulp.src( 'resources/assets/js/events-filters.js' )
		.pipe( sourcemaps.init() )
		.pipe( concat( 'events-filters.min.js' ) )
		.pipe( uglify() )
		.pipe( sourcemaps.mapSources( function( sourcePath, file ) {
			return 'public/assets/js/' + sourcePath;
		}))
		.pipe( sourcemaps.write( './' ) )
		.pipe( gulp.dest( 'public/assets/js' ) );

	// Vendors: Dashboard.
	gulp.src( 'resources/assets/js/vendor-dashboard.js' )
		.pipe( sourcemaps.init() )
		.pipe( concat( 'vendor-dashboard.min.js' ) )
		.pipe( uglify() )
		.pipe( sourcemaps.mapSources( function( sourcePath, file ) {
			return 'public/assets/js/' + sourcePath;
		}))
		.pipe( sourcemaps.write( './' ) )
		.pipe( gulp.dest( 'public/assets/js' ) );

	// Vendors: Dashboard Overview.
	gulp.src( 'resources/assets/js/vendor-dashboard-overview.js' )
		.pipe( sourcemaps.init() )
		.pipe( concat( 'vendor-dashboard-overview.min.js' ) )
		.pipe( uglify() )
		.pipe( sourcemaps.mapSources( function( sourcePath, file ) {
			return 'public/assets/js/' + sourcePath;
		}))
		.pipe( sourcemaps.write( './' ) )
		.pipe( gulp.dest( 'public/assets/js' ) );

	// Vendors: Dashboard Report By Date.
	gulp.src( 'resources/assets/js/vendor-dashboard-report-by-date.js' )
		.pipe( sourcemaps.init() )
		.pipe( concat( 'vendor-dashboard-report-by-date.min.js' ) )
		.pipe( uglify() )
		.pipe( sourcemaps.mapSources( function( sourcePath, file ) {
			return 'public/assets/js/' + sourcePath;
		}))
		.pipe( sourcemaps.write( './' ) )
		.pipe( gulp.dest( 'public/assets/js' ) );
} );

/**
 * CSS Lint
 *
 * @since 1.0.0
 */
gulp.task( 'css:lint', function( cb ) {
	pump( [
		gulp.src( [
			'resources/assets/css/*.css',
			'resources/assets/css/**/*.css'
		] ),
		scsslint( {
			'maxBuffer': 10007200,
			'reporterOutputFormat': 'Stats'
		} )
	], cb );
} );

/**
 * CSS Minify
 * 
 * @since 1.0.0
 */
gulp.task( 'css:minify', function() {

	// Events: Product Data (Admin).
	gulp.src( 'resources/assets/css/product-data.css' )
		.pipe( sourcemaps.init() )
		.pipe( concat( 'product-data.min.css' ) )
		.pipe( cleanCss() )
		.pipe( sourcemaps.mapSources( function( sourcePath, file ) {
			return 'resources/assets/css/' + sourcePath;
		}))
		.pipe( sourcemaps.write( './' ) )
		.pipe( gulp.dest( 'public/assets/css' ) );

	// Events: Filters.
	gulp.src( [
			'resources/assets/css/datepicker.css',
			'resources/assets/css/events-filters.css',
		] )
		.pipe( sourcemaps.init() )
		.pipe( concat( 'events-filters.min.css' ) )
		.pipe( cleanCss() )
		.pipe( sourcemaps.mapSources( function( sourcePath, file ) {
			return 'resources/assets/css/' + sourcePath;
		}))
		.pipe( sourcemaps.write( './' ) )
		.pipe( gulp.dest( 'public/assets/css' ) );

	// Vendors: Dashboard.
	gulp.src( [
			'resources/assets/css/datepicker.css',
			'resources/assets/css/vendor-dashboard.css',
		] )
		.pipe( sourcemaps.init() )
		.pipe( concat( 'vendor-dashboard.min.css' ) )
		.pipe( cleanCss() )
		.pipe( sourcemaps.mapSources( function( sourcePath, file ) {
			return 'resources/assets/css/' + sourcePath;
		}))
		.pipe( sourcemaps.write( './' ) )
		.pipe( gulp.dest( 'public/assets/css' ) );

} );

/* Minify */
gulp.task( 'minify', [ 'css:minify', 'js:minify'] );

/** Assets */
gulp.task( 'assets', [ 'minify' ] );

/**
 * Watch
 * 
 * @since 1.0.0
 */
gulp.task( 'watch', function () {
	gulp.watch( 'resources/assets/css/*.css', [ 'css:minify' ] );
	gulp.watch( 'resources/assets/js/*.js', [ 'js:minify' ] );
});

/**
 * Check Textdomain
 * 
 * @since 1.0.0
 */
gulp.task( 'checktextdomain', function() {
	gulp.src( [ 
		'*.php', 
		'app/**/**.php', 
		'resources/**/**.php'
	] )
		.pipe( checktextdomain( {
			text_domain: 'astoundify-wc-themes',
			correct_domain: true,
			force: true,
			keywords: [
				'__:1,2d',
				'_e:1,2d',
				'_x:1,2c,3d',
				'esc_html__:1,2d',
				'esc_html_e:1,2d',
				'esc_html_x:1,2c,3d',
				'esc_attr__:1,2d',
				'esc_attr_e:1,2d',
				'esc_attr_x:1,2c,3d',
				'_ex:1,2c,3d',
				'_n:1,2,4d',
				'_nx:1,2,4c,5d',
				'_n_noop:1,2,3d',
				'_nx_noop:1,2,3c,4d'
			],
		} ) );
} );

/**
 * Make POT
 * 
 * @since 1.0.0
 */
gulp.task( 'makepot', function() {
	gulp.src( [ 
		'*.php', 
		'app/**/**.php', 
		'resources/**/**.php'
	] )
		.pipe( wpPot( {
			domain: 'astoundify-wc-themes',
		} ))
		.pipe( gulp.dest( 'resources/languages/astoundify-wc-themes.pot' ) );
} );

/* i18n */
gulp.task( 'i18n', [ 'checktextdomain', 'makepot' ] );

/**
 * PHP Code Sniffer
 *
 * @since 1.0.0
 */
gulp.task( 'php', function() {
	gulp.src( [
		'app/*.php',
		'app/**/*.php',
		'bootstrap/*.php',
		'resources/*.php',
		'resources/**.php'
	] )
		.pipe( phpcs({
			'standard': './phpcs.ruleset.xml'
		}) )
		.pipe( phpcs.reporter( 'log' ) )
} );

/**
 * Clean build files.
 *
 * @since 1.0.0
 */
gulp.task( 'clean', function() {
	gulp.src( [ './astoundify-wc-themes' ], {
		read: false
	} )
		.pipe( clean() );
} );

/**
 * Move distribution files to a /dist directory.
 *
 * @since 1.0.0
 */
gulp.task( 'bundle', [ 'clean', 'assets', 'makepot' ], function( cb ) {
	gulp.src( [
		'astoundify-wc-themes.php',
		'app/*',
		'app/**',
		'bootstrap/*',
		'resources/*',
		'resources/**',
		'public/*',
		'public/**',
		'vendor/autoload.php',
		'vendor/composer/*',
		'vendor/composer/**',
		'vendor/astoundify/*',
		'vendor/astoundify/**',
		'LICENSE',
		'readme.txt'
	], {
		base: './'
	} )
		.pipe( gulp.dest( 'astoundify-wc-themes' ) );

	cb();
} );

/**
 * ZIP
 *
 * @since 1.0.0
 */
gulp.task( 'zip', function() {
	gulp.src( [ 'astoundify-wc-themes/**' ], {
		base: './'
 	} )
		.pipe( zip( 'astoundify-wc-themes-' + pkg.version + '.zip' ) )
		.pipe( gulp.dest( '' ) );
} );
