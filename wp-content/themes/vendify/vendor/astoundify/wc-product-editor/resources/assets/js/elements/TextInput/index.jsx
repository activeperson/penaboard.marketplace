/**
 * External dependencies.
 */
import React, { Fragment } from 'react';
import propTypes from 'prop-types';
import ReactTooltip from 'react-tooltip';

/**
 * Internal dependencies.
 */
import InputField from './InputField';

const TextInput = ( props ) => {
	const { label, id, labeled, hint, tooltip } = props;

	return (
		<div className="form-group">
			{ label && (
				<label className="label" htmlFor={ id }>
					<span>{ label }</span>

					{ tooltip && '' !== tooltip && (
						<Fragment>
							<button className="astoundify-wc-re-tooltip-toggle" data-tip={ tooltip }>
								?
							</button>

							<ReactTooltip
								effect="solid"
								place="bottom"
							/>
						</Fragment>
					) }
				</label>
			) }

			{ labeled ? (
				<div className="">
					<InputField { ...props } />
				</div>
			) : (
				<InputField { ...props } />
			) }

			{ hint && <div className="astoundify-wc-re-form-hint">{ hint }</div> }
		</div>
	);
};

TextInput.propTypes = {
	label: propTypes.string.isRequired,
	id: propTypes.string.isRequired,
	labeled: propTypes.bool,
	hint: propTypes.string,
	tooltip: propTypes.string,
};

TextInput.defaultProps = {
	labeled: false,
	hint: '',
	tooltip: '',
};

export default TextInput;
