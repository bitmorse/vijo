  <script type="text/x-handlebars" data-template-name="publications">
    {{outlet}}
  </script>

  <script type="text/x-handlebars" data-template-name="publications/latest">
    <h1>Recently Published Publications</h1>
    <hr />
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
      <h5><a {{bindAttr href="access_url"}} target="_blank">{{title_clean}}</a></h5>
      <h6>{{counter_total_all}} views | {{journal}} | {{timeago}} </h6>
      <p class="abstract">{{abstract}}</p>
      <a {{bindAttr href="access_url"}} target="_blank"><img {{bindAttr src="image_url"}} /></a>
      <hr />
    {{/each}}
  </script>
  <script type="text/x-handlebars" data-template-name="publications/top">
    <h1>Top Rated Publications</h1>
    <hr />
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
    <div class="publication">
      <h5><a {{bindAttr href="access_url"}} target="_blank">{{title_clean}}</a></h5>
      <h6>{{counter_total_all}} views | {{journal}} | {{timeago}} | <a href="javascript:$(this.target).closest('.publication_content').toggle();">show abstract</a></h6>
      
      <div class="publication_content" style="display:none">
        <p class="abstract">{{abstract}}</p>
        <a {{bindAttr href="access_url"}} target="_blank"><img {{bindAttr src="image_url"}} /></a>
      </div>

      <hr />
    </div>
    {{/each}}
  </script>

