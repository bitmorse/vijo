
App.Publication = DS.Model.extend({
  published: DS.attr('date'),
  title: DS.attr('string'),
  journal: DS.attr('string'),
  doi: DS.attr('string'),
  repec_url: DS.attr('string'),
  abstract: DS.attr('string'),
  twitter: DS.attr('string'),
  publication_date: DS.attr('string'),
  counter_total_all: DS.attr('number'),

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

  }.property('doi', 'repec_url'),
});
