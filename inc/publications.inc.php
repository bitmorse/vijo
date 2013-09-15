  <script type="text/x-handlebars" data-template-name="publications">
    {{outlet}}
  </script>

  <script type="text/x-handlebars" data-template-name="publications/personal">
    <h1>Your starred publications</h1>
    <hr />
   

    {{#each publication in model}}
    <div class="publication">
      <h5>{{#linkTo 'publication' publication}}{{publication.title_clean}}{{/linkTo}}</h5>
      <h6>{{publication.counter_total_all}} views | <a {{bindAttr href="publication.virtualjournal_url"}}>{{publication.journal}}</a>  | {{publication.timeago}}</h6>
      
      <div class="publication_content" style="display:none">
        <p class="abstract">{{publication.abstract}}</p>
        {{#linkTo 'publication' publication}}<img {{bindAttr src="publication.image_url"}} />{{/linkTo}}
      </div>

      <hr />
    </div>
    {{/each}}

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

    {{#each publication in model}}
    <div class="publication">
      <h5>{{#linkTo 'publication' publication}}{{publication.title_clean}}{{/linkTo}}</h5>
      <h6>{{publication.counter_total_all}} views | {{publication.journal}} | {{publication.timeago}}</h6>
      
      <div class="publication_content" style="display:none">
        <p class="abstract">{{publication.abstract}}</p>
        {{#linkTo 'publication' publication}}<img {{bindAttr src="publication.image_url"}} />{{/linkTo}}
      </div>

      <hr />
    </div>
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

    {{#each publication in model}}
    <div class="publication">
      <h5>{{#linkTo 'publication' publication}}{{publication.title_clean}}{{/linkTo}}</h5>
      <h6>{{publication.counter_total_all}} views | {{publication.journal}} | {{publication.timeago}}</h6>
      
      <div class="publication_content" style="display:none">
        <p class="abstract">{{publication.abstract}}</p>
        {{#linkTo 'publication' publication}}<img {{bindAttr src="publication.image_url"}} />{{/linkTo}}
      </div>

      <hr />
    </div>
    {{/each}}
  </script>


<script type="text/x-handlebars" data-template-name="publication">

  <div id="maincontainer" class="span12" style="margin-left:0px">
  <div class="row-fluid">

    <div id="publication">

      <center><h1>{{title_clean}}</h1></center>
      

      <hr>

      <div class="abstract">
        {{abstract}}

        <br/><br/>
        <a class="btn btn-large btn-success" {{bindAttr href="access_url"}}>Read Full-Text</a>
        <br />
        <br />
        <br />
      </div>

      <div class="metrics">

        {{authors_clean}} <br /> <br />
        {{timeago}} ({{publication_date_notime}}) <br />
        {{journal}}<br />
        {{#if altmetric_sparkline}} Sparkline: <img {{bindAttr src="altmetric_sparkline"}} /><br />

        <br />
        <br />
        
        <h5>Mention Score <a target="_blank" href="http://support.altmetric.com/knowledgebase/articles/83337-how-is-the-altmetric-score-calculated-"><i class="icon-question"></i></a></h5>

        <a {{bindAttr href="altmetric_url"}} onclick='window.open(this.href, "fenster1", "width=1000,height=800,status=yes,scrollbars=yes,resizable=yes"); return false;'><img {{bindAttr src="altmetric_badge"}} /></a>
        <br />
        <small>Metrics: altmetric.com</small>
        {{/if}}


        {{#if App.MorelikethisPublicationsController}}
          <br/>
          <br/>
          <h5>Related publications on vijo</h5>
          <ul class="morelikethis_publications">
          {{#each App.MorelikethisPublicationsController}}
            <li><a {{bindAttr href="vijo_url"}}>{{title}}</a></li>
          {{/each}}
          </ul>
        {{/if}}
        
        {{#if alchemy_concepts}}
          <br/>
          <br/>
          <h5>Concepts <br/><small>Source: alchemyapi.com</small></h5>
          <p>
          {{alchemy_concepts}}
          </p>
        {{/if}}

      </div>

    </div>



  </div>
  </div>


</script>