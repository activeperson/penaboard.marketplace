/* global woocommerce_admin_meta_boxes */
import axios from 'axios';

export const arrayToParams = ( array ) => {
	let string = '';
	array.forEach( ( element ) => {
		Object.keys( element ).forEach( ( key ) => {
			if ( string !== '' ) {
				string += '&';
			}
			string += `${ key }=${ encodeURIComponent( element[ key ] ) }`;
		} );
	} );
	return string;
};

export const updateAttributes = async ( attributes, postId, type ) => {
	const {
		ajax_url: url,
		save_attributes_nonce: security,
	} = woocommerce_admin_meta_boxes; // eslint-disable-line camelcase

	const attributeData = arrayToParams( attributes );
	const otherParams = arrayToParams( [
		{ post_id: postId },
		{ product_type: type },
		{ data: attributeData },
		{ action: 'woocommerce_save_attributes' },
		{ security },
	] );
	const params = {
		method: 'POST',
		url,
		data: otherParams,
		headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
	};
	try {
		const { data } = await axios( params );
		return data;
	} catch ( error ) {
		throw new Error( error );
	}
};

export default updateAttributes;
