/**
 * A file upload component which tries to mimic the downloads uploader fields from WooCommerce.
 * It uses the react-dnd logic and it is composed from a <Fields /> component which holds the child components named
 * <Field/> that stores data for each download entry.
 */
import React, { Fragment, Component } from 'react';
import propTypes from 'prop-types';
import { DndProvider, useDrop } from 'react-dnd'
import HTML5Backend from 'react-dnd-html5-backend'
import Fields from './fields'

class FileUpload extends Component {

	render() {
		const { onChange, multiple, downloads, label } = this.props;
		return (
			<DndProvider backend={HTML5Backend}>
				<Fields value={downloads} onChange={onChange} multiple={multiple} label={label} />
			</DndProvider>
		)
	}
}

FileUpload.propTypes = {
	onChange: propTypes.func.isRequired,
	multiple: propTypes.bool,
	downloads: propTypes.array
};

FileUpload.defaultProps = {
	multiple: true,
};

export default FileUpload;
