App = Ember.Application.create({ LOG_TRANSITIONS: true});

/** DATA STORE **/
App.Store = DS.Store.extend({
  revision: 12,
  adapter: DS.RESTAdapter.extend({
    namespace: 'api',
    url: 'http://vijo.inn.ac'
  })
});



/** MODELS **/
App.Publication = DS.Model.extend({
  published: DS.attr('date'),
  title: DS.attr('string'),
  abstract: DS.attr('string'),
  twitter: DS.attr('string'),
  publication_date: DS.attr('string')
});

App.Virtualjournal = DS.Model.extend({
  title: DS.attr('string'),
  description: DS.attr('string'),
  authors: DS.attr('string'),
  discipline : DS.attr('string'),
  title_contains: DS.attr('string'),
  abstract_contains: DS.attr('string'),
  papers_similar_to_author: DS.attr('string'),
  papers_similar_to_keywords: DS.attr('string'),
  minimum_amount_of_tweets: DS.attr('number'),
  created: DS.attr('date'),
  institution: DS.attr('string'),
  is_published_in: DS.attr('string'),
 
});

App.VirtualjournalPublication = Ember.Object.extend({
  id: null,
  journal: null,
  title: null,
  abstract: null,
  twitter: null,
  scopus: null,
  facebook: null,
  mendeley: null,
  nature: null,
  view_count: null,
  journalref: null,
  doi: null,
  repec_url: null,
  identifiers: null,
  notes: null,
  authors: null,
  author: null,
  score: null,

  is_published_in: function(){
    var journalref = this.get('journalref');
    var journal = this.get('journal');
    var notes = this.get('notes');

    if(journalref){
      return journalref;
    }else if (notes){
      return notes;
    }else if (journal){
      return journal;
    }else{
      return 'no journal information';
    }

  }.property('journal', 'journalref'),

  metrics: function(){
    var view_count = this.get('view_count');
    var twitter = this.get('twitter');
    var facebook = this.get('facebook');
    var nature = this.get('nature');
    var mendeley = this.get('mendeley');
    var scopus = this.get('scopus');

    if(twitter){
      return twitter + ' tweets';
    }else if (facebook){
      return facebook + ' on facebook';

    }else if (nature) {
      return nature + ' in nature';

    }else if (mendeley) {
      return mendeley + ' saves on mendeley';

    }else if (scopus){
      return scopus + ' on scopus';

    }else{
      return 'no metrics'
    }

  }.property('view_count', 'twitter', 'nature', 'facebook', 'mendeley', 'scopus'),

  image_url: function(){
    var doi = this.get('doi');
    var journal = this.get('journal');

    if(journal){
      return 'http://www.plosgenetics.org/article/fetchObject.action?uri=info:doi/'+doi+'.g001&representation=PNG_M';
    }else{
      return '';
    }

  }.property('doi', 'journal'),

  access_url: function() {
    var doi = this.get('doi');
    var repec_url = this.get('repec_url');
    var identifiers = this.get('identifiers');

    if (doi){
      return 'http://dx.doi.org/'+doi;
    }else if(repec_url){
      return repec_url;
    }else if(identifiers){
      var arxiv_id = identifiers.split(':');
      return 'http://arxiv.org/pdf/'+arxiv_id[2];
    }else{
      return 'no url available.';
    }

  }.property('doi', 'repec_url'),

  rank: function(){
    var score = this.get('score');
    return Math.ceil(score*100) + '%';
  }.property('score'),

  display_authors: function(){
    var author = this.get('author');
    var authors = this.get('authors');

    if(authors){
      return authors;
    }else if(author){
      return author;
    }else{
      return '...';
    }

  }.property('author','authors')

});

/** ROUTES **/
App.VirtualjournalsIndexRoute = Ember.Route.extend({
  model: function() {
    return App.Virtualjournal.find();
  }
});

App.VirtualjournalsNewRoute = Ember.Route.extend({
  model: function() {
    return App.Virtualjournal.createRecord();
  }
});

App.VirtualjournalRoute = Ember.Route.extend({
  setupController: function(controller, model){
      App.VirtualjournalPublicationStreamController.loadPublications(model.id);
  },
  model: function(params) {
    return App.Virtualjournal.find(params.virtualjournal_id);
  }
});

App.PublicationsIndexRoute = Ember.Route.extend({
  redirect: function() {
    var lastSorting = this.controllerFor('application').get('lastSorting');
    this.transitionTo('publications.' + lastSorting || 'publications.latest');
  }
});


App.PublicationsRoute = Ember.Route.extend({
  enter: function() {
    var controller = this.controllerFor('application');
    controller.set('lastSorting', this.templateName);
  },
  model: function() {
    return App.Publication.find();
  }
});

App.PublicationsTopRoute = App.PublicationsRoute.extend();
App.PublicationsLatestRoute = App.PublicationsRoute.extend();
App.PublicationsControversialRoute = App.PublicationsRoute.extend();
App.PublicationsRandomRoute = App.PublicationsRoute.extend();


/** CONTROLLERS **/ 
App.ApplicationController = Ember.Controller.extend({
  isSearching: false
});

App.VirtualjournalsIndexController = Ember.ArrayController.extend({
  sortProperties: ['created'],
  sortAscending: false
});


App.VirtualjournalPublicationStreamController = Ember.ArrayController.create({

    loadPublications: function(virtualjournal_id){
      var selectedVirtualjournalId = virtualjournal_id;
      var self = this;
      var results = [];

      self.set('content', []);


      c = $.getJSON('/api/virtualjournals/'+selectedVirtualjournalId+'.json?publicationstream=true')

      c.success(function(json) {
        var rawresults = json.virtualjournal.publication_stream;

        for (var i = 0; i < rawresults.length; i++) {
          var e = rawresults[i];

          results.push(App.VirtualjournalPublication.create({
            id: e._id,
            title: e._source.title,
            abstract: e._source.abstract,
            twitter: e._source.twitter,
            facebook: e._source.facebook,
            scopus: e._source.scopus,
            nature: e._source.nature,
            mendeley: e._source.mendeley,
            view_count: e._source.counter_total_all,
            doi: e._source.doi,
            repec_url: e._source.repec_url,
            identifiers: e._source.identifiers,
            journalref: e._source.journalref,
            journal: e._source.journal,
            notes: e._source.notes,
            score: e._score,
            authors: e._source.authors,
            author: e._source.author
          }));
        }

        self.set('content', results);

      });


    }
});

App.PublicationsIndexController = Ember.ArrayController.extend({
  sortProperties: ['title']
});

App.PublicationsTopController = Ember.ArrayController.extend({
  sortProperties: ['abstract']
});

App.PublicationsLatestController = Ember.ArrayController.extend({
  sortProperties: ['published'],
});

App.PublicationsControversialController = Ember.ArrayController.extend({
  sortProperties: ['published']
});


App.VirtualjournalsNewController = Ember.ObjectController.extend({
  submit: function(){
    this.get('store').commit();
    this.transitionTo('virtualjournals.index');
  }
});


/** VIEWS **/ 
App.SearchBoxView = Ember.TextField.extend({
  formBlurredBinding: 'App.adminController.formBlurred',
  keyDown: function(evt) {
    this.get('controller').set('isSearching', true); 
  },
  change: function(evt) {
    this.get('controller').set('isSearching', true); 
    App.PublicationsController.set('sortProperties', ['published']); 
  },
  click: function(){
    this.set('value', '');
  },
  value: "Search for publications, researchers or places..."
});


App.PublicationsView = Ember.View.extend({
  layoutName: 'default_layout',
  templateName: 'publications'
});

App.VirtualjournalsView = Ember.View.extend({
  layoutName: 'default_layout',
  templateName: 'virtualjournals'
});

App.VirtualjournalView = Ember.View.extend({
  layoutName: 'default_layout',
  templateName: 'virtualjournal'
});



/** ROUTER **/


App.Router.map(function() {
  this.resource('publications', function(){
    this.route('new');
    this.route('controversial');
    this.route('top');
    this.route('latest');
    this.route('random');
  });
  this.resource('publication', {path: '/publication/:publication_id'});

  this.resource('virtualjournals', function(){
    this.route('new');
    this.route('personal');
    this.route('coauthors');
  });
  this.resource('virtualjournal', {path: '/virtualjournal/:virtualjournal_id'});
});

