<?php defined('BASEPATH') || exit('No direct script access allowed');
/**
 * Bonfire
 *
 * An open source project to allow developers to jumpstart their development of
 * CodeIgniter applications.
 *
 * @package   Bonfire
 * @author    Bonfire Dev Team
 * @copyright Copyright (c) 2011 - 2014, Bonfire Dev Team
 * @license   http://opensource.org/licenses/MIT
 * @link      http://cibonfire.com
 * @since     Version 1.0
 * @filesource
 */

//------------------------------------------------------------------------------
// User Meta Fields Config - These are just examples of various options
// The following examples show how to use regular inputs, select boxes,
// state and country select boxes.
//------------------------------------------------------------------------------

$config['user_meta_fields'] =  array(
    /*array(
        'name'   => 'country',
        'label'   => lang('user_meta_country'),
        'rules'   => 'required|trim|max_length[100]',
        'admin_only'    => false,
        'form_detail' => array(
            'type' => 'country_select',
            'settings' => array(
                'name'		=> 'country',
                'id'		=> 'country',
                'maxlength'	=> '100',
                'class'		=> 'span6'
            ),
        ),
    ),
    array(
        'name'   => 'state',
        'label'   => lang('user_meta_state'),
        'rules'         => 'required|trim|max_length[3]',
        'form_detail' => array(
            'type' => 'state_select',
            'settings' => array(
                'name'		=> 'state',
                'id'		=> 'state',
                'maxlength' => '3',
                'class'		=> 'span1'
            ),
        ),
    ),*/
    /*array(
        'name'   => 'city',
        'label'   => lang('user_meta_city'),
        'rules'         => 'trim',
        'form_detail' => array(
            'type' => 'city_select',
            'settings' => array(
                'name'		=> 'city',
                'id'		=> 'city',
                'class'		=> 'span1'
            ),
        ),
    ),
    array(
        'name'   => 'reg_type',
        'label'   => lang('user_meta_reg_type'),
        'rules'   => 'required|trim|max_length[100]',
        'admin_only'    => false,
        'form_detail' => array(
            'type' => 'create_input',
            'settings' => array(
                'name'		=> 'reg_type',
                'id'		=> 'reg_type',
                'maxlength'	=> '100',
                'class'		=> 'span6'
            ),
        ),
    ),*/
    /*array(
        'name'   => 'birth_date',
        'label'   => lang('user_meta_birth_date'),
        'rules'   => 'required',
        'admin_only'    => false,
        'form_detail' => array(
            'type' => 'birth_date',
            'settings' => array(
                'name'		=> 'birth_date',
                'id'		=> 'birth_date',
                'class'		=> 'span6'
            ),
        ),
    ),*/
    /*array(
        'name'   => 'contact',
        'label'   => lang('user_meta_contact'),
        'rules'   => 'required|trim|max_length[12]',
        'admin_only'    => false,
        'form_detail' => array(
            'type' => 'create_input',
            'settings' => array(
                'name'		=> 'contact',
                'id'		=> 'contact',
                'maxlength'	=> '12',
                'class'		=> 'span6'
            ),
        ),
    ),
    array(
        'name'   => 'pro_pic',
        'label'   => lang('user_meta_pro_pic'),
        'rules'   => 'required',
        'admin_only'    => false,
        'form_detail' => array(
            'type' => 'pro_pic',
            'settings' => array(
                'name'		=> 'pro_pic',
                'id'		=> 'pro_pic',
                'class'		=> 'span6'
            ),
        ),
    ),*/
    array(
        'name'   => 'country',
        'label'   => lang('user_meta_country'),
        'rules'   => 'required|trim|max_length[100]',
        'admin_only'    => false,
        'form_detail' => array(
            'type' => 'country_select',
            'settings' => array(
                'name'		=> 'country',
                'id'		=> 'country',
                'maxlength'	=> '100',
                'class'		=> 'span12'
            ),
        ),
    ),
    array(
        'name'   => 'name',
        'label'   => lang('user_meta_name'),
        'rules'   => 'required|trim',
        'admin_only'    => false,
        'form_detail' => array(
            'type' => 'create_input',
            'settings' => array(
                'name'		=> 'name',
                'id'		=> 'name',
                'class'		=> 'span12'
            ),
        ),
    ),
    array(
        'name'   => 'address',
        'label'   => lang('user_meta_address'),
        'rules'   => 'required|trim',
        'admin_only'    => false,
        'form_detail' => array(
            'type' => 'create_textarea',
            'settings' => array(
                'name'		=> 'address',
                'id'		=> 'address',
                'class'		=> 'span12'
            ),
        ),
    ),
    array(
        'name'   => 'wallet_address',
        'label'   => lang('user_meta_wallet_address'),
        'rules'   => 'required|trim',
        'admin_only'    => false,
        'form_detail' => array(
            'type' => 'create_input',
            'settings' => array(
                'name'		=> 'wallet_address',
                'id'		=> 'wallet_address',
                'class'		=> 'span12'
            ),
        ),
    ),
    array(
        'name'   => 'proff_doc',
        'label'   => lang('user_meta_proff_doc'),
        'rules'   => 'required',
        'admin_only'    => false,
        'form_detail' => array(
            'type' => 'proff_pic',
            'settings' => array(
                'name'		=> 'proff_doc',
                'id'		=> 'proff_doc',
                'class'		=> 'span6'
            ),
        ),
    ),
    array(
        'name'   => 'proff_id_doc',
        'label'   => lang('user_meta_proff_id_doc'),
        'rules'   => 'required',
        'admin_only'    => false,
        'form_detail' => array(
            'type' => 'proff_id_doc',
            'settings' => array(
                'name'		=> 'proff_id_doc',
                'id'		=> 'proff_id_doc',
                'class'		=> 'span6'
            ),
        ),
    )

);