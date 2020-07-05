import React from 'react';
import propTypes from 'prop-types';
import Downshift from 'downshift';
import LoadingOverlay from 'components/LoadingOverlay/Element';

/**
 * WordPress dependencies.
 */
const { __ } = wp.i18n;

class SingleSelect extends React.Component {
  static propTypes = {
  	value: propTypes.oneOfType( [ propTypes.string, propTypes.bool ] ).isRequired,
  	id: propTypes.string.isRequired,
  	options: propTypes.arrayOf( propTypes.shape() ).isRequired,
  	onChange: propTypes.func.isRequired,
  	label: propTypes.string.isRequired,
  	labelKey: propTypes.string,
  	valueKey: propTypes.string,
  	loading: propTypes.bool,
  };

  static defaultProps = {
  	labelKey: 'label',
  	valueKey: 'value',
  	loading: false,
  };

  handleSave = ( value ) => {
  	const { id } = this.props;
  	const event = {
  		target: {
  			value,
  			name: id,
  			type: 'customSelect',
  		},
  	};
  	this.props.onChange( event );
  };

	showSelectedItem = ( selectedItem ) => {
		const { options, labelKey, valueKey } = this.props;
		if ( options.length === 0 ) {
			return __( 'No items available.' );
		}
		const selectedOption = options.find(
			( option ) => option[ valueKey ] === selectedItem
		);
		return selectedOption ? selectedOption[ labelKey ] : __( 'Select an item' );
	};

	render() {
		const { label, options, value, labelKey, valueKey, loading } = this.props;

		return (
			<Downshift
				defaultSelectedItem={ value }
				onChange={ this.handleSave }
			>
				{ ( {
					getLabelProps,
					getItemProps,
					isOpen,
					toggleMenu,
					selectedItem,
				} ) => (
					<div className="form-group">
						<label { ...getLabelProps() } className="label">
							{ label }
						</label>
						<div className="btn-group">
							<LoadingOverlay loading={ loading }>
								<button
									type="button"
									className="custom-select"
									onClick={ toggleMenu }
									data-toggle="dropdown"
									aria-haspopup="true"
									aria-expanded={ isOpen }
									disabled={ options.length === 0 }
								>
									{ this.showSelectedItem( selectedItem ) }
								</button>
								{ isOpen ? (
									<div className="custom-select-options">
										{ options
												.filter( ( option ) => option[ valueKey ] !== selectedItem )
												.map( ( item ) => (
													<button
														{ ...getItemProps( { item: item[ valueKey ] } ) }
														key={ item[ valueKey ] }
														value={ item[ valueKey ] }
														className="custom-select-options__option"
													>
														{ item[ labelKey ] }
													</button>
												) ) }
											</div>
								) : null }
							</LoadingOverlay>
						</div>
					</div>
				) }
			</Downshift>
		);
	}
}

export default SingleSelect;
