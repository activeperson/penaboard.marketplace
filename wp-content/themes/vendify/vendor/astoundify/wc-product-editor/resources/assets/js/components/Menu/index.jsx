import React from 'react';
import postShape from 'shapes/post';
import { insert } from 'utils/array';

// @todo Create an <Icon> component.
import DetailsIcon from 'icons/details';
import MediaIcon from 'icons/media';
import StockIcon from 'icons/inventory';
import RelatedIcon from 'icons/related';
import AttributesIcon from 'icons/attributes';
import VariationsIcon from 'icons/variations';
import ShippingIcon from 'icons/shipping';

import MenuItem from './Item';

const Menu = ( { post } ) => {
	let items = [
		{ label: 'Details', id: 'details', Icon: DetailsIcon },
		{ label: 'Media', id: 'media', Icon: MediaIcon },
		{ label: 'Inventory', id: 'stock', Icon: StockIcon },
		{ label: 'Related', id: 'related', Icon: RelatedIcon },
	];
	if ( post.type === 'variable' ) {
		items = [
			...items,
			{ label: 'Attributes', id: 'attributes', Icon: AttributesIcon },
			{ label: 'Variations', id: 'variations', Icon: VariationsIcon },
		];
	}
	if ( ! post.virtual ) {
		items = insert( items, 3, {
			label: 'Shipping',
			id: 'shipping',
			Icon: ShippingIcon,
		} );
	}
	return (
		<nav className="astoundify-wc-re-editor-menu">
			{ items.map( ( itemProps ) => <MenuItem key={ itemProps.id } { ...itemProps } /> ) }
		</nav>
	);
};

Menu.propTypes = {
	post: postShape.isRequired,
};

export default Menu;
