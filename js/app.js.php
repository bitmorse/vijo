<?php header('Content-Type: text/javascript'); ?>

App = Ember.Application.create({ LOG_TRANSITIONS: true});

/** DATA STORE **/
App.Store = DS.Store.extend({
  revision: 12,
  adapter: DS.RESTAdapter.extend({
    namespace: 'api',
    url: 'http://vijo.inn.ac'
  })
});

<?php
  foreach (glob("app-js-inc/models/*.inc.php") as $filename) { include $filename; } 
  foreach (glob("app-js-inc/controllers/*.inc.php") as $filename) { include $filename; } 
  foreach (glob("app-js-inc/routes/*.inc.php") as $filename) { include $filename; } 
  foreach (glob("app-js-inc/views/*.inc.php") as $filename) { include $filename; } 
?>

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
    this.route('alternative');
    this.route('personal');
    this.route('coauthors');
  });
  this.resource('virtualjournal', {path: '/virtualjournal/:virtualjournal_id'});
  this.resource('virtualjournal_edit', {path: '/virtualjournal/:virtualjournal_id/edit'});
  this.resource('virtualjournal_delete', {path: '/virtualjournal/:virtualjournal_id/delete'});
});

//jquery
(function() { 
$('.publication a').on( "click", function( event ) {
  $( event.target ).closest( ".publication_content" ).toggle();
  console.log('click!');
  $( event.target ).parents('.publication').toggle();
});
})();

