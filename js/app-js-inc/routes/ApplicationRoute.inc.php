App.ApplicationRoute = Ember.Route.extend({
  enter: function() {
    //always check if the user is authenticated
    var controller = this.controllerFor('application');
    controller.checkAuthState();
  }
});

App.AuthenticatedRoute = Ember.Route.extend({
  enter: function() {
  
  	var appcontroller = this.controllerFor('application');
    if(appcontroller.isAuthenticated){
    	console.log('AuthenticatedRoute says YES!');

    }else{
    	//clear the view before redirection
    	document.removeChild(document.documentElement);
		window.location = "/api/users/login"; 
    }
  },

  setupController: function(model, controller){

  	controller.set('model', model);

  	//set user variables
  	controller.set('innacFirstname', this.controllerFor('application').innacFirstname);
  	controller.set('innacLastname', this.controllerFor('application').innacLastname);
  	controller.set('innacUid', this.controllerFor('application').innacUid);

  }
});