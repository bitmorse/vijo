// by default, persist application data to localStorage change this file
// to use the RESTAdapter or your own adapter.

module.exports = DS.Store.extend({
  revision: 12
});

DS.RESTAdapter.reopen({
  namespace: 'api',
  url: 'http://vijo.inn.ac'
});