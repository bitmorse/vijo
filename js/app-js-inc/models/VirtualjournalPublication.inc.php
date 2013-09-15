
App.VirtualjournalPublication = Ember.Object.extend({
  id: null,
  source: null,
  journal: null,
  title: null,
  abstract: null,
  twitter: null,
  scopus: null,
  facebook: null,
  mendeley: null,
  source: null,
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
  publication_date: null,
  alchemy_concepts: null,
  starred_by_logged_in_user: null,
  altmetric: null,

  authors_clean: function(){

    var rawauthors = this.get('authors');
    
    if(rawauthors){
      if(rawauthors.indexOf(";") !== -1){
        //plos
        var authors = rawauthors.replace(/;/gi, ', ');
        return authors;

      }else if(rawauthors.indexOf("{") !== -1){
        //arxiv
        var rawauthorsjson = jQuery.parseJSON(rawauthors);
        return rawauthorsjson.forenames + ' ' + rawauthorsjson.keyname;

      }else{
        //others
        return rawauthors;
      }
    }

  }.property('authors'),

  title_clean: function(){
    var title = this.get('title');
    return title.replace(/(<([^>]+)>)/ig,"");
  }.property('title'),

  publication_date_notime: function() {

    if(this.get('publication_date')){
      var date = this.get('publication_date').split('T');
      return date[0];
    }else{
      return false;
    }

  }.property('publication_date'),


  timeago: function(){
    if(this.get('publication_date')){
       return "Published " + jQuery.timeago(this.get('publication_date'));
     }else if (this.get('published')){
       return "Published " + jQuery.timeago(this.get('published'));
     }
   
  }.property("publication_date", "published"),


  is_published_in: function(){
    var journalref = this.get('journalref');
    var journal = this.get('journal');
    var notes = this.get('notes');
    var source = this.get('source');

    if(journalref){
      return "arxiv, "+journalref;
    }else if (notes){
      return "arxiv, "+notes;
    }else if (journal){
      return journal;
    }else if (source){
      return source;
    }else{
      return 'no journal information';
    }

  }.property('journal', 'journalref', 'notes', 'source'),

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

  }.property('author','authors', 'source')

});