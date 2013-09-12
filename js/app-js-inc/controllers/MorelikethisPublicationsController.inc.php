App.MorelikethisPublicationsController = Ember.ArrayController.create({

    loadPublications: function(publication_id){
      var selectedPublicationId = publication_id;
      var self = this;
      var results = [];

      self.set('content', []);


      c = $.getJSON('/api/publications/mlt/'+selectedPublicationId+'.json')

      c.success(function(json) {

        if(json){
          var rawresults = json;

          for (var i = 0; i < rawresults.length; i++) {
            var e = rawresults[i];

            results.push(App.MorelikethisPublication.create({
              id: e.id,
              title: e.title,
              publication_date: e.publication_date
            }));
          }


          self.set('content', results);
        }

      });


    }
});