
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