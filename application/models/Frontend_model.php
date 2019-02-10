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

        $sqlTwo = "SELECT count(ID) as count FROM city_index WHERE state = '" . $state . "' LIMIT 10000";
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

        $sqlTwo = "SELECT count(ID) as count FROM name_index WHERE initial_city_state_slug = '" . $icss . "' LIMIT 100";
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

    function getDomainsByCityStateName($city, $state, $name, $limit = 5) {
        $db = $this->load->database('default', TRUE);
        $res = array();

        $ncs = $name . "-" . $city . "-" . $state;
        $sqlOne = "SELECT domain_name, num, registrant_name, domain_registrar_name, create_date, update_date, expiry_date, registrant_address, registrant_city, registrant_state, registrant_zip, registrant_email, registrant_phone, registrant_fax, domain_registrar_name FROM production_2 WHERE name_city_slug = '" . $ncs . "' LIMIT " . $limit;
        $reOne = $db->query($sqlOne);


        $sqlTwo = "SELECT ID FROM production_2 WHERE name_city_slug = '" . $ncs . "' LIMIT 50";
        $reTwo = $db->query($sqlTwo);

        if ($reOne->num_rows() > 0) {
            $res['results'] = $reOne->result();
            $res['total'] = $reTwo->num_rows();
            //$res['total'] = $total[0]->count;

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
        array_pop($x);
        
        $longest = longest_value($x);

        //$keywords = implode(" +", $x);
        if (isset($longest) && !empty($longest) && !is_numeric($longest) && strlen($longest) > 4) {
            $sql = "SELECT domain_name, registrant_name, name_slug, city_slug, registrant_state FROM production_2 WHERE MATCH(num) AGAINST('+" . $longest . "' IN BOOLEAN MODE) AND name_city_slug IN (SELECT name_city_slug FROM name_index) LIMIT 5";
            //exit();
            $re = $db->query($sql);

            if ($re->num_rows() > 0) {
                return $re->result();
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function getSomeNamesByID($id) {
        $db = $this->load->database('default', TRUE);

        $start = $id - 6;
        $end = $id + 6;

        $sql = "SELECT * FROM name_index WHERE ID >= '" . $start . "' AND ID <= '" . $end . "' LIMIT 13";
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

    function getNearbyCities($city, $state) {
        $this->load->database();
        $sql = "SELECT lat, lng FROM wp_locations WHERE city = " . $this->db->escape($city) . " AND state_id = '" . $state . "'";
        $re = $this->db->query($sql);
        $r = $re->result();

        if (isset($r[0]->lat)) {

            $sql = "SELECT city, state_id, city_slug, SQRT(
                    POW(69.1 * (lat - " . $r[0]->lat . "), 2) +
                    POW(69.1 * (" . $r[0]->lng . " - lng) * COS(lat / 57.3), 2)) AS distance
                    FROM wp_locations WHERE has_listings = 1 ORDER BY distance ASC LIMIT 22";
            $re = $this->db->query($sql);

            return $re->result();
        } else {
            return false;
        }
    }

    function getSitemapBatch($page) {
        $db = $this->load->database('default', TRUE);

        $perPage = 25000;
        $startID = 1;
        $endID = 25000;

        for ($i = 1; $i < $page; $i++) {
            $startID = $startID + 25000;
            $endID = $endID + 25000;
        }

        $sql = "SELECT state, city_slug, name_slug FROM name_index WHERE ID >= '" . $startID . "' AND ID <= '" . $endID . "'";
        $re = $db->query($sql);

        if ($re->num_rows() > 0) {
            return $re->result();
        } else {
            return false;
        }
    }

}
