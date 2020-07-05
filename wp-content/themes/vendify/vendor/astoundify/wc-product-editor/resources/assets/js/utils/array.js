/**
 * Utility to move an item in an array without mutating it.
 * @param {Array} items Original array
 * @param {number} index Item to move
 * @param {number} destination Where it goes
 */
export const move = ( items, index, destination ) => {
	const newArr = [ ...items ];
	newArr.splice( destination, 0, newArr.splice( index, 1 )[ 0 ] );
	return newArr;
};

/**
 * Utility to replace an item in an array without mutating it.
 * @param {Array} items Original array
 * @param {number} indexToReplace Index of item to replace
 * @param {Any} newItem Item to insert
 */
export const replace = ( items, indexToReplace, newItem ) => {
	const newArr = [ ...items ];
	newArr.splice( indexToReplace, 1, newItem );
	return newArr;
};

/**
 * Utility to remove an item from an array without mutating it.
 * @param {Array} items Original array
 * @param {number} indexToRemove Index of item to remove
 */
export const remove = ( items, indexToRemove ) => {
	const newArr = [ ...items ];
	newArr.splice( indexToRemove, 1 );
	return newArr;
};

/**
 * Utility to insert an item into an array without mutating it.
 * @param {Array} items Original array
 * @param {number} indexToInsert Index of where to put newItem
 * @param {Any} newItem Item to insert
 */
export const insert = ( items, indexToInsert, newItem ) => {
	const newArr = [ ...items ];
	newArr.splice( indexToInsert, 0, newItem );
	return newArr;
};
