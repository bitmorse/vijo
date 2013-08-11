  <script type="text/x-handlebars" data-template-name="publications">
    {{outlet}}
  </script>
  <script type="text/x-handlebars" data-template-name="publications/index">
    <ul>
    {{#each controller}}
         <li>{{title}}
         {{published}}</li>
    {{/each}}
    </ul>
  </script> 

  <script type="text/x-handlebars" data-template-name="publications/latest">
    <h1>Recently published publications</h1>
    <ul>
    {{#unless model}}
    <center>
      <img src="/img/loading-icon.gif" />
      &nbsp;
      &nbsp;
      &nbsp;
      <img src="/img/logo-big.png" />
    </center>
    {{/unless}}

    {{#each model}}
         <li>{{title}}
         {{publication_date}}</li>
    {{/each}}
    </ul>
  </script>
  <script type="text/x-handlebars" data-template-name="publications/top">
    <h1>Top rated publications</h1>
    {{#unless model}}
    <center>
      <img src="/img/loading-icon.gif" />
      &nbsp;
      &nbsp;
      &nbsp;
      <img src="/img/logo-big.png" />
    </center>
    {{/unless}}

    <ul>
    {{#each controller}}
         <li>{{title}}
         {{published}}</li>
    {{/each}}
    </ul>
  </script>
  <script type="text/x-handlebars" data-template-name="publications/controversial">
    <h1>Controversial</h1>

    <ul>
    {{#each controller}}
         <li>{{title}}
         {{published}}</li>
    {{/each}}
    </ul>
  </script>
  <script type="text/x-handlebars" data-template-name="publications/random">
    <h1>Random</h1>

    <ul>
    {{#each controller}}
         <li>{{title}}
         {{published}}</li>
    {{/each}}
    </ul>
  </script>
