<?php
class Grid_generator extends CI_Model {

    protected $arrayToSelect;
    public $arrayOfWhereCond;
    protected $arrayToSort;
    protected $arrayOfOrder;
    protected $multiple_arrayOfOrder;
    protected $arrayOfWhereInCond;
    protected $like;
    protected $arrayOfGroup;
    protected $message;
    protected $tableName;
    protected $status;
    protected $controllerFunction;
    protected $is_search;
    protected $is_join_set;
    public $arrayOfData;
    protected $between;
    protected $arrayOfJoin = array(
        "table" => array(
            "condition" => "",
            "type" => "left"
        )
    );
    protected $listing_category = array(
        "all" => "getAll",
        "active" => "getActive",
        "inactive" => "getPending",
        "newest" => "getNewest",
        "oldest" => "getOldest",
        "sold" => "getSold",
        "joined" => "getJoined",
        "not_joined" => "getNotJoined"
    );
    protected $arrayOfCategory = array(
        "category" => "all",
        "page" => 1,
        "sortby" => "",
        "order" => "",
        "search" => "",
        "search_filter" => ""
    );
    protected $arrayOfAction = array(
        "spec" => array("current_page" => 1),
        "action" => array(
            "ban" => "ban",
            "delete" => "delete",
            "deleteSelected" => "deleteSelected",
            "changePosition" => "changePosition",
            "setTopPosition" => "setTopPosition"
        )
    );

    const SELECTED_DELTED_SUCCESSFULLY = "selected elements successfully deleted";
    const SELECTED_NOT_DELTED = "selected elements not deleted";

    public function __construct($arrayOfParam) {
        parent::__construct();
        $this->tableName = $arrayOfParam[0];
        $this->controllerFunction = $arrayOfParam[1];
        $this->status = $arrayOfParam[2];

//        $this->load->library("pagination_extended", NULL, "pagination");
        $this->load->library('pagination_extended');
    }

    public function setSelect(array $arrayOfSelect) {
        $this->arrayToSelect = $arrayOfSelect;
    }

    public function setWhereCond(array $arrayOfWhereCond) {
        $this->arrayOfWhereCond = $arrayOfWhereCond;
    }

    public function setOrderBy(array $arrayOfOrder) {
        $this->arrayOfOrder = $arrayOfOrder;
    }

    //========start to multiple order by===========//
    public function setOrder_By(array $multiple_arrayOfOrder) {

        $this->multiple_arrayOfOrder = $multiple_arrayOfOrder;
    }
    //=======End===//


    public function setGroupBy(array $arrayOfGroup) {
        $this->arrayOfGroup = $arrayOfGroup;
    }

    public function setJoin(array $arrayOfJoin) {
        $this->is_join_set = TRUE;
        $this->arrayOfJoin = $arrayOfJoin;
    }

    public function setBetween(array $between) {
        $this->between = $between;
    }

    public function setListingCategory(array $listingCategory) {
        $this->listing_category = $listingCategory;
    }

    public function setCategory(array $arrayOfCategory) {
        $this->arrayOfCategory = $arrayOfCategory;
    }

    public function setAction(array $arrayOfAction) {
        $this->arrayOfAction = $arrayOfAction;
    }

    public function read($arrayOfSpec) {
        if ($arrayOfSpec != NULL) {

            //Checking if any category is set or not...
            if ($this->arrayOfCategory != NULL) {
                foreach ($this->arrayOfCategory as $category => $defaultValue) {
                    if (isset($arrayOfSpec[$category]) && !empty($arrayOfSpec[$category])) {
                        //set arrayOfData
                        $this->arrayOfData[$category] = urldecode($this->db->escape_str($arrayOfSpec[$category]));
                    } else {
                        //category is empty set default value for category...
                        $this->arrayOfData[$category] = urldecode($this->db->escape_str($defaultValue));
                    }
                }
            } else {
                
            }

//            echo "<pre>";
//            print_r($this->arrayOfData);
//            echo "</pre>";
            //Checking if any action is set or not
            if ($this->arrayOfAction != NULL) {
                //check for the action spec
                if ($this->arrayOfAction['spec'] != NULL) {
                    foreach ($this->arrayOfAction['spec'] as $spec => $defaultValue) {
                        if (isset($arrayOfSpec[$spec]) && !empty($arrayOfSpec[$spec])) {
                            //set arrayOfData
                            $this->arrayOfData[$spec] = $this->db->escape_str($arrayOfSpec[$spec]);
                        } else {
                            //category is empty set default value for category...
                            $this->arrayOfData[$spec] = $this->db->escape_str($defaultValue);
                        }
                    }
                } else {
                    //arrayOfSpec spec is null... message...
                }


                //check for the actual action 
                if ($this->arrayOfAction['action'] != NULL) {
                    if (isset($arrayOfSpec['action']) && !empty($arrayOfSpec['action'])) {
                        foreach ($this->arrayOfAction['action'] as $action => $methodToCall) {
                            if ($arrayOfSpec['action'] == $action) {
                                //call the specified method for the action set...
                                $this->message = $this->$methodToCall($arrayOfSpec);
                            }
                        }
                    }
                } else {
                    //arrayOfSepc action is null... message...
                }
            } else {
                //arrayOfAction is null... message...
            }
        } else {
            //arrayOfSpec is null... message...
            foreach ($this->arrayOfCategory as $category => $defaultValue) {
                //category is empty set default value for category...
                $this->arrayOfData[$category] = $this->db->escape_str($defaultValue);
            }
            foreach ($this->arrayOfAction['spec'] as $spec => $defaultValue) {
                //category is empty set default value for category...
                if ($spec == "current_page") {
                    $this->arrayOfData[$spec] = $this->arrayOfData['page'];
                } else {
                    $this->arrayOfData[$spec] = $this->db->escape_str($arrayOfSpec[$spec]);
                }
            }
        }

        //Checking and executing code accorging to the category...
        if ($this->arrayOfData['category'] != NULL) {
            if ($this->listing_category != NULL) {
                foreach ($this->listing_category as $category => $methodToCall) {
                    if ($this->arrayOfData['category'] == $category) {
                        $result = $this->$methodToCall();
                    }
                }
            }
        }

        if (isset($result) && !empty($result)) {
            return $result;
        } else {
            return FALSE;
        }
    }

    public function getAll() {


        if ($this->is_join_set === TRUE) {
            if ($this->arrayOfJoin != NULL) {
                foreach ($this->arrayOfJoin as $table => $arrayOfArray) {
                    if (is_array($arrayOfArray) && !empty($arrayOfArray)) {
                        $this->db->join($table, $arrayOfArray['condition'], isset($arrayOfArray['type']) ? $arrayOfArray['type'] : "inner" );
                    }
                }
            }
        }

        if ($this->arrayOfWhereCond != NULL) {
            foreach ($this->arrayOfWhereCond as $column => $value) {
                $this->db->where($column, $value);
            }
        }

        if ($this->between != NULL) {
            $from = urldecode($this->between['from']);
            $to = urldecode($this->between['to']);
            $this->db->where("{$this->between['column']} BETWEEN '{$from}' AND '{$to}'");
        }

        if ($this->arrayOfGroup != NULL && (count($this->arrayOfGroup) > 0)) {
            $this->db->group_by($this->arrayOfGroup['groupby']);
        }

        if ($this->multiple_arrayOfOrder != NULL && (count($this->multiple_arrayOfOrder) > 0)) {

            foreach ($this->multiple_arrayOfOrder as $key => $value_order) {
                //var_dump($key);
                //echo $this->multiple_arrayOfOrder[$key]['sortby'];
                // echo $this->multiple_arrayOfOrder[$key]['order'];
                //var_dump($value_order);
                $this->db->order_by($value_order['sortby'], $value_order['order']);
            }
            //var_dump($this->multiple_arrayOfOrder);die;

            $this->db->stop_cache();
        }


        if (isset($this->arrayOfData['search']) && !empty($this->arrayOfData['search'])) {
            //search is set...
            if (isset($this->arrayOfData['search_filter']) && !empty($this->arrayOfData['search_filter'])) {
                $this->is_search = TRUE;

                $this->db->like($this->arrayOfData['search_filter'], $this->arrayOfData['search']);
//                $counts = $this->db->count_all_results($this->tableName);
//                $counts = count($this->db->get());
                
                $this->db->from($this->tableName);
                $counts = count($this->db->get()->result());

//                echo "counts". $counts;
//                echo $this->db->last_query();
//                die();
                $result = $this->getResult($counts);
            }
        } else {
            //search is not set...
//            $counts = $this->db->count_all_results($this->tableName);
            
            $this->db->from($this->tableName);
            $counts = count($this->db->get()->result());
            
//            echo "counts". $counts;
//            echo $this->db->last_query();
//            die;
            $result = $this->getResult($counts);
        }
        return $result;
    }

    public function getActive() {
  if(is_array($this->arrayOfWhereCond)){
       
      $this->arrayOfWhereCond = array_merge($this->arrayOfWhereCond, array($this->status => '1'));

  }else{
         $this->arrayOfWhereCond = array($this->status => '1');
  }
      
        if ($this->is_join_set === TRUE) {
            if ($this->arrayOfJoin != NULL) {
                foreach ($this->arrayOfJoin as $table => $arrayOfArray) {
                    if (is_array($arrayOfArray) && !empty($arrayOfArray)) {
                        $this->db->join($table, $arrayOfArray['condition'], isset($arrayOfArray['type']) ? $arrayOfArray['type'] : "inner" );
                    }
                }
            }
        }

        $this->db->where($this->status, '1');

        if ($this->arrayOfWhereCond != NULL) {
            foreach ($this->arrayOfWhereCond as $column => $value) {
                $this->db->where($column, $value);
            }
        }

        if ($this->between != NULL) {
            $from = urldecode($this->between['from']);
            $to = urldecode($this->between['to']);
            $this->db->where("{$this->between['column']} BETWEEN '{$from}' AND '{$to}'");
        }

        if ($this->arrayOfGroup != NULL && (count($this->arrayOfGroup) > 0)) {
            $this->db->group_by($this->arrayOfGroup['groupby']);
        }

        if (isset($this->arrayOfData['search']) && !empty($this->arrayOfData['search'])) {
            //search is set...
            if (isset($this->arrayOfData['search_filter']) && !empty($this->arrayOfData['search_filter'])) {
                $this->is_search = TRUE;

                $this->db->like($this->arrayOfData['search_filter'], $this->arrayOfData['search']);
                //$counts = $this->db->count_all_results($this->tableName);
                $this->db->from($this->tableName);
                $counts = count($this->db->get()->result());
                
                $result = $this->getResult($counts);
            }
        } else {
            //search is not set...
            //$counts = $this->db->count_all_results($this->tableName);
            $this->db->from($this->tableName);
            $counts = count($this->db->get()->result());
            
            $result = $this->getResult($counts);
        }
        return $result;
    }

    public function getPending() {
        
           if(is_array($this->arrayOfWhereCond)){
                  $this->arrayOfWhereCond = array_merge($this->arrayOfWhereCond, array($this->status => '0'));
           }else{
               $this->arrayOfWhereCond = array($this->status => '0');
           }
     
        //

        if ($this->is_join_set === TRUE) {
            if ($this->arrayOfJoin != NULL) {
                foreach ($this->arrayOfJoin as $table => $arrayOfArray) {
                    if (is_array($arrayOfArray) && !empty($arrayOfArray)) {
                        $this->db->join($table, $arrayOfArray['condition'], isset($arrayOfArray['type']) ? $arrayOfArray['type'] : "inner" );
                    }
                }
            }
        }

        $this->db->where($this->status, '0');

        if ($this->arrayOfWhereCond != NULL) {
            foreach ($this->arrayOfWhereCond as $column => $value) {
                $this->db->where($column, $value);
            }
        }

        if ($this->between != NULL) {
            $from = urldecode($this->between['from']);
            $to = urldecode($this->between['to']);
            $this->db->where("{$this->between['column']} BETWEEN '{$from}' AND '{$to}'");
        }

        if ($this->arrayOfGroup != NULL && (count($this->arrayOfGroup) > 0)) {
            $this->db->group_by($this->arrayOfGroup['groupby']);
        }


        if (isset($this->arrayOfData['search']) && !empty($this->arrayOfData['search'])) {
            //search is set...
            if (isset($this->arrayOfData['search_filter']) && !empty($this->arrayOfData['search_filter'])) {
                $this->is_search = TRUE;

                $this->db->like($this->arrayOfData['search_filter'], $this->arrayOfData['search']);
                //$counts = $this->db->count_all_results($this->tableName);
                $this->db->from($this->tableName);
                $counts = count($this->db->get()->result());
                $result = $this->getResult($counts);
            }
        } else {
            //search is not set...
            //$counts = $this->db->count_all_results($this->tableName);
            $this->db->from($this->tableName);
            $counts = count($this->db->get()->result());
            $result = $this->getResult($counts);
        }
        return $result;
    }

    public function getSold() {
        if(is_array($this->arrayOfWhereCond)){
             $this->arrayOfWhereCond = array_merge($this->arrayOfWhereCond, array($this->status => '2'));
       
        }else{
             $this->arrayOfWhereCond = array($this->status => '2');
        }
       

        if ($this->is_join_set === TRUE) {
            if ($this->arrayOfJoin != NULL) {
                foreach ($this->arrayOfJoin as $table => $arrayOfArray) {
                    if (is_array($arrayOfArray) && !empty($arrayOfArray)) {
                        $this->db->join($table, $arrayOfArray['condition'], isset($arrayOfArray['type']) ? $arrayOfArray['type'] : "inner" );
                    }
                }
            }
        }

        $this->db->where($this->status, '2');

        if ($this->arrayOfWhereCond != NULL) {
            foreach ($this->arrayOfWhereCond as $column => $value) {
                $this->db->where($column, $value);
            }
        }

        if ($this->between != NULL) {
            $from = urldecode($this->between['from']);
            $to = urldecode($this->between['to']);
            $this->db->where("{$this->between['column']} BETWEEN '{$from}' AND '{$to}'");
        }

        if ($this->arrayOfGroup != NULL && (count($this->arrayOfGroup) > 0)) {
            $this->db->group_by($this->arrayOfGroup['groupby']);
        }


        if (isset($this->arrayOfData['search']) && !empty($this->arrayOfData['search'])) {
            //search is set...
            if (isset($this->arrayOfData['search_filter']) && !empty($this->arrayOfData['search_filter'])) {
                $this->is_search = TRUE;


                $this->db->like($this->arrayOfData['search_filter'], $this->arrayOfData['search']);
                //$counts = $this->db->count_all_results($this->tableName);
                $this->db->from($this->tableName);
                $counts = count($this->db->get()->result());
                $result = $this->getResult($counts);
            }
        } else {
            //search is not set...

            //$counts = $this->db->count_all_results($this->tableName);
            $this->db->from($this->tableName);
            $counts = count($this->db->get()->result());
            $result = $this->getResult($counts);
        }
        return $result;
    }

    public function getNewest() {

        $this->arrayToSort = array("sortby" => "created_on", "order" => "DESC");

        if ($this->is_join_set === TRUE) {
            if ($this->arrayOfJoin != NULL) {
                foreach ($this->arrayOfJoin as $table => $arrayOfArray) {
                    if (is_array($arrayOfArray) && !empty($arrayOfArray)) {
                        $this->db->join($table, $arrayOfArray['condition'], isset($arrayOfArray['type']) ? $arrayOfArray['type'] : "inner" );
                    }
                }
            }
        }

        if ($this->arrayOfWhereCond != NULL) {
            foreach ($this->arrayOfWhereCond as $column => $value) {
                $this->db->where($column, $value);
            }
        }

        if ($this->between != NULL) {
            $from = urldecode($this->between['from']);
            $to = urldecode($this->between['to']);
            $this->db->where("{$this->between['column']} BETWEEN '{$from}' AND '{$to}'");
        }


        if ($this->arrayOfGroup != NULL && (count($this->arrayOfGroup) > 0)) {
            $this->db->group_by($this->arrayOfGroup['groupby']);
        }


        if (isset($this->arrayOfData['search']) && !empty($this->arrayOfData['search'])) {
            //search is set...
            if (isset($this->arrayOfData['search_filter']) && !empty($this->arrayOfData['search_filter'])) {
                $this->is_search = TRUE;

                $this->db->like($this->arrayOfData['search_filter'], $this->arrayOfData['search']);
                //$counts = $this->db->count_all_results($this->tableName);
                $this->db->from($this->tableName);
                $counts = count($this->db->get()->result());
                $result = $this->getResult($counts);
            }
        } else {
            //search is not set...
            //$counts = $this->db->count_all_results($this->tableName);
            $this->db->from($this->tableName);
            $counts = count($this->db->get()->result());
            $result = $this->getResult($counts);
        }
        return $result;
    }

    public function getOldest() {

        $this->arrayToSort = array("sortby" => "created_on", "order" => "ASC");

        if ($this->is_join_set === TRUE) {
            if ($this->arrayOfJoin != NULL) {
                foreach ($this->arrayOfJoin as $table => $arrayOfArray) {
                    if (is_array($arrayOfArray) && !empty($arrayOfArray)) {
                        $this->db->join($table, $arrayOfArray['condition'], isset($arrayOfArray['type']) ? $arrayOfArray['type'] : "inner" );
                    }
                }
            }
        }

        if ($this->arrayOfWhereCond != NULL) {
            foreach ($this->arrayOfWhereCond as $column => $value) {
                $this->db->where($column, $value);
            }
        }

        if ($this->between != NULL) {
            $from = urldecode($this->between['from']);
            $to = urldecode($this->between['to']);
            $this->db->where("{$this->between['column']} BETWEEN '{$from}' AND '{$to}'");
        }

        if ($this->arrayOfGroup != NULL && (count($this->arrayOfGroup) > 0)) {
            $this->db->group_by($this->arrayOfGroup['groupby']);
        }

        if (isset($this->arrayOfData['search']) && !empty($this->arrayOfData['search'])) {
            //search is set...
            if (isset($this->arrayOfData['search_filter']) && !empty($this->arrayOfData['search_filter'])) {
                $this->is_search = TRUE;

                $this->db->like($this->arrayOfData['search_filter'], $this->arrayOfData['search']);
                //$counts = $this->db->count_all_results($this->tableName);
                $this->db->from($this->tableName);
                $counts = count($this->db->get()->result());
                $result = $this->getResult($counts);
            }
        } else {
            //search is not set...
            //$counts = $this->db->count_all_results($this->tableName);
            $this->db->from($this->tableName);
            $counts = count($this->db->get()->result());
            $result = $this->getResult($counts);
        }
        return $result;
    }

    public function getResult($counts = 0) {
        $this->pagination_extended->setParams($this->arrayOfData['page'], $counts);
        $offset = $this->pagination_extended->offset();
        $limit = $this->pagination_extended->per_page;

        if ($this->arrayToSelect != NULL) {
            $this->db->select($this->arrayToSelect);
        } else {
            $this->db->select("*");
        }

        if ($this->is_join_set === TRUE) {
            $this->db->from($this->tableName);
            if ($this->arrayOfJoin != NULL) {
                foreach ($this->arrayOfJoin as $table => $arrayOfArray) {
                    if (is_array($arrayOfArray) && !empty($arrayOfArray)) {
                        $this->db->join($table, $arrayOfArray['condition'], isset($arrayOfArray['type']) ? $arrayOfArray['type'] : "inner" );
                    }
                }
            }
        }

        if ($this->arrayOfWhereCond != NULL) {
            foreach ($this->arrayOfWhereCond as $column => $value) {
                $this->db->where($column, $value);
            }
        }

        if ($this->between != NULL) {
            $from = urldecode($this->between['from']);
            $to = urldecode($this->between['to']);
            $this->db->where("{$this->between['column']} BETWEEN '{$from}' AND '{$to}'");
        }

        if ($this->is_search === TRUE) {
            
             /*changes by cdp*/
            if ($this->tableName == 'review_rating' && $this->arrayOfData['search_filter'] == 'users.display_name') {
                $this->db->where("(nm_users.display_name LIKE '".$this->arrayOfData["search"]."%' OR  nm_review_rating.review_rating_author LIKE '".$this->arrayOfData["search"]."%')" );
                
            } else {
               $this->db->like($this->arrayOfData['search_filter'], $this->arrayOfData['search']);
            }
           
        }

        if (isset($this->arrayOfData['sortby']) && !empty($this->arrayOfData['sortby'])) {
            if (isset($this->arrayOfData['order']) && !empty($this->arrayOfData['order'])) {
                $this->db->order_by($this->arrayOfData['sortby'], $this->arrayOfData['order']);
            }
        }

        if ($this->arrayToSort != NULL && (count($this->arrayToSort) > 0)) {
            $this->db->order_by($this->arrayToSort['sortby'], $this->arrayToSort['order']);
        }

        if ($this->multiple_arrayOfOrder != NULL && (count($this->multiple_arrayOfOrder) > 0)) {

            foreach ($this->multiple_arrayOfOrder as $key => $value_order) {
                //var_dump($key);
                //echo $this->multiple_arrayOfOrder[$key]['sortby'];
                // echo $this->multiple_arrayOfOrder[$key]['order'];
                //var_dump($value_order);
                $this->db->order_by($value_order['sortby'], $value_order['order']);
            }
            //var_dump($this->multiple_arrayOfOrder);die;

            $this->db->stop_cache();
        }
		
		if($this->tableName != 'product'){
			if ($this->arrayOfOrder != NULL && (count($this->arrayOfOrder) > 0)) {
				$this->db->order_by($this->arrayOfOrder['sortby'], $this->arrayOfOrder['order']);
			}
		}else{
			$this->db->order_by('product_created', 'DESC');
		}

        if ($this->arrayOfGroup != NULL && (count($this->arrayOfGroup) > 0)) {
            $this->db->group_by($this->arrayOfGroup['groupby']);
        }

        $this->db->limit($limit);
        $this->db->offset($offset);

		//print_r($arrayToSort);

        if ($this->is_join_set === TRUE) {
            $query = $this->db->get();
        } else {
            $query = $this->db->get($this->tableName);
        }
		//echo "<br/><br/><br/><br/><br/><br/>";
		//echo $counts;
		//echo "<br/>";
      	//echo $this->db->last_query();
      	//unset page element from the arrayOfData;
        $this->arrayOfData["current_page"] = $this->arrayOfData['page'];
        unset($this->arrayOfData['page']);

        $pagination = $this->pagination_extended->printPaginationBar($this->controllerFunction, ($this->arrayOfData != NULL) ? $this->arrayOfData : NULL);
        if ($query->num_rows() != 0) {
            $data = array();
            if ($this->message != NULL) {
                $data['message'] = $this->message;
            }
            $data['result'] = $query->result();
            $data['pagination'] = $pagination;
            $data['data'] = $this->arrayOfData;
            $data['query'] = $this->db->last_query();
            return $data;
        } else {
            return FALSE;
        }
    }

    public function deleteSelected($arrayOfSpec) {
		$this->arrayOfData['page'] = $arrayOfSpec['current_page'];
        if ($arrayOfSpec != NULL) {
            $this->arrayOfData['page'] = $arrayOfSpec['current_page'];
            if (isset($arrayOfSpec['checked']) && !empty($arrayOfSpec['checked'])) {
                $i = 0;
                foreach ($arrayOfSpec['checked'] as $value) {
                    $this->db->where("ID", $value);
					
					//====START:TO ADD FOR SOFT DELETE=====//
					if($this->tableName == 'ring'){
						$datas = array();
						$datas['ring_status'] = '3';
						if($this->db->update($this->tableName,$datas)) {
                        	$i++;
                    	}	
					}else{ //put original code in else condition
						if($this->db->delete($this->tableName)) {
							$i++;
						}
					}
					//====END:TO ADD FOR SOFT DELETE=====//
				}

                if ($i === count($arrayOfSpec['checked'])) {
                    return self::SELECTED_DELTED_SUCCESSFULLY;
                } else {
                    return self::SELECTED_NOT_DELTED;
                }
            } else {
                //no checkboxes selected...
            }
        } else {
            //arrayOfSpec is null...
        }
    }

    public function changePosition($arrayOfSpec) {
        $this->arrayOfData['page'] = $arrayOfSpec['current_page'];
        if ($arrayOfSpec != NULL) {
            $state = $arrayOfSpec['state'];
            $currentPosition = $arrayOfSpec['position'];
            $category_filter_id = $arrayOfSpec['category_filter'];
            $id = $arrayOfSpec['id'];
            $table = $this->db->dbprefix($this->tableName);

            if ($state == "up") {
                $query = "SELECT id,category_id , ringPosition FROM nm_ring_category ";
                $query .= " WHERE ringPosition = ";
                $query .= "( SELECT min( ringPosition ) FROM nm_ring_category WHERE
                ringPosition > {$currentPosition} AND category_id = {$category_filter_id} )
                AND category_id = {$category_filter_id}";
                $resultSet = $this->db->query($query);
                $result = array_shift($resultSet->result_array());
            } else {
                $query = "SELECT id ,category_id, ringPosition FROM nm_ring_category ";
                $query .= "WHERE ringPosition = ";
                $query .= "( SELECT max( ringPosition ) FROM nm_ring_category WHERE
                ringPosition < {$currentPosition} AND category_id = {$category_filter_id} )
                AND category_id = {$category_filter_id}";
                $resultSet = $this->db->query($query);
                $result = array_shift($resultSet->result_array());
            }

            $id2 = $result['id'];
            $position2 = $result["ringPosition"];

            $query = "";
            $query = "UPDATE nm_ring_category SET ringPosition = {$currentPosition} WHERE id = {$id2}";
            $this->db->query($query);

            $query = "";
            $query = "UPDATE nm_ring_category SET ringPosition = {$position2} WHERE id = {$id}";
            $this->db->query($query);
        }
    }

    /*public function changePosition($arrayOfSpec) {
        $this->arrayOfData['page'] = $arrayOfSpec['current_page'];
        if ($arrayOfSpec != NULL) {
            $state = $arrayOfSpec['state'];
            $currentPosition = $arrayOfSpec['position'];
            $id = $arrayOfSpec['id'];
            $table = $this->db->dbprefix($this->tableName);

            if ($state == "up") {
                $query = "SELECT id , {$this->tableName}_position FROM {$table} ";
                $query .= "WHERE {$this->tableName}_position = ";
                $query .= "( SELECT min( {$this->tableName}_position ) FROM {$table} WHERE {$this->tableName}_position > {$currentPosition} )";
                $resultSet = $this->db->query($query);
                $result = array_shift($resultSet->result_array());
            } else {
                $query = "SELECT id , {$this->tableName}_position FROM {$table} ";
                $query .= "WHERE {$this->tableName}_position = ";
                $query .= "( SELECT max( {$this->tableName}_position ) FROM {$table} WHERE {$this->tableName}_position < {$currentPosition} )";
                $resultSet = $this->db->query($query);
                $result = array_shift($resultSet->result_array());
            }

            $id2 = $result['id'];
            $position2 = $result[$this->tableName . "_position"];

            $query = "";
            $query = "UPDATE {$table} SET {$this->tableName}_position = {$currentPosition} WHERE id = {$id2}";
            $this->db->query($query);

            $query = "";
            $query = "UPDATE {$table} SET {$this->tableName}_position = {$position2} WHERE id = {$id}";
            $this->db->query($query);
        }
    }
*/
    public function deleteOrder($arrayOfSpec) {
        $this->load->model('orderlist/orderdetail_model');
        $this->load->model('orderlist/orderbillingdetail_model');
        $this->load->model('orderlist/ordershippingdetail_model');

        $this->arrayOfData['page'] = $arrayOfSpec['current_page'];
        if ($arrayOfSpec != NULL) {
            $this->arrayOfData['page'] = $arrayOfSpec['current_page'];
            if (isset($arrayOfSpec['checked']) && !empty($arrayOfSpec['checked'])) {
                $i = 0;
                foreach ($arrayOfSpec['checked'] as $value) {

                    //===START:TO DELETE ORDERDETAIL AND BILLING AND SHIPPING TABLE===//
                    $is_orderdetail = $this->orderdetail_model->where("orderdetail_orderMasterID", $value)
                            ->find_all(1);
                    if (isset($is_orderdetail) && !empty($is_orderdetail)) {
                        foreach ($is_orderdetail as $orderdetail_list) {
                            $is_delete = $this->db->delete('orderdetail', array('orderdetail_orderMasterID' => $value));
                        }
                    }
                    // delete billing detail
                    $is_delete_billing = $this->db->delete('orderbillingdetail', array('orderbillingdetail_orderMasterID' => $value));
                    // delete shipping detail
                    $is_delete_shipping = $this->db->delete('ordershippingdetail', array('ordershippingdetail_orderMasterID' => $value));
                    // delete shipping detail*/
                    $is_delete_orderlist = $this->db->delete('orderlist', array('ID' => $value));
                    //===END:TO DELETE ORDERDETAIL AND BILLING AND SHIPPING TABLE===//
                    $i++;
                }

                if ($i === count($arrayOfSpec['checked'])) {
                    return self::SELECTED_DELTED_SUCCESSFULLY;
                } else {
                    return self::SELECTED_NOT_DELTED;
                }
            } else {
                //no checkboxes selected...
            }
        } else {
            //arrayOfSpec is null...
        }
    }

    public function deleteProduct($arrayOfSpec) {
		$this->load->model('product/productimage_model');

        $this->arrayOfData['page'] = $arrayOfSpec['current_page'];
        if ($arrayOfSpec != NULL) {
            $this->arrayOfData['page'] = $arrayOfSpec['current_page'];
            if (isset($arrayOfSpec['checked']) && !empty($arrayOfSpec['checked'])) {
                $i = 0;
                foreach ($arrayOfSpec['checked'] as $value) {
                    //====START: TO DELETE IMAGE====// hide code for soft delete
                     /*$product_images = $this->productimage_model->where("productimage_productID", $value)
                            ->find_all(1);
                    if (isset($product_images) && !empty($product_images)) {
                        foreach ($product_images as $image) {
                            @unlink(FCPATH . 'assets/uploads/product/' . $image['productimage_image']);
                            $is_delete = $this->db->delete('productimage', array('productimage_productID' => $value));
                        }
                    }*/
                    //====END: TO DELETE IMAGE====//
                    //$is_delete_product = $this->db->delete('product', array('ID' => $value));//original
					
					//new added code for soft delete (6-5-14)
					$this->db->where("ID", $value);
					$datas = array();
					$datas['product_status'] = '3';
					$is_delete_product = $this->db->update($this->tableName, $datas);
                    $i++;
                }

                if ($i === count($arrayOfSpec['checked'])) {
                    return self::SELECTED_DELTED_SUCCESSFULLY;
                } else {
                    return self::SELECTED_NOT_DELTED;
                }
            } else {
                //no checkboxes selected...
            }
        } else {
            //arrayOfSpec is null...
        }
    }
	
	public function deleteInventory($arrayOfSpec) {
        $this->load->model('diamond_inventory/diamond_inventory_model');

        $this->arrayOfData['page'] = $arrayOfSpec['current_page'];
        if ($arrayOfSpec != NULL) {
            $this->arrayOfData['page'] = $arrayOfSpec['current_page'];
            if (isset($arrayOfSpec['checked']) && !empty($arrayOfSpec['checked'])) {
                $i = 0;
                foreach ($arrayOfSpec['checked'] as $value) {
                    //====START: TO DELETE IMAGE====//
                    $diamond_inventory = $this->diamond_inventory_model->where("ID", $value)
                            ->find_all(1);
					if (isset($diamond_inventory) && !empty($diamond_inventory)) {
                    	@unlink(FCPATH . 'assets/uploads/inventory_file/'.$diamond_inventory[0]['diamond_inventory_vendorID'].'/'. $diamond_inventory[0]['diamond_inventory_csv_file']);
                    	$is_delete = $this->db->delete('diamond_inventory', array('ID' => $value));
					}
                    //====END: TO DELETE IMAGE====//
                    $i++;
                }

                if ($i === count($arrayOfSpec['checked'])) {
                    return self::SELECTED_DELTED_SUCCESSFULLY;
                } else {
                    return self::SELECTED_NOT_DELTED;
                }
            } else {
                //no checkboxes selected...
            }
        } else {
            //arrayOfSpec is null...
        }
    }

    ///////////////////////
    public function setTopPosition($arrayOfSpec){

        $this->arrayOfData['page'] = $arrayOfSpec['current_page'];
        //$productCategoryTable = 'ds_product_category';
        $ringCategoryTable = 'nm_ring_category';
        if ($arrayOfSpec != NULL) {
            $state = $arrayOfSpec['state'];
            $positionID = $arrayOfSpec['id'];
            $position = $arrayOfSpec['position'];

            $category_filter_id = $arrayOfSpec['category_filter'];
            if($state == 'top'){
                //Set current id to top
                $query = "UPDATE {$ringCategoryTable} SET ringPosition = 1 WHERE ID = ".$positionID;
                //echo "<br/>";
                $this->db->query($query);

                //update position other positions
                $selQuery = "SELECT ID, ring_id , category_id, ringPosition  FROM {$ringCategoryTable} ";
                $selQuery .= "WHERE category_id = ".$category_filter_id." and ID != {$positionID} order by ringPosition ASC";
                $result = $this->db->query($selQuery)->result_array();
                $i=2;
                foreach($result as $value){

                    $query = "UPDATE {$ringCategoryTable} SET ringPosition = {$i} WHERE ID = ".$value['ID'];
                    //echo "<br/>";
                    $this->db->query($query);
                    $i++;
                }
            }
            if($state == 'bottom'){
                //Get bottom Position from category
                $query ="SELECT max( ringPosition ) as position FROM {$ringCategoryTable} WHERE category_id = {$category_filter_id}";
                $maxPosition = $this->db->query($query)->row();

                if($maxPosition->position > 0){
                    //Set current id to bottom
                    $updateQuery = "UPDATE {$ringCategoryTable} SET ringPosition = {$maxPosition->position} WHERE ID = ".$positionID;
                    $this->db->query($updateQuery);

                    //update position other positions
                    $selQuery = "SELECT ID, ring_id , category_id, ringPosition  FROM {$ringCategoryTable} ";
                    $selQuery .= "WHERE category_id = ".$category_filter_id." and ID != {$positionID} order by ringPosition DESC";
                    $result = $this->db->query($selQuery)->result_array();
                    $i = ($maxPosition->position - 1);
                    foreach($result as $value){

                        $query = "UPDATE {$ringCategoryTable} SET ringPosition = {$i} WHERE ID = ".$value['ID'];
                        //echo "<br/>";
                        $this->db->query($query);
                        $i--;
                    }
                }

            }
        }
    }
    ///////////////////////
    public function getJoined() {
        if ($this->is_join_set === TRUE) {
            if ($this->arrayOfJoin != NULL) {
                foreach ($this->arrayOfJoin as $table => $arrayOfArray) {
                    if (is_array($arrayOfArray) && !empty($arrayOfArray)) {
                        $this->db->join($table, $arrayOfArray['condition'], isset($arrayOfArray['type']) ? $arrayOfArray['type'] : "inner");
                    }
                }
            }
        }

        if ($this->arrayOfWhereCond != NULL) {
            foreach ($this->arrayOfWhereCond as $column => $value) {
                $this->db->where($column, $value);
            }
        }

        if ($this->arrayOfWhereInCond != NULL) {
            foreach ($this->arrayOfWhereInCond as $column => $value) {
                $this->db->where_in($column, $value);
            }
        }

        if ($this->between != NULL) {
            foreach ($this->between as $column => $arrayOfValue) {
                $from = urldecode($arrayOfValue['from']);
                $to = urldecode($arrayOfValue['to']);
                $this->db->where("{$column} BETWEEN '{$from}' AND '{$to}'");
            }
        }

        $this->arrayOfWhereCond[$this->tableName . ".is_registered"] = "1";

        if ($this->like != NULL) {
            foreach ($this->like as $column => $arrayOfValue) {
                $value = $arrayOfValue['value'];
                $flag = $arrayOfValue['flag'];
                $this->db->like($column, $value, (!empty($flag)) ? $flag : "both");
            }
        }

        if (isset($this->arrayOfData['search']) && !empty($this->arrayOfData['search'])) {
            //search is set...
            if (isset($this->arrayOfData['search_filter']) && !empty($this->arrayOfData['search_filter'])) {
                $this->is_search = TRUE;
//
//                if ($this->is_join_set === TRUE) {
//                    if ($this->arrayOfJoin != NULL) {
//                        foreach ($this->arrayOfJoin as $table => $arrayOfArray) {
//                            if (is_array($arrayOfArray) && !empty($arrayOfArray)) {
//                                $this->db->join($table, $arrayOfArray['condition'], isset($arrayOfArray['type']) ? $arrayOfArray['type'] : "inner" );
//                            }
//                        }
//                    }
//                }

                $this->db->where($this->tableName . ".is_registered", "1");
                $this->db->like($this->arrayOfData['search_filter'], $this->arrayOfData['search']);
                $counts = $this->db->count_all_results($this->tableName);
//                dump($counts);
//                echo $this->db->last_query();
                $result = $this->getResult($counts);
            }
        } else {
            //search is not set...
//            if ($this->is_join_set === TRUE) {
//                    if ($this->arrayOfJoin != NULL) {
//                        foreach ($this->arrayOfJoin as $table => $arrayOfArray) {
//                            if (is_array($arrayOfArray) && !empty($arrayOfArray)) {
//                                $this->db->join($table, $arrayOfArray['condition'], isset($arrayOfArray['type']) ? $arrayOfArray['type'] : "inner" );
//                            }
//                        }
//                    }
//                }

            $this->db->where($this->tableName . ".is_registered", "1");
            $counts = $this->db->count_all_results($this->tableName);
            $result = $this->getResult($counts);
        }
        return $result;
    }
    public function getNotJoined() {
        if ($this->is_join_set === TRUE) {
            if ($this->arrayOfJoin != NULL) {
                foreach ($this->arrayOfJoin as $table => $arrayOfArray) {
                    if (is_array($arrayOfArray) && !empty($arrayOfArray)) {
                        $this->db->join($table, $arrayOfArray['condition'], isset($arrayOfArray['type']) ? $arrayOfArray['type'] : "inner");
                    }
                }
            }
        }

        if ($this->arrayOfWhereCond != NULL) {
            foreach ($this->arrayOfWhereCond as $column => $value) {
                $this->db->where($column, $value);
            }
        }

        if ($this->arrayOfWhereInCond != NULL) {
            foreach ($this->arrayOfWhereInCond as $column => $value) {
                $this->db->where_in($column, $value);
            }
        }

        if ($this->between != NULL) {
            foreach ($this->between as $column => $arrayOfValue) {
                $from = urldecode($arrayOfValue['from']);
                $to = urldecode($arrayOfValue['to']);
                $this->db->where("{$column} BETWEEN '{$from}' AND '{$to}'");
            }
        }

        $this->arrayOfWhereCond[$this->tableName . ".is_registered"] = "0";

        if ($this->like != NULL) {
            foreach ($this->like as $column => $arrayOfValue) {
                $value = $arrayOfValue['value'];
                $flag = $arrayOfValue['flag'];
                $this->db->like($column, $value, (!empty($flag)) ? $flag : "both");
            }
        }

        if (isset($this->arrayOfData['search']) && !empty($this->arrayOfData['search'])) {
            //search is set...
            if (isset($this->arrayOfData['search_filter']) && !empty($this->arrayOfData['search_filter'])) {
                $this->is_search = TRUE;
//
//                if ($this->is_join_set === TRUE) {
//                    if ($this->arrayOfJoin != NULL) {
//                        foreach ($this->arrayOfJoin as $table => $arrayOfArray) {
//                            if (is_array($arrayOfArray) && !empty($arrayOfArray)) {
//                                $this->db->join($table, $arrayOfArray['condition'], isset($arrayOfArray['type']) ? $arrayOfArray['type'] : "inner" );
//                            }
//                        }
//                    }
//                }

                $this->db->where($this->tableName . ".is_registered", "0");
                $this->db->like($this->arrayOfData['search_filter'], $this->arrayOfData['search']);
                $counts = $this->db->count_all_results($this->tableName);
//                dump($counts);
//                echo $this->db->last_query();
                $result = $this->getResult($counts);
            }
        } else {
            //search is not set...
//            if ($this->is_join_set === TRUE) {
//                    if ($this->arrayOfJoin != NULL) {
//                        foreach ($this->arrayOfJoin as $table => $arrayOfArray) {
//                            if (is_array($arrayOfArray) && !empty($arrayOfArray)) {
//                                $this->db->join($table, $arrayOfArray['condition'], isset($arrayOfArray['type']) ? $arrayOfArray['type'] : "inner" );
//                            }
//                        }
//                    }
//                }

            $this->db->where($this->tableName . ".is_registered", "0");
            $counts = $this->db->count_all_results($this->tableName);
            $result = $this->getResult($counts);
        }
        return $result;
    }

}
