<?php

class CH_Grid_generator
{
    protected $CI;
    protected $key = 'id';
    protected $select = array();
    public $where = array();
    protected $where_in = array();
    protected $sort = array();
    protected $order = array();
    protected $orderbymultiple = array();
    protected $search = array();
    protected $between = array();
    protected $join = array();
    protected $group_by = array();
    protected $table = "";
    protected $status_field = "status";
    protected $created_on_field = "created_on";
    protected $position_field = "position";
    protected $message = "";
    protected $count = 0;
    protected $action = array(
        "toggleStatus" => "_toggle_status",
        "delete" => "_delete",
        "deleteSelected" => "_delete_selected",
        "changePosition" => "_change_position"
    );
    //pagination fields
    protected $per_page = 10;
    protected $page = 1;
    protected $total_pages = 0;
    protected $offset = 0;
    protected $next = 0;
    protected $previous = 0;
    protected $record_from = 0;
    protected $record_to = 0;
    protected $pagination_options = array('5', '10', '25', '50', '100');
    public $req_data = array();

    public function __construct(array $config)
    {
        $this->CI = &get_instance();
        $this->initialize($config);
    }

    //public functions
    public function initialize($config)
    {
        if ($this->_validate($config)) {
            foreach ($config as $key => $value) {
                $this->$key = $value;
            }
        }
    }

    public function get_result()
    {
        $this->_fire_action();
        $this->_prep_query();

        $this->count = $this->CI->db->get()->num_rows();

        $this->_paginate();

        $this->CI->db->limit($this->per_page);
        $this->CI->db->offset($this->offset);

        $q = $this->CI->db->get();
//        lq();
        //echo 'query :::: <br/>'.$this->CI->db->last_query();

        $this->CI->db->flush_cache();


        if ($q->num_rows() != 0) {
            $data = array();
            if ($this->message != NULL) {
                $data['message'] = $this->message;
            }
            $data['result'] = $q->result();
            $data['data'] = $this->req_data;
            /*$data['pagination'] = array(
                "total_count" => $this->count,
                "total_pages" => $this->total_pages,
                "record_from" => $this->record_from,
                "record_to" => $this->record_to,
                "page" => $this->page,
                "next" => $this->next,
                "previous" => $this->previous
            );
            $data['query'] = $this->CI->db->last_query();*/
            $data['pagination'] = $this->print_pagination();
            return $data;
        } else {
            return FALSE;
        }
    }

    //private functions
    private function _fire_action()
    {
        if ($this->_validate($this->action)) {
            if (isset($this->req_data['action']) && $this->_validate($this->req_data['action'])) {
                foreach ($this->action as $action => $method) {
                    if ($this->req_data['action'] == $action) {
                        $this->message = $this->$method();
                    }
                }
            }
        }
    }

    private function _prep_query()
    {
        $this->CI->db->start_cache();

        $this->_prep_category();

        //select
        if ($this->_validate($this->select)) {
            $this->CI->db->select($this->select);
        }

        //from
        $this->CI->db->from($this->table);

        //join
        if ($this->_validate($this->join)) {
            foreach ($this->join as $table => $cond_type) {
                if (is_array($cond_type) && $this->_validate($cond_type)) {
                    $this->CI->db->join($table, $cond_type['condition'], isset($cond_type['type']) ? $cond_type['type'] : "inner");
                }
            }
        }

        //where
        if ($this->_validate($this->where)) {
            foreach ($this->where as $column => $value) {
                $this->CI->db->where($column, $value);
            }
        }

        //where in
        if ($this->_validate($this->where_in)) {
            foreach ($this->where_in as $column => $value) {
                $this->CI->db->where_in($column, $value);
            }
        }

        //between
        if (isset($this->req_data['between']) && $this->_validate($this->req_data['between'])) {
            //$this->_data['between'] = $this->req_data['between'];    	
            foreach ($this->req_data['between'] as $field => $from_to) {
                if (is_array($from_to) && $this->_validate($from_to) && !empty($from_to['from']) && !empty($from_to['to'])) {
                    $this->CI->db->where("{$field} BETWEEN '{$from_to['from']}' AND '{$from_to['to']}'");
                }
            }
        }

        //search
        if (isset($this->req_data['search']) && $this->_validate($this->req_data['search'])) {
            //$this->_data['search'] = $this->req_data['search'];   	
            foreach ($this->req_data['search'] as $field => $value) {
                if ($this->_validate($field) && $this->_validate($value)) {
                    //$this->CI->db->like($field, $value, "after");
                    $this->CI->db->like($field, $value, "both");
                }
            }
        }

        //sort
        if (isset($this->req_data['sortby']) && $this->_validate($this->req_data['sortby']) && $this->_validate($this->req_data['order'])) {
            $this->CI->db->order_by($this->req_data['sortby'], $this->req_data['order']);
        }
        if ($this->_validate($this->sort)) {
            $this->CI->db->order_by($this->sort['sortby'], $this->sort['order']);
        }
        if ($this->_validate($this->order)) {
            $this->CI->db->order_by($this->order['sortby'], $this->order['order']);
        }


        if ($this->_validate($this->orderbymultiple)) {
            //var_dump($this->orderbymultiple);die;

            foreach ($this->orderbymultiple as $key_array => $value_order) {
//                var_dump($key_array);
//                var_dump($value_order);
//                echo $value_order;

                $this->CI->db->order_by($value_order['sortby'], $value_order['order']);
                //$this->CI->db->order_by($this->orderbymultiple['order_second']['sortby'],$this->orderbymultiple['order_second']['order']);
                //$this->CI->db->order_by($this->orderbymultiple['createdon']['sortby'].' '.$this->orderbymultiple['createdon']['order'], $this->orderbymultiple['device_id']['sortby'].' '.$this->orderbymultiple['device_id']['order']);

            }
            //var_dump($this->orderbymultiple);die;
        }


        //group by
        if (is_array($this->group_by) && $this->_validate($this->group_by)) {
            $this->CI->db->group_by($this->group_by);
        }


        $this->CI->db->stop_cache();
    }

    protected function _prep_category()
    {
        if (isset($this->req_data['category'])) {
            switch ($this->req_data['category']) {
                case 'active':
                    //$this->where = array($this->status_field => 1);
                    $this->CI->db->where($this->table . "." . $this->status_field, 1);
                    break;

                case 'inactive':
                    //$this->where = array($this->status_field => 0);
                    $this->CI->db->where($this->table . "." . $this->status_field, 0);
                    break;

                case 'newest':
                    $this->CI->db->order_by($this->table . "." . $this->created_on_field, "DESC");
                    //$this->sort = array("sortby" => $this->created_on_field, "order" => "DESC");
                    break;

                case 'oldest':
                    $this->CI->db->order_by($this->table . "." . $this->created_on_field, "ASC");
                    //$this->sort = array("sortby" => $this->created_on_field, "order" => "ASC");
                    break;
                case 'oldest':
                    $this->CI->db->order_by($this->table . "." . $this->created_on_field, "ASC");
                    //$this->sort = array("sortby" => $this->created_on_field, "order" => "ASC");
                    break;
                case 'draft':
                    //$this->where = array($this->status_field => 1);
                    $this->CI->db->where($this->table . "." . $this->status_field, 0);
                    break;
                case 'open':
                    //$this->where = array($this->status_field => 1);
                    $this->CI->db->where($this->table . "." . $this->status_field, 1);
                    break;
                case 'wp':
                    //$this->where = array($this->status_field => 1);
                    $this->CI->db->where($this->table . "." . $this->status_field, 2);
                    break;
                case 'approved':
                    //$this->where = array($this->status_field => 1);
                    $this->CI->db->where($this->table . "." . $this->status_field, 3);
                    break;
                case 'rejected':
                    //$this->where = array($this->status_field => 1);
                    $this->CI->db->where($this->table . "." . $this->status_field, 4);
                    break;
                case 'requested':
                    //$this->where = array($this->status_field => 1);
                    $this->CI->db->where($this->table . "." . $this->status_field, 6);
                    break;
                case 'canceled':
                    //$this->where = array($this->status_field => 1);
                    $this->CI->db->where($this->table . "." . $this->status_field, 5);
                    break;

                default:
                    break;
            }
        }
    }

    protected function _validate($var)
    {
        if (isset($var) && !empty($var) && $var != NULL) {
            return TRUE;
        }
        return FALSE;
    }

    private function _paginate()
    {
        $this->page = (isset($this->req_data['page']) && $this->_validate($this->req_data['page'])) ? (int)$this->req_data['page'] : 1;
        if (isset($this->req_data['per_page']) && !empty($this->req_data['per_page']) && is_numeric($this->req_data['per_page'])) {
            $this->per_page = $this->req_data['per_page'];
        }

        if (!is_int($this->page)) {
            $this->page = 1;
        }

        $this->total_pages = ceil($this->count / $this->per_page);

        if ($this->total_pages > 0) {
            if ($this->page > 0 && $this->page > $this->total_pages) {
                $this->page = $this->total_pages;
            } else if ($this->page <= 0) {
                $this->page = 1;
            }
        } else {
            $this->page = 1;
        }

        if (($this->page + 1) <= $this->total_pages) {
            $this->next = $this->page + 1;
        }

        if (($this->page - 1) > 0) {
            $this->previous = $this->page - 1;
        }

        $this->offset = ($this->page - 1) * $this->per_page;
        $this->record_from = $this->offset + 1;
        $this->record_to = ($this->offset + $this->per_page > $this->count) ? $this->count : $this->offset + $this->per_page;
    }

    private function _delete_selected()
    {
        if (isset($this->req_data) && $this->_validate($this->req_data)) {
            if (isset($this->req_data['checked']) && !empty($this->req_data['checked'])) {
                $i = 0;
                foreach ($this->req_data['checked'] as $value) {
                    $this->CI->db->where($this->key, $value);
                    if ($this->CI->db->delete($this->table)) {
                        $i++;
                    }
                }
                if ($i === count($this->req_data['checked'])) {
                    return "{$i} rows successfully deleted";
                } else {
                    return "Deletion failed";
                }
            } else {
                return "No checkboxes selected";
            }
        }
    }

    private function _delete()
    {
        if (isset($this->req_data) && $this->_validate($this->req_data)) {

            if (isset($this->req_data['delete_id']) && !empty($this->req_data['delete_id'])) {
                $this->CI->db->where($this->key, $this->req_data['delete_id']);
                if ($this->CI->db->delete($this->table)) {
                    return "Row successfully deleted";
                } else {
                    return "Deletion failed";
                }
            }
        }
    }

    protected function _delete_user() {

        if (isset($this->req_data) && $this->_validate($this->req_data)) {

            if (isset($this->req_data['delete_id']) && !empty($this->req_data['delete_id'])) {

                $update = array($this->deleted_field => 1);
                $where = array($this->key => $this->req_data['delete_id']);

                if ($this->CI->db->update($this->table, $update, $where)) {
                    return "success";
                } else {
                    return "fail";
                }
            }
        }
    }

    protected function _toggle_status()
    {
        if (isset($this->req_data) && $this->_validate($this->req_data)) {
            if (isset($this->req_data['id']) && !empty($this->req_data['id'])) {
                $id = $this->req_data['id'];
                $table = $this->CI->db->dbprefix($this->table);
                $q = "UPDATE {$table} SET {$this->status_field} = IF({$table}.{$this->status_field} = 1 , 0, 1) WHERE {$table}.{$this->key} = {$id}";
                $this->CI->db->query($q);
            }
        }
    }

    protected function _change_position()
    {
        if ($this->req_data != NULL) {
            $state = $this->req_data['state'];
            $currentPosition = $this->req_data['position'];
            $id = $this->req_data['id'];
            $table = $this->CI->db->dbprefix($this->table);
            $status_cond = "";

            if (isset($this->req_data['category']) && $this->req_data['category'] == 'active') {
                $status_cond = " AND {$this->status_field} = 1";
            } else if (isset($this->req_data['category']) && $this->req_data['category'] == 'inactive') {
                $status_cond = " AND {$this->status_field} = 0";
            }

            if ($state == "up") {
                $query = "SELECT id , {$this->position_field} FROM {$table} ";
                $query .= "WHERE {$this->position_field} = ";
                $query .= "( SELECT min( {$this->position_field} ) FROM {$table} WHERE {$this->position_field} > {$currentPosition} {$status_cond} )";
                $resultSet = $this->CI->db->query($query);
                $result = array_shift($resultSet->result_array());
            } else {
                $query = "SELECT id , {$this->position_field} FROM {$table} ";
                $query .= "WHERE {$this->position_field} = ";
                $query .= "( SELECT max( {$this->position_field} ) FROM {$table} WHERE {$this->position_field} < {$currentPosition} {$status_cond} )";
                $resultSet = $this->CI->db->query($query);
                $result = array_shift($resultSet->result_array());
            }

            $id2 = $result['id'];
            $position2 = $result[$this->position_field];

            $query = "UPDATE {$table} SET {$this->position_field} = {$currentPosition} WHERE id = {$id2}";
            $this->CI->db->query($query);

            $query = "UPDATE {$table} SET {$this->position_field} = {$position2} WHERE id = {$id}";
            $this->CI->db->query($query);
        }
    }

    //Grid builder functions

    public function print_grid_filters($config)
    {
        $output = "";
        if (!empty($config) && is_array($config)) {
            $output .= $this->print_hidden_fields();
            foreach ($config as $key => $value) {
                switch ($key) {
                    case 'category':
                        $output .= $this->print_category($value);
                        break;
                    case 'search_field':
                        $output .= $this->print_serach_field($value);
                        break;
                    case 'search_field_with_filter':
                        $output .= $this->print_search_field_with_filter($value);
                        break;
                    case 'search_dropdown':
                        $output .= $this->print_search_dropdown($value);
                        break;
                    case 'between':
                        $output .= $this->print_between($value);
                        break;
                    default:
                        break;
                }
            }
            $output .= $this->print_submit_button();
            $output .= $this->print_reset_button();
            $output .= $this->print_delete_button();
        }
        return $output;
    }

    public function print_hidden_fields()
    {
        $output = <<<EOT
                <input type="hidden" value="" name="sortby" id="sortby" class="reset-input">
                <input type="hidden" value="" name="order" id="order" class="reset-input">
                <input type="hidden" value="" name="action" id="action" class="reset-input">
EOT;
        return $output;
    }

    public function print_category($config)
    {
        $output = "";
        if (!empty($config) && is_array($config)) {
            $output .= "<select name='category' class='category-dropdown reset-dropdown form-control input-small' >";
            $output .= "<option value='all'>All</option>";
            foreach ($config as $key => $value) {
                $output .= "<option value='{$key}'>{$value}</option>";
            }
            $output .= "</select>&nbsp;";
        }
        return $output;
    }

    public function print_serach_field($param, $wrap_start_tag = "", $wrap_end_tag = "")
    {
        $output = "";
        if (!empty($param)) {
            $output .= $wrap_start_tag;
            foreach ($param as $key => $value) {
                $output .= "<td><input type='text' class='search-field reset-input form-control' name='search[{$key}]' placeholder='{$value}' />&nbsp;</td>";
            }
            $output .= $wrap_end_tag;
        }
        return $output;
    }

    public function print_search_field_with_filter($param, $wrap_start_tag = "", $wrap_end_tag = "")
    {
        $output = "";
        if (!empty($param) && is_array($param)) {
            $output .= $wrap_start_tag;
            foreach ($param as $k => $v) {
                if (!empty($v) && is_array($v)) {
                    $i = 0;
                    $j = 1;
                    foreach ($v as $key => $value) {
                        //echo ' :in in: ';
                        if ($i == 0) {
                            $output .= "<td><input type='text' class='search-field reset-input form-control' rel_id='serach_filed{$j}' name='search[{$key}]' />&nbsp;</td>";
                            $output .= "<td><select class='search-field-dropdown reset-dropdown form-control input-small ' rel='serach_filed{$j}' >";
                        }
                        $output .= "<option value='{$key}'>{$value}</option>";
                        $i++;
                    }
                    $output .= "</select>&nbsp;</td>";
                    $j++;
                }
            }
            $output .= $wrap_start_tag;
        }
        return $output;
    }

    public function print_search_dropdown($config, $wrap_start_tag = "", $wrap_end_tag = "")
    {
        $output = "";
        if (!empty($config) && is_array($config)) {
            foreach ($config as $column => $ar) {
                if (!empty($ar) && is_array($ar)) {
                    if (!empty($wrap_start_tag)) {
                        $output .= $wrap_start_tag;
                    }
                    $output .= "<td><select name='search[{$column}]' class='search-dropdown reset-dropdown' >";
                    foreach ($ar as $value => $label) {
                        $output .= "<option value='{$value}'>{$label}</option>";
                    }
                    $output .= "</select>&nbsp;</td>";
                    if (!empty($wrap_end_tag)) {
                        $output .= $wrap_end_tag;
                    }
                }
            }
        }
        return $output;
    }

    public function print_between($config, $wrap_start_tag = "", $wrap_end_tag = "")
    {
        $output = "";
        if (!empty($config) && is_array($config)) {
            foreach ($config as $value => $label) {
                if (!empty($wrap_start_tag)) {
                    $output .= $wrap_start_tag;
                }
                $output .= <<<EOT
                        <td><input class='form-control input-small' name="between[{$value}][from]" value="" placeholder="{$label} From" class="reset-input"/>&nbsp;</td>
                        <td><input class='form-control input-small' name="between[{$value}][to]" value="" placeholder="{$label} To" class="reset-input" />&nbsp;</td>
                        {$wrap_end_tag}
EOT;
                if (!empty($wrap_end_tag)) {
                    $output .= $wrap_end_tag;
                }
            }
        }
        return $output;
    }

    public function print_delete_button($text = "Delete Selected", $class = "delete-selected btn-danger")
    {
        return $this->_button($text, $class);
    }

    public function print_submit_button($text = "Find", $class = "submit-filters")
    {
        return $this->_button($text, $class);
    }

    public function print_reset_button($text = "Reset", $class = "reset-filters")
    {
        return $this->_button($text, $class);
    }

    public function print_pagination()
    {
        $options = "";
        if (!empty($this->pagination_options)) {
            foreach ($this->pagination_options as $value) {
                if ($value == $this->per_page) {
                    $options .= '<option value="' . $value . '" selected="selected">' . $value . '</option>';
                } else {
                    $options .= '<option value="' . $value . '">' . $value . '</option>';
                }
            }
        }

//        $first = Template::theme_url('images/first.png');
        $last = Template::theme_url('images/last.png');
        $prev = Template::theme_url('images/prev.png');
        $next = Template::theme_url('images/next.png');


        /*reset-dropdown*/
        $output = <<<PAGE
        <div class="inner_pagination">
		<div class="pDiv2">
                        <div class="selects">
                        <select class="selectpicker show-tick per_page span2 form-control input-xsmall form-control input-xsmall input-sm input-inline" name="per_page" id="per_page">
                            {$options}
                        </select>
                        </div>
                  <div class="btnseparator"></div>
                  <div class="type">
                  <label>
                        <span>Page</span>

                        <span><a effect='tooltip' title='First' class="first_page pagination_link btn btn-sm default prev" href="javascript:void(0);" value="1"><i class="fa fa-angle-double-left" title="First"></i></a></span>


                        <span><a effect='tooltip' title='Prev' class="prev_page pagination_link btn btn-sm default prev" href="javascript:void(0);" value="{$this->previous}"><i class="fa fa-angle-left" title="Previous" alt="Previous"></i></a></span>



                        <input type="text" class="pagination-panel-input form-control input-mini input-inline input-sm" id="page" size="4" value="{$this->page}" name="page">


                        <span><a effect='tooltip' title='Next' class="next_page pagination_link btn btn-sm default " href="javascript:void(0);" value="{$this->next}" ><i class="fa fa-angle-right" title="Last" title="Next" alt="Next"></i></a></span>

<span><a effect='tooltip' title='Last' class="last_page pagination_link btn btn-sm default" href="javascript:void(0);" value="{$this->total_pages}" ><i class="fa fa-angle-double-right" title="Last" alt="Last"></i></a></span>

                    <span>of</span>
                        <span class="last-page-number">{$this->total_pages}</span>
                        </label>
                    </div>
                    <div class="forms">
                        <div class="ajax_refresh_and_loading">
                        </div>
                    </div>
					                  <div class="btnseparator"></div>
                    <div class="record-form">
                        <label>
                        <span>Displaying</span>
                        <span class="page-starts-from">{$this->record_from}</span>
                        <span>to</span>
                        <span class="page-ends-to">{$this->record_to}</span> of <span class="total_items" id="total_items">{$this->count}</span> items</span>
                        </label>
                    </div>

				</div>
            </div>
PAGE;
        return $output;
    }

    private function _button($text = "Button", $class = "button")
    {
        $output = "";
        $output .= "<button type='button' class='btn {$class}' title='{$text}' data-original-title=''>{$text}</button>&nbsp;";
        return $output;
    }

}