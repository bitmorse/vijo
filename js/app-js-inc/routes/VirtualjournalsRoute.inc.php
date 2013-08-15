App.VirtualjournalsIndexRoute = Ember.Route.extend({
  model: function() {
    return App.Virtualjournal.find();
  }
});


App.VirtualjournalsNewRoute = App.AuthenticatedRoute.extend({
  model: function() {
    return App.Virtualjournal.createRecord();
  }
});