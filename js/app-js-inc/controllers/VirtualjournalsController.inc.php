App.VirtualjournalsIndexController = Ember.ArrayController.extend({
  sortProperties: ['created'],
  sortAscending: false
});

App.VirtualjournalsNewController = Ember.ObjectController.extend({
  submit: function(){
    this.get('store').commit();
    this.transitionTo('virtualjournals.index');
  }
});
