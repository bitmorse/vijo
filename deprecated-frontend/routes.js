var App = require('./app');

App.Router.map(function() {

  // generated by ember-generate --scaffold
  this.resource('filters');
  this.resource('filter', {path: '/filters/:filter_id'});
  this.route('edit_filter', {path: '/filters/:filter_id/edit'});
  this.route('new_filter', {path: '/filters/new'});
  // end generated routes


});

