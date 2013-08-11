var Filter = DS.Model.extend({
	name: DS.attr('string'),
	titleContains: DS.attr('string'),
	abstractContains: DS.attr('string')
});

module.exports = Filter;

