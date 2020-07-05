import React from 'react';

const MediaIcon = () => (
	<svg width="26" height="26" xmlns="http://www.w3.org/2000/svg">
		<g fill="none" fillRule="evenodd">
			<rect
				stroke="#FFF"
				strokeWidth="2"
				x="1"
				y="1"
				width="24"
				height="24"
				rx="2"
			/>
			<path fill="#000" d="M6 0h14v26H6z" />
			<path fill="#000" d="M0 6h26v14H0z" />
			<path
				fill="#FFF"
				d="M9 0h8v2H9zM9 24h8v2H9zM24 9h2v8h-2zM15.5 13l-1.291 6.097c-.116.544-.653.985-1.209.985-.552 0-1.094-.443-1.209-.985L10.5 13H7l5.323-5.767a.908.908 0 0 1 1.354 0L19 13h-3.5zM0 9h2v8H0z"
			/>
		</g>
	</svg>
);

export default MediaIcon;
