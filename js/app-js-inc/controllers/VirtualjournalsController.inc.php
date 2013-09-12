App.VirtualjournalsIndexController = App.ApplicationController.extend({
  sortProperties: ['created'],
  sortAscending: false
});

App.VirtualjournalsNewController = Ember.ObjectController.extend({
  submit: function(){
    this.get('store').commit();
    this.transitionToRoute('virtualjournals.index');
  },
  contains_authors_in_references_weights: [1,10,100]
});


App.VirtualjournalEditController = Ember.ObjectController.extend({

  save: function() {
    this.get('store').commit();
    this.transitionToRoute('virtualjournals.index');
  },
  contains_authors_in_references_weights: [1,10,100]


});


App.VirtualjournalDeleteController = Em.ObjectController.extend({
    confirmRemove: function(record) {
      
      record.deleteRecord();

      this.get('store').commit();

      this.transitionToRoute('virtualjournals.index');
    }
});