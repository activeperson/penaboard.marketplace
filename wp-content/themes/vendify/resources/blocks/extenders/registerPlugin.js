/**
 * WordPress dependencies.
 */
const { __ } = wp.i18n;

const { Component, Fragment } = wp.element;
const { TextControl, RangeControl } = wp.components;
const { PluginSidebar, PluginSidebarMoreMenuItem } = wp.editPost;
const { registerPlugin } = wp.plugins;
const { compose } = wp.compose;

const { withSelect, select, withDispatch } = wp.data;

class VendifySidebarPlugin extends Component {
	constructor() {
		super( ...arguments );

		this.state = {
			key: null,
			selectedValue: ''
		};

		this.handleOptionChange = this.handleOptionChange.bind( this );
		this.updateClassNames = this.updateClassNames.bind( this );
	}

	handleOptionChange( e ){
		const { props } = this;
		const { meta } = props.postData;

		let newValue = e.target.value;

		// in case there is a click on the same checkbox it means that we are trying to uncheck.
		if ( newValue === meta.vendify_content_width ) {
			newValue = '';
		}

		this.props.updateContentWidth( newValue );

		// I just wanna trigger a re-render;
		this.setState({ key: Math.random(), selectedValue: newValue });
	}

	updateClassNames( newClass = '', allClasses ) {
		const body = document.querySelector( 'body' );

		// remove any old className
		allClasses.map( ( c ) => {
			body.classList.remove( c );
		});

		if ( newClass !== '' ) {
			// add the new className
			body.classList.add( 'vendify_content_width_' + newClass );
		}
	}

	render() {
		const { props } = this;
		const { meta } = props.postData;
		const currentValue = ( typeof meta.vendify_content_width !== "undefined" && meta.vendify_content_width !== "" ) ? meta.vendify_content_width : '';

		let body_classes = [];

		let contentWidthFields = ['very-thin', 'thin', 'normal', 'wide', 'very-wide' ].map( ( i, j ) => {
			body_classes.push( 'vendify_content_width_' + i );

			return <fieldset className="vendify_content_width_img_radio_button" key={ i }>
				<input type="radio" id={i} value={i} name={"vendify_content_width[" + i + "]"} checked={ currentValue === i } onClick={this.handleOptionChange}/>
				<label htmlFor={i}>{i}</label>
			</fieldset>
		});

		this.updateClassNames( currentValue, body_classes );

		return <Fragment>
			<PluginSidebarMoreMenuItem target="vendify-editor-sidebar">
				{ __( 'Vendify Sidebar' ) }
			</PluginSidebarMoreMenuItem>
			<PluginSidebar
				name="vendify-editor-sidebar"
				title={ __( 'Vendify Extras' ) }
				className="vendify-sidebar-body"
			>

				<h3 className="field-title">{__( 'Content Width' )}</h3>
				<form action="#" name="vendify-content-width" className="vendify-content-width-field">
					{contentWidthFields}
				</form>

				<p className="components-base-control__help">{__( 'Select the desired Content Width for this page. Blocks with alignment Wide or Full will ignore this setting.' )}</p>

			</PluginSidebar>
		</Fragment>
	}
}

let VendifySidebarPluginComposed = compose([
	withSelect( ( select ) => {
		return {
			postData: select( 'core/editor' ).getCurrentPost(),
		};
	}),
	withDispatch( (dispatch, props ) => {
		return {
			updateContentWidth( newWidth ) {
				let meta = props.postData.meta;

				meta['vendify_content_width'] = newWidth;

				dispatch( 'core/editor' ).editPost( { meta: { vendify_content_width: newWidth } } );
			},
		};

	})
])( VendifySidebarPlugin );

registerPlugin( 'vendify-editor-sidebar', {
	icon: 'layout',
	render: VendifySidebarPluginComposed,
} );
