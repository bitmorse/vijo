Virtual Journal
==

This package consists of:

- Ember.js Frontend: /index.php
- CakePHP Backend: /api


## Requirements
- PHP5/Apache2
- QScience (http://inn.ac) OAuth Consumer
- MongoDB (with a publications collection)
- Elasticsearch (indexing the mongodb publications collection)


## Installation


This package will currently not work if you don't have MongoDB and Elasticsearch already up and running.

You will also need to rename 

/api/app/Config/database.php.default
/api/app/Config/core.php.default

to

/api/app/Config/database.php
/api/app/Config/core.php

and change the respective values within.


## API Documentation

### Create a new virtual journal (filter)


URL:
- /api/virtualjournals.json

Method:
- POST

Data (replace null with your values):
- {"virtualjournal":{"title":null,"description":null,"authors":null,"discipline":null,"title_contains":null,"abstract_contains":null,"papers_similar_to_author":null,"papers_similar_to_keywords":null,"minimum_amount_of_tweets":null,"created":null,"institution":null,"is_published_in":null}}

Return value:
- virtualjournal_id



### List all public journals

URL:
- /api/virtualjournals.json

Method:
- GET

### Show the results (publications) of a virtual journal:

URL:
- /api/virtualjournals/[virtualjournal_id].json


Method:
- GET

