App.ApplicationController = Ember.Controller.extend({
  isSearching: false,
  isAuthenticated: localStorage.isAuthenticated,
  innacUid: localStorage.innacUid,
  innacFirstname: localStorage.innacFirstname,
  innacLastname: localStorage.innacLastname,

  isAuthenticatedChanged: function(){
    localStorage.isAuthenticated = this.get('isAuthenticated');
  }.observes('isAuthenticated'),
  
  innacUidChanged: function(){
    localStorage.innacUid = this.get('innacUid');
  }.observes('innacUid'),

  innacFirstnameChanged: function(){
    localStorage.innacFirstname = this.get('innacFirstname');
  }.observes('innacFirstname'),

  innacLastnameChanged: function(){
    localStorage.innacLastname = this.get('innacLastname');
  }.observes('innacLastname'),


  checkAuthState: function(test){
    var user;
    var c;
    var self = this;

    c = $.getJSON('/api/users/me.json');
    
    c.success(function(json){

      if(json.user.uid > 0){

        console.log("authorized");
        self.set('isAuthenticated', true);
        self.set('innacUid', json.user.uid);
        self.set('innacFirstname', json.user.firstname);
        self.set('innacLastname', json.user.lastname);            

        return true;

      }else{
        self.set('isAuthenticated', false);
        console.log('not authed');

        return false;
      }
    });    
  },

  //top searchbar method
  search: function(searchTerm){
    var self = this;
    var results = [];

    //start searching from 3 characters
    if(searchTerm.length > 2){
      console.log(searchTerm);

      results.push(App.SearchBoxResult.create({
        title: searchTerm
      }));

      self.set('content', results);

    }

  }
});

