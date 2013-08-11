<script type="text/x-handlebars" data-template-name="default_layout">
     <div class="row-fluid">
        <div class="span3">
         

          <ul class="sidebarmenu">
            <li class="first"><span>Virtual Journals</span></li>
            <li><span>{{#linkTo "virtualjournals.index"}}Community Journals{{/linkTo}}</span></li>
            <li><span>{{#linkTo "virtualjournals.new"}}Create your own Journal{{/linkTo}}</span></li>

          </ul>


           <ul class="sidebarmenu">
            <li class="first"><span>Discover</span></li>
            <li>{{#linkTo "publications.top"}}Top rated publications{{/linkTo}}</li>
            <li>{{#linkTo "publications.latest"}}Latest publications{{/linkTo}}</li>
            <!-- <li>{{#linkTo "publications.controversial"}}Controversial{{/linkTo}}</li>
            <li class="last">{{#linkTo "publications.random"}}Random{{/linkTo}}</li> -->
          </ul>


        </div>

        <div id="maincontainer" class="span9">
            {{yield}}
        </div>
      </div>
  </script>