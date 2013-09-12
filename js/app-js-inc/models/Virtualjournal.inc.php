App.Virtualjournal = DS.Model.extend({
  title: DS.attr('string'),
  description: DS.attr('string'),
  created: DS.attr('date'),
  created_by: DS.attr('string'),
  created_by_url: DS.attr('string'),
  contains_keywords_important: DS.attr('string'),
  contains_keywords_normal: DS.attr('string'),
  contains_keywords_supplementary: DS.attr('string'),
  contains_authors_in_references: DS.attr('string'),
  contains_authors_in_references_weight: DS.attr('string'),
  belongs_to_logged_in_user: DS.attr('string')
});