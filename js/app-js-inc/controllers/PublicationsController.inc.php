App.PublicationsIndexController = Ember.ArrayController.extend({
  sortProperties: ['title']
});

App.PublicationsTopController = Ember.ArrayController.extend({
  sortProperties: ['publication_date'],
  sortAscending: false
});

App.PublicationsLatestController = Ember.ArrayController.extend({
  sortProperties: ['publication_date'],
  sortAscending: false

});

App.PublicationsControversialController = Ember.ArrayController.extend({
  sortProperties: ['published']
});

App.PublicationsPersonalController = Ember.ArrayController.extend({
  sortProperties: ['id']
});
