import PropTypes from 'prop-types';
import classNames from 'classnames';

/**
 * WordPress dependencies
 */
const { SVG, Path, G } = wp.components;

const VendifyLogo = ( { width, height, className } ) => {
	const classes = classNames( 'vendify-logo', className );

	return <SVG width={width} height={height} className={classes}>
		<defs>
			<linearGradient x1="50%" y1="2.052%" x2="50%" y2="50.178%" id="a">
			<stop stopColor="#0062E0" offset="0%"/>
			<stop stopColor="#002ACF" offset="100%"/>
			</linearGradient><Path d="M6 9.895a3 3 0 1 1 0-6 3 3 0 0 1 0 6zm12 0a3 3 0 1 1 0-6 3 3 0 0 1 0 6z" id="c"/>
			<filter x="-38.9%" y="-83.3%" width="177.8%" height="333.3%" filterUnits="objectBoundingBox" id="b">
			<feOffset dy="2" in="SourceAlpha" result="shadowOffsetOuter1"/>
			<feGaussianBlur stdDeviation="2" in="shadowOffsetOuter1" result="shadowBlurOuter1"/>
			<feColorMatrix values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.169270833 0" in="shadowBlurOuter1"/>
			</filter>
		</defs>
		<G fill="none" fillRule="evenodd">
			<Path fill="url(#a)" d="M0 0h23.895L24 23.895H0z" transform="translate(1 .105)"/>
			<G transform="translate(1 .105)">
				<use fill="#000" filter="url(#b)"/>
				<use fill="#01068A"/>
			</G>
			<Path d="M7 7l2 5.5s1 3.5 4 3.5 4-3.5 4-3.5L19 7" stroke="#FFF" strokeWidth="2" strokeLinecap="round"/>
		</G>
	</SVG>;
}

VendifyLogo.propTypes = {
	width: PropTypes.string,
	height: PropTypes.string,
	className: PropTypes.string,
}

VendifyLogo.defaultProps = {
	width: '26',
	height: '24'
}

export default VendifyLogo;

