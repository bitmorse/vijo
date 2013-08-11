
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
        {{input description hint="e.g. Space Technology of the future in particular CubeSat research."}}
        {{input authors hint="e.g. Claude Nicollier, Chris Hadfield"}}
        {{input discipline hint="e.g. Material Sciences, Astrophysics"}}
      </fieldset>
      <br />
      <br />
      <fieldset>
        <legend>Publications <b>you</b> want in this journal</legend>
        {{input title_contains hint="e.g. CubeSat"}}
        {{input abstract_contains hint="e.g. de-orbit a satellite"}}
        {{input minimum_amount_of_tweets hint="e.g. 5"}}
        {{input papers_similar_to_author hint=""}}
        {{input papers_similar_to_keywords hint="e.g. orbit, debris, myon, airglow"}}
        {{input institution hint="e.g. EPFL"}}
        {{input is_published_in hint="e.g. PLOS One"}}
      </fieldset>
      <br />
      {{submit "Create virtual journal" class="btn-primary btn btn-success"}}
    {{/formFor}}


</script>



<script type="text/x-handlebars" data-template-name="virtualjournals/index">
  <h1>Popular virtual journals  {{#linkTo "virtualjournals.new" class="btn btn-primary offset3"}}create a virtual journal{{/linkTo}}</h1>
  <h5>Containing 1'136'502 <u>open access</u> publications</h5>
    <br/>
    <br/>

    <table class="table">
      <tr>
        <th style="opacity:0.5">Score</th>
        <th>Title</th>
        <th>Description</th>
        <th>Discipline</th>
        <th></th>
      </tr>
    {{#each virtualjournal in controller}}
      <tr>
        <td style="opacity:0.5">0 <i class="icon-arrow-up"></i><i class="icon-arrow-down"></i></td>
        <td><strong>{{virtualjournal.title}}</strong></td>
        <td>{{virtualjournal.description}}</td>
        <td>{{virtualjournal.discipline}}</td>
        <td>{{#linkTo "virtualjournal" virtualjournal}}view{{/linkTo}}</td>
        
      </tr>
    {{/each}}
    </table>


</script>



<script type="text/x-handlebars" data-template-name="virtualjournals">
  <div class="row-fluid">
    {{outlet}}
  </div>
</script>
