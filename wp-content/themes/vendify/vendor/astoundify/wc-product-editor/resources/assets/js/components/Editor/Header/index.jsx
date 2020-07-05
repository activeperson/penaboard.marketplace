import React from 'react';
import propTypes from 'prop-types';
import { NavLink } from 'react-router-dom';

const CloseSVG = () => (
	<svg width="17px" height="20px" viewBox="0 0 17 20">
		<g id="Page-1" stroke="none" strokeWidth="1" fill="none" fillRule="evenodd">
			<g
				id="Event-Editor-#10"
				transform="translate(-451.000000, -105.000000)"
				fill="#D3D3D3"
				fillRule="nonzero"
			>
				<g id="Sidebar-Menus" transform="translate(100.000000, 80.000000)">
					<g id="Profile">
						<g id="Header">
							<g
								id="Icon/20px/Normal/Minimize"
								transform="translate(350.000000, 25.000000)"
							>
								<path
									d="M3,0 L16,0 C17.1045695,-2.02906125e-16 18,0.8954305 18,2 L18,18 C18,19.1045695 17.1045695,20 16,20 L3,20 C1.8954305,20 1,19.1045695 1,18 L1,2 C1,0.8954305 1.8954305,2.02906125e-16 3,0 Z M3,2 L3,18 L16,18 L16,2 L3,2 Z M3,2 L10,2 L10,18 L3,18 L3,2 Z M7.52424598,11.9636548 L5.56072765,10.0444307 L7.53621177,8.02438244 C7.82582019,7.72824086 7.82052402,7.25339666 7.52438244,6.96378823 C7.22824086,6.67417981 6.75339666,6.67947598 6.46378823,6.97561756 L3.43927235,10.0683623 L6.47575402,13.0363452 C6.77196928,13.3258782 7.24681211,13.3204612 7.53634518,13.024246 C7.82587824,12.7280307 7.82046125,12.2531879 7.52424598,11.9636548 Z"
									id="Icon"
								/>
							</g>
						</g>
					</g>
				</g>
			</g>
		</g>
	</svg>
);
const Header = ( { title } ) => (
	<header className="astoundify-wc-re-header">
		<h4>{ title }</h4>
		<NavLink to="/">
			<CloseSVG />
		</NavLink>
	</header>
);

Header.propTypes = {
	title: propTypes.string.isRequired,
};

export default Header;
