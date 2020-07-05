import axios from 'axios';

const apiRequest = async ( url, method = 'GET', body = null, headers = {} ) => {
	const { apiRoot, nonce } = window.astoundifyWrp;
	const params = {
		method,
		url: `${ apiRoot }${ url }`,
		headers: {
			...headers,
			'X-WP-Nonce': nonce,
		},
	};
	if ( body ) {
		params.data = body;
	}
	try {
		const { data } = await axios( params );
		return data;
	} catch ( error ) {
		throw new Error( error );
	}
};

export default apiRequest;
