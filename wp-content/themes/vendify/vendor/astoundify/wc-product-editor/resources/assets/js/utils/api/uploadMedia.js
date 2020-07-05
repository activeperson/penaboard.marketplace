import apiRequest from './apiRequest';

const uploadMedia = async ( { file } ) => {
	const { type, name } = file;
	const headers = {
		'Content-Type': type,
		'Content-Disposition': `attachment; filename="${ name }"`,
	};
	const formData = new FormData();
	formData.append( 'file', file );
	const data = await apiRequest( 'wp/v2/media', 'POST', formData, headers );
	return data;
};

export default uploadMedia;
