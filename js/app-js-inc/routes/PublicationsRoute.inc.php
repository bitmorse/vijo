App.PublicationsIndexRoute = Ember.Route.extend({
  redirect: function() {
    this.transitionTo('publications.latest');
  }
});

App.PublicationsTopRoute = Ember.Route.extend({
  model: function() {
    return App.Publication.find({ sort : 'top'});
  }
});

App.PublicationsLatestRoute = Ember.Route.extend({
  model: function() {
    return App.Publication.find({ sort : 'latest'});
  }
});

App.PublicationsPersonalRoute = App.AuthenticatedRoute.extend({
  model: function() {
    return App.Publication.find({ find : 'starred'});
  }
});
