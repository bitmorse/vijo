App.Publication = DS.Model.extend({
  published: DS.attr('date'),
  altmetric: DS.attr('string'),
  title: DS.attr('string'),
  journal: DS.attr('string'),
  doi: DS.attr('string'),
  repec_url: DS.attr('string'),
  abstract: DS.attr('string'),
  authors: DS.attr('string'),
  twitter: DS.attr('string'),
  publication_date: DS.attr('string'),
  counter_total_all: DS.attr('number'),
  alchemy_concepts: DS.attr('string'),

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


  altmetric_badge: function(){

    if(this.get('altmetric') !== 'Not Found'){
        var altmetricraw = this.get('altmetric');
        var altmetric = $.parseJSON(altmetricraw); 
        return altmetric.images.medium;
    }else{
        return false;
    }
   
  }.property('altmetric'),

  altmetric_url: function(){

    if(this.get('altmetric') !== 'Not Found'){
        var altmetricraw = this.get('altmetric');
        var altmetric = $.parseJSON(altmetricraw); 
        return altmetric.details_url;
    }else{
        return false;
    }
   
  }.property('altmetric'),

  altmetric_sparkline: function(){

    if(this.get('altmetric') !== 'Not Found'){
        var altmetricraw = this.get('altmetric');
        var altmetric = $.parseJSON(altmetricraw); 
        var sparkdata = altmetric.context.all.sparkline.join();

        return "https://chart.googleapis.com/chart?cht=ls&chs=100x20&chd=t:"+sparkdata;
    }else{
        return false;
    }

  }.property('altmetric'),


  title_clean: function(){
    var title = this.get('title');
    return title.replace(/(<([^>]+)>)/ig,"");
  }.property('title'),

  timeago: function(){
    return jQuery.timeago(this.get('publication_date'));
  }.property("publication_date"),

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

  }.property('doi', 'repec_url', 'identifiers'),

  publication_date_notime: function() {

    if(this.get('publication_date')){
      var date = this.get('publication_date').split('T');
      return date[0];
    }else{
      return false;
    }

  }.property('publication_date')

});
