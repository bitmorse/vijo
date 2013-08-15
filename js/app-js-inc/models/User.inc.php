App.User = DS.Model.extend({
  uid: DS.attr('number'),
  fullname: DS.attr('string'),
  firstname: DS.attr('string'),
  lastname: DS.attr('string')
});
