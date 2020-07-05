import React from 'react';
import propTypes from 'prop-types';
import Downshift from 'downshift';

class CreateTags extends React.Component {
  static propTypes = {
  	name: propTypes.string.isRequired,
  	options: propTypes.arrayOf( propTypes.string ).isRequired,
  	updateAttribute: propTypes.func.isRequired,
  	label: propTypes.string.isRequired,
  	placeholder: propTypes.string,
  	labelKey: propTypes.string,
  	valueKey: propTypes.string,
  	attributeId: propTypes.string.isRequired,
  };

  static defaultProps = {
  	placeholder: '',
  	labelKey: 'label',
  	valueKey: 'value',
  };
  state = {
  	selectedItems: this.props.options,
  };

  handleChange = ( value ) => {
  	const { name, attributeId } = this.props;
  	const event = {
  		target: {
  			name,
  			value,
  		},
  	};
  	this.props.updateAttribute( attributeId, event );
  };

  selectItem = ( item ) => {
  	if ( ! this.state.selectedItems.includes( item ) ) {
  		this.setState( { selectedItems: [ ...this.state.selectedItems, item ] } );
  		this.handleChange( [ ...this.state.selectedItems, item ] );
  	}
  };

  removeItem = ( toRemove ) => {
  	this.setState( {
  		selectedItems: [
  			...this.state.selectedItems.filter( ( item ) => item !== toRemove ),
  		],
  	} );
  	this.handleChange( [
  		...this.state.selectedItems.filter( ( item ) => item !== toRemove ),
  	] );
  };

  addItem = ( toAdd, clearSelection ) => {
  	clearSelection();
  	this.setState( ( prevState ) => {
  		const selectedItems = [ ...prevState.selectedItems, toAdd ];
  		this.handleChange( selectedItems );
  		return { selectedItems };
  	} );
  };

  handleFocus = ( { target: { select } } ) => select();

  renderTags = () => {
  	const { selectedItems } = this.state;

  	if ( selectedItems.length === 1 ) {
  		return null;
  	}

  	return (
			<div className="astoundify-wc-re-tags-list">
				{ selectedItems
  				.filter( ( val ) => val !== 'New Option' )
  				.map( ( value, index ) => (
						<div key={ `${ value }-${ index }` } className="btn btn-outline-neutral">
  						{ value }
							
							<button
								className="close"
								onClick={ () => this.removeItem( value ) }
							/>
  					</div>
  				) ) }
  		</div>
  	);
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

						{ inputValue && (
							<button
								className="form-control__add-tag"
								onClick={ () => this.addItem( inputValue, clearSelection ) }
							>
								+
							</button>
						) }
					</div>
				) }
			</Downshift>
		);
  }
}

export default CreateTags;
