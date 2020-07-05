var gulp            = require( 'gulp' );
var fs              = require( 'fs' );
var concat          = require( 'gulp-concat' );
var pump            = require( 'pump' );
var pkg             = JSON.parse( fs.readFileSync( './package.json' ) );

var wpPot           = require( 'gulp-wp-pot' );
var checktextdomain = require( 'gulp-checktextdomain' );

var zip             = require( 'gulp-zip' );
var clean           = require( 'gulp-clean' );

var scsslint        = require( 'gulp-csslint' );
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
			'app/assets/**/*.js',
		]),
		jshint( '.jshintrc' ),
		jshint.reporter( 'default' ),
		jshint.reporter( 'fail' )
	], cb );
} );

/**
 * CSS Lint
 *
 * @since 1.0.0
 */
gulp.task( 'css:lint', function( cb ) {
	pump( [
		gulp.src( [
			'app/assets/css/*.css',
			'app/assets/css/**/*.css'
		] ),
		scsslint( {
			'maxBuffer': 10007200,
			'reporterOutputFormat': 'Stats'
		} )
	], cb );
} );

/**
 * PHP Code Sniffer
 *
 * @since 1.0.0
 */
gulp.task( 'php', function() {
	gulp.src( [
		'app/*.php',
		'app/**/*.php',
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
	gulp.src( [ './astoundify-themecustomizer' ], {
		read: false
	} )
		.pipe( clean() );
} );

/**
 * Move distribution files to a /dist directory.
 *
 * @since 1.0.0
 */
gulp.task( 'bundle', [ 'clean' ], function( cb ) {
	gulp.src( [
		'astoundify-themecustomizer.php',
		'app/*',
		'app/**',
		'vendor/*',
		'vendor/**',
		'!vendor/composer',
		'!vendor/composer/*',
		'!vendor/autoload.php',
		'LICENSE',
	], {
		base: './'
	} )
		.pipe( gulp.dest( 'astoundify-themecustomizer' ) );

	cb();
} );

/**
 * ZIP
 *
 * @since 1.0.0
 */
gulp.task( 'zip', function() {
	gulp.src( [ 'astoundify-themecustomizer/**' ], {
		base: './'
 	} )
		.pipe( zip( 'astoundify-themecustomizer-' + pkg.version + '.zip' ) )
		.pipe( gulp.dest( '' ) );
} );