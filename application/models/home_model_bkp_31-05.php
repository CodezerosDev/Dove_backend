<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home_model extends BF_Model {



    public function __construct() {
        parent::__construct();

    }

    public function fetch_current_userinfo()
    {

        $user_id = $this->session->userdata('user_id');
        $query = $this->db->select('bfu.display_name,bfu.referral_code,bum.meta_value,bfu.is_verified')->from('bf_users as bfu')
                ->join('bf_user_meta as bum','bum.user_id = bfu.id and bum.meta_key ="wallet_address"','left')->where('id',$user_id)->get()->first_row();

        if($query){
            return $query;
        }else{
            return false;
        }
    }

    public function fetch_buy_token_instruction()
    {

        $query = $this->db->select('page_content')->from('bf_pages')->where('page_slug','buy_token_instruction')->get()->first_row();

        if($query){
            return $query;
        }else{
            return false;
        }
    }

    public function fetch_total_app_user()
    {

        $query = $this->db->select('count(id) as totaluser',false)->from('bf_users')->where('role_id',4)->get()->first_row();

        if($query){
            return $query;
        }else{
            return false;
        }
    }
    public function fetch_total_app_manager()
    {

        $query = $this->db->select('count(id) as totalmanager',false)->from('bf_users')->where('role_id',7)->get()->first_row();

        if($query){
            return $query;
        }else{
            return false;
        }
    }


}
