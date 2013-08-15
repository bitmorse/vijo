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


<table>
    <tr>
        <th>Action</th>
        <th>URL</th>
        <th>Method</th>
        <th>Parameters</th>
        <th>Return values</th>
    </tr>
    <tr>
        <td>Create a new virtual journal</td>
        <td>/api/virtualjournals.json</td>
        <td>POST</td>
        <td>
        Replace null with your value: 
        {"virtualjournal":{"title":null,"description":null,"authors":null,"discipline":null,"title_contains":null,"abstract_contains":null,"papers_similar_to_author":null,"papers_similar_to_keywords":null,"minimum_amount_of_tweets":null,"created":null,"institution":null,"is_published_in":null}}</td>
        <td>[virtualjournal_id]</td>
    </tr>

    <tr>
        <td>List all public journals</td>
        <td>/api/virtualjournals.json</td>
        <td>GET</td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td>List the results (publications) of a virtual journal</td>
        <td>/api/virtualjournals/[virtualjournal_id].json</td>
        <td>GET</td>
        <td></td>
        <td></td>
        <td></td>
    </tr>

</table>
