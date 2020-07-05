import { shape, arrayOf, string, number } from 'prop-types';

export const categoryShape = shape( {
	id: number.isRequired,
	name: string.isRequired,
	slug: string.isRequired,
	parent: number.isRequired,
	count: number.isRequired,
} );

export const arrayOfCategories = arrayOf( categoryShape );
