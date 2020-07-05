import { shape, string, number, arrayOf, bool, objectOf } from 'prop-types';

export const variationShape = shape( {
	id: number.isRequired,
	description: string.isRequired,
	sku: string.isRequired,
	price: string.isRequired,
	regular_price: string.isRequired,
	sale_price: string.isRequired,
	visible: bool.isRequired,
	purchasable: bool.isRequired,
	virtual: bool.isRequired,
	weight: string.isRequired,
	dimensions: shape( {
		length: string.isRequired,
		width: string.isRequired,
		height: string.isRequired,
	} ),
	shipping_class: string.isRequired,
	shipping_class_id: number.isRequired,
	image: shape( {
		id: number.isRequired,
		date_created: string.isRequired,
		src: string.isRequired,
		name: string.isRequired,
		alt: string.isRequired,
		position: number.isRequired,
	} ),
	attributes: arrayOf(
		shape( {
			id: number.isRequired,
			name: string.isRequired,
			option: string.isRequired,
		} )
	),
} );

export const arrayOfVariations = arrayOf( variationShape );

export default variationShape;
