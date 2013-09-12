App.VirtualjournalPublicationStreamController = Ember.ArrayController.create({
    
    loadingPublications: true,
    foundPublications: true,

    loadPublications: function(virtualjournal_id){
      var selectedVirtualjournalId = virtualjournal_id;
      var self = this;
      var results = [];

      self.set('content', []);
      self.set('loadingPublications', true);
      self.set('foundPublications', true);


      c = $.getJSON('/api/virtualjournals/'+selectedVirtualjournalId+'.json?publicationstream=true')

      c.success(function(json) {

        if(json.virtualjournal.publication_stream !== null){
          var rawresults = json.virtualjournal.publication_stream;

          for (var i = 0; i < rawresults.length; i++) {
            var e = rawresults[i];

            results.push(App.VirtualjournalPublication.create({
              id: e._id,
              title: e._source.title,
              source: e._source.source,
              abstract: e._source.abstract,
              twitter: e._source.twitter,
              facebook: e._source.facebook,
              scopus: e._source.scopus,
              nature: e._source.nature,
              mendeley: e._source.mendeley,
              view_count: e._source.counter_total_all,
              doi: e._source.doi,
              repec_url: e._source.repec_url,
              identifiers: e._source.identifiers,
              journalref: e._source.journalref,
              journal: e._source.journal,
              notes: e._source.notes,
              score: e._score,
              authors: e._source.authors,
              author: e._source.author,
              publication_date: e._source.publication_date,
              published: e._source.published
            }));

            self.set('foundPublications', true);
            self.set('loadingPublications', false);

          }
        }else{
          self.set('foundPublications', false);
          self.set('loadingPublications', false);
        }

        self.set('content', results);

      });


    }
});