export const transformAttributes = ( attributes ) =>
	attributes.map( ( { name, options, position }, index ) => ( {
		[ encodeURIComponent( `attribute_names[${ position }]` ) ]: name,
		[ encodeURIComponent( `attribute_position[${ position }]` ) ]: index,
		[ encodeURIComponent( `attribute_values[${ position }]` ) ]: options.join( '|' ),
		[ encodeURIComponent( `attribute_variation[${ position }]` ) ]: true,
		[ encodeURIComponent( `attribute_visibility[${ position }]` ) ]: true,
	} ) );

export const eslint = () => null;
