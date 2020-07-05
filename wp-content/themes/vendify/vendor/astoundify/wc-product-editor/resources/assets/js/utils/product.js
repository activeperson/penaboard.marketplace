export const productType = [
	{
		label: 'Simple',
		value: 'simple',
	},
	{
		label: 'Variable',
		value: 'variable',
	},
];

export const currentCategories = ( categories ) =>
	categories.map( ( value ) => value.id );

export const currentTags = ( tags ) => tags.map( ( value ) => value.id );

export const getWeightUnit = () => {
	return astoundifyWrp.weightUnit;
};

export const getDimensionsUnit = () => {
	return astoundifyWrp.dimensionUnit;
};
