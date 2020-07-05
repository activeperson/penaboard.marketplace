import React from 'react';

const TrashIcon = () => (
	<svg
		width="24px"
		height="27px"
		viewBox="0 0 24 27"
		version="1.1"
		xmlns="http://www.w3.org/2000/svg"
	>
		<defs>
			<path
				d="M56.5294118,6.70588235 L56.5294118,6 L61.4705882,6 L61.4705882,6.70588235 L65,6.70588235 L65,8.82352941 L53,8.82352941 L53,6.70588235 L56.5294118,6.70588235 Z M53.7058824,9.52941176 L64.2941176,9.52941176 L64.2941176,20.8235294 L53.7058824,20.8235294 L53.7058824,9.52941176 Z"
				id="path-1"
			/>
			<filter
				x="-79.2%"
				y="-50.6%"
				width="258.3%"
				height="228.2%"
				filterUnits="objectBoundingBox"
				id="filter-2"
			>
				<feMorphology
					radius="1"
					operator="dilate"
					in="SourceAlpha"
					result="shadowSpreadOuter1"
				/>
				<feOffset
					dx="0"
					dy="2"
					in="shadowSpreadOuter1"
					result="shadowOffsetOuter1"
				/>
				<feGaussianBlur
					stdDeviation="2.5"
					in="shadowOffsetOuter1"
					result="shadowBlurOuter1"
				/>
				<feComposite
					in="shadowBlurOuter1"
					in2="SourceAlpha"
					operator="out"
					result="shadowBlurOuter1"
				/>
				<feColorMatrix
					values="0 0 0 0 0   0 0 0 0 0   0 0 0 0 0  0 0 0 0.0946841033 0"
					type="matrix"
					in="shadowBlurOuter1"
				/>
			</filter>
		</defs>
		<g id="Page-1" stroke="none" strokeWidth="1" fill="none" fillRule="evenodd">
			<g id="Event-Editor-#10" transform="translate(-178.000000, -755.000000)">
				<g id="Sidebar-Menus" transform="translate(100.000000, 80.000000)">
					<g id="Media">
						<g
							id="Uploader-Gallery"
							transform="translate(30.000000, 405.000000)"
						>
							<g id="Group-9-Copy" transform="translate(1.000000, 268.000000)">
								<g id="Delete-(icon)">
									<use
										fill="black"
										fillOpacity="1"
										filter="url(#filter-2)"
										xlinkHref="#path-1"
									/>
									<use
										fillOpacity="0.784222147"
										fill="#FFFFFF"
										fillRule="evenodd"
										xlinkHref="#path-1"
									/>
									<path
										strokeOpacity="0.110563859"
										stroke="#000000"
										strokeWidth="1"
										d="M56.0294118,6.20588235 L56.0294118,5.5 L61.9705882,5.5 L61.9705882,6.20588235 L65.5,6.20588235 L65.5,9.32352941 L52.5,9.32352941 L52.5,6.20588235 L56.0294118,6.20588235 Z M53.2058824,9.02941176 L64.7941176,9.02941176 L64.7941176,21.3235294 L53.2058824,21.3235294 L53.2058824,9.02941176 Z"
									/>
								</g>
							</g>
						</g>
					</g>
				</g>
			</g>
		</g>
	</svg>
);

export default TrashIcon;
