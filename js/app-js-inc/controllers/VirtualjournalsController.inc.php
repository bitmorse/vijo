App.VirtualjournalsIndexController = App.ApplicationController.extend({
  sortProperties: ['views'],
  sortAscending: false
});

App.VirtualjournalsNewController = Ember.ObjectController.extend({
  submit: function(){
    this.get('store').commit();
    //this.transitionToRoute('virtualjournals.index');
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


App.VirtualjournalController = Em.ObjectController.extend({
  publicationSource: [{"name":"All sources", "value":"*"},{"name":"Public Library of Science", "value":"plos"},{"name":"ArXiv.org", "value":"arxiv"},{"name":"RePeC Economics", "value":"repec"}],

  publicationSourceActive: [],

  applyFacets: function(model){
      var facets = 'source='+this.get('publicationSourceActive.value')+'&keyword='+this.get('refineKeyword');

      App.VirtualjournalPublicationStreamController.loadPublications(model.id, facets);
  },


  starVIJOPublication: function(model, journal_id){
    if(localStorage.isAuthenticated === "true"){
      App.VirtualjournalPublicationStreamController.findProperty("id", model.id).set("starred_by_logged_in_user", "icon-star");
      $.getJSON('/api/publications/star/'+journal_id+'/'+model.id+'.json');
    }else{
      window.location = "/api/users/login"; 
    }
  },

  hideVIJOPublication: function(model, journal_id){
    if(localStorage.isAuthenticated === "true"){
      $.getJSON('/api/publications/hide/'+journal_id+'/'+model.id+'.json');
      $("#"+model.id).hide();
    }else{
      window.location = "/api/users/login"; 
    }
  }
});

