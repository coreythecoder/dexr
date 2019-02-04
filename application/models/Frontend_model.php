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
        $sqlOne = "SELECT name, name_slug FROM name_index WHERE initial_city_state_slug = '" . $icss . "' ORDER BY name ASC LIMIT " . $start . ", " . $perPage;
        $reOne = $db->query($sqlOne);

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

    function getDomainsByCityStateName($city, $state, $name, $limit = 10) {
        $db = $this->load->database('default', TRUE);
        $res = array();

        $ncs = $name . "-" . $city . "-" . $state;
        $sqlOne = "SELECT * FROM production_2 WHERE name_city_slug = '" . $ncs . "' ORDER BY created_date_normalized ASC LIMIT " . $limit;
        $reOne = $db->query($sqlOne);


        $sqlTwo = "SELECT count(ID) as count FROM production_2 WHERE name_city_slug = '" . $ncs . "' ORDER BY created_date_normalized ASC LIMIT 10000";
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

    function getSomeNamesFromLetterCityState($city, $state, $letter, $limit) {
        $db = $this->load->database('default', TRUE);

        $icss = $letter . "-" . $city . "-" . $state;
        $sqlOne = "SELECT name, name_slug FROM name_index WHERE initial_city_state_slug = '" . $icss . "' ORDER BY name ASC LIMIT " . $limit;
        $re = $db->query($sqlOne);

        if ($re->num_rows() > 0) {
            return $re->result();
        } else {
            return false;
        }
    }

    function getSimilarDomains($keywords) {
        $db = $this->load->database('default', TRUE);

        $x = explode(" ", $keywords);
        //$keywords = implode(" +", $x);
        $sql = "SELECT domain_name, registrant_name, name_slug, city_slug, registrant_state FROM production_2 WHERE MATCH(num) AGAINST('+" . $x[0] . "' IN BOOLEAN MODE) LIMIT 5";
        $re = $db->query($sql);

        if ($re->num_rows() > 0) {
            return $re->result();
        } else {
            return false;
        }
    }

    function getSomeNamesByID($id) {
        $db = $this->load->database('default', TRUE);

        $start = $id - 5;
        $end = $id + 5;

        $sql = "SELECT * FROM name_index WHERE ID >= '" . $start . "' AND ID <= '" . $end . "' LIMIT 11";
        $re = $db->query($sql);

        if ($re->num_rows() > 0) {
            return $re->result();
        } else {
            return false;
        }
    }

    function getNameIdFromNameSlugCityState($city, $state, $name) {
        $db = $this->load->database('default', TRUE);

        $sql = "SELECT ID FROM name_index WHERE city_slug = '" . $city . "' AND name_slug = '" . $name . "' AND state = '" . $state . "' LIMIT 1";
        $re = $db->query($sql);

        if ($re->num_rows() > 0) {
            return $re->result();
        } else {
            return false;
        }
    }

}
