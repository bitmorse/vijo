var FilterController = Ember.ObjectController.extend({

  destroy: function() {
    if (!confirm('Are you sure?')) return;
    this.get('model').deleteRecord();
    this.get('store').commit();
    this.get('target').transitionTo('filters');
  }
  
});

module.exports = FilterController;

