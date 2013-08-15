<script type="text/x-handlebars" data-template-name="virtualjournal">
  <div id="maincontainer" class="span12" style="margin-left:0px">
  <div class="row-fluid">

  <h1>
        {{title}}
  </h1>
  <h2>
        {{discipline}}
  </h2>
  <h2>{{authors}}</h2>
  <p>{{description}}</p>
  <a style="float:right; position:relative; right:0; top:-90" href='javascript:$("#filterdetails").toggle();' class="btn btn-small">show/hide journal details</a>

  <table id="filterdetails" class="table hide">
  	<tr>
  		<th>Title contains</th>
  		<td>{{title_contains}}</td>
  	</tr>

  	<tr>	
  		<th>Abstract contains</th>
  		<td>{{abstract_contains}}</td>
  	</tr>

  	<tr>	
  		<th>Min. tweets</th>
  		<td>{{minimum_amount_of_tweets}}</td>
  	</tr>

  	<tr>	
  		<th>Related to author</th>
  		<td>{{papers_similar_to_author}}</td>
  	</tr>

  	<tr>	
  		<th>Related to keywords</th>
  		<td>{{papers_similar_to_keywords}}</td>
  	</tr>

  	<tr>	
  		<th>Institution</th>
  		<td>{{institution}}</td>
  	</tr>

  	<tr>	
  		<th>Published in</th>
  		<td>{{is_published_in}}</td>
  	</tr>

  </table>

 	<hr />

 	{{#unless App.VirtualjournalPublicationStreamController}}
 		<center>
	 		<img src="/img/loading-icon.gif" />
	 		&nbsp;
	 		&nbsp;
	 		&nbsp;
	 		<img src="/img/logo-big.png" />
	 	</center>
 	{{/unless}}
 		
 	{{#each App.VirtualjournalPublicationStreamController}}

	<h5>{{rank}} <i {{bindAttr title="score"}} class="icon-sign-blank"></i> <a {{bindAttr href="access_url"}} target="_blank">{{title}}</a></h5>
	<h6>{{metrics}} | {{is_published_in}} | {{display_authors}}</h6>
	<p class="abstract">{{abstract}}</p>

	<a {{bindAttr href="access_url"}} target="_blank"><img {{bindAttr src="image_url"}} /></a>
	
	<hr />
 	{{/each}} 

  </div>
  </div>
</script>
