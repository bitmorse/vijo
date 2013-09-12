App.MorelikethisPublication = Ember.Object.extend({
  id: null,
  title: null,
  publication_date: null,

  timeago: function(){
    if(this.get('publication_date')){
       return "Published " + jQuery.timeago(this.get('publication_date'));
     }else{
       return false;
     }
   
  }.property("publication_date"),

  vijo_url: function() {
    var id = this.get('id');

    return 'http://vijo.inn.ac/#/publication/'+id;

  }.property('id')

});