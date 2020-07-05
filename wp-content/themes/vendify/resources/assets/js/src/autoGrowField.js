/**
 *
 * Autogrowing textareas
 *
 */

const autoGrowField = function() {
	const fieldList = document.querySelectorAll( '.js-autogrow-field' );

	for ( let i = 0; i < fieldList.length; i++ ) {
		const field = fieldList[ i ];
		const baseScrollHeight = field.scrollHeight;
		const baseHeight = field.offsetHeight;

		field.addEventListener( 'input', function( e ) {
			e.target.style.height = `${ baseHeight }px`;

			const currentScrollHeight = e.target.scrollHeight;
			const currentHeight = baseHeight + ( currentScrollHeight - baseScrollHeight );

			e.target.style.height = `${ currentHeight }px`;
		} );
	}
};

export default autoGrowField();

