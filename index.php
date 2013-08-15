	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />	
  <title>vijo</title>
  <link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/css/bootstrap-combined.no-icons.min.css" rel="stylesheet">
  <link href="//netdna.bootstrapcdn.com/font-awesome/3.1.1/css/font-awesome.css" rel="stylesheet">
  <link href="/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css">
  <link href="/css/style.css" rel="stylesheet" type="text/css">
  <link href='http://fonts.googleapis.com/css?family=Lato:400,700' rel='stylesheet' type='text/css'>
  <link rel="shortcut icon" href="/img/favicon.ico">

  <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
  <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->

</head>
<body>

  <script type="text/x-handlebars">
    <div class="navbar navbar-fixed-top" id="header">
      <div class="navbar-inner">
        <div class="container">
          <div class="row">

            <div class="span3">
              <a class="brand" href="http://vijo.inn.ac"><img src="/img/logo.png" class="logo" /></a>
            </div>
            <div class="span6">
              {{view App.SearchBoxView id="search"}}

              {{#if isSearching}}
                  {{#view App.SearchBoxResultsView}}
                  <ul id="searchAutosuggest">

                    <li>{{#each model}} {{title}} {{/each}}</li>

                    <li class="author"><i class="icon-user"></i><small>Author</small><a href="">Dirk Helbing</a> </li>
                    <li class="author"><i class="icon-user"></i><small>Author</small><a href="">Stefano Balietti</a> </li>
                    <li class="paper"><i class="icon-file"></i><small>Paper</small><a href="">How to create an innovation accelerator</a></li>
                    <li class="filter"><i class="icon-search"></i><small>Filter</small><a href="">Biology</a></li>
                  </ul>
                  {{/view}}
              {{/if}}

            </div>


            <div class="span3">
              <ul class="nav">
                <li>
                  <a class="dropdown-toggle" id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="#/virtualjournals">
                  &#128214;
                  </a>
                  <ul id="filtersMenu" class="dropdown-menu" role="menu">
                    <li>{{#linkTo "virtualjournals.personal"}}<i class="icon-user"></i>My Publications & Related{{/linkTo}}</li>
                    <li class="divider"></li>
                    <li><a href=""><i class="icon-reorder"></i>test</a></li>
                    <li><a href=""><i class="icon-reorder"></i>chem</a></li>

                    <li class="dropdown-submenu pull-left">
                      {{#linkTo "virtualjournals.index"}}<i class="icon-search"></i>More...{{/linkTo}}
                      <ul class="dropdown-menu">
                        <li>{{#linkTo "virtualjournals.new"}}<i class="icon-pencil"></i>Create a virtual journal{{/linkTo}}</li>
                        <li>{{#linkTo "virtualjournals.index"}}<i class="icon-book"></i>Browse community journals{{/linkTo}}</li>
                        <li>{{#linkTo "virtualjournals.coauthors"}}<i class="icon-book"></i>Browse co-authors journals{{/linkTo}}</li>

                      </ul>
                    </li>
                  </ul>
                </li>

                {{#if isAuthenticated}}
                  <li><a href="#/users/activity">&#127758;</a></li>
                  <li><a href="#/users/me"><img src="http://www.gravatar.com/avatar/3a9358a3be54a38943a2e849ddc2b901" width="30"></a></li>
                {{/if}}
              </ul>
                <div class="dropdown">
                 
                </div>
            </div>

          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container">
      {{outlet}}
     
      <div class="row-fluid">
        <div class="span3"></div>
        <div id="footer" class="span9"><strong>vijo</strong> virtual journal —  <a href="http://futurict.eu">FuturICT</a> | <a href="http://www.ethz.ch">ETH Zürich</a></div>
      </div>
    </div>
  </script>

  <?php
    foreach (glob("inc/*.inc.php") as $filename) { include $filename; } 
  ?>

  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
  <script src="/js/lib/jquery.timeago.js"></script>
  <script src="/js/lib/bootstrap-dropdown.js"></script>
  
  <script src="/js/lib/handlebars-1.0.0-rc.3.js"></script>
  <script src="/js/lib/ember-1.0.0-rc.3.js"></script>
  <script src="/js/lib/ember-data.rev12.js"></script>
  <script src="/js/lib/ember-easyForm-0.3.2.js"></script>

  <script src="/js/app.js.php"></script>

  <!-- Piwik -->
  <script type="text/javascript">
    var _paq = _paq || [];
    _paq.push(["trackPageView"]);
    _paq.push(["enableLinkTracking"]);

    (function() { 
      var u=(("https:" == document.location.protocol) ? "https" : "http") + "://trck.bitmorse.com/";
      _paq.push(["setTrackerUrl", u+"piwik.php"]);
      _paq.push(["setSiteId", "7"]);
      var d=document, g=d.createElement("script"), s=d.getElementsByTagName("script")[0]; g.type="text/javascript";
      g.defer=true; g.async=true; g.src=u+"piwik.js"; s.parentNode.insertBefore(g,s);
    })();
  </script>
  <!-- End Piwik Code -->

  <script type="text/javascript" src="http://www.inn.ac/sites/all/modules/innacWidget/embed.js"></script>
  <div id="innac_widget"></div>
</body>
</html>
