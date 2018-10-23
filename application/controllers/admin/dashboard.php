<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Bonfire
 *
 * An open source project to allow developers get a jumpstart their development of CodeIgniter applications
 *
 * @package   Bonfire
 * @author    Bonfire Dev Team
 * @copyright Copyright (c) 2011 - 2013, Bonfire Dev Team
 * @license   http://guides.cibonfire.com/license.html
 * @link      http://cibonfire.com
 * @since     Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * Content context controller
 *
 * The controller which displays the homepage of the Content context in Bonfire site.
 *
 * @package    Bonfire
 * @subpackage Controllers
 * @category   Controllers
 * @author     Bonfire Dev Team
 * @link       http://guides.cibonfire.com/helpers/file_helpers.html
 *
 */
class Dashboard extends Admin_Controller
{


    /**
     * Controller constructor sets the Title and Permissions
     *
     */
    public function __construct()
    {
        parent::__construct();

        Template::set('toolbar_title', 'Dashboard');

        $this->load->model('home_model');

        $this->auth->restrict('Site.Dashboard.View');
    }//end __construct()

    //--------------------------------------------------------------------

    /**
     * Displays the initial page of the Content context
     *
     * @return void
     */
    public function index()
    {

        // Fetch manager reference number
        if($this->session->userdata('role_id') == 7){
            $referral_code = $this->db->select('username,referral_code')->from('bf_users')->where('id',$this->session->userdata('user_id'))->get()->first_row();

            Template::set('referralcode', $referral_code);
        }

        $total_app_users = $this->home_model->fetch_total_app_user();
        Template::set('total_app_users', $total_app_users->totaluser);

        $pending_users = $this->home_model->fetch_pending_app_user();
        Template::set('pending_users', $pending_users->totaluser);

        $verified_users = $this->home_model->fetch_verified_app_user();
        Template::set('verified_users', $verified_users->totaluser);

        $rejected_users = $this->home_model->fetch_rejected_app_user();
        Template::set('rejected_users', $rejected_users->totaluser);

        $total_app_manager = $this->home_model->fetch_total_app_manager();
        Template::set('total_app_manager', $total_app_manager->totalmanager);

        Template::set_view('admin/dashboard/index');
        Template::render();
    }//end index()

    //--------------------------------------------------------------------


}//end class