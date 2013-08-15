App.VirtualjournalRoute = Ember.Route.extend({
  setupController: function(controller, model){
      App.VirtualjournalPublicationStreamController.loadPublications(model.id);
  },
  model: function(params) {
    return App.Virtualjournal.find(params.virtualjournal_id);
  }
});