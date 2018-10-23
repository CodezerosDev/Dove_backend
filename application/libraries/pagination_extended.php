<?php

class Pagination_extended {

    public $current_page;
    public $per_page;
    public $total_counts;

    public function __construct() {
        $CI = & get_instance();
        $CI->load->library('settings/settings_lib');
        $this->per_page = $CI->settings_lib->item('site.list_limit');       
    }

    public function setCurrentPage($current_page = 1) {
        $this->current_page = (int) $current_page;
    }

    public function setPerPage($per_page = 10) {
        $this->per_page = (int) $per_page;
    }

    public function setTotalCounts($total_counts = 0) {
        $this->total_counts = (int) $total_counts;
    }

    public function setParams($current_page = 1, $total_counts = 0) {
        $this->current_page = (int) $current_page;
        $this->total_counts = (int) $total_counts;
    }

    public function total_pages() {
        return ceil($this->total_counts / $this->per_page);
    }

    public function previous_page() {
        return $this->current_page - 1;
    }

    public function next_page() {
        return $this->current_page + 1;
    }

    public function has_next_page() {
        return $this->next_page() <= $this->total_pages() ? TRUE : FALSE;
    }

    public function has_previous_page() {
        return $this->previous_page() >= 1 ? TRUE : FALSE;
    }

    public function offset() {
        return ($this->current_page - 1) * $this->per_page;
    }

    public function printPaginationBar($controllerFunction, $arrayOfQueryString = NULL) {
        $queryString = $this->getQueryString($arrayOfQueryString);
        
        if (isset($queryString) && !empty($queryString)) {
            $links = '&' . $queryString;
        } else {
            $links = '';
        }

        $output = "";
        $output .= "<ul> ";
        if ($this->has_previous_page()) {
            $output .= "<li><a href=" . site_url("{$controllerFunction}?page={$this->previous_page()}{$links}") . ">&laquo;</a></li>";
        } else {
            $output .= "<li class=\"disabled\"><span><a>&laquo;</a></span></li>";
        }

        for ($i = 1; $i <= $this->total_pages(); $i++) {
            $output .= "<li ";
            if ($i == $this->current_page) {
                $output .= "class = \"disabled\"";
            }
            $output .= " ><a href=" . site_url("{$controllerFunction}?page={$i}{$links}") . ">{$i}</a></li>";
        }

        if ($this->has_next_page()) {
            $output .= "<li><a href=" . site_url("{$controllerFunction}?page={$this->next_page()}{$links}") . ">&raquo;</a></li>";
        } else {
            $output .= "<li class=\"disabled\"><span><a>&raquo;</a></span></li>";
        }
        $output .= " </ul>";
        return $output;
    }

    public function getQueryString($arrayOfQueryString) {
        $queryString = '';
        $i = 0;
        if ($arrayOfQueryString == NULL) {
            return NULL;
        } else {
            foreach ($arrayOfQueryString as $param => $value) {
                $value = urlencode($value);
                if ($i == count($arrayOfQueryString) - 1) {
                    //end of the array do not concate &
                    $queryString .= ("{$param}={$value}");
                } else {
                    $queryString .= ("{$param}={$value}&");
                }
                $i++;
            }
        }
        return $queryString;
    }

    public function printAjaxPagination($controllerFunction, $arrayOfParams) {
        
    }

    public function getAjaxQueryString($arrayOfParams) {

        if ($arrayOfParams != NULL) {
            $queryString = '{';
            $i = 0;
            foreach ($arrayOfParams as $param => $value) {
                if ($i == count($arrayOfParams) - 1) {
                    $queryString .= $param . ': ' . $value;
                } else {
                    $queryString .= $param . ': ' . $value . ', ';
                }
                $i++;
            }
            $queryString .= '}';
            return $queryString;
        } else {
            echo "params are null";
        }
    }

}

?>