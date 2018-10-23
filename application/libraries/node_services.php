<?php
/**
 * @package : Node Services API
 * @author  : Lalit Patadiya
 * @version : 0.1
 * @access  : public
 * @license : 
 */
class Node_services extends Front_Controller{

    /**
	 * lpbitcore::__construct()
	 */
    public function __construct(){
        $this->load->library('settings/settings_lib');

    }


    /**
     * Function Name : create_wallet()
     * Purpose       : create wallet
     * Input Param   : --
     *
     */
    public function create_wallet(){

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://webcluestech.com:5551/wallet/create');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER , true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json'));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }


    /**
     * Function Name : addressTokenbalance()
     * Purpose       : Fetch the address token balance
     * Input Param   : address
     *
     */
    public function addressTokenbalance($address){

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://webcluestech.com:5551/dove-token/balance/address/'.$address);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER , true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json'));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $output = curl_exec($ch);
        curl_close($ch);
        
        return $output;
    }

    /**
     * Function Name : addressTokenbalance()
     * Purpose       : Fetch the address token balance
     * Input Param   : address
     *
     */
    public function tokenTransfer($param){

        $from = trim($param['from']);
        $to = trim($param['to']);
        $key = trim($param['key']);
        $amount = trim($param['amount']);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://webcluestech.com:5551/dove-token/transfer');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER , true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Accept:application/json'));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }

}