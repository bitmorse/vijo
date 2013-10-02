App.ApplicationController = Ember.Controller.extend({
  isSearching: false,
  isAuthenticated: localStorage.isAuthenticated,
  innacUid: localStorage.innacUid,
  innacUsername: localStorage.innacUsername,
  innacFirstname: localStorage.innacFirstname,
  innacLastname: localStorage.innacLastname,

  isAuthenticatedChanged: function(){
    localStorage.isAuthenticated = this.get('isAuthenticated');
  }.observes('isAuthenticated'),
  
  innacUidChanged: function(){
    localStorage.innacUid = this.get('innacUid');
  }.observes('innacUid'),

  innacUsernameChanged: function(){
    localStorage.innacUsername = this.get('innacUsername');
  }.observes('innacUsername'),

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

      if(typeof json.user !== 'undefined'){
        if(json.user.uid > 0){

          console.log("authorized");
          self.set('isAuthenticated', true);
          self.set('innacUid', json.user.uid);
          self.set('innacFirstname', json.user.firstname);
          self.set('innacLastname', json.user.lastname);            
          self.set('innacUsername', json.user.username);            

          return true;

        }else{
          self.set('isAuthenticated', false);
          console.log('not authed');

          return false;
        }
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

      c = $.getJSON('/api/publications/search/query?keywords='+searchTerm);

      c.success(function(jsonResult){
        
        //go through the results and push them to our result object
        for(var i = 0; i < jsonResult.length; i++){
          results.push(App.SearchBoxResult.create({
            title: jsonResult[i].title,
            href: '/#/publication/'+jsonResult[i].id,
          }));
        }

        self.set('isSearching', true);
        self.set('content', results);
      });


    }

  },

  connectOutlet: function(){
    window.scrollTo(0, 0);
    this._super.apply(this, arguments);
  },

  //for analytics
  currentPathChanged: function() {
    var page;

    // window.location gets updated later in the current run loop, so we will
    // wait until the next run loop to inspect its value and make the call
    // to track the page view
    Ember.run.next(function() {
      // Track the page in piwik
      if (!Ember.isNone(_paq)) {
        // Assume that if there is a hash component to the url then we are using
        // the hash location strategy. Otherwise, we'll assume the history
        // strategy.
        page = window.location.hash.length > 0 ?
               window.location.hash.substring(1) :
               window.location.pathname;

        _paq.push(['setDocumentTitle', page]);
        _paq.push(["trackPageView", page]);
        _paq.push(["enableLinkTracking"]);

      }
    });
  }.observes('currentPath')
});

