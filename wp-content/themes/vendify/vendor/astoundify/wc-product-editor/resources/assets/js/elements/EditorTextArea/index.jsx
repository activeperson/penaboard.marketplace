import React from 'react';
import propTypes from 'prop-types';
import RichTextEditor from 'react-rte';

const toolbarConfig = {
	display: [ 'INLINE_STYLE_BUTTONS', 'BLOCK_TYPE_BUTTONS', 'LINK_BUTTONS' ],
	INLINE_STYLE_BUTTONS: [
		{ label: 'Bold', style: 'BOLD', className: 'custom-css-class' },
		{ label: 'Italic', style: 'ITALIC' },
		{ label: 'Underline', style: 'UNDERLINE' },
	],
	BLOCK_TYPE_BUTTONS: [
		{ label: 'UL', style: 'unordered-list-item' },
		{ label: 'OL', style: 'ordered-list-item' },
	],
};

class EditorTextArea extends React.Component {
  static propTypes = {
  	id: propTypes.string.isRequired,
  	label: propTypes.string.isRequired,
  	value: propTypes.string.isRequired,
  	placeholder: propTypes.string,
  	onBlur: propTypes.func.isRequired,
  	onChange: propTypes.func.isRequired,
  	textAreaHint: propTypes.string,
  	hint: propTypes.string,
  };

  static defaultProps = {
  	textAreaHint: '',
  	hint: '',
  	placeholder: '',
  };

  state = {
  	value: RichTextEditor.createValueFromString( this.props.value, 'html' ),
  };

  handleChange = ( value ) => {
  	const { id: name } = this.props;
  	this.setState( { value } );
  	const event = {
  		target: {
  			value: value.toString( 'html' ),
  			name,
  		},
  	};
  	this.props.onChange( event );
  };

  handleBlur = () => {
  	const { id: name } = this.props;
  	const { value } = this.state;
  	const event = { target: { value: value.toString( 'html' ), name } };
  	this.props.onBlur( event );
  };

  render() {
  	const { id, label, placeholder, textAreaHint, hint } = this.props;

  	return (
			<div className="form-group">
				<label className="label" htmlFor={ id }>
					{ label }
				</label>

				<div className="custom-textarea">
					<RichTextEditor
						toolbarConfig={ toolbarConfig }
						value={ this.state.value }
						onChange={ this.handleChange }
						onBlur={ this.handleBlur }
						placeholder={ placeholder }
					/>
					{ textAreaHint && (
						<span className="textarea__hint">
							{ textAreaHint }
						</span>
					) }
				</div>

				{ hint && <div className="astoundify-wc-re-form-hint">{ hint }</div> }
			</div>
  	);
  }
}

export default EditorTextArea;
