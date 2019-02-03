<?php

class Frontend_model extends CI_Model {

    function getCitiesFromState($state, $page = 1) {
        $db = $this->load->database('default', TRUE);
        $res = array();

        $perPage = 200;
        if ($page > 1) {
            $page = $page - 1;
            $start = $page * $perPage;
        } else {
            $start = 0;
        }

        $sqlOne = "SELECT city, slug FROM city_index WHERE state = '" . $state . "' ORDER BY city ASC LIMIT " . $start . ", " . $perPage;
        $reOne = $db->query($sqlOne);

        $sqlTwo = "SELECT count(ID) as count FROM city_index WHERE state = '" . $state . "' ORDER BY city ASC LIMIT 10000";
        $reTwo = $db->query($sqlTwo);

        if ($reOne->num_rows() > 0) {
            $res['results'] = $reOne->result();
            $total = $reTwo->result();
            $res['total'] = $total[0]->count;

            return $res;
        } else {
            return false;
        }
    }

    function getNamesFromLetterCityState($city, $state, $letter, $page = 1) {
        $db = $this->load->database('default', TRUE);
        $res = array();

        $perPage = 200;
        if ($page > 1) {
            $page = $page - 1;
            $start = $page * $perPage;
        } else {
            $start = 0;
        }

        $icss = $letter . "-" . $city . "-" . $state;
        echo $sqlOne = "SELECT name, name_slug FROM name_index WHERE initial_city_state_slug = '" . $icss . "' ORDER BY name ASC LIMIT " . $start . ", " . $perPage;
        $reOne = $db->query($sqlOne); exit();

        $sqlTwo = "SELECT count(ID) as count FROM name_index WHERE initial_city_state_slug = '" . $icss . "' ORDER BY name ASC LIMIT 10000";
        $reTwo = $db->query($sqlTwo);

        if ($reOne->num_rows() > 0) {
            $res['results'] = $reOne->result();
            $total = $reTwo->result();
            $res['total'] = $total[0]->count;

            return $res;
        } else {
            return false;
        }
    }

    function getAllByNameCitySlug($slug) {

        $sql = "SELECT ";
        $re = $db->query($sql);

        if ($re->num_rows() > 0) {
            return $re->result();
        } else {
            return false;
        }
    }

}
