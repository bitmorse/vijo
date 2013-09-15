<script type="text/x-handlebars" data-template-name="virtualjournal">

  <div id="maincontainerwrapper" class="span12">
    <div id="maincontainer" class="span9" style="margin-left:0px">
    <div class="row-fluid">

      <h1>
        {{title}} 
      </h1>
      {{#if created_by}}<h4>Journal Editor: <a {{bindAttr href="created_by_url"}} target="_blank">{{created_by}}</a></h4>{{/if}}
      <br />
       
      <div class="btn-group"> 
        {{#linkTo virtualjournals class="btn btn-small"}}<i class="icon-arrow-left"></i> Back to List{{/linkTo}}
          
        {{#if belongs_to_logged_in_user}}
          {{#linkTo "virtualjournal_edit" model class="btn btn-small"}}<i class="icon-edit"></i> Edit{{/linkTo}}
          {{#linkTo "virtualjournal_delete" model class="btn btn-small btn-danger"}}<i class="icon-remove"></i> Delete{{/linkTo}}
        {{/if}}

        <a onclick='$("#filterdetails").toggle();' class="btn btn-small"><i class="icon-info"></i> Info</a>
      </div>
      <br />
      <p>{{description}}</p>
     


      <table id="filterdetails" class="table hide">
      	<tr>
      		<th>Important</th>
      		<td>{{contains_keywords_important}}</td>
      	</tr>

      	<tr>	
      		<th>Normal</th>
      		<td>{{contains_keywords_normal}}</td>
      	</tr>

      	<tr>	
      		<th>Supplementary</th>
      		<td>{{contains_keywords_supplementary}}</td>
      	</tr>

        <tr>  
          <th>In References</th>
          <td>{{contains_authors_in_references}}</td>
        </tr>

      	<tr>	
      		<th>Created by</th>
      		<td>{{created_by}}</td>
      	</tr>
      </table>


     	<hr />
      {{#unless App.VirtualjournalPublicationStreamController.foundPublications}}
          <p class="span3">
            Unfortunately no matches we're found for this journal yet. If this is a new research field, check back in while to see if there are any new publications. Otherwise edit the journal.
          </p>
      {{/unless}}

     	{{#unless App.VirtualjournalPublicationStreamController}}
        {{#if App.VirtualjournalPublicationStreamController.loadingPublications}}
     		<center>
    	 		<img src="/img/loading-icon.gif" />
    	 		&nbsp;
    	 		&nbsp;
    	 		&nbsp;
    	 		<img src="/img/logo-big.png" />
    	 	</center>
        {{/if}}
     	{{/unless}}



      <table id="publicationstream">
       	{{#each App.VirtualjournalPublicationStreamController}}

          <tr {{bindAttr id="id"}}>
            <td valign=top class="star">
              <i {{bindAttr title="score" class="starred_by_logged_in_user"}} {{action starVIJOPublication this virtualjournal_id}}></i><br />
              <i {{bindAttr class="hidden_by_logged_in_user"}} {{action hideVIJOPublication this virtualjournal_id}}></i>
            </td>
            
            {{#linkTo 'publication' this tagName="td" class="result"}}
            	<strong>{{title_clean}}</strong> <br/>
            	<small>{{authors_clean}} | {{is_published_in}} | {{metrics}} | {{timeago}}</small>

            	<a {{bindAttr href="access_url"}} target="_blank"><img {{bindAttr src="image_url"}} /></a>
            	
            	<hr />
            {{/linkTo}}
          </tr>

       	{{/each}}
      </table>

    </div>
    </div>


     <div id="virtualjournalSidebar">


         {{#if App.VirtualjournalPublicationStreamController.termsFacet}}<strong>Most used words in titles of these papers:</strong><br/>{{/if}}
        {{App.VirtualjournalPublicationStreamController.termsFacet}}  

          <div id="virtualjournalFacets">
          <strong>Filter in results:</strong><br/>
           Keyword:<br />{{view Ember.TextField valueBinding="refineKeyword" id="refineKeyword"}}<br />
           Source:<br/> {{view Ember.Select contentBinding="publicationSource" selectionBinding="publicationSourceActive" optionLabelPath="content.name" optionValuePath="content.value"}}<br />

            <button {{action applyFacets this}} class="btn btn-success">
              Apply Filter
            </button>
          </div>


      </div>

  </div>

</script>


<script type="text/x-handlebars" data-template-name="virtualjournal_edit">
  <div id="maincontainer" class="span12" style="margin-left:0px">
  <div class="row-fluid">

    <form {{action save on="submit"}}>
    
      <fieldset>
        <legend>Journal description</legend>
        Title: <br />{{view Ember.TextField valueBinding="title" id="title"}}<br />
        Description: <br />{{view Ember.TextField valueBinding="description" id="description"}}<br />

      </fieldset>
      <br />
      <br />
      <fieldset class="virtualjournal">
        <legend>Publications <b>you</b> want in this journal</legend>
         Important keywords: <br />{{view Ember.TextArea valueBinding="contains_keywords_important"  id="contains_keywords_important"}}<br />
         Normal keywords: <br />{{view Ember.TextArea valueBinding="contains_keywords_normal" id="contains_keywords_normal"}}<br />
         Least important keywords: <br />{{view Ember.TextArea valueBinding="contains_keywords_supplementary" id="contains_keywords_supplementary"}}<br />
         Cited authors: <br />{{view Ember.TextArea valueBinding="contains_authors_in_references" id="contains_authors_in_references"}}<br />
         Cited authors weight:<br/> {{view Ember.Select contentBinding="contains_authors_in_references_weights" style="width:100px"}} <span class="hint">How to rank papers that cite authors in the list above.</span>

      </fieldset>

      <button type="submit">Save</button>

    </form>
</script>



<script type="text/x-handlebars" data-template-name="virtualjournal_delete"> 
  <div id="maincontainer" class="span12" style="margin-left:0px">
  <div class="row-fluid">

      <fieldset>
        <legend>Remove</legend>
        <div class="row-fluid">
            Are you sure you want to delete the journal <strong>{{title}}</strong>?

        </div>
    </fieldset>
    <ht />
    {{#linkTo virtualjournals class="btn"}}Back to List{{/linkTo}}
    <button {{action confirmRemove this}} class="btn btn-danger">
        Delete
    </button>

  </div></div>
</script>
