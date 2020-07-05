import { shape, string, number, bool, arrayOf } from 'prop-types';

const postShape = shape( {
	permalink: string,
} );

export const attributeShape = shape( {
	id: number.isRequired,
	name: string.isRequired,
	position: number.isRequired,
	visible: bool.isRequired,
	variation: bool.isRequired,
	options: arrayOf( string ).isRequired,
} );

export const arrayOfAttributes = arrayOf( attributeShape );

export default postShape;
