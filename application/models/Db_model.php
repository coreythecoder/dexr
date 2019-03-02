<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Db_model extends CI_Model {

    function processDataset($uid, $name, $keys, $matches, $values, $POST, $daterange = false) {

        $db = $this->load->database('default', TRUE);

        // CHECK IF FILTER ID EXISTS & SAVE
        if (!$this->audienceNameExists($name, $uid)) {
            $this->insertFilters($keys, $matches, $values, $name);
        }

        // SAVE DATASET LOG
        if (!$this->datasetExists($uid, $name)) {

            $table = "user_" . $uid . "_" . rand(9999, 99999) . rand(9999, 99999);

            $dataset = $this->insertDataset($uid, $name, $table);
        } else {
            return false;
        }

        // CREATE DATASET
        $this->createDatabaseTable($uid, $name, $POST, $table, $daterange);

        return $this->datasetExists($uid, $name)[0]->ID;
    }

    function datasetExists($uid, $name) {
        $db = $this->load->database('default', TRUE);
        $sql = "SELECT * FROM user_datasets WHERE user_id = '" . $uid . "' AND name = '" . $name . "'";
        $re = $db->query($sql);

        if ($re->num_rows() > 0) {
            return $re->result();
        } else {
            return false;
        }
    }

    function insertDataset($uid, $name, $table) {
        $db = $this->load->database('default', TRUE);
        $sql = "INSERT INTO user_datasets SET user_id = '" . $uid . "', name = '" . $name . "', table_name = '" . $table . "'";
        $re = $db->query($sql);

        return true;
    }

    function createDatabaseTable($uid, $name, $POST, $table, $dateRange) {

        $db = $this->load->database('default', TRUE);

        $newTable = "
CREATE TABLE `" . $table . "` (
  `ID` int(11) NOT NULL,
  `num` varchar(100) NOT NULL,
  `domain_name` varchar(255) NOT NULL,
  `created_date_normalized` varchar(10) NOT NULL,
  `create_date` varchar(255) NOT NULL,
  `update_date` varchar(255) NOT NULL,
  `expiry_date` varchar(255) NOT NULL,
  `domain_registrar_id` varchar(255) NOT NULL,
  `domain_registrar_name` varchar(255) NOT NULL,
  `domain_registrar_whois` varchar(255) NOT NULL,
  `domain_registrar_url` varchar(255) NOT NULL,
  `registrant_name` varchar(255) NOT NULL,
  `registrant_company` varchar(255) NOT NULL,
  `registrant_address` varchar(255) NOT NULL,
  `registrant_city` varchar(255) NOT NULL,
  `registrant_state` varchar(255) NOT NULL,
  `registrant_zip` varchar(255) NOT NULL,
  `registrant_country` varchar(255) NOT NULL,
  `registrant_email` varchar(255) NOT NULL,
  `registrant_phone` varchar(255) NOT NULL,
  `registrant_fax` varchar(255) NOT NULL,
  `administrative_name` varchar(255) NOT NULL,
  `administrative_company` varchar(255) NOT NULL,
  `administrative_address` varchar(255) NOT NULL,
  `administrative_city` varchar(255) NOT NULL,
  `administrative_state` varchar(255) NOT NULL,
  `administrative_zip` varchar(255) NOT NULL,
  `administrative_country` varchar(255) NOT NULL,
  `administrative_email` varchar(255) NOT NULL,
  `administrative_phone` varchar(255) NOT NULL,
  `administrative_fax` varchar(255) NOT NULL,
  `technical_name` varchar(255) NOT NULL,
  `technical_company` varchar(255) NOT NULL,
  `technical_address` varchar(255) NOT NULL,
  `technical_city` varchar(255) NOT NULL,
  `technical_state` varchar(255) NOT NULL,
  `technical_zip` varchar(255) NOT NULL,
  `technical_country` varchar(255) NOT NULL,
  `technical_email` varchar(255) NOT NULL,
  `technical_phone` varchar(255) NOT NULL,
  `technical_fax` varchar(255) NOT NULL,
  `billing_name` varchar(255) NOT NULL,
  `billing_company` varchar(255) NOT NULL,
  `billing_address` varchar(255) NOT NULL,
  `billing_city` varchar(255) NOT NULL,
  `billing_state` varchar(255) NOT NULL,
  `billing_zip` varchar(255) NOT NULL,
  `billing_country` varchar(255) NOT NULL,
  `billing_email` varchar(255) NOT NULL,
  `billing_phone` varchar(255) NOT NULL,
  `billing_fax` varchar(255) NOT NULL,
  `name_server_1` varchar(255) NOT NULL,
  `name_server_2` varchar(255) NOT NULL,
  `name_server_3` varchar(255) NOT NULL,
  `name_server_4` varchar(255) NOT NULL,
  `domain_status_1` varchar(255) NOT NULL,
  `domain_status_2` varchar(255) NOT NULL,
  `domain_status_3` varchar(255) NOT NULL,
  `domain_status_4` varchar(255) NOT NULL,
  `name_slug` varchar(100) NOT NULL,
  `company_slug` varchar(150) NOT NULL,
  `address_slug` varchar(150) NOT NULL,
  `city_slug` varchar(50) NOT NULL,
  `name_city_slug` varchar(255) NOT NULL,
  `opt_out` INT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";


        $alterTable = "ALTER TABLE `" . $table . "`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `name_slug` (`name_slug`),
  ADD KEY `company_slug` (`company_slug`),
  ADD KEY `address_slug` (`address_slug`),
  ADD KEY `city_slug` (`city_slug`),
  ADD KEY `registrant_phone` (`registrant_phone`),
  ADD KEY `registrant_email` (`registrant_email`),
  ADD KEY `domain_index` (`domain_name`),
  ADD KEY `registrant_city` (`registrant_city`),
  ADD KEY `registrant_name` (`registrant_name`),
  ADD KEY `registrant_company` (`registrant_company`),
  ADD KEY `registrant_address` (`registrant_address`),
  ADD KEY `registrant_state` (`registrant_state`),
  ADD KEY `registrant_zip` (`registrant_zip`),
  ADD KEY `create_date` (`create_date`),
  ADD KEY `domain_name` (`domain_name`),
  ADD KEY `name_city_slug` (`name_city_slug`),
  ADD KEY `created_date_normalized` (`created_date_normalized`),
  ADD FULLTEXT `num` (`num`);";

        $alterTableTwo = "ALTER TABLE `" . $table . "`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT";
        $db->query($newTable);
        $db->query($alterTable);
        $db->query($alterTableTwo);

        // GET COLUMNS
        $cols = $this->db->list_fields($table);

        //CREATE NEW TABLE

        $this->transferTable($POST, 10000, $dateRange, $table, $cols);
        //$sql = "INSERT INTO " . $table . " (" . trim(rtrim(implode(", ", $cols), ", ")) . ") SELECT " . trim(rtrim(implode(", ", $cols), ", ")) . " FROM production_2 LIMIT 10000";
        //$db->query($sql);
        return true;
    }

    function applyFilters($POST, $limit = 100, $dateRange) {

        $domainName = "";
        $city = "";
        $state = "";
        $country = "";
        $email = "";
        $registrar = "";
        $registrantName = "";
        $org = "";
        $street = "";
        $zip = "";
        $phone = "";
        $country = "";
        $name = "";

        $i = 0;
        if (!empty($POST['keyword'])) {
            $res = "";
            $res = "SELECT domain_name,created_date_normalized,update_date,expiry_date,registrant_name,registrant_company,registrant_address,registrant_city,registrant_state,registrant_zip,registrant_email,registrant_phone,registrant_fax FROM production_2 WHERE ";

            $pot = array();

            if (isset($dateRange) && !empty($dateRange)) {
                $e = explode(" - ", $dateRange);
                $startDate = $e[0];
                $endDate = $e[1];
                //$res .= " ((STR_TO_DATE(create_date, '%Y-%m-%d %H:%i:%s UTC') >= STR_TO_DATE('" . $startDate . "', '%m/%d/%Y') AND STR_TO_DATE(create_date, '%Y-%m-%d %H:%i:%s UTC') <= STR_TO_DATE('" . $endDate . "', '%m/%d/%Y')) OR (STR_TO_DATE(create_date, '%d-%b-%y') >= STR_TO_DATE('" . $startDate . "', '%m/%d/%Y') AND STR_TO_DATE(create_date, '%d-%b-%y') <= STR_TO_DATE('" . $endDate . "', '%m/%d/%Y'))) AND ";

                $startDate = explode('/', $startDate);
                $endDate = explode('/', $endDate);
                $startDate = $startDate[2] . "-" . $startDate[0] . "-" . $startDate[1];
                $endDate = $endDate[2] . "-" . $endDate[0] . "-" . $endDate[1];

                $res .= " created_date_normalized >= '" . $startDate . "' AND created_date_normalized <= '" . $endDate . "' + INTERVAL 1 DAY AND ";
            }

            foreach ($POST['keyword'] as $keyword) {
                if (!empty($POST['keyword'][$i])) {

                    if ($POST['type'][$i] == 'equals') {
                        $type = "=";
                    } elseif ($POST['type'][$i] == 'not_equals') {
                        $type = "!=";
                    } elseif ($POST['type'][$i] == 'not_contains') {
                        $type = "NOT REGEXP";
                    } else {
                        $type = "REGEXP";
                    }

                    if ($POST['col'][$i] == 'domainName' && $type !== 'REGEXP') {
                        if (!empty($domainName) && $POST['type'][$i] !== 'not_equals' && $POST['type'][$i] !== 'not_contains') {
                            $pot[] = $i;
                        } if (!empty($domainName)) {
                            $domainName .= " AND domain_name = '" . $POST['keyword'][$i] . "'";
                        } else {
                            $domainName .= "domain_name = '" . $POST['keyword'][$i] . "'";
                        }
                    } elseif ($POST['col'][$i] == 'domainName' && $type == 'REGEXP') {
                        if (!empty($domainName) && $POST['type'][$i] !== 'not_equals' && $POST['type'][$i] !== 'not_contains') {
                            $pot[] = $i;
                        } if (!empty($domainName)) {
                            $domainName .= " AND MATCH(num) AGAINST('" . $POST['keyword'][$i] . "' IN BOOLEAN MODE)";
                        } else {
                            $domainName .= "MATCH(num) AGAINST('" . $POST['keyword'][$i] . "' IN BOOLEAN MODE)";
                        }
                    }

                    if ($POST['col'][$i] == 'registrant_city') {
                        if (!empty($city) && $POST['type'][$i] !== 'not_equals' && $POST['type'][$i] !== 'not_contains') {
                            $pot[] = $i;
                        } if (!empty($city)) {
                            $city .= " AND registrant_city " . $type . " '" . $POST['keyword'][$i] . "'";
                        } else {
                            $city .= "registrant_city " . $type . " '" . $POST['keyword'][$i] . "'";
                        }
                    }

                    if ($POST['col'][$i] == 'registrant_state') {
                        if (!empty($state) && $POST['type'][$i] !== 'not_equals' && $POST['type'][$i] !== 'not_contains') {
                            $pot[] = $i;
                        } if (!empty($state)) {
                            $state .= " AND registrant_state " . $type . " '" . $POST['keyword'][$i] . "'";
                        } else {
                            $state .= "registrant_state " . $type . " '" . $POST['keyword'][$i] . "'";
                        }
                    }

                    if ($POST['col'][$i] == 'registrant_country') {
                        if (!empty($country) && $POST['type'][$i] !== 'not_equals' && $POST['type'][$i] !== 'not_contains') {
                            $pot[] = $i;
                        } if (!empty($country)) {
                            $country .= " AND registrant_country " . $type . " '" . $POST['keyword'][$i] . "'";
                        } else {
                            $country .= "registrant_country " . $type . " '" . $POST['keyword'][$i] . "'";
                        }
                    }

                    if ($POST['col'][$i] == 'contactEmail') {
                        if (!empty($email) && $POST['type'][$i] !== 'not_equals' && $POST['type'][$i] !== 'not_contains') {
                            $pot[] = $i;
                        } if (!empty($email)) {
                            $email .= " AND registrant_email " . $type . " '" . $POST['keyword'][$i] . "'";
                        } else {
                            $email .= "registrant_email " . $type . " '" . $POST['keyword'][$i] . "'";
                        }
                    }

                    if ($POST['col'][$i] == 'registrarName') {
                        if (!empty($registrar) && $POST['type'][$i] !== 'not_equals' && $POST['type'][$i] !== 'not_contains') {
                            $pot[] = $i;
                        } if (!empty($registrar)) {
                            $registrar .= " AND domain_registrar_name " . $type . " '" . $POST['keyword'][$i] . "'";
                        } else {
                            $registrar .= "domain_registrar_name " . $type . " '" . $POST['keyword'][$i] . "'";
                        }
                    }

                    if ($POST['col'][$i] == 'registrant_name') {
                        if (!empty($name) && $POST['type'][$i] !== 'not_equals' && $POST['type'][$i] !== 'not_contains') {
                            $pot[] = $i;
                        } if (!empty($name)) {
                            $name .= " AND registrant_name " . $type . " '" . $POST['keyword'][$i] . "'";
                        } else {
                            $name .= "registrant_name " . $type . " '" . $POST['keyword'][$i] . "'";
                        }
                    }

                    if ($POST['col'][$i] == 'registrant_organization') {
                        if (!empty($org) && $POST['type'][$i] !== 'not_equals' && $POST['type'][$i] !== 'not_contains') {
                            $pot[] = $i;
                        } if (!empty($org)) {
                            $org .= " AND registrant_company " . $type . " '" . $POST['keyword'][$i] . "'";
                        } else {
                            $org .= "registrant_company " . $type . " '" . $POST['keyword'][$i] . "'";
                        }
                    }

                    if ($POST['col'][$i] == 'registrant_street1') {
                        if (!empty($address) && $POST['type'][$i] !== 'not_equals' && $POST['type'][$i] !== 'not_contains') {
                            $pot[] = $i;
                        } if (!empty($address)) {
                            $address .= " AND registrant_address " . $type . " '" . $POST['keyword'][$i] . "'";
                        } else {
                            $address .= "registrant_address " . $type . " '" . $POST['keyword'][$i] . "'";
                        }
                    }

                    if ($POST['col'][$i] == 'registrant_postalCode') {
                        if (!empty($zip) && $POST['type'][$i] !== 'not_equals' && $POST['type'][$i] !== 'not_contains') {
                            $pot[] = $i;
                        } if (!empty($zip)) {
                            $zip .= " AND registrant_zip " . $type . " '" . $POST['keyword'][$i] . "'";
                        } else {
                            $zip .= "registrant_zip " . $type . " '" . $POST['keyword'][$i] . "'";
                        }
                    }

                    if ($POST['col'][$i] == 'registrant_telephone') {
                        if (!empty($phone) && $POST['type'][$i] !== 'not_equals' && $POST['type'][$i] !== 'not_contains') {
                            $pot[] = $i;
                        } if (!empty($phone)) {
                            $phone .= " AND registrant_phone " . $type . " '" . $POST['keyword'][$i] . "'";
                        } else {
                            $phone .= "registrant_phone " . $type . " '" . $POST['keyword'][$i] . "'";
                        }
                    }
                }
                $i++;
            }

            if (!empty($domainName)) {
                $peices[] = $domainName;
            }
            if (!empty($city)) {
                $peices[] = $city;
            }
            if (!empty($state)) {
                $peices[] = $state;
            }
            if (!empty($country)) {
                $peices[] = $country;
            }
            if (!empty($email)) {
                $peices[] = $email;
            }
            if (!empty($registrar)) {
                $peices[] = $registrar;
            }
            if (!empty($name)) {
                $peices[] = $name;
            }
            if (!empty($org)) {
                $peices[] = $org;
            }
            if (!empty($address)) {
                $peices[] = $address;
            }
            if (!empty($zip)) {
                $peices[] = $zip;
            }
            if (!empty($phone)) {
                $peices[] = $phone;
            }
            if (!empty($country)) {
                $peices[] = $country;
            }

            $query = implode(" AND ", $peices);
            $res .= $query;

            if (!empty($pot)) {
                foreach ($pot as $p) {
                    $colName = $POST['col'][$p];
                    $res .= " OR ";

                    if ($POST['type'][$p] == 'equals') {
                        $type = "=";
                    } elseif ($POST['type'][$p] == 'not_equals') {
                        $type = "!=";
                    } elseif ($POST['type'][$p] == 'not_contains') {
                        $type = "NOT REGEXP";
                    } else {
                        $type = "REGEXP";
                    }

                    $parts = explode(" AND ", $query);
                    $e = 0;
                    foreach ($parts as $part) {
                        if (strpos($part, $POST['col'][$p]) !== false) {
                            $parts[$e] = $POST['col'][$p] . " " . $type . " '" . $POST['keyword'][$p] . "'";
                        }
                        $e++;
                    }

                    $res .= implode(" AND ", $parts);
                }
            } else {
                //$res = $res;
            }
        }

        $db = $this->load->database('default', TRUE);
        //echo $res;
        // echo $res . " GROUP BY registrant_organization LIMIT " . $limit; exit();
        //echo $res . " LIMIT " . $limit; exit();

        $re = $db->query($res . " LIMIT " . $limit);
        $r = $re->result();

        return $r;
    }

    function transferTable($POST, $limit = 100, $dateRange, $table, $cols) {

        $domainName = "";
        $city = "";
        $state = "";
        $country = "";
        $email = "";
        $registrar = "";
        $registrantName = "";
        $org = "";
        $street = "";
        $zip = "";
        $phone = "";
        $country = "";
        $name = "";

        if (!empty($POST['keyword'])) {
            $res = "";

            $res .= "INSERT INTO " . $table . " (" . trim(rtrim(implode(", ", $cols), ", ")) . ") ";

            $res .= "SELECT * FROM production_2 WHERE ";

            $pot = array();

            if (isset($dateRange) && !empty($dateRange)) {
                $e = explode(" - ", $dateRange);
                $startDate = $e[0];
                $endDate = $e[1];
                //$res .= " ((STR_TO_DATE(create_date, '%Y-%m-%d %H:%i:%s UTC') >= STR_TO_DATE('" . $startDate . "', '%m/%d/%Y') AND STR_TO_DATE(create_date, '%Y-%m-%d %H:%i:%s UTC') <= STR_TO_DATE('" . $endDate . "', '%m/%d/%Y')) OR (STR_TO_DATE(create_date, '%d-%b-%y') >= STR_TO_DATE('" . $startDate . "', '%m/%d/%Y') AND STR_TO_DATE(create_date, '%d-%b-%y') <= STR_TO_DATE('" . $endDate . "', '%m/%d/%Y'))) AND ";

                 $startDate = explode('/', $startDate);
                $endDate = explode('/', $endDate);
                $startDate = $startDate[2] . "-" . $startDate[0] . "-" . $startDate[1];
                $endDate = $endDate[2] . "-" . $endDate[0] . "-" . $endDate[1];

                $res .= " created_date_normalized >= '" . $startDate . "' AND created_date_normalized <= '" . $endDate . "' + INTERVAL 1 DAY AND ";
            }

            foreach ($POST['keyword'] as $keyword) {
                if (!empty($POST['keyword'][$i])) {


                    if ($POST['type'][$i] == 'equals') {
                        $type = "=";
                    } elseif ($POST['type'][$i] == 'not_equals') {
                        $type = "!=";
                    } elseif ($POST['type'][$i] == 'not_contains') {
                        $type = "NOT REGEXP";
                    } else {
                        $type = "REGEXP";
                    }

                    if ($POST['col'][$i] == 'domainName' && $type !== 'REGEXP') {
                        if (!empty($domainName) && $POST['type'][$i] !== 'not_equals' && $POST['type'][$i] !== 'not_contains') {
                            $pot[] = $i;
                        } if (!empty($domainName)) {
                            $domainName .= " AND domain_name = '" . $POST['keyword'][$i] . "'";
                        } else {
                            $domainName .= "domain_name = '" . $POST['keyword'][$i] . "'";
                        }
                    } elseif ($POST['col'][$i] == 'domainName' && $type == 'REGEXP') {
                        if (!empty($domainName) && $POST['type'][$i] !== 'not_equals' && $POST['type'][$i] !== 'not_contains') {
                            $pot[] = $i;
                        } if (!empty($domainName)) {
                            $domainName .= " AND MATCH(num) AGAINST('" . $POST['keyword'][$i] . "' IN BOOLEAN MODE)";
                        } else {
                            $domainName .= "MATCH(num) AGAINST('" . $POST['keyword'][$i] . "' IN BOOLEAN MODE)";
                        }
                    }

                    if ($POST['col'][$i] == 'registrant_city') {
                        if (!empty($city) && $POST['type'][$i] !== 'not_equals' && $POST['type'][$i] !== 'not_contains') {
                            $pot[] = $i;
                        } if (!empty($city)) {
                            $city .= " AND registrant_city " . $type . " '" . $POST['keyword'][$i] . "'";
                        } else {
                            $city .= "registrant_city " . $type . " '" . $POST['keyword'][$i] . "'";
                        }
                    }

                    if ($POST['col'][$i] == 'registrant_state') {
                        if (!empty($state) && $POST['type'][$i] !== 'not_equals' && $POST['type'][$i] !== 'not_contains') {
                            $pot[] = $i;
                        } if (!empty($state)) {
                            $state .= " AND registrant_state " . $type . " '" . $POST['keyword'][$i] . "'";
                        } else {
                            $state .= "registrant_state " . $type . " '" . $POST['keyword'][$i] . "'";
                        }
                    }

                    if ($POST['col'][$i] == 'registrant_country') {
                        if (!empty($country) && $POST['type'][$i] !== 'not_equals' && $POST['type'][$i] !== 'not_contains') {
                            $pot[] = $i;
                        } if (!empty($country)) {
                            $country .= " AND registrant_country " . $type . " '" . $POST['keyword'][$i] . "'";
                        } else {
                            $country .= "registrant_country " . $type . " '" . $POST['keyword'][$i] . "'";
                        }
                    }

                    if ($POST['col'][$i] == 'contactEmail') {
                        if (!empty($email) && $POST['type'][$i] !== 'not_equals' && $POST['type'][$i] !== 'not_contains') {
                            $pot[] = $i;
                        } if (!empty($email)) {
                            $email .= " AND registrant_email " . $type . " '" . $POST['keyword'][$i] . "'";
                        } else {
                            $email .= "registrant_email " . $type . " '" . $POST['keyword'][$i] . "'";
                        }
                    }

                    if ($POST['col'][$i] == 'registrarName') {
                        if (!empty($registrar) && $POST['type'][$i] !== 'not_equals' && $POST['type'][$i] !== 'not_contains') {
                            $pot[] = $i;
                        } if (!empty($registrar)) {
                            $registrar .= " AND domain_registrar_name " . $type . " '" . $POST['keyword'][$i] . "'";
                        } else {
                            $registrar .= "domain_registrar_name " . $type . " '" . $POST['keyword'][$i] . "'";
                        }
                    }

                    if ($POST['col'][$i] == 'registrant_name') {
                        if (!empty($name) && $POST['type'][$i] !== 'not_equals' && $POST['type'][$i] !== 'not_contains') {
                            $pot[] = $i;
                        } if (!empty($name)) {
                            $name .= " AND registrant_name " . $type . " '" . $POST['keyword'][$i] . "'";
                        } else {
                            $name .= "registrant_name " . $type . " '" . $POST['keyword'][$i] . "'";
                        }
                    }

                    if ($POST['col'][$i] == 'registrant_organization') {
                        if (!empty($org) && $POST['type'][$i] !== 'not_equals' && $POST['type'][$i] !== 'not_contains') {
                            $pot[] = $i;
                        } if (!empty($org)) {
                            $org .= " AND registrant_company " . $type . " '" . $POST['keyword'][$i] . "'";
                        } else {
                            $org .= "registrant_company " . $type . " '" . $POST['keyword'][$i] . "'";
                        }
                    }

                    if ($POST['col'][$i] == 'registrant_street1') {
                        if (!empty($address) && $POST['type'][$i] !== 'not_equals' && $POST['type'][$i] !== 'not_contains') {
                            $pot[] = $i;
                        } if (!empty($address)) {
                            $address .= " AND registrant_address " . $type . " '" . $POST['keyword'][$i] . "'";
                        } else {
                            $address .= "registrant_address " . $type . " '" . $POST['keyword'][$i] . "'";
                        }
                    }

                    if ($POST['col'][$i] == 'registrant_postalCode') {
                        if (!empty($zip) && $POST['type'][$i] !== 'not_equals' && $POST['type'][$i] !== 'not_contains') {
                            $pot[] = $i;
                        } if (!empty($zip)) {
                            $zip .= " AND registrant_zip " . $type . " '" . $POST['keyword'][$i] . "'";
                        } else {
                            $zip .= "registrant_zip " . $type . " '" . $POST['keyword'][$i] . "'";
                        }
                    }

                    if ($POST['col'][$i] == 'registrant_telephone') {
                        if (!empty($phone) && $POST['type'][$i] !== 'not_equals' && $POST['type'][$i] !== 'not_contains') {
                            $pot[] = $i;
                        } if (!empty($phone)) {
                            $phone .= " AND registrant_phone " . $type . " '" . $POST['keyword'][$i] . "'";
                        } else {
                            $phone .= "registrant_phone " . $type . " '" . $POST['keyword'][$i] . "'";
                        }
                    }
                }
                $i++;
            }

            if (!empty($domainName)) {
                $peices[] = $domainName;
            }
            if (!empty($city)) {
                $peices[] = $city;
            }
            if (!empty($state)) {
                $peices[] = $state;
            }
            if (!empty($country)) {
                $peices[] = $country;
            }
            if (!empty($email)) {
                $peices[] = $email;
            }
            if (!empty($registrar)) {
                $peices[] = $registrar;
            }
            if (!empty($name)) {
                $peices[] = $name;
            }
            if (!empty($org)) {
                $peices[] = $org;
            }
            if (!empty($address)) {
                $peices[] = $address;
            }
            if (!empty($zip)) {
                $peices[] = $zip;
            }
            if (!empty($phone)) {
                $peices[] = $phone;
            }
            if (!empty($country)) {
                $peices[] = $country;
            }

            $query = implode(" AND ", $peices);
            $res .= $query;

            if (!empty($pot)) {
                foreach ($pot as $p) {
                    $colName = $POST['col'][$p];
                    $res .= " OR ";

                    if ($POST['type'][$p] == 'equals') {
                        $type = "=";
                    } elseif ($POST['type'][$p] == 'not_equals') {
                        $type = "!=";
                    } elseif ($POST['type'][$p] == 'not_contains') {
                        $type = "NOT REGEXP";
                    } else {
                        $type = "REGEXP";
                    }

                    $parts = explode(" AND ", $query);
                    $e = 0;
                    foreach ($parts as $part) {
                        if (strpos($part, $POST['col'][$p]) !== false) {
                            $parts[$e] = $POST['col'][$p] . " " . $type . " '" . $POST['keyword'][$p] . "'";
                        }
                        $e++;
                    }


                    $res .= implode(" AND ", $parts);
                }
            } else {
                //$res = $res;
            }
        }

        $db = $this->load->database('default', TRUE);
        //echo $res;
        // echo $res . " GROUP BY registrant_organization LIMIT " . $limit; exit();
        //echo $res . " LIMIT " . $limit;
        //echo $res . " LIMIT " . $limit;
        //exit();

        $re = $db->query($res . " LIMIT " . $limit);

        return true;
    }

    function applyFiltersDataset($table_name, $POST, $limit = 100, $dateRange, $page) {

        $page--;
        $start = $page * $limit;

        $domainName = "";
        $city = "";
        $state = "";
        $country = "";
        $email = "";
        $registrar = "";
        $registrantName = "";
        $org = "";
        $street = "";
        $zip = "";
        $phone = "";
        $country = "";
        $name = "";

        $i = 0;
        if (!empty($POST['keyword'][0])) {
            $res = "";
            $res = "SELECT ID, domain_name,create_date,update_date,expiry_date,registrant_name,registrant_company,registrant_address,registrant_city,registrant_state,registrant_zip,registrant_email,registrant_phone,registrant_fax FROM " . $table_name . " WHERE ";

            $pot = array();

            if (isset($dateRange) && !empty($dateRange)) {
                $e = explode(" - ", $dateRange);
                $startDate = $e[0];
                $endDate = $e[1];
                //$res .= " ((STR_TO_DATE(create_date, '%Y-%m-%d %H:%i:%s UTC') >= STR_TO_DATE('" . $startDate . "', '%m/%d/%Y') AND STR_TO_DATE(create_date, '%Y-%m-%d %H:%i:%s UTC') <= STR_TO_DATE('" . $endDate . "', '%m/%d/%Y')) OR (STR_TO_DATE(create_date, '%d-%b-%y') >= STR_TO_DATE('" . $startDate . "', '%m/%d/%Y') AND STR_TO_DATE(create_date, '%d-%b-%y') <= STR_TO_DATE('" . $endDate . "', '%m/%d/%Y'))) AND ";

                 $startDate = explode('/', $startDate);
                $endDate = explode('/', $endDate);
                $startDate = $startDate[2] . "-" . $startDate[0] . "-" . $startDate[1];
                $endDate = $endDate[2] . "-" . $endDate[0] . "-" . $endDate[1];

                $res .= " created_date_normalized >= '" . $startDate . "' AND created_date_normalized <= '" . $endDate . "' + INTERVAL 1 DAY AND ";
            }

            foreach ($POST['keyword'] as $keyword) {
                if (!empty($POST['keyword'][$i])) {

                    if ($POST['type'][$i] == 'equals') {
                        $type = "=";
                    } elseif ($POST['type'][$i] == 'not_equals') {
                        $type = "!=";
                    } elseif ($POST['type'][$i] == 'not_contains') {
                        $type = "NOT REGEXP";
                    } else {
                        $type = "REGEXP";
                    }

                    if ($POST['col'][$i] == 'domainName' && $type !== 'REGEXP') {
                        if (!empty($domainName) && $POST['type'][$i] !== 'not_equals' && $POST['type'][$i] !== 'not_contains') {
                            $pot[] = $i;
                        } if (!empty($domainName)) {
                            $domainName .= " AND domain_name = '" . $POST['keyword'][$i] . "'";
                        } else {
                            $domainName .= "domain_name = '" . $POST['keyword'][$i] . "'";
                        }
                    } elseif ($POST['col'][$i] == 'domainName' && $type == 'REGEXP') {
                        if (!empty($domainName) && $POST['type'][$i] !== 'not_equals' && $POST['type'][$i] !== 'not_contains') {
                            $pot[] = $i;
                        } if (!empty($domainName)) {
                            $domainName .= " AND MATCH(num) AGAINST('" . $POST['keyword'][$i] . "' IN BOOLEAN MODE)";
                        } else {
                            $domainName .= "MATCH(num) AGAINST('" . $POST['keyword'][$i] . "' IN BOOLEAN MODE)";
                        }
                    }

                    if ($POST['col'][$i] == 'registrant_city') {
                        if (!empty($city) && $POST['type'][$i] !== 'not_equals' && $POST['type'][$i] !== 'not_contains') {
                            $pot[] = $i;
                        } if (!empty($city)) {
                            $city .= " AND registrant_city " . $type . " '" . $POST['keyword'][$i] . "'";
                        } else {
                            $city .= "registrant_city " . $type . " '" . $POST['keyword'][$i] . "'";
                        }
                    }

                    if ($POST['col'][$i] == 'registrant_state') {
                        if (!empty($state) && $POST['type'][$i] !== 'not_equals' && $POST['type'][$i] !== 'not_contains') {
                            $pot[] = $i;
                        } if (!empty($state)) {
                            $state .= " AND registrant_state " . $type . " '" . $POST['keyword'][$i] . "'";
                        } else {
                            $state .= "registrant_state " . $type . " '" . $POST['keyword'][$i] . "'";
                        }
                    }

                    if ($POST['col'][$i] == 'registrant_country') {
                        if (!empty($country) && $POST['type'][$i] !== 'not_equals' && $POST['type'][$i] !== 'not_contains') {
                            $pot[] = $i;
                        } if (!empty($country)) {
                            $country .= " AND registrant_country " . $type . " '" . $POST['keyword'][$i] . "'";
                        } else {
                            $country .= "registrant_country " . $type . " '" . $POST['keyword'][$i] . "'";
                        }
                    }

                    if ($POST['col'][$i] == 'contactEmail') {
                        if (!empty($email) && $POST['type'][$i] !== 'not_equals' && $POST['type'][$i] !== 'not_contains') {
                            $pot[] = $i;
                        } if (!empty($email)) {
                            $email .= " AND registrant_email " . $type . " '" . $POST['keyword'][$i] . "'";
                        } else {
                            $email .= "registrant_email " . $type . " '" . $POST['keyword'][$i] . "'";
                        }
                    }

                    if ($POST['col'][$i] == 'registrarName') {
                        if (!empty($registrar) && $POST['type'][$i] !== 'not_equals' && $POST['type'][$i] !== 'not_contains') {
                            $pot[] = $i;
                        } if (!empty($registrar)) {
                            $registrar .= " AND domain_registrar_name " . $type . " '" . $POST['keyword'][$i] . "'";
                        } else {
                            $registrar .= "domain_registrar_name " . $type . " '" . $POST['keyword'][$i] . "'";
                        }
                    }

                    if ($POST['col'][$i] == 'registrant_name') {
                        if (!empty($name) && $POST['type'][$i] !== 'not_equals' && $POST['type'][$i] !== 'not_contains') {
                            $pot[] = $i;
                        } if (!empty($name)) {
                            $name .= " AND registrant_name " . $type . " '" . $POST['keyword'][$i] . "'";
                        } else {
                            $name .= "registrant_name " . $type . " '" . $POST['keyword'][$i] . "'";
                        }
                    }

                    if ($POST['col'][$i] == 'registrant_organization') {
                        if (!empty($org) && $POST['type'][$i] !== 'not_equals' && $POST['type'][$i] !== 'not_contains') {
                            $pot[] = $i;
                        } if (!empty($org)) {
                            $org .= " AND registrant_company " . $type . " '" . $POST['keyword'][$i] . "'";
                        } else {
                            $org .= "registrant_company " . $type . " '" . $POST['keyword'][$i] . "'";
                        }
                    }

                    if ($POST['col'][$i] == 'registrant_street1') {
                        if (!empty($address) && $POST['type'][$i] !== 'not_equals' && $POST['type'][$i] !== 'not_contains') {
                            $pot[] = $i;
                        } if (!empty($address)) {
                            $address .= " AND registrant_address " . $type . " '" . $POST['keyword'][$i] . "'";
                        } else {
                            $address .= "registrant_address " . $type . " '" . $POST['keyword'][$i] . "'";
                        }
                    }

                    if ($POST['col'][$i] == 'registrant_postalCode') {
                        if (!empty($zip) && $POST['type'][$i] !== 'not_equals' && $POST['type'][$i] !== 'not_contains') {
                            $pot[] = $i;
                        } if (!empty($zip)) {
                            $zip .= " AND registrant_zip " . $type . " '" . $POST['keyword'][$i] . "'";
                        } else {
                            $zip .= "registrant_zip " . $type . " '" . $POST['keyword'][$i] . "'";
                        }
                    }

                    if ($POST['col'][$i] == 'registrant_telephone') {
                        if (!empty($phone) && $POST['type'][$i] !== 'not_equals' && $POST['type'][$i] !== 'not_contains') {
                            $pot[] = $i;
                        } if (!empty($phone)) {
                            $phone .= " AND registrant_phone " . $type . " '" . $POST['keyword'][$i] . "'";
                        } else {
                            $phone .= "registrant_phone " . $type . " '" . $POST['keyword'][$i] . "'";
                        }
                    }
                }
                $i++;
            }

            if (!empty($domainName)) {
                $peices[] = $domainName;
            }
            if (!empty($city)) {
                $peices[] = $city;
            }
            if (!empty($state)) {
                $peices[] = $state;
            }
            if (!empty($country)) {
                $peices[] = $country;
            }
            if (!empty($email)) {
                $peices[] = $email;
            }
            if (!empty($registrar)) {
                $peices[] = $registrar;
            }
            if (!empty($name)) {
                $peices[] = $name;
            }
            if (!empty($org)) {
                $peices[] = $org;
            }
            if (!empty($address)) {
                $peices[] = $address;
            }
            if (!empty($zip)) {
                $peices[] = $zip;
            }
            if (!empty($phone)) {
                $peices[] = $phone;
            }
            if (!empty($country)) {
                $peices[] = $country;
            }

            $query = implode(" AND ", $peices);
            $res .= $query;

            if (!empty($pot)) {
                foreach ($pot as $p) {
                    $colName = $POST['col'][$p];
                    $res .= " OR ";

                    if ($POST['type'][$p] == 'equals') {
                        $type = "=";
                    } elseif ($POST['type'][$p] == 'not_equals') {
                        $type = "!=";
                    } elseif ($POST['type'][$p] == 'not_contains') {
                        $type = "NOT REGEXP";
                    } else {
                        $type = "REGEXP";
                    }

                    $parts = explode(" AND ", $query);
                    $e = 0;
                    foreach ($parts as $part) {
                        if (strpos($part, $POST['col'][$p]) !== false) {
                            $parts[$e] = $POST['col'][$p] . " " . $type . " '" . $POST['keyword'][$p] . "'";
                        }
                        $e++;
                    }


                    $res .= implode(" AND ", $parts);
                }
            } else {
                //$res = $res;
            }
        } else {
            $res = "SELECT * FROM " . $table_name;
        }

        $res .= " ORDER BY ID LIMIT " . $start . ", " . $limit;

        $db = $this->load->database('default', TRUE);
        //echo $res;
        // echo $res . " GROUP BY registrant_organization LIMIT " . $limit; exit();
        //echo $res . " LIMIT " . $limit;
        //echo $res . " LIMIT " . $limit;
        //exit();

        $re = $db->query($res);
        $r = $re->result();

        return $r;
    }

    function applyFiltersDataset_count($table_name, $POST, $limit = 100, $dateRange, $page) {

        $page--;
        $start = $page * $limit;

        $domainName = "";
        $city = "";
        $state = "";
        $country = "";
        $email = "";
        $registrar = "";
        $registrantName = "";
        $org = "";
        $street = "";
        $zip = "";
        $phone = "";
        $country = "";
        $name = "";

        $i = 0;
        if (!empty($POST['keyword'][0])) {
            $res = "";
            $res = "SELECT ID FROM " . $table_name . " USE INDEX (domain_index) WHERE ";

            $pot = array();

            if (isset($dateRange) && !empty($dateRange)) {
                $e = explode(" - ", $dateRange);
                $startDate = $e[0];
                $endDate = $e[1];
                //$res .= " ((STR_TO_DATE(create_date, '%Y-%m-%d %H:%i:%s UTC') >= STR_TO_DATE('" . $startDate . "', '%m/%d/%Y') AND STR_TO_DATE(create_date, '%Y-%m-%d %H:%i:%s UTC') <= STR_TO_DATE('" . $endDate . "', '%m/%d/%Y')) OR (STR_TO_DATE(create_date, '%d-%b-%y') >= STR_TO_DATE('" . $startDate . "', '%m/%d/%Y') AND STR_TO_DATE(create_date, '%d-%b-%y') <= STR_TO_DATE('" . $endDate . "', '%m/%d/%Y'))) AND ";

                $startDate = explode('/', $startDate);
                $endDate = explode('/', $endDate);
                $startDate = array_reverse($startDate);
                $endDate = array_reverse($endDate);

                $res .= " created_date_normalized >= '" . implode('-', $startDate) . "' AND created_date_normalized <= '" . implode('-', $endDate) . "' + INTERVAL 1 DAY AND ";
            }

            foreach ($POST['keyword'] as $keyword) {
                if (!empty($POST['keyword'][$i])) {

                    if ($POST['type'][$i] == 'equals') {
                        $type = "=";
                    } elseif ($POST['type'][$i] == 'not_equals') {
                        $type = "!=";
                    } elseif ($POST['type'][$i] == 'not_contains') {
                        $type = "NOT REGEXP";
                    } else {
                        $type = "REGEXP";
                    }

                    if ($POST['col'][$i] == 'domainName') {
                        if (!empty($domainName) && $POST['type'][$i] !== 'not_equals' && $POST['type'][$i] !== 'not_contains') {
                            $pot[] = $i;
                        } if (!empty($domainName)) {
                            $domainName .= " AND domain_name " . $type . " '" . $POST['keyword'][$i] . "'";
                        } else {
                            $domainName .= "domain_name " . $type . " '" . $POST['keyword'][$i] . "'";
                        }
                    }

                    if ($POST['col'][$i] == 'registrant_city') {
                        if (!empty($city) && $POST['type'][$i] !== 'not_equals' && $POST['type'][$i] !== 'not_contains') {
                            $pot[] = $i;
                        } if (!empty($city)) {
                            $city .= " AND registrant_city " . $type . " '" . $POST['keyword'][$i] . "'";
                        } else {
                            $city .= "registrant_city " . $type . " '" . $POST['keyword'][$i] . "'";
                        }
                    }

                    if ($POST['col'][$i] == 'registrant_state') {
                        if (!empty($state) && $POST['type'][$i] !== 'not_equals' && $POST['type'][$i] !== 'not_contains') {
                            $pot[] = $i;
                        } if (!empty($state)) {
                            $state .= " AND registrant_state " . $type . " '" . $POST['keyword'][$i] . "'";
                        } else {
                            $state .= "registrant_state " . $type . " '" . $POST['keyword'][$i] . "'";
                        }
                    }

                    if ($POST['col'][$i] == 'registrant_country') {
                        if (!empty($country) && $POST['type'][$i] !== 'not_equals' && $POST['type'][$i] !== 'not_contains') {
                            $pot[] = $i;
                        } if (!empty($country)) {
                            $country .= " AND registrant_country " . $type . " '" . $POST['keyword'][$i] . "'";
                        } else {
                            $country .= "registrant_country " . $type . " '" . $POST['keyword'][$i] . "'";
                        }
                    }

                    if ($POST['col'][$i] == 'contactEmail') {
                        if (!empty($email) && $POST['type'][$i] !== 'not_equals' && $POST['type'][$i] !== 'not_contains') {
                            $pot[] = $i;
                        } if (!empty($email)) {
                            $email .= " AND registrant_email " . $type . " '" . $POST['keyword'][$i] . "'";
                        } else {
                            $email .= "registrant_email " . $type . " '" . $POST['keyword'][$i] . "'";
                        }
                    }

                    if ($POST['col'][$i] == 'registrarName') {
                        if (!empty($registrar) && $POST['type'][$i] !== 'not_equals' && $POST['type'][$i] !== 'not_contains') {
                            $pot[] = $i;
                        } if (!empty($registrar)) {
                            $registrar .= " AND domain_registrar_name " . $type . " '" . $POST['keyword'][$i] . "'";
                        } else {
                            $registrar .= "domain_registrar_name " . $type . " '" . $POST['keyword'][$i] . "'";
                        }
                    }

                    if ($POST['col'][$i] == 'registrant_name') {
                        if (!empty($name) && $POST['type'][$i] !== 'not_equals' && $POST['type'][$i] !== 'not_contains') {
                            $pot[] = $i;
                        } if (!empty($name)) {
                            $name .= " AND registrant_name " . $type . " '" . $POST['keyword'][$i] . "'";
                        } else {
                            $name .= "registrant_name " . $type . " '" . $POST['keyword'][$i] . "'";
                        }
                    }

                    if ($POST['col'][$i] == 'registrant_organization') {
                        if (!empty($org) && $POST['type'][$i] !== 'not_equals' && $POST['type'][$i] !== 'not_contains') {
                            $pot[] = $i;
                        } if (!empty($org)) {
                            $org .= " AND registrant_company " . $type . " '" . $POST['keyword'][$i] . "'";
                        } else {
                            $org .= "registrant_company " . $type . " '" . $POST['keyword'][$i] . "'";
                        }
                    }

                    if ($POST['col'][$i] == 'registrant_street1') {
                        if (!empty($address) && $POST['type'][$i] !== 'not_equals' && $POST['type'][$i] !== 'not_contains') {
                            $pot[] = $i;
                        } if (!empty($address)) {
                            $address .= " AND registrant_address " . $type . " '" . $POST['keyword'][$i] . "'";
                        } else {
                            $address .= "registrant_address " . $type . " '" . $POST['keyword'][$i] . "'";
                        }
                    }

                    if ($POST['col'][$i] == 'registrant_postalCode') {
                        if (!empty($zip) && $POST['type'][$i] !== 'not_equals' && $POST['type'][$i] !== 'not_contains') {
                            $pot[] = $i;
                        } if (!empty($zip)) {
                            $zip .= " AND registrant_zip " . $type . " '" . $POST['keyword'][$i] . "'";
                        } else {
                            $zip .= "registrant_zip " . $type . " '" . $POST['keyword'][$i] . "'";
                        }
                    }

                    if ($POST['col'][$i] == 'registrant_telephone') {
                        if (!empty($phone) && $POST['type'][$i] !== 'not_equals' && $POST['type'][$i] !== 'not_contains') {
                            $pot[] = $i;
                        } if (!empty($phone)) {
                            $phone .= " AND registrant_phone " . $type . " '" . $POST['keyword'][$i] . "'";
                        } else {
                            $phone .= "registrant_phone " . $type . " '" . $POST['keyword'][$i] . "'";
                        }
                    }
                }
                $i++;
            }

            if (!empty($domainName)) {
                $peices[] = $domainName;
            }
            if (!empty($city)) {
                $peices[] = $city;
            }
            if (!empty($state)) {
                $peices[] = $state;
            }
            if (!empty($country)) {
                $peices[] = $country;
            }
            if (!empty($email)) {
                $peices[] = $email;
            }
            if (!empty($registrar)) {
                $peices[] = $registrar;
            }
            if (!empty($name)) {
                $peices[] = $name;
            }
            if (!empty($org)) {
                $peices[] = $org;
            }
            if (!empty($address)) {
                $peices[] = $address;
            }
            if (!empty($zip)) {
                $peices[] = $zip;
            }
            if (!empty($phone)) {
                $peices[] = $phone;
            }
            if (!empty($country)) {
                $peices[] = $country;
            }

            $query = implode(" AND ", $peices);
            $res .= $query;

            if (!empty($pot)) {
                foreach ($pot as $p) {
                    $colName = $POST['col'][$p];
                    $res .= " OR ";

                    if ($POST['type'][$p] == 'equals') {
                        $type = "=";
                    } elseif ($POST['type'][$p] == 'not_equals') {
                        $type = "!=";
                    } elseif ($POST['type'][$p] == 'not_contains') {
                        $type = "NOT REGEXP";
                    } else {
                        $type = "REGEXP";
                    }

                    $parts = explode(" AND ", $query);
                    $e = 0;
                    foreach ($parts as $part) {
                        if (strpos($part, $POST['col'][$p]) !== false) {
                            $parts[$e] = $POST['col'][$p] . " " . $type . " '" . $POST['keyword'][$p] . "'";
                        }
                        $e++;
                    }


                    $res .= implode(" AND ", $parts);
                }
            } else {
                //$res = $res;
            }
        } else {
            $res = "SELECT * FROM " . $table_name;
        }

        $res .= " ORDER BY ID LIMIT 10000";

        $db = $this->load->database('default', TRUE);
        //echo $res;
        // echo $res . " GROUP BY registrant_organization LIMIT " . $limit; exit();
        //echo $res . " LIMIT " . $limit;
        //echo $res . " LIMIT " . $limit;
        //exit();

        $re = $db->query($res);
        $r = $re->num_rows();

        return $r;
    }

    function applyFilters_Count($POST, $dateRange, $limit = 5000) {

        $domainName = "";
        $city = "";
        $state = "";
        $country = "";
        $email = "";
        $registrar = "";
        $registrantName = "";
        $org = "";
        $street = "";
        $zip = "";
        $phone = "";
        $country = "";
        $name = "";

        $i = 0;
        if (!empty($POST['keyword'][0])) {
            $res = "";
            $res = "SELECT ID FROM production_2 USE INDEX (domain_index) WHERE ";

            $pot = array();

            if (isset($dateRange) && !empty($dateRange)) {
                $e = explode(" - ", $dateRange);
                $startDate = $e[0];
                $endDate = $e[1];
                $startDate = explode('/', $startDate);
                $endDate = explode('/', $endDate);
                $startDate = array_reverse($startDate);
                $endDate = array_reverse($endDate);

                $res .= " created_date_normalized >= '" . implode('-', $startDate) . "' AND created_date_normalized <= '" . implode('-', $endDate) . "' + INTERVAL 1 DAY AND ";
            }

            foreach ($POST['keyword'] as $keyword) {
                if (!empty($POST['keyword'][$i])) {

                    if ($POST['type'][$i] == 'equals') {
                        $type = "=";
                    } elseif ($POST['type'][$i] == 'not_equals') {
                        $type = "!=";
                    } elseif ($POST['type'][$i] == 'not_contains') {
                        $type = "NOT REGEXP";
                    } else {
                        $type = "REGEXP";
                    }

                    if ($POST['col'][$i] == 'domainName') {
                        if (!empty($domainName) && $POST['type'][$i] !== 'not_equals' && $POST['type'][$i] !== 'not_contains') {
                            $pot[] = $i;
                        } if (!empty($domainName)) {
                            $domainName .= " AND domain_name " . $type . " '" . $POST['keyword'][$i] . "'";
                        } else {
                            $domainName .= "domain_name " . $type . " '" . $POST['keyword'][$i] . "'";
                        }
                    }

                    if ($POST['col'][$i] == 'registrant_city') {
                        if (!empty($city) && $POST['type'][$i] !== 'not_equals' && $POST['type'][$i] !== 'not_contains') {
                            $pot[] = $i;
                        } if (!empty($city)) {
                            $city .= " AND registrant_city " . $type . " '" . $POST['keyword'][$i] . "'";
                        } else {
                            $city .= "registrant_city " . $type . " '" . $POST['keyword'][$i] . "'";
                        }
                    }

                    if ($POST['col'][$i] == 'registrant_state') {
                        if (!empty($state) && $POST['type'][$i] !== 'not_equals' && $POST['type'][$i] !== 'not_contains') {
                            $pot[] = $i;
                        } if (!empty($state)) {
                            $state .= " AND registrant_state " . $type . " '" . $POST['keyword'][$i] . "'";
                        } else {
                            $state .= "registrant_state " . $type . " '" . $POST['keyword'][$i] . "'";
                        }
                    }

                    if ($POST['col'][$i] == 'registrant_country') {
                        if (!empty($country) && $POST['type'][$i] !== 'not_equals' && $POST['type'][$i] !== 'not_contains') {
                            $pot[] = $i;
                        } if (!empty($country)) {
                            $country .= " AND registrant_country " . $type . " '" . $POST['keyword'][$i] . "'";
                        } else {
                            $country .= "registrant_country " . $type . " '" . $POST['keyword'][$i] . "'";
                        }
                    }

                    if ($POST['col'][$i] == 'contactEmail') {
                        if (!empty($email) && $POST['type'][$i] !== 'not_equals' && $POST['type'][$i] !== 'not_contains') {
                            $pot[] = $i;
                        } if (!empty($email)) {
                            $email .= " AND registrant_email " . $type . " '" . $POST['keyword'][$i] . "'";
                        } else {
                            $email .= "registrant_email " . $type . " '" . $POST['keyword'][$i] . "'";
                        }
                    }

                    if ($POST['col'][$i] == 'registrarName') {
                        if (!empty($registrar) && $POST['type'][$i] !== 'not_equals' && $POST['type'][$i] !== 'not_contains') {
                            $pot[] = $i;
                        } if (!empty($registrar)) {
                            $registrar .= " AND domain_registrar_name " . $type . " '" . $POST['keyword'][$i] . "'";
                        } else {
                            $registrar .= "domain_registrar_name " . $type . " '" . $POST['keyword'][$i] . "'";
                        }
                    }

                    if ($POST['col'][$i] == 'registrant_name') {
                        if (!empty($name) && $POST['type'][$i] !== 'not_equals' && $POST['type'][$i] !== 'not_contains') {
                            $pot[] = $i;
                        } if (!empty($name)) {
                            $name .= " AND registrant_name " . $type . " '" . $POST['keyword'][$i] . "'";
                        } else {
                            $name .= "registrant_name " . $type . " '" . $POST['keyword'][$i] . "'";
                        }
                    }

                    if ($POST['col'][$i] == 'registrant_organization') {
                        if (!empty($org) && $POST['type'][$i] !== 'not_equals' && $POST['type'][$i] !== 'not_contains') {
                            $pot[] = $i;
                        } if (!empty($org)) {
                            $org .= " AND registrant_company " . $type . " '" . $POST['keyword'][$i] . "'";
                        } else {
                            $org .= "registrant_company " . $type . " '" . $POST['keyword'][$i] . "'";
                        }
                    }

                    if ($POST['col'][$i] == 'registrant_street1') {
                        if (!empty($address) && $POST['type'][$i] !== 'not_equals' && $POST['type'][$i] !== 'not_contains') {
                            $pot[] = $i;
                        } if (!empty($address)) {
                            $address .= " AND registrant_address " . $type . " '" . $POST['keyword'][$i] . "'";
                        } else {
                            $address .= "registrant_address " . $type . " '" . $POST['keyword'][$i] . "'";
                        }
                    }

                    if ($POST['col'][$i] == 'registrant_postalCode') {
                        if (!empty($zip) && $POST['type'][$i] !== 'not_equals' && $POST['type'][$i] !== 'not_contains') {
                            $pot[] = $i;
                        } if (!empty($zip)) {
                            $zip .= " AND registrant_zip " . $type . " '" . $POST['keyword'][$i] . "'";
                        } else {
                            $zip .= "registrant_zip " . $type . " '" . $POST['keyword'][$i] . "'";
                        }
                    }

                    if ($POST['col'][$i] == 'registrant_telephone') {
                        if (!empty($phone) && $POST['type'][$i] !== 'not_equals' && $POST['type'][$i] !== 'not_contains') {
                            $pot[] = $i;
                        } if (!empty($phone)) {
                            $phone .= " AND registrant_phone " . $type . " '" . $POST['keyword'][$i] . "'";
                        } else {
                            $phone .= "registrant_phone " . $type . " '" . $POST['keyword'][$i] . "'";
                        }
                    }
                }
                $i++;
            }

            if (!empty($domainName)) {
                $peices[] = $domainName;
            }
            if (!empty($city)) {
                $peices[] = $city;
            }
            if (!empty($state)) {
                $peices[] = $state;
            }
            if (!empty($country)) {
                $peices[] = $country;
            }
            if (!empty($email)) {
                $peices[] = $email;
            }
            if (!empty($registrar)) {
                $peices[] = $registrar;
            }
            if (!empty($name)) {
                $peices[] = $name;
            }
            if (!empty($org)) {
                $peices[] = $org;
            }
            if (!empty($address)) {
                $peices[] = $address;
            }
            if (!empty($zip)) {
                $peices[] = $zip;
            }
            if (!empty($phone)) {
                $peices[] = $phone;
            }
            if (!empty($country)) {
                $peices[] = $country;
            }

            $query = implode(" AND ", $peices);
            $res .= $query;

            if (!empty($pot)) {
                foreach ($pot as $p) {
                    $colName = $POST['col'][$p];
                    $res .= " OR ";

                    if ($POST['type'][$p] == 'equals') {
                        $type = "=";
                    } elseif ($POST['type'][$p] == 'not_equals') {
                        $type = "!=";
                    } elseif ($POST['type'][$p] == 'not_contains') {
                        $type = "NOT REGEXP";
                    } else {
                        $type = "REGEXP";
                    }

                    $parts = explode(" AND ", $query);
                    $e = 0;
                    foreach ($parts as $part) {
                        if (strpos($part, $POST['col'][$p]) !== false) {
                            $parts[$e] = $POST['col'][$p] . " " . $type . " '" . $POST['keyword'][$p] . "'";
                        }
                        $e++;
                    }


                    $res .= implode(" AND ", $parts);
                }
            } else {
                //$res = $res;
            }
        }

        $db = $this->load->database('default', TRUE);
        //echo $res;
        // echo $res . " GROUP BY registrant_organization LIMIT " . $limit; exit();
        //echo $res . " LIMIT " . $limit; exit();
        $re = $db->query($res . " LIMIT " . $limit);
        //$r = $re->result();

        return $re->num_rows();
    }

    function createTable() {
        $db = $this->load->database('default', TRUE);
        $cols = array("domainName", "registrarName", "contactEmail", "whoisServer", "nameServers", "createdDate", "updatedDate", "expiresDate", "standardRegCreatedDate", "standardRegUpdatedDate", "standardRegExpiresDate", "status", "RegistryData_rawText", "WhoisRecord_rawText", "Audit_auditUpdatedDate", "registrant_rawText", "registrant_email", "registrant_name", "registrant_organization", "registrant_street1", "registrant_street2", "registrant_street3", "registrant_street4", "registrant_city", "registrant_state", "registrant_postalCode", "registrant_country", "registrant_fax", "registrant_faxExt", "registrant_telephone", "registrant_telephoneExt", "administrativeContact_rawText", "administrativeContact_email", "administrativeContact_name", "administrativeContact_organization", "administrativeContact_street1", "administrativeContact_street2", "administrativeContact_street3", "administrativeContact_street4", "administrativeContact_city", "administrativeContact_state", "administrativeContact_postalCode", "administrativeContact_country", "administrativeContact_fax", "administrativeContact_faxExt", "administrativeContact_telephone", "administrativeContact_telephoneExt", "billingContact_rawText", "billingContact_email", "billingContact_name", "billingContact_organization", "billingContact_street1", "billingContact_street2", "billingContact_street3", "billingContact_street4", "billingContact_city", "billingContact_state", "billingContact_postalCode", "billingContact_country", "billingContact_fax", "billingContact_faxExt", "billingContact_telephone", "billingContact_telephoneExt", "technicalContact_rawText", "technicalContact_email", "technicalContact_name", "technicalContact_organization", "technicalContact_street1", "technicalContact_street2", "technicalContact_street3", "technicalContact_street4", "technicalContact_city", "technicalContact_state", "technicalContact_postalCode", "technicalContact_country", "technicalContact_fax", "technicalContact_faxExt", "technicalContact_telephone", "technicalContact_telephoneExt", "zoneContact_rawText", "zoneContact_email", "zoneContact_name", "zoneContact_organization", "zoneContact_street1", "zoneContact_street2", "zoneContact_street3", "zoneContact_street4", "zoneContact_city", "zoneContact_state", "zoneContact_postalCode", "zoneContact_country", "zoneContact_fax", "zoneContact_faxExt", "zoneContact_telephone", "zoneContact_telephoneExt", "registrarIANAID");

        $create = "CREATE TABLE domains (";
        foreach ($cols as $col) {
            $create .= "" . $col . " varchar (100) NOT NULL, ";
        }
        $create .= ")";

        $db->query($create);
    }

    function insertFile($fileName) {
        $db = $this->load->database('default', TRUE);
        $cols = array("domainName", "registrarName", "contactEmail", "whoisServer", "nameServers", "createdDate", "updatedDate", "expiresDate", "standardRegCreatedDate", "standardRegUpdatedDate", "standardRegExpiresDate", "status", "RegistryData_rawText", "WhoisRecord_rawText", "Audit_auditUpdatedDate", "registrant_rawText", "registrant_email", "registrant_name", "registrant_organization", "registrant_street1", "registrant_street2", "registrant_street3", "registrant_street4", "registrant_city", "registrant_state", "registrant_postalCode", "registrant_country", "registrant_fax", "registrant_faxExt", "registrant_telephone", "registrant_telephoneExt", "administrativeContact_rawText", "administrativeContact_email", "administrativeContact_name", "administrativeContact_organization", "administrativeContact_street1", "administrativeContact_street2", "administrativeContact_street3", "administrativeContact_street4", "administrativeContact_city", "administrativeContact_state", "administrativeContact_postalCode", "administrativeContact_country", "administrativeContact_fax", "administrativeContact_faxExt", "administrativeContact_telephone", "administrativeContact_telephoneExt", "billingContact_rawText", "billingContact_email", "billingContact_name", "billingContact_organization", "billingContact_street1", "billingContact_street2", "billingContact_street3", "billingContact_street4", "billingContact_city", "billingContact_state", "billingContact_postalCode", "billingContact_country", "billingContact_fax", "billingContact_faxExt", "billingContact_telephone", "billingContact_telephoneExt", "technicalContact_rawText", "technicalContact_email", "technicalContact_name", "technicalContact_organization", "technicalContact_street1", "technicalContact_street2", "technicalContact_street3", "technicalContact_street4", "technicalContact_city", "technicalContact_state", "technicalContact_postalCode", "technicalContact_country", "technicalContact_fax", "technicalContact_faxExt", "technicalContact_telephone", "technicalContact_telephoneExt", "zoneContact_rawText", "zoneContact_email", "zoneContact_name", "zoneContact_organization", "zoneContact_street1", "zoneContact_street2", "zoneContact_street3", "zoneContact_street4", "zoneContact_city", "zoneContact_state", "zoneContact_postalCode", "zoneContact_country", "zoneContact_fax", "zoneContact_faxExt", "zoneContact_telephone", "zoneContact_telephoneExt", "registrarIANAID");

        $colNames = "";
        foreach ($cols as $col) {
            $colNames .= $col . ', ';
        }

        $query = "LOAD DATA LOCAL INFILE '" . $fileName . "' INTO TABLE domains FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '\"' LINES TERMINATED BY '\r\n' IGNORE 1 LINES (FID,domain_name,query_time,create_date,update_date,expiry_date,domain_registrar_id,domain_registrar_name,domain_registrar_whois,domain_registrar_url,registrant_name,registrant_company,registrant_address,registrant_city,registrant_state,registrant_zip,registrant_country,registrant_email,registrant_phone,registrant_fax,administrative_name,administrative_company,administrative_address,administrative_city,administrative_state,administrative_zip,administrative_country,administrative_email,administrative_phone,administrative_fax,technical_name,technical_company,technical_address,technical_city,technical_state,technical_zip,technical_country,technical_email,technical_phone,technical_fax,billing_name,billing_company,billing_address,billing_city,billing_state,billing_zip,billing_country,billing_email,billing_phone,billing_fax,name_server_1,name_server_2,name_server_3,name_server_4,domain_status_1,domain_status_2,domain_status_3,domain_status_4) SET ID = NULL";

        $db->query($query);

        return true;
    }

    function findByKeyword($keyword) {
        $db = $this->load->database('default', TRUE);
        $sql = "SELECT domainName, registrarName, createdDate, registrant_email, registrant_name, registrant_city, registrant_state, registrant_country, registrant_telephone FROM domains WHERE domainName REGEXP '" . $keyword . "'";
        $re = $db->query($sql);
        $r = $re->result();

        return $r;
    }

    function audienceNameExists($name, $uid = 1) {
        $db = $this->load->database('default', TRUE);
        $sql = "SELECT filter_id FROM user_filters WHERE user_id = '" . $uid . "' AND filter_id = '" . $name . "'";
        $re = $db->query($sql);

        if ($re->num_rows() > 0) {
            return $re->result();
        } else {
            return false;
        }
    }

    function getAudiences($uid) {
        $db = $this->load->database('default', TRUE);
        $sql = "SELECT * FROM user_filters WHERE user_id = '" . $uid . "' GROUP BY filter_id";
        $re = $db->query($sql);

        if ($re->num_rows() > 0) {
            return $re->result();
        } else {
            return false;
        }
    }

    function getDatasets($uid) {
        $db = $this->load->database('default', TRUE);
        $sql = "SELECT * FROM user_datasets WHERE user_id = '" . $uid . "' ORDER BY ID DESC";
        $re = $db->query($sql);

        if ($re->num_rows() > 0) {
            return $re->result();
        } else {
            return false;
        }
    }

    function getDataset($tableID, $count = false, $page = false) {
        $db = $this->load->database('default', TRUE);
        if ($count && $page) {
            $page--;
            $start = $page * $count;
            $sql = "SELECT * FROM " . $tableID . " ORDER BY ID LIMIT " . $start . ", " . $count;
        } elseif ($count) {
            $sql = "SELECT * FROM " . $tableID . " ORDER BY ID LIMIT " . $count;
        } else {
            $sql = "SELECT * FROM " . $tableID . "";
        }
        //echo $sql; exit();
        $re = $db->query($sql);
        if ($re->num_rows() > 0) {
            return $re;
        } else {
            return false;
        }
    }

    function getFilters($uid) {
        $db = $this->load->database('default', TRUE);
        $sql = "SELECT * FROM user_filters WHERE user_id = '" . $uid . "' GROUP BY filter_id";
        $re = $db->query($sql);

        if ($re->num_rows() > 0) {
            return $re->result();
        } else {
            return false;
        }
    }

    function getFilter($uid, $filter_id) {
        $db = $this->load->database('default', TRUE);
        $sql = "SELECT * FROM user_filters WHERE user_id = '" . $uid . "' AND filter_id = '" . $filter_id . "'";
        $re = $db->query($sql);

        if ($re->num_rows() > 0) {
            return $re->result();
        } else {
            return false;
        }
    }

    function getUserZaps($uid) {
        $db = $this->load->database('default', TRUE);
        $sql = "SELECT * FROM user_zaps WHERE user_id = '" . $uid . "'";
        $re = $db->query($sql);

        if ($re->num_rows() > 0) {
            return $re->result();
        } else {
            return false;
        }
    }

    function userPlanType($uid) {
        $db = $this->load->database('default', TRUE);
        $sql = "SELECT plan FROM users WHERE ID = '" . $uid . "'";
        $re = $db->query($sql);

        if ($re->num_rows() > 0) {
            $r = $re->result();
            return $r[0]->plan;
        } else {
            return false;
        }
    }

    function getZapInfo($zid) {
        $db = $this->load->database('default', TRUE);
        $sql = "SELECT * FROM user_zaps WHERE ID = '" . $zid . "'";
        $re = $db->query($sql);

        if ($re->num_rows() > 0) {
            return $re->result();
        } else {
            return false;
        }
    }

    function getRecord($recordID, $tableName) {
        $db = $this->load->database('default', TRUE);
        $sql = "SELECT * FROM " . $tableName . " WHERE ID = '" . $recordID . "'";
        $re = $db->query($sql);

        if ($re->num_rows() > 0) {
            return $re->result();
        } else {
            return false;
        }
    }

    function getDatasetInfo($dataset_id) {
        $db = $this->load->database('default', TRUE);
        $sql = "SELECT * FROM user_datasets WHERE ID = '" . $dataset_id . "'";
        $re = $db->query($sql);

        if ($re->num_rows() > 0) {
            $r = $re->result();
            return $r[0];
        } else {
            return false;
        }
    }

    function getCampaigns($uid) {
        $db = $this->load->database('default', TRUE);
        $sql = "SELECT * FROM user_campaigns WHERE user_id = '" . $uid . "'";
        $re = $db->query($sql);

        if ($re->num_rows() > 0) {
            return $re->result();
        } else {
            return false;
        }
    }

    function getEmails($uid) {
        $db = $this->load->database('default', TRUE);
        $sql = "SELECT * FROM user_templates WHERE user_id = '" . $uid . "'";
        $re = $db->query($sql);

        if ($re->num_rows() > 0) {
            return $re->result();
        } else {
            return false;
        }
    }

    function getInboxes($uid) {
        $db = $this->load->database('default', TRUE);
        $sql = "SELECT * FROM user_inboxes WHERE user_id = '" . $uid . "'";
        $re = $db->query($sql);

        if ($re->num_rows() > 0) {
            return $re->result();
        } else {
            return false;
        }
    }

    function filters($filter_id) {
        $db = $this->load->database('default', TRUE);
        $sql = "SELECT * FROM user_filters WHERE filter_id = '" . $filter_id . "'";
        $re = $db->query($sql);

        if ($re->num_rows() > 0) {
            return $re->result();
        } else {
            return false;
        }
    }

    function deleteAudience($filter_id, $uid) {
        $db = $this->load->database('default', TRUE);
        $sql = "DELETE FROM user_filters WHERE user_id = '" . $uid . "' AND filter_id = '" . $filter_id . "'";
        $re = $db->query($sql);

        return true;
    }

    function deleteUserTable($dataset_id, $uid) {
        $db = $this->load->database('default', TRUE);

        $datasetInfo = $this->getDatasetInfo($dataset_id);

        if ($uid !== $datasetInfo->user_id) {

            return false;
        } else {

            $sql = "DELETE FROM user_datasets WHERE ID = " . $datasetInfo->ID . "";
            $re = $db->query($sql);

            $sqlTwo = "DROP TABLE " . $datasetInfo->table_name . "";
            $re = $db->query($sqlTwo);

            return true;
        }
    }

    function deleteInbox($inbox_id, $uid) {
        $db = $this->load->database('default', TRUE);
        $sql = "DELETE FROM user_inboxes WHERE user_id = '" . $uid . "' AND ID = '" . $inbox_id . "'";
        $re = $db->query($sql);

        return true;
    }

    function deleteZap($zap_id) {
        $db = $this->load->database('default', TRUE);
        $sql = "DELETE FROM user_zaps WHERE ID = '" . $zap_id . "'";
        $re = $db->query($sql);

        return true;
    }

    function insertFilters($keys, $matches, $values, $name, $uid = 1) {
        $db = $this->load->database('default', TRUE);

        $i = 0;
        foreach ($keys as $key) {
            $sql = "INSERT INTO user_filters SET user_id = '" . $uid . "', filter_id = '" . $name . "', filter_key = '" . $key . "', match_type = '" . $matches[$i] . "', filter_value = '" . $values[$i] . "'";
            $re = $db->query($sql);
            $i++;
        }

        return true;
    }

    function insertZap($zapUrl, $zapName, $UID) {
        $db = $this->load->database('default', TRUE);

        $sql = "INSERT INTO user_zaps SET user_id = '" . $UID . "', zap_url = '" . trim($zapUrl) . "', zap_name = '" . trim($zapName) . "'";
        $re = $db->query($sql);

        return true;
    }

    function saveInbox($POST, $uid) {
        $db = $this->load->database('default', TRUE);
        $sql = "INSERT INTO user_inboxes SET address = '" . $POST['address'] . "', user_id = '" . $uid . "', imap_server = '" . $POST['imap_server'] . "', imap_password = '" . $POST['imap_password'] . "', smtp_server = '" . $POST['smtp_server'] . "', smtp_password = '" . $POST['smtp_password'] . "'";
        $db->query($sql);

        return true;
    }

    function inboxExists($address) {
        $db = $this->load->database('default', TRUE);
        $sql = "SELECT * FROM user_inboxes WHERE address = '" . $address . "'";
        $re = $db->query($sql);

        if ($re->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function insertTemplate($POST, $uid) {
        $db = $this->load->database('default', TRUE);

        $sql = "INSERT INTO user_templates SET user_id = '" . $uid . "', name = '" . $POST['name'] . "', subject = '" . $POST['subject'] . "', body = '" . $POST['body'] . "', address = '" . $POST['address'] . "'";
        $re = $db->query($sql);

        return true;
    }

    function insertCampaign($POST, $uid) {
        $db = $this->load->database('default', TRUE);

        $sql = "INSERT INTO user_campaigns SET user_id = '" . $uid . "', name = '" . $POST['name'] . "', target_id = '" . $POST['target'] . "', inbox_id = '" . $POST['inbox'] . "', template_id = '" . $POST['template'] . "', schedule = '" . $POST['schedule'] . "'";
        $re = $db->query($sql);

        return true;
    }

    function checkFileExists($filename, $status) {
        $db = $this->load->database('default', TRUE);
        $sql = "SELECT * FROM download_log WHERE file_name = '" . $filename . "' AND status = '" . $status . "'";
        $re = $db->query($sql);

        if ($re->num_rows() > 0) {
            return $re->result();
        } else {
            return false;
        }
    }

    function insertFileLog($filename, $status) {
        $db = $this->load->database('default', TRUE);

        $sql = "INSERT INTO download_log SET file_name = '" . $filename . "', status = '" . $status . "'";
        $re = $db->query($sql);

        return true;
    }

    ////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////

    function insertOptOut($POST) {
        $db = $this->load->database('default', TRUE);
        date_default_timezone_set("America/New_York");
        $POST['dob'] = strtotime($POST['birthMonth'] . '/' . $POST['birthDay'] . '/' . $POST['birthYear']);
        $sql = "INSERT INTO yoliya_optOuts SET optOuts_url = '" . $POST['url'] . "', optOuts_fName = '" . $POST['fName'] . "', optOuts_lName = '" . $POST['lName'] . "', optOuts_emailAddress = '" . $POST['email'] . "', optOuts_address = '" . $POST['address'] . "', optOuts_city = '" . $POST['city'] . "', optOuts_state = '" . $POST['state'] . "', optOuts_zip = '" . $POST['zip'] . "', optOuts_phone = '" . $POST['phone'] . "', optOuts_dob = '" . $POST['dob'] . "', optOuts_cityState = '" . $POST['city.state'] . "', optOuts_fullAddressLastFirstMiddle = '" . $POST['fullAddress.last.first.middle'] . "'";
        $db->query($sql);

        return true;
    }

    function checkReportExists($name, $nid) {
        $db = $this->load->database('default', TRUE);
        $sql = "SELECT * FROM apiResponses WHERE api = '" . $name . "' AND nid = '" . $nid . "'";
        $re = $db->query($sql);
        $r = $re->result();

        if ($re->num_rows() > 0) {
            $json = json_decode($r[0]->response);
            if (isset($json->{'@persons_count'}) && $json->{'@persons_count'} > 0) {
                return $re->result();
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function saveAPIResponse($api, $nid, $response) {
        $db = $this->load->database('default', TRUE);
        $sql = "INSERT INTO apiResponses SET api = '" . $api . "', nid = '" . $nid . "', response = " . $this->db->escape($response) . "";
        $db->query($sql);

        return true;
    }

    function logError($error) {
        $db = $this->load->database('default', TRUE);
        $sql = "INSERT INTO errors SET error = " . $this->db->escape($error) . "";
        $db->query($sql);

        return true;
    }

    function newReport($pid, $nid, $uid, $first, $middle = "", $last, $dob = "", $street = "", $city = "", $state = "", $zip = "", $phone = "", $email = "", $username = "") {
        $db = $this->load->database('default', TRUE);
        $sql = "INSERT INTO reports SET pid = '" . $pid . "', nid = '" . $nid . "', uid = '" . $uid . "', first = " . $this->db->escape($first) . ", middle = " . $this->db->escape($middle) . ", last = " . $this->db->escape($last) . ", dob = " . $this->db->escape($dob) . ", street = " . $this->db->escape($street) . ", city = " . $this->db->escape($city) . ", state = " . $this->db->escape($state) . ", zip = " . $this->db->escape($zip) . ", phone = " . $this->db->escape($phone) . ", email = " . $this->db->escape($email) . ", username = " . $this->db->escape($username) . "";
        $db->query($sql);

        return $db->insert_id();
    }

    function getReports($uid) {
        $db = $this->load->database('default', TRUE);
        $sql = "SELECT * FROM reports WHERE uid = '" . $uid . "'";
        $re = $db->query($sql);

        if ($re->num_rows() > 0) {
            return $re->result();
        } else {
            return false;
        }
    }

    function getCharges($uid) {
        $db = $this->load->database('default', TRUE);
        $sql = "SELECT * FROM payment_logs WHERE userid = '" . $uid . "' ORDER BY ID DESC LIMIT 20";
        $re = $db->query($sql);

        if ($re->num_rows() > 0) {
            return $re->result();
        } else {
            return false;
        }
    }

    function countReports($uid) {
        $db = $this->load->database('default', TRUE);
        $sql = "SELECT ID FROM reports WHERE uid = '" . $uid . "'";
        $re = $db->query($sql);

        if ($re->num_rows() > 0) {
            return $re->num_rows();
        } else {
            return 0;
        }
    }

    function getReport($rid) {
        $db = $this->load->database('default', TRUE);
        $sql = "SELECT * FROM reports WHERE ID = '" . $rid . "'";
        $re = $db->query($sql);

        if ($re->num_rows() > 0) {
            return $re->result();
        } else {
            return false;
        }
    }

    function getAPIResponse($nid, $api) {
        $db = $this->load->database('default', TRUE);
        $sql = "SELECT * FROM apiResponses WHERE api = '" . $api . "' AND nid = '" . $nid . "'";
        $re = $db->query($sql);

        if ($re->num_rows() > 0) {
            return $re->result();
        } else {
            return false;
        }
    }

    function saveStripeCustomerID($uID, $customerID) {
        $db = $this->load->database('default', TRUE);
        $sql = "UPDATE users SET stripeCustomerID = '" . $customerID . "' WHERE ID = '" . $uID . "'";
        $db->query($sql);

        return true;
    }

    function getCustomerID($ID) {
        $db = $this->load->database('default', TRUE);
        $sql = "SELECT * FROM users WHERE ID = '" . $ID . "'";
        $re = $db->query($sql);

        if ($re->num_rows() > 0) {
            $r = $re->result();
            return $r[0]->stripeCustomerID;
        } else {
            return false;
        }
    }

}
