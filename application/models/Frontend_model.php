<?php

class Frontend_model extends CI_Model {

    function getAllFromEmail($email, $limit = 10) {
        $db = $this->load->database('default', TRUE);
        $sql = "SELECT domain_name, registrant_email, city_slug, registrant_state, registrant_phone, registrant_address FROM production_2 WHERE registrant_email = '" . $email . "' AND opt_out = '0' LIMIT " . $limit;
        $re = $db->query($sql);

        if ($re->num_rows() > 0) {
            return $re->result();
        } else {
            return false;
        }
    }

    function getAllFromPhone($phone, $limit = 10) {
        $db = $this->load->database('default', TRUE);
        $sql = "SELECT domain_name, city_slug, registrant_state, registrant_phone, registrant_address, registrant_email FROM production_2 WHERE registrant_phone = '" . $phone . "' AND opt_out = '0' LIMIT " . $limit;
        $re = $db->query($sql);

        if ($re->num_rows() > 0) {
            return $re->result();
        } else {
            return false;
        }
    }
    
        function getDomains() {
        $db = $this->load->database('default', TRUE);
        $sql = "SELECT domain_name FROM production_2 LIMIT 1000";
        $re = $db->query($sql);

        if ($re->num_rows() > 0) {
            return $re->result();
        } else {
            return false;
        }
    }

    function getAllFromAddress($address, $limit = 10) {
        $db = $this->load->database('default', TRUE);
        $address = explode("|", $address);
        $sql = "SELECT domain_name, city_slug, registrant_state, registrant_phone, registrant_address, registrant_email FROM production_2 WHERE registrant_address = '" . $address[0] . "' AND city_slug = '" . $address[1] . "' AND registrant_state = '" . $address[2] . "' AND opt_out = '0' LIMIT " . $limit;
        $re = $db->query($sql);

        if ($re->num_rows() > 0) {
            return $re->result();
        } else {
            return false;
        }
    }

    function insertOptOut($POST) {

        $db = $this->load->database('default', TRUE);
        $sql = "INSERT INTO opt_outs SET first = '" . $POST['first'] . "', last = '" . $POST['last'] . "', email = '" . $POST['email'] . "', reg_email = '" . $POST['reg_email'] . "'";
        $db->query($sql);

        //UPDATE PRODUCTION OPT OUT
        $IDs = $this->updateProductionOptOut($POST['reg_email']);

        // FROM IDS, CHECK IF DOMAINS EXISTS FOR NAME-CITY-STATE
        if ($IDs) {
            foreach ($IDs as $ID) {

                //GET NAME FROM PRODUCTION
                $nameInfo = $this->getDomainInfoByID($ID->ID)[0];

                if ($nameInfo) {
                    //UPDATE SIMILAR DOMAINS OPT OUT
                    $this->updateSimilarOptOut($ID->ID);

                    //LOOKUP OTHER EMAILS/NAMES FROM PRODUCTION
                    $names = $this->getDomainsByCityStateName($nameInfo->city_slug, $nameInfo->registrant_state, $nameInfo->name_slug, 1);

                    //IF NONE, UPDATE NAME NAME IN INDEX TO OPT OUT    
                    if (!$names) {
                        $this->updateNameIndexOptOut($nameInfo->name_city_slug);
                    }
                }
            }
        }
    }

    function updateSimilarOptOut($ID) {
        $db = $this->load->database('default', TRUE);

        $sql = "UPDATE similar_domains SET opt_out = '1' WHERE domain_ID = '" . $ID . "' LIMIT 1";
        $db->query($sql);
    }

    function updateProductionOptOut($email) {

        $db = $this->load->database('default', TRUE);

        $sql = "UPDATE production_2 SET opt_out = '1' WHERE registrant_email = '" . $email . "' LIMIT 20";
        $db->query($sql);

        $sqlTwo = "SELECT ID FROM production_2 WHERE registrant_email = '" . $email . "' AND opt_out = '1' LIMIT 20";
        $r = $db->query($sqlTwo);

        return $r->result();
    }

    function updateNameIndexOptOut($nameCitySlug) {

        $db = $this->load->database('default', TRUE);
        $sql = "UPDATE name_index SET opt_out = '1' WHERE name_city_slug = '" . $nameCitySlug . "' LIMIT 1";
        $db->query($sql);
    }

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
        $sqlOne = "SELECT name, name_slug FROM name_index WHERE initial_city_state_slug = '" . $icss . "' AND opt_out = '0' ORDER BY name ASC LIMIT " . $start . ", " . $perPage;
        $reOne = $db->query($sqlOne);

        $sqlTwo = "SELECT count(ID) as count FROM name_index WHERE initial_city_state_slug = '" . $icss . "' AND opt_out = '0' LIMIT 100";
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
        $sqlOne = "SELECT domain_name, num, registrant_name, domain_registrar_name, create_date, update_date, expiry_date, registrant_address, registrant_city, registrant_state, registrant_zip, registrant_email, registrant_phone, registrant_fax, domain_registrar_name, city_slug FROM production_2 WHERE name_city_slug = '" . $ncs . "' AND opt_out = '0' LIMIT " . $limit;
        $reOne = $db->query($sqlOne);


        $sqlTwo = "SELECT ID FROM production_2 WHERE name_city_slug = '" . $ncs . "' AND opt_out = '0' LIMIT 25";
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
        $sqlOne = "SELECT name, name_slug FROM name_index WHERE initial_city_state_slug = '" . $icss . "' AND opt_out = '0' ORDER BY name ASC LIMIT " . $limit;
        $re = $db->query($sqlOne);

        if ($re->num_rows() > 0) {
            return $re->result();
        } else {
            return false;
        }
    }

    function getDomainInfoByID($ID) {
        $db = $this->load->database('default', TRUE);

        $sql = "SELECT domain_name, registrant_name, name_slug, city_slug, registrant_state, name_slug, name_city_slug FROM production_2 WHERE ID = '" . $ID . "' AND name_city_slug IN (SELECT name_city_slug FROM name_index) LIMIT 1";

        $re = $db->query($sql);

        if ($re->num_rows() > 0) {
            return $re->result();
        } else {
            return false;
        }
    }

    function getDomainInfoByDomain($domain, $match_field, $match_value) {

        $db = $this->load->database('default', TRUE);

        $sql = "SELECT * FROM production_2 WHERE domain_name = '" . $domain . "' AND " . $match_field . " = '" . $match_value . "' LIMIT 1";

        $re = $db->query($sql);

        if ($re->num_rows() > 0) {
            $r = $re->result();
            return $r[0];
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
            $sql = "SELECT domain_ID FROM similar_domains WHERE keyword = '" . $longest . "' AND opt_out = '0' LIMIT 7";
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

        $sql = "SELECT * FROM name_index WHERE ID >= '" . $start . "' AND ID <= '" . $end . "' AND opt_out = '0' LIMIT 13";
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

        $sql = "SELECT state, city_slug, name_slug FROM name_index WHERE ID >= '" . $startID . "' AND ID <= '" . $endID . "' AND opt_out = '0'";
        $re = $db->query($sql);

        if ($re->num_rows() > 0) {
            return $re->result();
        } else {
            return false;
        }
    }

}
