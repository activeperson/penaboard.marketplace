
  
/**
 * WordPress dependencies.
 */
const { getCategories, setCategories } = wp.blocks;

/**
 * Internal dependencies.
 */
import VendifyLogo from '../components/vendify-logo';

setCategories( [
	// Add a Vendify block category.
	{
		slug: 'vendify',
		title: 'Vendify',
		icon: <VendifyLogo />,
	},
	...getCategories().filter( ( { slug } ) => slug !== 'vendify' ),
] );