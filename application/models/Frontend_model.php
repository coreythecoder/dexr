<?php

class Frontend_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        if (defined('REQUEST') && REQUEST == "external") {
            return;
        }
        $db = $this->load->database('default', TRUE);
    }
    
    function getByNameCitySlug($slug){
        
        $sql = "";
        $re = $db->query($sql);

        if ($re->num_rows() > 0) {
            return $re->result();
        } else {
            return false;
        }
        
    }

}
