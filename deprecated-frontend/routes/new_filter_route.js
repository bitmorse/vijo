var filter = require('../models/filter');

var NewFilterRoute = Ember.Route.extend({

  renderTemplate: function() {
    this.render('edit_filter', {controller: 'new_filter'});
  },

  model: function() {
    return filter.createRecord();
  },

  exit: function() {
    var model = this.get('controller.model');
    if (!model.get('isSaving')) {
      model.deleteRecord();
    }
  }

});

module.exports = NewFilterRoute;

