import React, {Fragment, useRef} from 'react'
import propTypes from 'prop-types';
import TrashIcon from 'icons/trash';
import { useDrag, useDrop } from 'react-dnd'

/**
 * WordPress dependencies.
 */
const { __ } = wp.i18n;

const ItemTypes = { CARD: 'card' };

const Field = ( props ) => {

	const { index, title, id, value, moveCard, removeCard, updateCard, openModal } = props;

	const ref = useRef(null);

	const [, drop] = useDrop({
		accept: ItemTypes.CARD,
		hover(item, monitor) {
			if (!ref.current) {
				return
			}

			const dragIndex = item.index;
			const hoverIndex = index;

			// Don't replace items with themselves
			if (dragIndex === hoverIndex) {
				return
			}

			// Determine rectangle on screen
			const hoverBoundingRect = ref.current.getBoundingClientRect();

			// Get vertical middle
			const hoverMiddleY = (hoverBoundingRect.bottom - hoverBoundingRect.top) / 2;

			// Determine mouse position
			const clientOffset = monitor.getClientOffset();

			// Get pixels to the top
			const hoverClientY = clientOffset.y - hoverBoundingRect.top;

			// Only perform the move when the mouse has crossed half of the items height
			// When dragging downwards, only move when the cursor is below 50%
			// When dragging upwards, only move when the cursor is above 50%

			// Dragging downwards
			if (dragIndex < hoverIndex && hoverClientY < hoverMiddleY) {
				return
			}

			// Dragging upwards
			if (dragIndex > hoverIndex && hoverClientY > hoverMiddleY) {
				return
			}

			// Time to actually perform the action
			moveCard(dragIndex, hoverIndex);

			// Note: we're mutating the monitor item here!
			// Generally it's better to avoid mutations,
			// but it's good here for the sake of performance
			// to avoid expensive index searches.
			item.index = hoverIndex
		},

		drop(item, monitor){
			const dragIndex = item.index;
			const hoverIndex = index;

			// save the new cards list
			moveCard(dragIndex, hoverIndex, true);
		}
	});

	const [{isDragging}, drag] = useDrag({
		item: { type: ItemTypes.CARD },
		collect: monitor => ({
			isDragging: !!monitor.isDragging(),
		}),
	});

	drag(drop(ref));

	return (
		<div
			className="downloads_field"
			ref={ref}
			style={{
				opacity: isDragging ? 0.5 : 1,
			}}
		>
			<fieldset data-index={index} >
				<img
					src={ `${ astoundifyWrp.pluginUrl }/public/images/upload-media.png` }
					onClick={openModal}
					width="25px"
				/>

				<input className="form-control" type="text" name="attachment_name" placeholder={ __( 'Name' ) } value={title} onChange={updateCard} />
				<input className="form-control" type="text" name="attachment_url" value={value} placeholder={ __( 'URL' ) } onChange={updateCard} />
				<input type="hidden" name="attachment_id" value={id} onChange={updateCard} />

				<button className="astoundify-wc-re-remove_download" onClick={removeCard}>
					<TrashIcon />
				</button>

			</fieldset>
		</div>
	)
};

Field.propTypes = {
	title: propTypes.string.isRequired,
	value: propTypes.string,
	moveCard: propTypes.func,
	removeCard: propTypes.func
};

export default Field
