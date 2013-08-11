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
            $virtualjournalsclean[] = array(
                'id'=> @$virtualjournal['Virtualjournal']['_id'], 
                'title' => @$virtualjournal['Virtualjournal']['title'], 
                'discipline' => @$virtualjournal['Virtualjournal']['discipline'], 
                'description' => @$virtualjournal['Virtualjournal']['description'],
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

        if(@$virtualjournal['Virtualjournal']['minimum_amount_of_tweets']){
            $mintweets = @$virtualjournal['Virtualjournal']['minimum_amount_of_tweets'];
        }else{
            $mintweets = '0';
        }

        //perform elasticsearch query
        $virtualjournalQuery = '{
                                    "query": {
                                        "bool": {
                                            "should": [
                                                {
                                                    "text": {
                                                        "paper.title": "'.@$virtualjournal['Virtualjournal']['title_contains'].'"
                                                    }
                                                },
                                                {
                                                    "text": {
                                                        "paper.abstract": "'.@$virtualjournal['Virtualjournal']['abstract_contains'].'"
                                                    }
                                                },
                                                {
                                                    "text": {
                                                        "paper.journal": "'.@$virtualjournal['Virtualjournal']['is_published_in'].'"
                                                    }
                                                },
                                                {
                                                    "text": {
                                                        "paper.authors": "'.@$virtualjournal['Virtualjournal']['papers_similar_to_author'].'"
                                                    }
                                                },
                                                {
                                                    "range": {
                                                        "paper.twitter": {
                                                            "from":"'.$mintweets.'",
                                                            "to":"9999999"
                                                        }
                                                    }
                                                }
                                            ],
                                            "must": []
                                        }
                                    },
                                    "from": 0,
                                    "size": 50,
                                    "sort": [],
                                    "facets": {}
                                }';

        //dont search if not explicitly requested!
        if($_GET['publicationstream'] == 'true'){
            $publicationStreamRaw = $this->CurlHTTP->Post('http://inn.ac:9200/_search', $virtualjournalQuery, 'vijo', 0);
            $publicationStream = json_decode($publicationStreamRaw, 1);
            $publicationStream = $publicationStream['hits']['hits'];
        }else{
            $publicationStream = '';
        }

       
        $virtualjournalclean = array(
               'id'=> @$virtualjournal['Virtualjournal']['_id'], 
                'title' => @$virtualjournal['Virtualjournal']['title'], 
                'discipline' => @$virtualjournal['Virtualjournal']['discipline'], 
                'description' => @$virtualjournal['Virtualjournal']['description'],
                'created' => @date('Y-M-d H:i:s', $virtualjournal['Virtualjournal']['created']->sec),
                'title_contains'=> @$virtualjournal['Virtualjournal']['title_contains'],
                'abstract_contains'=> @$virtualjournal['Virtualjournal']['abstract_contains'],
                'papers_similar_to_author'=> @$virtualjournal['Virtualjournal']['papers_similar_to_author'],
                'papers_similar_to_keywords'=> @$virtualjournal['Virtualjournal']['papers_similar_to_keywords'],
                'minimum_amount_of_tweets'=> @$virtualjournal['Virtualjournal']['minimum_amount_of_tweets'],
                'institution'=> @$virtualjournal['Virtualjournal']['institution'],
                'is_published_in'=> @$virtualjournal['Virtualjournal']['is_published_in'],
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


        $this->Virtualjournal->create();
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
                'title' => 'Dirks favorites',
                'description' => 'papers by dirk',
                'author' => 'Dirk Helbing',
                'category' => 'Test',
                'version' => '1.0',
                'core' => '7.x',
                'author_website' => 'http://helbing.org',
                'author_email' => 'dirk.helbing@gess.ethz.ch'
            ),

            'actions' => array(
                array(
                    'create'=>array(
                        'authors'=>'Dirk Helbing',
                        'discipline'=>'social sciences',
                        'title_contains'=>'Networks',
                        'abstract_contains'=>'Economics',
                        'papers_similar_to_author'=>'Stefano Balietti',
                        'papers_by_author'=>'',
                        'papers_similar_to_keywords'=>'networks, connectivity, users'
                    )
                )
            )

        );

        //YAML encode the virtualjournal
        $virtualjournalDataYAML = Spyc::YAMLDump($virtualjournalData);


        //patterns table data structure
        $path = 'profiles/qscience_profile/patterns/';
        $fileName = 'lipsum'.rand(0,100000).'.yaml';

        

        $patternsDbData = array(
            'Pattern' => array(
                'name' => $fileName,
                'pattern' => serialize($virtualjournalData),
                'format' => 'yaml',
                'title' => 'Lorem Dummy Pattern - '.rand(0,100000),
                'file' => $path.$fileName,
                'descr' => '',
                'updated' => time(),
                'status' => '0',
                'uuuid' => $this->patterns_utils_get_uuuid(),
                'author' => 'vijoDummyUser'
            )
        );



        //insert our virtualjournal into the patterns table
        App::import('model', 'Pattern');
        $Pattern = new Pattern();

        $Pattern->create();
        $Pattern->save($patternsDbData);




        /** EXPERIMENTAL *******/



    }

    public function delete($id) {
        if ($this->Virtualjournals->delete($id)) {
            $message = 'Deleted';
        } else {
            $message = 'Error';
        }
        $this->set(array(
            'message' => $message,
            '_serialize' => array('message')
        ));
    }

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