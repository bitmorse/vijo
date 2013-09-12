<?php 

//load spyc for yaml handling (patterns exchange)
App::uses('Spyc', 'Vendor');


class VirtualjournalsController extends AppController {
    public $components = array('RequestHandler');


    public function beforeFilter(){
        parent::beforeFilter();

        //method specific api options -> REST!
        if($_SERVER['REQUEST_METHOD'] == 'OPTIONS'){
            header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
            exit();
        }
    }

    public function index() {
        $virtualjournals = $this->Virtualjournal->find('all', array('limit'=>'100'));
        $virtualjournalsclean = array();
        foreach ($virtualjournals as $virtualjournal) {

            if(@$virtualjournal['Virtualjournal']['created_by'] == $this->Session->read('User.user.username')){
                $belongs_to_logged_in_user = true;
            }else{
                $belongs_to_logged_in_user = '';
            }

            $virtualjournalsclean[] = array(
                'id'=> @$virtualjournal['Virtualjournal']['_id'], 
                'title' => @$virtualjournal['Virtualjournal']['title'], 
                'description' => @$virtualjournal['Virtualjournal']['description'],
                'contains_authors_in_references' => @$virtualjournal['Virtualjournal']['contains_authors_in_references'],
                'contains_keywords_important' => @$virtualjournal['Virtualjournal']['contains_keywords_important'],
                'contains_keywords_normal' => @$virtualjournal['Virtualjournal']['contains_keywords_normal'],
                'contains_keywords_supplementary' => @$virtualjournal['Virtualjournal']['contains_keywords_supplementary'],
                'belongs_to_logged_in_user' => $belongs_to_logged_in_user,
                'created_by' => @$virtualjournal['Virtualjournal']['created_by'],
                'created_by_url' => 'http://inn.ac/users/'.@$virtualjournal['Virtualjournal']['created_by'],
                'modified' => date('Y-M-d H:i:s', @$virtualjournal['Virtualjournal']['modified']->sec),
                'created' => date('Y-M-d H:i:s', @$virtualjournal['Virtualjournal']['created']->sec)
            );
        }

        $this->set(array(
            'virtualjournals' => $virtualjournalsclean,
            '_serialize' => array('virtualjournals')
        ));
    }


    public function view($id) {
        $virtualjournal = $this->Virtualjournal->find('first', array('conditions' => array('_id' => $id)));


        if(@$virtualjournal['Virtualjournal']['created_by'] == $this->Session->read('User.user.username')){
            $belongs_to_logged_in_user = true;
        }else{
            $belongs_to_logged_in_user = '';
        }

        $keywords5 = rtrim(@$virtualjournal['Virtualjournal']['contains_keywords_important']);
        $keywords3 = rtrim(@$virtualjournal['Virtualjournal']['contains_keywords_normal']);
        $keywords1 = rtrim(@$virtualjournal['Virtualjournal']['contains_keywords_supplementary']);

        $references =  rtrim(@$virtualjournal['Virtualjournal']['contains_authors_in_references']);
        $references_weight = $virtualjournal['Virtualjournal']['contains_authors_in_references_weight'];

        if($keywords5){$keywords5 = str_replace("\n", " OR ", $keywords5); $q_keywords .= '('.$keywords5.')^5 '; }else{$q_keywords .= '(*) ';}
        if($keywords3){$keywords3 = str_replace("\n", " OR ", $keywords3); $q_keywords .= 'OR ('.$keywords3.')^3 '; }else{$q_keywords .= 'OR (*) ';}
        if($keywords1){$keywords1 = str_replace("\n", " OR ", $keywords1); $q_keywords .= 'OR ('.$keywords1.')^1 '; }else{$q_keywords .= 'OR (*) ';}
        
        if($references && $references_weight){$references = str_replace("\n", " OR ", $references); $q_references .= '('.$references.')^'.$references_weight.' '; }else{$q_references = '*';}

     

        //perform elasticsearch query
        $virtualjournalQuery = '{"query":
                        {"bool":
                            {"should":
                                [
                                    {"query_string":{"default_field":"paper.references","query":"'.@$q_references.'"}},
                                    {
                                      "range" : {
                                        "publication_date" : {
                                          "boost" : 10,
                                          "gte" : "'.date('Y-m-d', strtotime('-1 months')).'"
                                        }
                                      }
                                    },
                                    {
                                      "range" : {
                                        "publication_date" : {
                                          "boost" : 2,
                                          "gte" : "'.date('Y-m-d', strtotime('-6 months')).'"
                                        }
                                      }
                                    },
                                    {
                                      "range" : {
                                        "publication_date" : {
                                          "boost" : 1,
                                          "gte" : "'.date('Y-m-d', strtotime('-2 years')).'"
                                        }
                                      }
                                    }
                                    
                                ],
                                "must_not":[],
                                "must":[
                                    {"query_string":{"fields" : ["abstract^5", "title^2", "authors"], "query":"'.$q_keywords.'", "use_dis_max" : true}}
                                ]
                            }
                        },
                        "from":0,
                        "size":50,
                        "sort":[],
                        "facets":{
                            "tags": {
                                "terms": {
                                    "field": "alchemy_concepts",
                                    "size": 100
                                }
                        }}
                    }';


        

        //dont search if not explicitly requested!
        if($_GET['publicationstream'] == 'true'){
            $publicationStreamRaw = $this->CurlHTTP->Post('http://inn.ac:9200/publications/_search', $virtualjournalQuery, 'vijo', 0);
            $publicationStream = json_decode($publicationStreamRaw, 1);
            $publicationStream = $publicationStream['hits']['hits'];
        }else{
            $publicationStream = '';
        }

       
        $virtualjournalclean = array(
               'id'=> @$virtualjournal['Virtualjournal']['_id'], 
                'title' => @$virtualjournal['Virtualjournal']['title'], 
                'description' => @$virtualjournal['Virtualjournal']['description'],
                'created' => @date('Y-M-d H:i:s', $virtualjournal['Virtualjournal']['created']->sec),
                'contains_authors_in_references' => @$virtualjournal['Virtualjournal']['contains_authors_in_references'],
                'contains_keywords_important' => @$virtualjournal['Virtualjournal']['contains_keywords_important'],
                'contains_keywords_normal' => @$virtualjournal['Virtualjournal']['contains_keywords_normal'],
                'contains_keywords_supplementary' => @$virtualjournal['Virtualjournal']['contains_keywords_supplementary'],
                'belongs_to_logged_in_user' => $belongs_to_logged_in_user,
                'created_by' =>  @$virtualjournal['Virtualjournal']['created_by'],
                'created_by_url' => 'http://inn.ac/users/'.@$virtualjournal['Virtualjournal']['created_by'],
                'publication_stream' => @$publicationStream
            );


        $this->set(array(
            'virtualjournal' => $virtualjournalclean,
            '_serialize' => array('virtualjournal')
        ));
    }

    public function edit($id) {

        $this->Virtualjournal->id = $id;

        if ($this->Virtualjournal->save($this->request->data['virtualjournal'])) {
            $message = 'Saved';
        } else {
            $message = 'Error';
        }
        $this->set(array(
            'message' => $message,
            '_serialize' => array('message')
        ));
    }
    
    public function add() {

        if($this->Session->read('User.user.username') == ""){
            header('Location: /api/users/login');
            exit();
        }



        $this->Virtualjournal->create();
        $this->request->data['virtualjournal']['created_by'] = $this->Session->read('User.user.username');

        if ($this->Virtualjournal->save($this->request->data['virtualjournal'])) {
            $message = $this->Virtualjournal->getLastInsertID();
        } else {
            $message = 'Error!';
        }


        $this->set(array(
            'virtualjournal_id' => $message,
            '_serialize' => array('virtualjournal_id')
        ));


        /** EXPERIMENTAL PATTERNS DB ADDITION *******/
        
        //our example virtual journal (in patterns format)
        $virtualjournalData = array(
            'info' => array(
                'title' =>  $this->request->data['virtualjournal']['title'],
                'description' =>  $this->request->data['virtualjournal']['description'],
                'author' => $this->request->data['virtualjournal']['created_by'],
                'category' => 'vijo',
                'version' => '1.0',
                'core' => '7.x',
                'author_website' => 'http://inn.ac/users/'.$this->request->data['virtualjournal']['created_by'],
                'author_email' => ''
            ),

            'actions' => array(
                array(
                    'create'=>array(
                        'contains_authors_in_references' => @$this->request->data['virtualjournal']['contains_authors_in_references'],
                        'contains_keywords_important' => @$this->request->data['virtualjournal']['contains_keywords_important'],
                        'contains_keywords_normal' => @$this->request->data['virtualjournal']['contains_keywords_normal'],
                        'contains_keywords_supplementary' => @$this->request->data['virtualjournal']['contains_keywords_supplementary']
                    )
                )
            )

        );

        //YAML encode the virtualjournal
        $virtualjournalDataYAML = Spyc::YAMLDump($virtualjournalData);


        //patterns table data structure
        $drupal_path = '/var/storage/generic1/www/sites/inn.ac/patterns/sites/default/';
        $path = 'files/patterns_server/';
        $fileName = 'vijo'.str_replace(' ', '_', strtolower($this->request->data['virtualjournal']['title'])).rand(0,10000).'.yaml';

        
        $patternsDbData = array(
            'Pattern' => array(
                'name' => $fileName,
                'category' => 'vijo',
                'pattern' => serialize($virtualjournalData),
                'title' => $this->request->data['virtualjournal']['title'], 
                'file_path' => 'public://patterns_server/'.$fileName,
                'file_name' => $fileName,
                'file_format' => 'yaml',
                'description' => $this->request->data['virtualjournal']['description'], 
                'created' => time(),
                'status' => '0',
                'uuuid' => $this->patterns_utils_get_uuuid(),
                'author' => $this->request->data['virtualjournal']['created_by'],
                'uploader' => $this->Session->read('User.user.uid')
            )
        );



        //insert our virtualjournal into the patterns table
        App::import('model', 'Pattern');
        $Pattern = new Pattern();

        $Pattern->create();
        $Pattern->save($patternsDbData);


        //write patterns yaml to drupal path
        file_put_contents($drupal_path.$path.$fileName, $virtualjournalDataYAML);

        /** EXPERIMENTAL *******/

    }

    public function delete($id) {

        //check if this is the users journal
        $virtualjournal = $this->Virtualjournal->find('first', array('conditions' => array('_id' => $id)));

        if($virtualjournal['Virtualjournal']['created_by'] == $this->Session->read('User.user.username')){

            if ($this->Virtualjournal->delete($id)) {
                $message = 'Deleted';
            } else {
                $message = 'Error';
            }

        }else{
            $message = 'Unauthorized';
        }


       
        $this->set(array(
            'message' => $message,
            '_serialize' => array('message')
        ));

        exit();
    }


    /** EXPERIMENTAL *******/
    /*
    {

        get all concepts
          "query": {
            "query_string": {
              "query": "*"
            }
          },
          "facets": {
            "tags": {
              "terms": {
                "field": "alchemy_concepts",
                "size": 100
              }
            }
          }
        }

        boosted search
        {
          "query": {
            "query_string": {
              "query": "(networks)^10"
            }
          },
          "facets": {
            "tags": {
              "terms": {
                "field": "alchemy_concepts",
                "size": 100
              }
            }
          }
        }


        {"query":
            {"bool":
                {"must":
                    [{"term": {"paper.authors":""}},{"term":{"paper.references":""}},{"query_string":{"default_field":"_all","query":"d"}}],
                    "must_not":[],
                    "should":[]
                }
            },
            "from":0,
            "size":50,
            "sort":[],
            "facets":{
                "tags": {
                    "terms": {
                        "field": "alchemy_concepts",
                        "size": 100
                    }
            }}
        }
    */

    public function experimental($type = '') {

        $keywords5 = rtrim($_POST['keywords5']);
        $keywords3 = rtrim($_POST['keywords3']);
        $keywords1 = rtrim($_POST['keywords1']);

        $references =  rtrim($_POST['references']);

        if($keywords5){$keywords5 = str_replace("\r\n", " OR ", $keywords5); $q_keywords .= '('.$keywords5.')^5 '; }
        if($keywords3){$keywords3 = str_replace("\r\n", " OR ", $keywords3); $q_keywords .= 'OR ('.$keywords3.')^3 '; }
        if($keywords1){$keywords1 = str_replace("\r\n", " OR ", $keywords1); $q_keywords .= 'OR ('.$keywords1.')^1 '; }
        
        if($references){$references = str_replace("\r\n", " OR ", $references); $q_references .= '('.$references.')^'.$_POST['refweight'].' '; }


        echo '
            <h3>Search</h3>
            <h4>1 Keyword per line</h4>
            <form action="http://vijo.inn.ac/api/virtualjournals/experimental/query" method="POST">
                <fieldset>
                    <legend>Your Virtual Journal</legend>

                    Keywords - <b>5</b> Points (input * to skip keyword search):<br />
                    <textarea name="keywords5" type="input" style="height: 100px;max-height:100px;width:600px">'.@$_POST['keywords5'].'</textarea><br /><br />

                    Keywords - <b>3</b> Points (input * to skip keyword search):<br />
                    <textarea name="keywords3" type="input" style="height: 100px;max-height:100px;width:600px">'.@$_POST['keywords3'].'</textarea><br /><br />

                    Keywords - <b>1</b> Points (input * to skip keyword search):<br />
                    <textarea name="keywords1" type="input" style="height: 100px;max-height:100px;width:600px">'.@$_POST['keywords1'].'</textarea><br /><br />


                    In References ( <select name="refweight">
                        <option>1</option>
                        <option>3</option>
                        <option>5</option>
                        <option>11</option>
                    </select> Points):<br />
                    <textarea name="references" type="input" style="height: 100px;max-height:100px;width:600px">'.@$_POST['references'].'</textarea><br /><br />
                   

                    <br/><br/>

                    <input type="submit" />
                </fieldset>
            </form>

            <h3>Results</h3>
            <h4>Keyword weighting: <font color="red">'.$q_keywords.' OR '.$q_references.'</font></h4>
            
        ';

        
        if(!$q_references){$q_references = '*';}

        $query = '{"query":
                        {"bool":
                            {"should":
                                [
                                    {"query_string":{"default_field":"paper.references","query":"'.@$q_references.'"}},
                                    {
                                      "range" : {
                                        "publication_date" : {
                                          "boost" : 10,
                                          "gte" : "'.date('Y-m-d', strtotime('-1 months')).'"
                                        }
                                      }
                                    },
                                    {
                                      "range" : {
                                        "publication_date" : {
                                          "boost" : 2,
                                          "gte" : "'.date('Y-m-d', strtotime('-6 months')).'"
                                        }
                                      }
                                    },
                                    {
                                      "range" : {
                                        "publication_date" : {
                                          "boost" : 1,
                                          "gte" : "'.date('Y-m-d', strtotime('-2 years')).'"
                                        }
                                      }
                                    }
                                    
                                ],
                                "must_not":[],
                                "must":[
                                    {"query_string":{"fields" : ["abstract^5", "title^2", "authors"], "query":"'.$q_keywords.'", "use_dis_max" : true}}
                                ]
                            }
                        },
                        "from":0,
                        "size":50,
                        "sort":[],
                        "facets":{
                            "tags": {
                                "terms": {
                                    "field": "alchemy_concepts",
                                    "size": 100
                                }
                        }}
                    }';

        $search_url = 'http://inn.ac:9200/publications/_search';

        $json_results = $this->CurlHTTP->Post($search_url, $query, '', 0);
        $results = json_decode($json_results, 1);


        foreach ($results['facets']['tags']['terms'] as $kw) {
            echo $kw['term'].', ';
        }
        echo '<br/>';
        echo '<br/>';


        echo('Found: '.$results['hits']['total'] .'<br /><br/>');

        foreach ($results['hits']['hits'] as $result) {
            echo $result['_score'] .' - ';
            echo $result['_source']['value']['title'];
            echo $result['_source']['title'] . ' -- <b>';
            echo $result['_source']['value']['authors'];
            echo $result['_source']['authors'] . '</b> -- ';
            echo $result['_source']['value']['source'];
            echo $result['_source']['source'] . ' - published on: ' ;
            echo $result['_source']['publication_date'] . '';
            echo '<br><br/><b>Abstract:</b><br/>';

            if(is_array($result['_source']['abstract'])){ echo $result['_source']['abstract'][0]; }else{ echo $result['_source']['abstract']; echo $result['_source']['value']['abstract']; }
            echo '<hr>';

        }


        exit();
    }
    /** EXPERIMENTAL *******/





    private function patterns_utils_get_uuuid() {

    // The field names refer to RFC 4122 section 4.1.2

    return sprintf('%04x%04x-%04x-%03x4-%04x-%04x%04x%04x',
        mt_rand(0, 65535), mt_rand(0, 65535), // 32 bits for "time_low"
        mt_rand(0, 65535), // 16 bits for "time_mid"
        mt_rand(0, 4095),  // 12 bits before the 0100 of (version) 4 for "time_hi_and_version"
        bindec(substr_replace(sprintf('%016b', mt_rand(0, 65535)), '01', 6, 2)),
            // 8 bits, the last two of which (positions 6 and 7) are 01, for "clk_seq_hi_res"
            // (hence, the 2nd hex digit after the 3rd hyphen can only be 1, 5, 9 or d)
            // 8 bits for "clk_seq_low"
        mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535) // 48 bits for "node"
    );
}
}