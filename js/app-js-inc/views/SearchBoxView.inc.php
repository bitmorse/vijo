App.SearchBoxView = Ember.TextField.extend({

  keyUp: function(evt) {
    this.get('controller').set('isSearching', true);
    this.get('controller').search(this.get('value'));
  },
  change: function(evt) {
    this.get('controller').set('isSearching', true);
  },
  click: function(){
    this.set('value', '');
  },
  value: "Search for publications, researchers or places..."
});

App.SearchBoxResultsView = Ember.View.extend({
  mouseLeave: function(evt){
    this.get('controller').set('isSearching', false); 
  },
  click: function(evt){
    this.get('controller').set('isSearching', false); 
  }
});