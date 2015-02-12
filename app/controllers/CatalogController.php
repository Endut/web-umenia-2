<?php

class CatalogController extends \BaseController {

	public function index()
	{
		$search = Input::get('search', null);
		$input = Input::all();
		// dd($input);

		$authors = Item::listValues('author');
		$work_types = Item::listValues('work_type', ',', true);
		$tags = Item::listValues('subject');
		$galleries = Item::listValues('gallery');

		
		if (Input::has('search')) {
			$search = Input::get('search', '');
			$json_params = '
				{
				  "query": {
				  "bool": {
				    "should": [
				      { "match": {
				          "author": {
				            "query": "'.$search.'",
				            "boost": 3
				          }
				        }
				      },

				      { "match": { "title":          "'.$search.'" }},
				      { "match": { "title.stemmed": "'.$search.'" }},
				      { "match": { 
				        "title.stemmed": { 
				          "query": "'.$search.'",  
				          "analyzer" : "slovencina_synonym" 
				        }
				      }
				      },

				      { "match": {
				          "subject.folded": {
				            "query": "'.$search.'",
				            "boost": 1
				          }
				        }
				      },

				      { "match": {
				          "description": {
				            "query": "'.$search.'",
				            "boost": 1
				          }
				        }
				      },
				      { "match": {
				          "description.stemmed": {
				            "query": "'.$search.'",
				            "boost": 0.9
				          }
				        }
				      },
				      { "match": {
				          "description.stemmed": {
				            "query": "'.$search.'",
				            "analyzer" : "slovencina_synonym",
				            "boost": 0.5
				          }
				        }
				      },

				      { "match": {
				          "place.folded": {
				            "query": "'.$search.'",
				            "boost": 1
				          }
				        }
				      }


				    ]
				  }
				  },
				  "size": 1000
				}
			';
			$params = json_decode($json_params, true);

			$items = Item::search($params)->paginate(18);

		} else {

			$items = Item::where(function($query) use ($search, $input) {
	                /** @var $query Illuminate\Database\Query\Builder  */
	                if (!empty($search)) {
	                	$query->where('title', 'LIKE', '%'.$search.'%')->orWhere('author', 'LIKE', '%'.$search.'%')->orWhere('subject', 'LIKE', '%'.$search.'%')->orWhere('id', 'LIKE', '%'.$search.'%');
	                }
	                if(!empty($input['author'])) {
	                	$query->where('author', 'LIKE', '%'.$input['author'].'%');
	                }
	                if(!empty($input['work_type'])) {
	                	// dd($input['work_type']);
	                	$query->where('work_type', 'LIKE', $input['work_type'].'%');
	                }
	                if(!empty($input['subject'])) {
	                	//tieto 2 query su tu kvoli situaciam, aby nenaslo pre kucove slovo napr. "les" aj diela s klucovy slovom "pleso"
	                	$query->whereRaw('( subject LIKE "%'.$input['subject'].';%" OR subject LIKE "%'.$input['subject'].'" )');
	                }
	                if(!empty($input['gallery'])) {
	                	$query->where('gallery', 'LIKE', '%'.$input['gallery'].'%');
	                }
	                if(!empty($input['year-range'])) {
	                	$range = explode(',', $input['year-range']);
	                	// dd("where('date_earliest', '>', $range[0])->where('date_latest', '<', $range[1])");
	                	$query->where('date_earliest', '>', $range[0])->where('date_latest', '<', $range[1]);
	                }
	                if(!empty($input['free_download'])) {
	                	$query->where('free_download', '=', '1')->whereNotNull('iipimg_url');
	                }

	                return $query;
	            })
	           ->orderBy('created_at', 'DESC')->paginate(18);
		}

		$queries = DB::getQueryLog();
		$last_query = end($queries);
		// dd($last_query);

		return View::make('katalog', array(
			'items'=>$items, 
			'authors'=>$authors, 
			'work_types'=>$work_types, 
			'tags'=>$tags, 
			'galleries'=>$galleries, 
			'search'=>$search, 
			'input'=>$input, 
			));
	}

	public function getSuggestions()
	{
	 	$q = (Input::has('search')) ? Input::get('search') : 'null';

		$result = Elastic::search([
	        	'type' => Item::ES_TYPE,
	        	'body'  => array(
	                'query' => array(
	                    'multi_match' => array(
	                        'query'  	=> $q,
	                        'type' 		=> 'cross_fields',
							// 'fuzziness' =>  2,
							// 'slop'		=>  2,
        	                'fields' 	=> array("author.suggest", "title.suggest"),
	                        'operator' 	=> 'and'
	                    ),
	                ),
	                'size' => '10',
	            ),        	
	      	]);

		$data = array();
		$data['results'] = array();
		$data['count'] = 0;
		// $data['items'] = array();
		foreach ($result['hits']['hits'] as $key => $hit) {
			$data['count']++;
			$data['results'][] = array_merge(
				['id' => $hit['_id']],
				$hit['_source']
			) ;
		}

	    return Response::json($data);	
	}


}