<?php

if (!function_exists("check_file")) {

    function check_file(array $file, $type, $size) {

        $ci = & get_instance();
        $ci->load->helper("number");
        $size = $size * 1024; //convert to byte.

        $file_types = implode(",", $type);

        if ($file['error'] != 0) {
            return "Error in file upload";
        }
        if (!in_array($file['type'], $type)) {
            return "Only {$file_types} are allowed";
        }
        if ($file['size'] <= 0 || $file['size'] > $size) {
            $allowed_size = byte_format($size);
            return "File size is greater than allowed size of $allowed_size.";
        }
        if ($file['name'] == "") {
            return "Error in file upload";
        }

        return TRUE;
    }

}


if (!function_exists("check_file_multiple")) {

    function check_file_multiple(array $file, $type, $size) {
        $ci = & get_instance();
        $ci->load->helper("number");
        $size = $size * 1024; //convert to byte.

        $file_types = implode(",", $type);
        $total_files = count($file['name']);

        for ($i = 0; $i < $total_files; $i++) {
            if ($file['error'][$i] != 0) {
                return "Error in file upload";
            }
            if (!in_array($file['type'][$i], $type)) {
                return "Only {$file_types} are allowed";
            }
            if ($file['size'][$i] <= 0 || $file['size'][$i] > $size) {
                $allowed_size = byte_format($size);
                return "File size is greater than allowed size of $allowed_size.";
            }
            if ($file['name'][$i] == "") {
                return "Error in file upload";
            }
        }

        return TRUE;
    }

}



if (!function_exists("uploadFile")) {

    function uploadFile($fileName, $config, $multiple = FALSE) {

        $ci = & get_instance();

        if (!file_exists($config['upload_path'])) {
            mkdir($config['upload_path'], 0777);
        }

        $ci->load->library('upload');
        $ci->upload->initialize($config);

        if ($multiple) {
            //do multiple file upload...
            if (!$ci->upload->do_multi_upload($fileName)) {
                return FALSE;
            } else {
                return $ci->upload->get_multi_upload_data();
            }
        } else {
            //do single file upload...
            if (!$ci->upload->do_upload($fileName)) {
                return FALSE;
            } else {
                return $ci->upload->data();
            }
        }
    }

}

if (!function_exists("delete_file")) {

    function delete_file($file) {

        if (file_exists($file)) {
            if (@unlink($file)) {
                return TRUE;
            }
        }
        return FALSE;
    }

}

if (!function_exists("download_file")) {

    function download_file($file_name, $path) {
        if (!empty($path)) {
            $file_content = file_get_contents($path);
            $name = $file_name;
            force_download($name, $file_content);
        } else {
            show_404();
        }
    }

}
