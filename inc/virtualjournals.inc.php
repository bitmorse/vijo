
<script type="text/x-handlebars" data-template-name="virtualjournals/coauthors">
  <h1>Your co-authors have been reading...</h1>  
</script>

<script type="text/x-handlebars" data-template-name="virtualjournals/personal">
  <h1>A virtual journal based on your papers</h1>  
</script>



<script type="text/x-handlebars" data-template-name="virtualjournals/new">
  <h1>Create a virtual journal</h1> 

    {{#formFor controller}}
      <fieldset>
        <legend>Journal description</legend>
        {{input title hint="e.g. Prof. Nicolliers Special Interests"}}
        {{input description hint="e.g. Latest papers on pico-satellites"}}
      </fieldset>
      <br />
      <br />
      <fieldset>
        <legend>Publications <b>you</b> want in this journal</legend>
        {{input contains_keywords_important as="text" hint="Most important keywords for your journal - Choose wisely!" label='<i class=\"icon-star\"></i><i class=\"icon-star\"></i>'}}
        <br />
        {{input contains_keywords_normal as="text" hint="Other keywords that may apply." label='<i class=\"icon-star\"></i>'}}
        <br />
        {{input contains_keywords_supplementary as="text" hint="Not important keywords, but why leave them out?" label='<i class=\"icon-star-half-empty\"></i>'}}
        <br />
        {{input contains_authors_in_references as="text" hint="Cited authors to primarily give weight to." label='<i class=\"icon-quote-right\"></i>'}}
        Cited authors weight:<br/> {{view Ember.Select contentBinding="contains_authors_in_references_weights" style="width:100px"}} <span class="hint">How to rank papers that cite authors in the list above.</span>
      </fieldset>
      <br />
      {{submit "Create virtual journal" class="btn-primary btn btn-success"}}
    {{/formFor}}


</script>



<script type="text/x-handlebars" data-template-name="virtualjournals/index">
  <h1>Popular virtual journals  {{#linkTo "virtualjournals.new" class="btn btn-primary offset3"}}create a virtual journal{{/linkTo}}</h1>
  <h5>Containing 1'410'392 <u>open access</u> publications</h5>
    <br/>
    <br/>

    <table class="table virtualjournals">
      <tr>
        <th style="display:none;opacity:0.5">Score</th>
        <th>Title</th>
        <th>Description</th>
        <th>Views</th>
        <th></th>
      </tr>
      {{#each virtualjournal in model}}
        {{#linkTo "virtualjournal" virtualjournal tagName="tr"}}
          <td style="display:none;opacity:0.5">0 <i class="icon-arrow-up"></i><i class="icon-arrow-down"></i></td>
          <td><strong>{{virtualjournal.title}}</strong></td>
          <td>{{virtualjournal.description}}</td>
          <td>{{virtualjournal.views}}</td>
          <td>
            {{#if virtualjournal.belongs_to_logged_in_user}}
            <div class="btn-group">
              {{#linkTo "virtualjournal_edit" virtualjournal class="btn btn-small"}}<i class="icon-pencil"></i>{{/linkTo}}
              {{#linkTo "virtualjournal_delete" virtualjournal class="btn btn-small"}}<i class="icon-remove"></i>{{/linkTo}}
            </div>
            {{/if}}
          </td>
        {{/linkTo}}
      {{/each}}



    </table>
</script>






<script type="text/x-handlebars" data-template-name="virtualjournals">
  <div class="row-fluid">
    {{outlet}}
  </div>
</script>
