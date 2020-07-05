import React, { Fragment, useState, useCallback} from 'react'

/**
 * WordPress dependencies.
 */
const { __ } = wp.i18n;

import update from 'immutability-helper'
import Field from './field'

const Fields = ( props ) => {
	const { onChange } = props;
	const downloads = props.value;
	let [cards, setCards] = useState(downloads);

	/**
	 * A function that will update cards position on drag-and-drop action.
	 * @type {Function}
	 */
	const moveCard = useCallback( (dragIndex, hoverIndex, saveCards = false) => {

		if ( typeof dragIndex === "undefined" || hoverIndex === "undefined" ) {
			return null;
		}

		const dragCard = cards[dragIndex];
		const newCards = update(cards, {
			$splice: [[dragIndex, 1], [hoverIndex, 0, dragCard]],
		});

		setCards( newCards );

		if ( saveCards ) {
			onChange( newCards );
		}

	}, [cards],);

	/**
	 * A function that will be bound to the click event of the card list and it will create a new empty card field.
	 * @type {Function}
	 */
	const addCard = useCallback( ( event ) => {
		cards = update(cards, {
			$push: [{ id: '', name: '', file: '' }],
		});

		setCards( cards );

		event.target.parentElement.setAttribute( 'data-index', parseInt( event.target.parentElement.childElementCount ) );

		onChange( cards );

	}, [cards],);

	/**
	 * A function that will be bound on the click event of the remove button. Will remove the card based on its index.
	 * @type {Function}
	 */
	const removeCard = useCallback(( event ) => {
		event.preventDefault();

		const index = event.target.parentElement.getAttribute( 'data-index' );
		cards = update(cards, {$splice: [[ index, 1] ]});

		setCards(cards);

		onChange( cards );

	}, [cards],);

	/**
	 * This function will update field values for a specific field.
	 * @type {Function}
	 */
	const updateCard = useCallback(( event ) => {
		const parent = event.target.parentElement;
		const index = parent.getAttribute( 'data-index' );
		const id = parent.querySelector( '[name="attachment_id"]' ).value;
		const value = parent.querySelector( '[name="attachment_url"]' ).value;
		const title = parent.querySelector( '[name="attachment_name"]' ).value;
		const newVal = { id: id, name: title, file: value };

		cards = update(cards, {
			[index]: { $set: newVal },
		});

		setCards( cards );

		onChange( cards );

	}, [cards],);

	/**
	 * This is a try to implement to WordPress media uploader in front-end, in reactjs 8-)
	 * It will be found on the open-modal button and it will update the image URL on selection.
	 * @type {Function}
	 */
	let openModal = useCallback( ( event ) => {
		event.preventDefault();

		const parent = event.target.parentElement;
		let index = parent.getAttribute( 'data-index' );
		const id = parent.querySelector( '[name="attachment_id"]' ).value;
		let value = parent.querySelector( '[name="attachment_url"]' ).value;
		const title = parent.querySelector( '[name="attachment_name"]' ).value;

		// If the media frame already exists, reopen it.
		if ( window.downloadable_file_frame ) {
			window.downloadable_file_frame.open();
			return;
		}

		let downloadable_file_states = [
			// Main states.
			new wp.media.controller.Library({
				library:   wp.media.query(),
				multiple:  true,
				title:     __( 'Choose' ),
				priority:  20,
				filterable: __( 'uploaded' )
			})
		];

		// Create the media frame.
		window.downloadable_file_frame = wp.media.frames.downloadable_file = wp.media({
			// Set the title of the modal.
			title: __( 'Choose' ),
			library: {
				type: ''
			},
			button: {
				text: __( 'Choose' )
			},
			multiple: true,
			states: downloadable_file_states
		});

		// When an image is selected, run a callback.
		window.downloadable_file_frame.on( 'select', ( what ) => {
			let selection = window.downloadable_file_frame.state().get( 'selection' );

			selection.map( function( attachment ) {
				attachment = attachment.toJSON();
				if ( attachment.url ) {
					value = attachment.url;

					const filename = value.substring(value.lastIndexOf('/')+1);
					const newVal = { id: id, name: filename, file: value };

					let newCards = update(cards, {
						[index]: { $set: newVal },
					});

					setCards( newCards );

					// Make sure this model is not cached, otherwise we'll assign attachments on the wrong position.
					delete window.downloadable_file_frame;
				}
			});
		});

		// Set post to 0 and set our custom type.
		window.downloadable_file_frame.on( 'ready', function() {
			window.downloadable_file_frame.uploader.options.uploader.params = {
				type: 'downloadable_product'
			};
		});

		// Finally, open the modal.
		window.downloadable_file_frame.open();
	}, [cards],);

	const renderCard = (props, index) => {
		if ( typeof props === "undefined" ) {
			return null;
		}

		const {name, id, file} = props;

		return <Field
			title={name}
			id={id}
			value={file}
			moveCard={moveCard}
			removeCard={removeCard}
			updateCard={updateCard}
			openModal={openModal}
			index={index}
			key={ Math.random().toString(26).slice(2) + '_' + index }
		/>;
	};

	return (
		<div className="astoundify-wc-re-downloads_fields">
			{cards.map((card, i) => renderCard(card, i))}

			<button className="astoundify-wc-re-add_download btn-secondary" onClick={ addCard }>{ __( 'Add file' ) }</button>
		</div>
	);
};

export default Fields
