App.PublicationRoute = Ember.Route.extend({
  setupController: function(controller, model){
      App.MorelikethisPublicationsController.loadPublications(model.id);
  },
  model: function(params) {
    return App.Publication.find(params.publication_id);
  }
});