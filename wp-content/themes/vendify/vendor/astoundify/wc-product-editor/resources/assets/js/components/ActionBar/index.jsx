import React from 'react';
import propTypes from 'prop-types';
import { formatRelative, parseISO } from 'date-fns';

import postShape from 'shapes/post';
import Button from 'elements/Button';

/**
 * WordPress dependencies.
 */
const { __ } = wp.i18n;

const ActionsBar = ( { publishPost, post } ) => (
	<div className="astoundify-wc-re-action-bar">
		<a
			className="astoundify-wc-re-action-bar__back"
			href={ astoundifyWrp.productsUrl }
		>
			{ __( 'Back to My Products' ) }
		</a>

		{ post && post.date_modified && (
			<div className="astoundify-wc-re-action-bar__info">
				<span className="astoundify-wc-re-action-bar__info--label">
					{ __( 'Last Save' ) }
				</span>
				<span className="astoundify-wc-re-action-bar__info--date">
					{ formatRelative( parseISO(post.date_modified), new Date() ) }
				</span>
			</div>
		) }

		<div className="astoundify-wc-re-action-bar__actions">
			<Button success onClick={ publishPost }>
				{ 'draft' === post.status ? __( 'Publish' ) : __( 'Update' ) }
			</Button>
		</div>
	</div>
);

ActionsBar.propTypes = {
	publishPost: propTypes.func.isRequired,
	post: postShape.isRequired,
};

export default ActionsBar;
