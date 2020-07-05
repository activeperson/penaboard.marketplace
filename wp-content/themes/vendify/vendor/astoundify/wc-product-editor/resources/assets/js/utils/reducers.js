const { isEmpty, omit } = _;

export const mergeState = ( state, { data }, key ) => {
	const items = data[ key ];
	if ( ! data || isEmpty( data ) ) {
		return state;
	}

	return Object.keys( items ).reduce(
		( nextState, id ) => {
			// eslint-disable-next-line
      nextState[id] = { ...items[id] };
			return nextState;
		},
		{ ...state }
	);
};

export const insertToState = ( state, id, data ) => ( {
	...state,
	[ id ]: data,
} );

export const removeFromState = ( state, id ) => {
	if ( state[ id ] ) {
		return omit( state, id );
	}
	return state;
};
