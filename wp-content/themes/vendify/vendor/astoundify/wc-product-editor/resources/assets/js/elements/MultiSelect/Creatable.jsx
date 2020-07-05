/**
 * External dependencies.
 */
import React from 'react';
import propTypes from 'prop-types';
import Downshift from 'downshift';

/**
 * Internal dependencies.
 */
import Multiselect from './index';

class Createable extends Multiselect {
  static defaultProps = {
  	placeholder: '',
  	labelKey: 'label',
  	valueKey: 'value',
  };

  state = {
  	selectedItems: this.props.options,
  };

  render() {
  	const { name, label, placeholder } = this.props;

		return (
			<Downshift>
				{ ( { getInputProps, inputValue, clearSelection } ) => (
					<div className="form-group">
						<label className="label" htmlFor={ name }>
							{ label }
						</label>

						{ this.renderTags() }

						<input
							{ ...getInputProps( {
								name,
							} ) }
							className="form-control"
							placeholder={ placeholder }
						/>
						<button
							className="form-control__add-tag"
							onClick={ () => this.addItem( inputValue, clearSelection ) }
						>
							+
						</button>
					</div>
				) }
			</Downshift>
		);
  }
}

export default Createable;
