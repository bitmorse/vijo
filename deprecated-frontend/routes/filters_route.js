var Filter = require('../models/filter');

var FilterRoute = Ember.Route.extend({
  setupController: function(controller, filter) {
    controller.set('content', filter);
  },

  model: function() {
    return Filter.find();
  }

});

module.exports = FilterRoute;

