export const replacePrice = ( oldPrice, newPrice ) =>
	oldPrice.replace( /\d*\.?\d*$/, Number( newPrice ).toFixed( 2 ) );

export const eslint = () => null;
