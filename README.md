Virtual Journal
==

This package consists of:

- Ember.js Frontend: /index.php
- CakePHP Backend: /api


Requirements
==
- PHP5/Apache2
- QScience (http://inn.ac) OAuth Consumer
- MongoDB (with a publications collection)
- Elasticsearch (indexing the mongodb publications collection)


Installation
==

This package will currently not work if you don't have MongoDB and Elasticsearch already up and running.

You will also need to rename 

/api/app/Config/database.php.default
/api/app/Config/core.php.default

to

/api/app/Config/database.php
/api/app/Config/core.php

and change the respective values within.