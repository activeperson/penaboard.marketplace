/**
 * Update an object's key that exists in an array of objects.
 *
 * @since 1.0.0
 *
 * @param {object}
 * @param {number}
 * @param {object}
 */
export const updateDeep = ( object, index, update ) => {
	return [
		...object.slice( 0, index ),
		{
			...object[ index ],
			...update,
		},
		...object.slice( index + 1 ),
	];
};

/**
 * Create a class based on dim ratio.
 *
 * @param {number} ratio Dim ratio.
 * @return {string} Class HTML list.
 */
export const dimRatioToClass = function( ratio ) {
	return `has-background-dim has-background-dim-${ ratio }`;
};

/**
 * Create a class based on background image.
 *
 * @param {string} url Image URL.
 * @return {Object} Image styles.
 */
export const backgroundImageStyles = function( url ) {
	return url ?
		{ backgroundImage: `url(${ url })` } :
		undefined;
};
