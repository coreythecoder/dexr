<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Frontend extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (defined('REQUEST') && REQUEST == "external") {
            return;
        }
        $this->load->model("frontend_model");
        $this->load->helper("aws");
    }

    public function index() {
        if (defined('REQUEST') && REQUEST == "external") {
            return;
        }

        $data['metaTitle'] = "B2B Marketing Tools, Link Building Outreach & Domain Research";
        $data['metaDescription'] = "Dexr provides business to business marketing tools, link building outreach and research tools to help you discover & connect with web site owners & local small businesses.";

        $this->load->view('frontend/header', $data);
        $this->load->view('frontend/index');
        $this->load->view('frontend/footer-states');
    }

    public function pricing() {

        $data['metaTitle'] = "Pricing";
        $data['metaDescription'] = "Dexr free account & pricing information.";

        $this->load->view('frontend/header', $data);
        $this->load->view('frontend/pricing');
        $this->load->view('frontend/footer-no-states');
    }

    public function opt_out() {

        $data['messages'] = "";
        $messages = "";

        if (isset($_POST['reg_email']) && isset($_POST['g-recaptcha-response'])) {
            if (isset($_POST['first']) && empty($_POST['first'])) {
                $messages .= "<div class='alert alert-danger'>First name required.</div>";
            }
            if (isset($_POST['last']) && empty($_POST['last'])) {
                $messages .= "<div class='alert alert-danger'>Last name required.</div>";
            }
            if (isset($_POST['email']) && empty($_POST['email'])) {
                $messages .= "<div class='alert alert-danger'>Email name required.</div>";
            }
            if (isset($_POST['reg_email']) && empty($_POST['reg_email'])) {
                $messages .= "<div class='alert alert-danger'>Domain registration email required.</div>";
            }

            if (!empty($messages)) {
                $data['messages'] = $messages;
            } else {
                $this->frontend_model->insertOptOut($this->input->post());
                $data['messages'] = "<div class='alert alert-success'>Removal request received.  Please allow 3-5 business days for processing. Also, please note; the maximum number of domains this tool will remove is 20. Please contact support for bulk removals.</div>";
            }
        }

        $data['metaTitle'] = "Remove Your Information & Opt Out of Dexr.";
        $data['metaDescription'] = "Remove your information from the dexr public web site.";

        $this->load->view('frontend/header', $data);
        $this->load->view('frontend/opt-out');
        $this->load->view('frontend/footer-no-states');
    }

    public function state($state, $page = false) {

        if ($page == '1') {
            header('Location: /' . $state);
        }

        $statesArray = statesArray();
        $data['state'] = $statesArray[strtoupper($state)];

        $data['cities'] = "";
        $cities = $this->frontend_model->getCitiesFromState($state, $page);
        if ($cities['results']) {
            foreach ($cities['results'] as $c) {
                $data['cities'] .= "<div class='col-md-4 col-xs-6'><a href='/" . $state . "/" . $c->slug . "'>" . ucwords(strtolower($c->city)) . "</a></div>";
            }
        } else {
            redirect("https://dexr.io/", 'location', 301);
            //show_404();
        }

        $data['count'] = $cities['total'];
        $data['maxPerPage'] = 200;
        $data['lastPage'] = ($data['count'] / $data['maxPerPage']);
        $data['thisPage'] = $page;

        $data['url'] = $url = explode("/", $_SERVER['REQUEST_URI']);
        if (!isset($url[2]) || empty($url[2])) {
            $data['url'][2] = $url[2] = 1;
            $data['thisPage'] = $thisPage = 1;
        }
        $next = $url[2] + 1;
        $previous = $url[2] - 1;

        $data['prev'] = "/" . $url[1] . "/" . $previous;
        $data['next'] = "/" . $url[1] . "/" . $next;

        $metaPage = "";
        if ($page > 1) {
            $metaPage = " - Page " . $page;
        }

        $data['metaTitle'] = "List of " . $statesArray[strtoupper($state)] . " Business Owners & Web Site Owners" . $metaPage;
        $data['metaDescription'] = "Dexr is the leading provider for " . $statesArray[strtoupper($state)] . " Business Owner & Web Site Owner lists available for download. Our database contains full contact info such as owner name, email, phone and address." . $metaPage;

        $this->load->view('frontend/header', $data);
        $this->load->view('frontend/state');
        $this->load->view('frontend/footer-fixed-pagination');
    }

    public function city($state, $city) {

        $statesArray = statesArray();
        $data['state'] = $statesArray[strtoupper($state)];
        $data['city'] = ucwords(str_replace('-', ' ', $city));

        $data['state_abr'] = $state;
        $data['city_slug'] = $city;

        $data['names'] = "";

        $names = $this->frontend_model->getSomeNamesFromLetterCityState($city, $state, 12);

        if ($names) {
            $bucket = array();
            foreach ($names as $n) {
                $letter = mb_substr($n->initial_city_state_slug, 0, 1, 'utf-8');
                $bucket[$letter][] = $n;
            }
        }

        ksort($bucket);
        foreach ($bucket as $k => $v) {
            $index_link = "";

            if (count($v) >= 12) {
                $index_link = "<a href='/" . $state . "/" . $city . "/" . $k . "'>View " . strtoupper($k) . " Index...</a>";
            }
            $data['names'] .= "<div style='margin-bottom:30px;'><div class='col-md-12' style='border-bottom:1px solid #ddd;margin-bottom:15px;'><h2 style='display:inline-block;'>" . $k . "</h2><span class='pull-right' style='position:relative; top:40px;'>" . $index_link . "</span></div>";

            foreach ($v as $names) {

                if ($names) {

                    $data['names'] .= "<div class='col-md-4'><a href='/" . $state . "/" . $city . "/" . $names->name_slug . "'>" . ucwords(strtolower($names->name)) . "</a></div>";
                }
            }
            $data['names'] .= "</div>";
        }

        if (empty($data['names'])) {
            //header('Location: /' . $state);
            redirect("https://dexr.io/" . $state, 'location', 301);
        }

        $nearby = $this->frontend_model->getNearbyCities($data['city'], $state);
        $data['nearby'] = "";
        if ($nearby) {
            foreach ($nearby as $n) {
                if ($n->city_slug !== $city)
                    $data['nearby'] .= "<div class='col-md-4'><a href='/" . strtolower($n->state_id) . "/" . $n->city_slug . "'>" . $n->city . ", " . $n->state_id . "</a> (" . number_format($n->distance, 2, '.', '') . " m)</div>";
            }
        }

        $data['metaTitle'] = "List of " . $data['city'] . ", " . strtoupper($data['state_abr']) . " Business Owners & Web Site Owners";
        $data['metaDescription'] = "Dexr is the leading provider for " . $data['city'] . ", " . strtoupper($data['state_abr']) . " Business Owner & Web Site Owner lists available for download. Our database contains full contact info such as owner name, email, phone and address.";

        $this->load->view('frontend/header', $data);
        $this->load->view('frontend/city');
        $this->load->view('frontend/footer-fixed-pagination');
    }

    public function name($state, $city, $name, $page = false) {

        $name = urldecode($name);

        $this->load->helper("mapbox");

        /*
         * // REDIRECT FOR SPECIAL CHARS
          $currPath = $_SERVER['REQUEST_URI'];
          $redirChars = array("%A0", "%C2", "%C3", "%A3", "%A1", "%AD", "%84", "%E2", "%A2", "%BA", "%B1", "%20", "%BC", "%A9", "%A7", "%C5");

          if (isset($currPath)) {
          foreach ($redirChars as $char) {
          if (strpos($currPath, $char) !== FALSE) {
          $currPath = str_replace($char, "-", $currPath);
          }
          }
          $newPath = str_replace("--", "-", $currPath);
          $newPath = preg_replace('/-+/', '-', $newPath);
          if (substr($newPath, -1) == "-") {
          $newPath = substr_replace($newPath, "", -1);
          }
          if ($currPath !== $newPath) {
          echo $currPath . " => " . $newPath;
          exit();
          }

          //redirect("https://dexr.io" . substr_replace($currPath, "", -1), 'location', 301);
          }
         * 
         */

        if ($page == '1') {
            //header('Location: /' . $state . "/" . $city . "/" . $name);
        }

        $statesArray = statesArray();
        $data['state'] = $statesArray[strtoupper($state)];
        $data['state_abr'] = $state;
        $data['city'] = ucwords(str_replace('-', ' ', $city));
        $data['city_slug'] = $city;
        $data['name_slug'] = $name;
        $data['domains'] = "";
        $siteList = array();
        $i = 0;

        $data['redirect'] = "/report/" . $state . "/" . $city . "/" . $name;

        // GET NEARBY CITIES WITH MATCHING NAME
        $data['nearbyCities'] = "";
        $nearby = $this->frontend_model->getNearbyCitiesMatchingName($name, $city, $state);
        if ($nearby) {
            foreach ($nearby as $n) {
                $data['nearbyCities'] .= "<div class='col-md-4 other-names-in-city'><span class='fa fa-user'></span> <a href='/" . $n->state . "/" . $n->city_slug . "/" . $n->name_slug . "'>" . ucwords(strtolower($n->name)) . " in " . ucwords(strtolower(unslugify($n->city_slug))) . ", " . strtoupper($n->state) . "</a></div>";
            }
        }

        // GET OTHER NAMES IN SAME CITY_STATE
        $data['sameCityNames'] = "";
        $sameCityNames = $this->frontend_model->getSomeFromCity($city, $state, 15);
        if ($sameCityNames) {
            foreach ($sameCityNames as $s) {
                $data['sameCityNames'] .= "<div class='col-md-4 other-names-in-city'><span class='fa fa-user'></span> <a href='/" . $s->state . "/" . $s->city_slug . "/" . $s->name_slug . "'>" . ucwords(strtolower($s->name)) . " in " . ucwords(strtolower(unslugify($s->city_slug))) . ", " . strtoupper($s->state) . "</a></div>";
            }
        }

        // GET ALL DOMAINS MATCHING THIS FL/CITY/NAME
        $domains = $this->frontend_model->getDomainsByCityStateName($city, $state, $name);
        $nId = $this->frontend_model->getNameIdFromNameSlugCityState($city, $state, $name);
        $data['total'] = $domains['total'];

        $domainBucket = array();
        $addressBucket = array();

        if ($domains['results']) {

            foreach ($domains['results'] as $d) {
                $data['domains'] .= "<div class='row domain'>";
                $data['domains'] .= "<div class='col-md-12'><h2 class='word-break'><i class='fa fa-asterisk' style='color:#09afdf;'></i> " . $d->domain_name . "</h2><div class='separator'></div></div>";

                $created = "";
                if (!empty($d->created_date_normalized)) {
                    $ex = explode(" ", $name);
                    $created = " " . ucwords(strtolower($ex[0])) . " registered this web site on " . date('M d, Y', strtotime($d->created_date_normalized)) . ". ";
                }
                $expires = "";
                if (!empty($d->expiry_date)) {
                    $expires = " The expiration for " . ucwords($d->domain_name) . " is listed as " . date('M d, Y', strtotime($d->expiry_date)) . ". ";
                }

                $updated = "";
                if (!empty($d->update_date)) {
                    $updated = " The site's info was last updated on " . date('M d, Y', strtotime($d->update_date));
                }

                if (!empty($d->registrant_company)) {
                    $updated .= " by " . ucwords(strtolower($d->registrant_company)) . " who is the registered company for this domain.";
                } else {
                    $updated .= ".";
                }

                $contact = "";
                if (!empty($d->registrant_phone)) {
                    $contact = " You may be able to contact them at " . formatPhoneNumber($d->registrant_phone);
                }

                if (!empty($d->registrant_email)) {
                    $contact .= " or using their email address at " . obfuscate_email($d->registrant_email) . ".";
                } else {
                    $contact .= ".";
                }

                if ($data['total'] > 5) {
                    $totalListed = '5';
                } else {
                    $totalListed = $data['total'];
                }

                if ($i == 0) {
                    $data['paragraph'] = "<div class='col-md-12'><p>" . ucwords(str_replace('-', ' ', strtolower($name))) . " was located at the street address " . ucwords(strtolower($d->registrant_address)) . ", " . $data['city'] . ", " . strtoupper($state) . " when they registered " . ucwords($d->domain_name) . " at " . str_replace('Llc', 'LLC', ucwords(strtolower($d->domain_registrar_name))) . "." . $created . $expires . $updated . $contact . " We have " . $data['total'] . " domain registration(s) total in our database, " . $totalListed . " of which are listed below. For the complete list please <a href='/" . uri_string() . "/report' rel='nofollow'>see pricing</a>.</p><div class='separator'></div></div>";
                }

                $data['domains'] .= "<div class='col-md-12'>";
                $data['domains'] .= "<div class='col-md-4'><div class='col-title'>Keyword Split</div><div class='col-info'>" . $d->num . "</div></div>";
                if (!empty($d->created_date_normalized)) {
                    $data['domains'] .= "<div class='col-md-4'><div class='col-title'>Created</div><div class='col-info'>" . date('M d, Y', strtotime($d->created_date_normalized)) . "</div></div>";
                } else {
                    //$data['domains'] .= "<div class='col-md-4'><div class='col-title'>Created</div><div class='col-info'>-</div></div>";
                }

                if (!empty($d->update_date)) {
                    $data['domains'] .= "<div class='col-md-4'><div class='col-title'>Updated</div><div class='col-info'>" . date('M d, Y', strtotime($d->update_date)) . "</div></div>";
                } else {
                    //$data['domains'] .= "<div class='col-md-4'><div class='col-title'>Updated</div><div class='col-info'>-</div></div>";
                }

                if (!empty($d->expiry_date)) {
                    $data['domains'] .= "<div class='col-md-4'><div class='col-title'>Expiration</div><div class='col-info'>" . date('M d, Y', strtotime($d->expiry_date)) . "</div></div>";
                } else {
                    //$data['domains'] .= "<div class='col-md-4'><div class='col-title'>Expiration</div><div class='col-info'>-</div></div>";
                }

                //if (!empty($d->registrant_name)) {
                //    $data['domains'] .= "<div class='col-md-4'><div class='col-title'>Registrant Name</div><div class='col-info'>" . $d->registrant_name . "</div></div>";
                //} else {
                //    $data['domains'] .= "<div class='col-md-4'><div class='col-title'>Registrant Name</div><div class='col-info'>-</div></div>";
                //}

                if (!empty($d->registrant_company)) {
                    $data['domains'] .= "<div class='col-md-4'><div class='col-title'>Company</div><div class='col-info'>" . ucwords(strtolower($d->registrant_company)) . "</div></div>";
                } else {
                    //$data['domains'] .= "<div class='col-md-4'><div class='col-title'>Company</div><div class='col-info'>-</div></div>";
                }

                //if (!empty($d->registrant_address)) {
                //    $data['domains'] .= "<div class='col-md-4'><div class='col-title'>Address</div><div class='col-info'>" . $d->registrant_address . "</div></div>";
                //} else {
                //    $data['domains'] .= "<div class='col-md-4'><div class='col-title'>Address</div><div class='col-info'>-</div></div>";
                //}

                //if (!empty($d->registrant_city)) {
                //    $data['domains'] .= "<div class='col-md-4'><div class='col-title'>City</div><div class='col-info'>" . ucwords(strtolower($d->registrant_city)) . ", " . $d->registrant_state . "</div></div>";
                //} else {
                //    $data['domains'] .= "<div class='col-md-4'><div class='col-title'>City</div><div class='col-info'>-</div></div>";
                //}

                //if (!empty($d->registrant_state)) {
                //    $data['domains'] .= "<div class='col-md-4'><div class='col-title'>State</div><div class='col-info'>" . $d->registrant_state . "</div></div>";
                //} else {
                    //$data['domains'] .= "<div class='col-md-4'><div class='col-title'>State</div><div class='col-info'>-</div></div>";
                //}

                //if (!empty($d->registrant_zip)) {
                //    $data['domains'] .= "<div class='col-md-4'><div class='col-title'>Zip</div><div class='col-info'>" . $d->registrant_zip . "</div></div>";
                //} else {
                //    $data['domains'] .= "<div class='col-md-4'><div class='col-title'>Zip</div><div class='col-info'>-</div></div>";
                //}

                //if (!empty($d->registrant_email)) {
                //    $data['domains'] .= "<div class='col-md-4'><div class='col-title'>Email</div><div class='col-info'><small><a href='/" . uri_string() . "/report' rel='nofollow' class='btn btn-default-transparent uncover_btn'>Uncover Email<br>" . obfuscate_email($d->registrant_email) . "</a></small></div></div>";
                //} else {
                //    $data['domains'] .= "<div class='col-md-4'><div class='col-title'>Email</div><div class='col-info'>-</div></div>";
                //}

                //if (!empty($d->registrant_phone)) {
                //    $data['domains'] .= "<div class='col-md-4'><div class='col-title'>Phone</div><div class='col-info'>" . formatPhoneNumber($d->registrant_phone) . "</div></div>";
                //} else {
                //    $data['domains'] .= "<div class='col-md-4'><div class='col-title'>Phone</div><div class='col-info'>-</div></div>";
                //}

                //if (!empty($d->registrant_fax)) {
                //    $data['domains'] .= "<div class='col-md-4'><div class='col-title'>Fax</div><div class='col-info'>" . formatPhoneNumber($d->registrant_fax) . "</div></div>";
                //} else {
                //    $data['domains'] .= "<div class='col-md-4'><div class='col-title'>Fax</div><div class='col-info'>-</div></div>";
                //}

                //$data['domains'] .= "<div class='col-md-4'><div class='col-title'>Registrar</div><div class='col-info'>" . str_replace('Llc', 'LLC', ucwords(strtolower($d->domain_registrar_name))) . "</div></div>";

                $data['domains'] .= "</div>";

                if ($i < 3) {
                    $siteList[] = $d->domain_name;
                    $i++;
                }
                $data['domains'] .= "</div>";

                $domainBucket['theseDomains'][$d->domain_name] = $d->domain_name;
                $domainBucket['emails'][$d->registrant_email] = trim($d->registrant_email);
                $domainBucket['cities'][$d->city_slug . ", " . $d->registrant_state] = $d->city_slug . ", " . $d->registrant_state;
                $domainBucket['phones'][trim($d->registrant_phone)] = trim($d->registrant_phone);
                $domainBucket['addresses'][slugify($d->registrant_address) . "|" . $d->city_slug . "|" . $d->registrant_state] = slugify($d->registrant_address) . "|" . $d->city_slug . "|" . $d->registrant_state;
                
            }

            //echo var_dump($domainBucket); // exit();

            $newBucket = array();

            if ($domainBucket['emails']) {
                foreach ($domainBucket['emails'] as $bucketEmails) {
                    $bucketFromEmail = $this->frontend_model->getAllFromEmail($bucketEmails, 10);
                    if ($bucketFromEmail) {
                        foreach ($bucketFromEmail as $bfe) {
                            if (!in_array($bfe->domain_name, $domainBucket['theseDomains'])) {
                                $newBucket['domains'][$bfe->domain_name] = $bfe->domain_name;
                            }
                            if (!in_array($bfe->city_slug . ", " . $bfe->registrant_state, $domainBucket['cities'])) {
                                $newBucket['cities'][$bfe->city_slug . ", " . $bfe->registrant_state] = $bfe->city_slug . ", " . $bfe->registrant_state;
                            }
                            if (!in_array($bfe->registrant_phone, $domainBucket['phones'])) {
                                $newBucket['phones'][$bfe->registrant_phone] = $bfe->registrant_phone;
                            }
                            if (!in_array(slugify($bfe->registrant_address) . "|" . $bfe->city_slug . "|" . $bfe->registrant_state, $domainBucket['addresses'])) {
                                $newBucket['addresses'][slugify($bfe->registrant_address) . "|" . $bfe->city_slug . "|" . $bfe->registrant_state] = slugify($bfe->registrant_address) . "|" . $bfe->city_slug . "|" . $bfe->registrant_state;
                            }
                        }
                    }
                }
            }

            if ($domainBucket['phones']) {
                foreach ($domainBucket['phones'] as $bucketPhones) {
                    $bucketFromPhone = $this->frontend_model->getAllFromPhone($bucketPhones, 10);
                    if ($bucketFromPhone) {
                        foreach ($bucketFromPhone as $bfe) {
                            if (!in_array($bfe->domain_name, $domainBucket['theseDomains'])) {
                                $newBucket['domains'][$bfe->domain_name] = $bfe->domain_name;
                            }
                            if (!in_array($bfe->registrant_email, $domainBucket['emails'])) {
                                $newBucket['emails'][$bfe->registrant_email] = $bfe->registrant_email;
                            }
                            if (!in_array($bfe->city_slug . ", " . $bfe->registrant_state, $domainBucket['cities'])) {
                                $newBucket['cities'][$bfe->city_slug . ", " . $bfe->registrant_state] = $bfe->city_slug . ", " . $bfe->registrant_state;
                            }
                            if (!in_array(slugify($bfe->registrant_address) . "|" . $bfe->city_slug . "|" . $bfe->registrant_state, $domainBucket['addresses'])) {
                                $newBucket['addresses'][slugify($bfe->registrant_address) . "|" . $bfe->city_slug . "|" . $bfe->registrant_state] = slugify($bfe->registrant_address) . "|" . $bfe->city_slug . "|" . $bfe->registrant_state;
                            }
                        }
                    }
                }
            }

            if ($domainBucket['addresses']) {
                foreach ($domainBucket['addresses'] as $bucketAddress) {
                    $bucketFromAddress = $this->frontend_model->getAllFromAddress($bucketAddress, 10);
                    if ($bucketFromAddress) {
                        foreach ($bucketFromPhone as $bfe) {
                            if (!in_array($bfe->domain_name, $domainBucket['theseDomains'])) {
                                $newBucket['domains'][$bfe->domain_name] = $bfe->domain_name;
                            }
                            if (!in_array($bfe->registrant_email, $domainBucket['emails'])) {
                                $newBucket['emails'][$bfe->registrant_email] = $bfe->registrant_email;
                            }
                            if (!in_array($bfe->city_slug . ", " . $bfe->registrant_state, $domainBucket['cities'])) {
                                $newBucket['cities'][$bfe->city_slug . ", " . $bfe->registrant_state] = $bfe->city_slug . ", " . $bfe->registrant_state;
                            }
                            if (!in_array($bfe->registrant_phone, $domainBucket['phones'])) {
                                $newBucket['phones'][$bfe->registrant_phone] = $bfe->registrant_phone;
                            }
                        }
                    }
                }
            }

            //echo var_dump($newBucket);
            $data['allDomains'] = implode(", ", $domainBucket['theseDomains']);
            if (isset($newBucket['domains']) && !empty($newBucket['domains'])) {
                $data['allDomains'] .= ", " . implode(", ", $newBucket['domains']);
            }

            if (!isset($newBucket['addresses'])) {
                $newBucket['addresses'] = array();
            }
            $obfuscated = array();
            $merged = array_merge($newBucket['addresses'], $domainBucket['addresses']);
            foreach ($merged as $address) {
                $obfuscated[] = ucwords(unslugify(explode("|", $address)[0]));
            }
            $data['contains_addresses'] = '
              <div class="col-md-3 other-text">
              <div class="col-md-4 text-center">
              <div class="others-number mobile-center">' . count(array_merge($newBucket['addresses'], $domainBucket['addresses'])) . '</div>
              </div>
              <div class="col-md-8">
              <div class="others-label small mobile-center">Address(es)</div>
              <div class="others-list small mobile-center"><strong>' . implode(",<br>", $obfuscated) . '</strong></div>
              </div>
              </div>';

            if (!isset($newBucket['phones'])) {
                $newBucket['phones'] = array();
            }
            $obfuscated = array();
            $merged = array_merge($newBucket['phones'], $domainBucket['phones']);
            foreach ($merged as $phone) {
                $obfuscated[] = formatPhoneNumber($phone);
            }
            $data['contains_phones'] = '
              <div class="col-md-3 other-text">
              <div class="col-md-4 text-center">
              <div class="others-number mobile-center">' . count(array_merge($newBucket['phones'], $domainBucket['phones'])) . '</div>
              </div>
              <div class="col-md-8">
              <div class="others-label small mobile-center">Phone(s)</div>
              <div class="others-list small mobile-center"><strong>' . implode(",<br>", $obfuscated) . '</strong></div>
              </div>
              </div>';


            if (!isset($newBucket['cities'])) {
                $newBucket['cities'] = array();
            }
            $unslugged = array();
            $merged = array_merge($newBucket['cities'], $domainBucket['cities']);
            foreach ($merged as $city) {
                if (strlen($city) > 2) {
                    $ex = explode(", ", $city);
                    $unslugged[] = ucwords(unslugify($ex[0])) . ", " . strtoupper($ex[1]);
                }
            }

            $data['contains_cities'] = '
              <div class="col-md-3 other-text">
              <div class="col-md-4 text-center">
              <div class="others-number mobile-center">' . count(array_merge($newBucket['cities'], $domainBucket['cities'])) . '</div>
              </div>
              <div class="col-md-8">
              <div class="others-label small mobile-center">Cities</div>
              <div class="others-list small mobile-center"><strong>' . implode(",<br>", $unslugged) . '</strong></div>
              </div>
              </div>';

            if (!isset($newBucket['emails'])) {
                $newBucket['emails'] = array();
            }
            $obfuscated = array();
            $merged = array_merge($newBucket['emails'], $domainBucket['emails']);
            foreach ($merged as $email) {
                $obfuscated[] = obfuscate_email($email);
            }
            $data['contains_emails'] = '
              <div class="col-md-3 other-text">
              <div class="col-md-4 text-center">
              <div class="others-number mobile-center">' . count(array_merge($newBucket['emails'], $domainBucket['emails'])) . '</div>
              </div>
              <div class="col-md-8">
              <div class="others-label small mobile-center">Email(s)</div>
              <div class="others-list small mobile-center"><strong>' . implode(",<br>", $obfuscated) . '</strong></div>
              </div>
              </div>';




            $idRollList = "";
            $data['names'] = "";

            if ($nId[0]->ID && !empty($nId[0]->ID)) {
                $idRoll = $this->frontend_model->getSomeNamesByID($nId[0]->ID);
                if ($idRoll) {
                    foreach ($idRoll as $ir) {
                        $idRollList .= "<div class='col-md-3'><a href='/" . $ir->state . "/" . $ir->city_slug . "/" . $ir->name_slug . "'>" . ucwords(strtolower($ir->name)) . "</a></div>";
                    }
                    $data['names'] .= '
              <div class="col-md-12">
              <h4>Other Popular People & Businesses</h4>
              <div class="separator"></div>
              ' . $idRollList . '
              </div>
              ';
                }
            }

            //$data['domains'] .= "</div>";
        } else {
            redirect("https://dexr.io/" . $state . "/" . $city, 'location', 301);
            //show_404();
        }

        if (count($siteList) > 0) {
            $siteList = implode(', ', $siteList);
        } else {
            $siteList = $siteList[0];
        }

        $data['name'] = ucwords($domains['results'][0]->registrant_name);

        if (empty($data['names'])) {
            //header('Location: /' . $state);
        }

        //$data['showAds'] = true;

        $data['metaTitle'] = "Webmaster: " . ucwords(str_replace('-', ' ', strtolower($name))) . " in " . $data['city'] . ", " . strtoupper($state);
        $data['metaDescription'] = "Contact webmaster " . ucwords(str_replace('-', ' ', strtolower($name))) . " in " . $data['city'] . ", " . strtoupper($state) . " by address: " . $domains['results'][0]->registrant_address . ", email or phone: ".formatPhoneNumber($domains['results'][0]->registrant_phone).". They've registered " . $siteList . ".";

        $this->load->view('frontend/header', $data);
        $this->load->view('frontend/name');
        $this->load->view('frontend/footer-no-states');
    }

    public function name_report($state, $city, $name, $page = false) {

        $data['checkoutModal'] = true;
        $data['noIndex'] = true;

        $this->load->helper("mapbox");

        /*
         * // REDIRECT FOR SPECIAL CHARS
          $currPath = $_SERVER['REQUEST_URI'];
          $redirChars = array("%A0", "%C2", "%C3", "%A3", "%A1", "%AD", "%84", "%E2", "%A2", "%BA", "%B1", "%20", "%BC", "%A9", "%A7", "%C5");

          if (isset($currPath)) {
          foreach ($redirChars as $char) {
          if (strpos($currPath, $char) !== FALSE) {
          $currPath = str_replace($char, "-", $currPath);
          }
          }
          $newPath = str_replace("--", "-", $currPath);
          $newPath = preg_replace('/-+/', '-', $newPath);
          if (substr($newPath, -1) == "-") {
          $newPath = substr_replace($newPath, "", -1);
          }
          if ($currPath !== $newPath) {
          echo $currPath . " => " . $newPath;
          exit();
          }

          //redirect("https://dexr.io" . substr_replace($currPath, "", -1), 'location', 301);
          }
         * 
         */

        if ($page == '1') {
            //header('Location: /' . $state . "/" . $city . "/" . $name);
        }

        $statesArray = statesArray();
        $data['state'] = $statesArray[strtoupper($state)];
        $data['state_abr'] = $state;
        $data['city'] = ucwords(str_replace('-', ' ', $city));
        $data['city_slug'] = $city;
        $data['name_slug'] = $name;
        $data['domains'] = "";
        $siteList = array();
        $i = 0;

        $data['redirect'] = "/report/" . $state . "/" . $city . "/" . $name;

        $domains = $this->frontend_model->getDomainsByCityStateName($city, $state, $name);
        $nId = $this->frontend_model->getNameIdFromNameSlugCityState($city, $state, $name);
        $data['total'] = $domains['total'];

        $domainBucket = array();
        $addressBucket = array();

        if ($domains['results']) {
            foreach ($domains['results'] as $d) {
                $data['domains'] .= "<div class='row domain'>";
                $data['domains'] .= "<div class='col-md-12'><h2 class='word-break'><i class='fa fa-asterisk' style='color:#09afdf;'></i> " . $d->domain_name . "</h2><div class='separator'></div></div>";

                $created = "";
                if (!empty($d->created_date_normalized)) {
                    $ex = explode(" ", $name);
                    $created = " " . ucwords(strtolower($ex[0])) . " registered this web site on " . date('M d, Y', strtotime($d->created_date_normalized)) . ". ";
                }
                $expires = "";
                if (!empty($d->expiry_date)) {
                    $expires = " The expiration for " . ucwords($d->domain_name) . " is listed as " . date('M d, Y', strtotime($d->expiry_date)) . ". ";
                }

                $updated = "";
                if (!empty($d->update_date)) {
                    $updated = " The site's info was last updated on " . date('M d, Y', strtotime($d->update_date));
                }

                if (!empty($d->registrant_company)) {
                    $updated .= " by " . ucwords(strtolower($d->registrant_company)) . " who is the registered company for this domain.";
                } else {
                    $updated .= ".";
                }

                $contact = "";
                if (!empty($d->registrant_phone)) {
                    $contact = " You may be able to contact them at " . obfuscate_phone(formatPhoneNumber($d->registrant_phone));
                }

                if (!empty($d->registrant_email)) {
                    $contact .= " or using their email address at " . obfuscate_email($d->registrant_email) . ".";
                } else {
                    $contact .= ".";
                }

                if ($data['total'] > 5) {
                    $totalListed = '5';
                } else {
                    $totalListed = $data['total'];
                }

                if ($i == 0) {
                    $data['domains'] .= "<div class='col-md-12'><p>" . ucwords(str_replace('-', ' ', strtolower($name))) . " was located at " . obfuscate_address(ucwords(strtolower($d->registrant_address))) . " in " . $data['city'] . ", " . strtoupper($state) . " when they registered " . ucwords($d->domain_name) . " at " . str_replace('Llc', 'LLC', ucwords(strtolower($d->domain_registrar_name))) . "." . $created . $expires . $updated . $contact . " We have " . $data['total'] . " domain registration(s) total in our database, " . $totalListed . " of which are listed below. For the complete list please <a data-toggle='modal' data-target='#exampleModal'>see pricing</a>.</p><div class='separator'></div></div>";
                }

                $data['domains'] .= "<div class='col-md-9'>";
                $data['domains'] .= "<div class='col-md-4'><div class='col-title'>Keyword Split</div><div class='col-info'>" . $d->num . "</div></div>";
                if (!empty($d->created_date_normalized)) {
                    $data['domains'] .= "<div class='col-md-4'><div class='col-title'>Created</div><div class='col-info'>" . date('M d, Y', strtotime($d->created_date_normalized)) . "</div></div>";
                } else {
                    $data['domains'] .= "<div class='col-md-4'><div class='col-title'>Created</div><div class='col-info'>-</div></div>";
                }

                if (!empty($d->update_date)) {
                    $data['domains'] .= "<div class='col-md-4'><div class='col-title'>Updated</div><div class='col-info'>" . date('M d, Y', strtotime($d->update_date)) . "</div></div>";
                } else {
                    $data['domains'] .= "<div class='col-md-4'><div class='col-title'>Updated</div><div class='col-info'>-</div></div>";
                }

                if (!empty($d->expiry_date)) {
                    $data['domains'] .= "<div class='col-md-4'><div class='col-title'>Expiration</div><div class='col-info'>" . date('M d, Y', strtotime($d->expiry_date)) . "</div></div>";
                } else {
                    $data['domains'] .= "<div class='col-md-4'><div class='col-title'>Expiration</div><div class='col-info'>-</div></div>";
                }

                if (!empty($d->registrant_name)) {
                    $data['domains'] .= "<div class='col-md-4'><div class='col-title'>Registrant Name</div><div class='col-info'>" . $d->registrant_name . "</div></div>";
                } else {
                    $data['domains'] .= "<div class='col-md-4'><div class='col-title'>Registrant Name</div><div class='col-info'>-</div></div>";
                }

                if (!empty($d->registrant_company)) {
                    $data['domains'] .= "<div class='col-md-4'><div class='col-title'>Company</div><div class='col-info'>" . ucwords(strtolower($d->registrant_company)) . "</div></div>";
                } else {
                    $data['domains'] .= "<div class='col-md-4'><div class='col-title'>Company</div><div class='col-info'>-</div></div>";
                }

                if (!empty($d->registrant_address)) {
                    $data['domains'] .= "<div class='col-md-4'><div class='col-title'>Address</div><div class='col-info'>" . obfuscate_address($d->registrant_address) . "</div></div>";
                } else {
                    $data['domains'] .= "<div class='col-md-4'><div class='col-title'>Address</div><div class='col-info'>-</div></div>";
                }

                if (!empty($d->registrant_city)) {
                    $data['domains'] .= "<div class='col-md-4'><div class='col-title'>City</div><div class='col-info'>" . ucwords(strtolower($d->registrant_city)) . ", " . $d->registrant_state . "</div></div>";
                } else {
                    $data['domains'] .= "<div class='col-md-4'><div class='col-title'>City</div><div class='col-info'>-</div></div>";
                }

                if (!empty($d->registrant_state)) {
                    $data['domains'] .= "<div class='col-md-4'><div class='col-title'>State</div><div class='col-info'>" . $d->registrant_state . "</div></div>";
                } else {
                    $data['domains'] .= "<div class='col-md-4'><div class='col-title'>State</div><div class='col-info'>-</div></div>";
                }

                if (!empty($d->registrant_zip)) {
                    $data['domains'] .= "<div class='col-md-4'><div class='col-title'>Zip</div><div class='col-info'>" . $d->registrant_zip . "</div></div>";
                } else {
                    $data['domains'] .= "<div class='col-md-4'><div class='col-title'>Zip</div><div class='col-info'>-</div></div>";
                }

                if (!empty($d->registrant_email)) {
                    $data['domains'] .= "<div class='col-md-4'><div class='col-title'>Email</div><div class='col-info'><small><button data-toggle='modal' data-target='#exampleModal' type='button' class='btn btn-default-transparent uncover_btn'>Uncover Email<br>" . obfuscate_email($d->registrant_email) . "</button></small></div></div>";
                } else {
                    $data['domains'] .= "<div class='col-md-4'><div class='col-title'>Email</div><div class='col-info'>-</div></div>";
                }

                if (!empty($d->registrant_phone)) {
                    $data['domains'] .= "<div class='col-md-4'><div class='col-title'>Phone</div><div class='col-info'>" . obfuscate_phone(formatPhoneNumber($d->registrant_phone)) . "</div></div>";
                } else {
                    $data['domains'] .= "<div class='col-md-4'><div class='col-title'>Phone</div><div class='col-info'>-</div></div>";
                }

                if (!empty($d->registrant_fax)) {
                    $data['domains'] .= "<div class='col-md-4'><div class='col-title'>Fax</div><div class='col-info'>" . formatPhoneNumber($d->registrant_fax) . "</div></div>";
                } else {
                    $data['domains'] .= "<div class='col-md-4'><div class='col-title'>Fax</div><div class='col-info'>-</div></div>";
                }

                $data['domains'] .= "<div class='col-md-4'><div class='col-title'>Registrar</div><div class='col-info'>" . str_replace('Llc', 'LLC', ucwords(strtolower($d->domain_registrar_name))) . "</div></div>";

                $data['domains'] .= "</div>";
                /*
                  $addy = explode("|", explode("#", ucwords(strtolower($d->registrant_address)))[0])[0] . " " . $data['city'] . ", " . strtoupper($state);
                  if (!array_key_exists($addy, $addressBucket)) {
                  $geo = forwardGeocode($addy);
                  } else {
                  $geo = $addressBucket[$addy];
                  }
                  $geod = $geo['center'][0] . "," . $geo['center'][1];
                  if (!isset($data['oneMap'])) {
                  $data['oneMap'] = $geod;
                  }
                  $data['domains'] .= "<div class='col-md-3 text-center'>"
                  . "<img style='width:250px; height:250px; border-radius:50%; margin-top:40px; margin-bottom:40px; margin-left:auto; margin-right:auto;' src='https://api.mapbox.com/styles/v1/mapbox/streets-v11/static/pin-s-building+285A98(" . $geod . ")/" . $geod . ",15.67,0.00,0.00/300x300@2x?access_token=pk.eyJ1IjoiZGV4ciIsImEiOiJjanZzcndybDYwdWVmM3pvZWFpcnBsYmRhIn0.bl_iQq9nNrlVGVMU6TZOyA'></img>"
                  . "</div>";
                  $addressBucket[$addy] = $geo;
                 */



                if ($i == 0 && 1 == 2) {

                    $data['domains'] .= "<div class='row'>";
                    $data['domains'] .= "<div class='col-md-12'>";
                    $data['domains'] .= '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                                        <!-- Name Top Main Column -->
                                        <ins class="adsbygoogle"
                                             style="display:block"
                                             data-ad-client="ca-pub-2063867378055756"
                                             data-ad-slot="5520348789"
                                             data-ad-format="auto"
                                             data-full-width-responsive="true"></ins>
                                        <script>
                                        (adsbygoogle = window.adsbygoogle || []).push({});
                                        </script>';
                    $data['domains'] .= "</div>";
                    $data['domains'] .= "</div>";
                }



                if (!empty($d->num)) {
                    $sim = $this->frontend_model->getSimilarDomains($d->num);
                    if ($sim) {
                        $data['domains'] .= "</div><div class='row'><div class='col-md-1'></div>";
                        $data['domains'] .= "<div class='col-md-11'>";
                        $data['domains'] .= "<div class='row' style='margin-bottom:80px;'><div class='col-md-12'><h5 style='border-bottom:1px solid #ddd; padding-bottom:8px;'>Similar Web Sites</h5></div><div class='col-md-12'>";
                        foreach ($sim as $s) {
                            $domainInfo = $this->frontend_model->getDomainInfoByID($s->domain_ID);
                            if ($domainInfo) {
                                if ($domainInfo[0]->domain_name !== $d->domain_name) {
                                    $data['domains'] .= "<div class='col-md-4' style='margin-bottom:10px;'><a href='/" . strtolower($domainInfo[0]->registrant_state) . "/" . $domainInfo[0]->city_slug . "/" . $domainInfo[0]->name_slug . "'>" . ucwords(strtolower($domainInfo[0]->registrant_name)) . "</a><br><small>" . $domainInfo[0]->domain_name . "</small></div>";
                                }
                            }
                        }
                        $data['domains'] .= "</div>";
                        $data['domains'] .= "</div></div>";
                    }
                }

                if ($i < 3) {
                    $siteList[] = $d->domain_name;
                    $i++;
                }
                $data['domains'] .= "</div>";

                $domainBucket['theseDomains'][$d->domain_name] = $d->domain_name;
                $domainBucket['emails'][$d->registrant_email] = trim($d->registrant_email);
                $domainBucket['cities'][$d->city_slug . ", " . $d->registrant_state] = $d->city_slug . ", " . $d->registrant_state;
                $domainBucket['phones'][trim($d->registrant_phone)] = trim($d->registrant_phone);
                $domainBucket['addresses'][slugify($d->registrant_address) . "|" . $d->city_slug . "|" . $d->registrant_state] = slugify($d->registrant_address) . "|" . $d->city_slug . "|" . $d->registrant_state;
            }

            //echo var_dump($domainBucket); // exit();

            $newBucket = array();

            if ($domainBucket['emails']) {
                foreach ($domainBucket['emails'] as $bucketEmails) {
                    $bucketFromEmail = $this->frontend_model->getAllFromEmail($bucketEmails, 10);
                    if ($bucketFromEmail) {
                        foreach ($bucketFromEmail as $bfe) {
                            if (!in_array($bfe->domain_name, $domainBucket['theseDomains'])) {
                                $newBucket['domains'][$bfe->domain_name] = $bfe->domain_name;
                            }
                            if (!in_array($bfe->city_slug . ", " . $bfe->registrant_state, $domainBucket['cities'])) {
                                $newBucket['cities'][$bfe->city_slug . ", " . $bfe->registrant_state] = $bfe->city_slug . ", " . $bfe->registrant_state;
                            }
                            if (!in_array($bfe->registrant_phone, $domainBucket['phones'])) {
                                $newBucket['phones'][$bfe->registrant_phone] = $bfe->registrant_phone;
                            }
                            if (!in_array(slugify($bfe->registrant_address) . "|" . $bfe->city_slug . "|" . $bfe->registrant_state, $domainBucket['addresses'])) {
                                $newBucket['addresses'][slugify($bfe->registrant_address) . "|" . $bfe->city_slug . "|" . $bfe->registrant_state] = slugify($bfe->registrant_address) . "|" . $bfe->city_slug . "|" . $bfe->registrant_state;
                            }
                        }
                    }
                }
            }

            if ($domainBucket['phones']) {
                foreach ($domainBucket['phones'] as $bucketPhones) {
                    $bucketFromPhone = $this->frontend_model->getAllFromPhone($bucketPhones, 10);
                    if ($bucketFromPhone) {
                        foreach ($bucketFromPhone as $bfe) {
                            if (!in_array($bfe->domain_name, $domainBucket['theseDomains'])) {
                                $newBucket['domains'][$bfe->domain_name] = $bfe->domain_name;
                            }
                            if (!in_array($bfe->registrant_email, $domainBucket['emails'])) {
                                $newBucket['emails'][$bfe->registrant_email] = $bfe->registrant_email;
                            }
                            if (!in_array($bfe->city_slug . ", " . $bfe->registrant_state, $domainBucket['cities'])) {
                                $newBucket['cities'][$bfe->city_slug . ", " . $bfe->registrant_state] = $bfe->city_slug . ", " . $bfe->registrant_state;
                            }
                            if (!in_array(slugify($bfe->registrant_address) . "|" . $bfe->city_slug . "|" . $bfe->registrant_state, $domainBucket['addresses'])) {
                                $newBucket['addresses'][slugify($bfe->registrant_address) . "|" . $bfe->city_slug . "|" . $bfe->registrant_state] = slugify($bfe->registrant_address) . "|" . $bfe->city_slug . "|" . $bfe->registrant_state;
                            }
                        }
                    }
                }
            }

            if ($domainBucket['addresses']) {
                foreach ($domainBucket['addresses'] as $bucketAddress) {
                    $bucketFromAddress = $this->frontend_model->getAllFromAddress($bucketAddress, 10);
                    if ($bucketFromAddress) {
                        foreach ($bucketFromPhone as $bfe) {
                            if (!in_array($bfe->domain_name, $domainBucket['theseDomains'])) {
                                $newBucket['domains'][$bfe->domain_name] = $bfe->domain_name;
                            }
                            if (!in_array($bfe->registrant_email, $domainBucket['emails'])) {
                                $newBucket['emails'][$bfe->registrant_email] = $bfe->registrant_email;
                            }
                            if (!in_array($bfe->city_slug . ", " . $bfe->registrant_state, $domainBucket['cities'])) {
                                $newBucket['cities'][$bfe->city_slug . ", " . $bfe->registrant_state] = $bfe->city_slug . ", " . $bfe->registrant_state;
                            }
                            if (!in_array($bfe->registrant_phone, $domainBucket['phones'])) {
                                $newBucket['phones'][$bfe->registrant_phone] = $bfe->registrant_phone;
                            }
                        }
                    }
                }
            }

            //echo var_dump($newBucket);

            if (!isset($newBucket['addresses'])) {
                $newBucket['addresses'] = array();
            }
            $obfuscated = array();
            $merged = array_merge($newBucket['addresses'], $domainBucket['addresses']);
            foreach ($merged as $address) {
                $obfuscated[] = ucwords(obfuscate_address(unslugify(explode("|", $address)[0])));
            }
            $data['contains_addresses'] = '
                    <div class="col-md-3 other-text">
                        <div class="col-md-4 text-center">
                            <div class="others-number mobile-center">' . count(array_merge($newBucket['addresses'], $domainBucket['addresses'])) . '</div>
                        </div>
                        <div class="col-md-8">
                            <div class="others-label small mobile-center">Address(es)</div>
                            <div class="others-list small mobile-center"><strong>' . implode(",<br>", $obfuscated) . '</strong></div>
                        </div>
                    </div>';

            if (!isset($newBucket['phones'])) {
                $newBucket['phones'] = array();
            }
            $obfuscated = array();
            $merged = array_merge($newBucket['phones'], $domainBucket['phones']);
            foreach ($merged as $phone) {
                $obfuscated[] = obfuscate_phone(formatPhoneNumber($phone));
            }
            $data['contains_phones'] = '
                    <div class="col-md-3 other-text">
                        <div class="col-md-4 text-center">
                            <div class="others-number mobile-center">' . count(array_merge($newBucket['phones'], $domainBucket['phones'])) . '</div>
                        </div>
                        <div class="col-md-8">
                            <div class="others-label small mobile-center">Phone(s)</div>
                            <div class="others-list small mobile-center"><strong>' . implode(",<br>", $obfuscated) . '</strong></div>
                        </div>
                    </div>';


            if (!isset($newBucket['cities'])) {
                $newBucket['cities'] = array();
            }
            $unslugged = array();
            $merged = array_merge($newBucket['cities'], $domainBucket['cities']);
            foreach ($merged as $city) {
                if (strlen($city) > 2) {
                    $ex = explode(", ", $city);
                    $unslugged[] = ucwords(unslugify($ex[0])) . ", " . strtoupper($ex[1]);
                }
            }

            $data['contains_cities'] = '
                    <div class="col-md-3 other-text">
                        <div class="col-md-4 text-center">
                            <div class="others-number mobile-center">' . count(array_merge($newBucket['cities'], $domainBucket['cities'])) . '</div>
                        </div>
                        <div class="col-md-8">
                            <div class="others-label small mobile-center">Cities</div>
                            <div class="others-list small mobile-center"><strong>' . implode(",<br>", $unslugged) . '</strong></div>
                        </div>
                    </div>';

            if (!isset($newBucket['emails'])) {
                $newBucket['emails'] = array();
            }
            $obfuscated = array();
            $merged = array_merge($newBucket['emails'], $domainBucket['emails']);
            foreach ($merged as $email) {
                $obfuscated[] = obfuscate_email($email);
            }
            $data['contains_emails'] = '
                    <div class="col-md-3 other-text">
                        <div class="col-md-4 text-center">
                            <div class="others-number mobile-center">' . count(array_merge($newBucket['emails'], $domainBucket['emails'])) . '</div>
                        </div>
                        <div class="col-md-8">
                            <div class="others-label small mobile-center">Email(s)</div>
                            <div class="others-list small mobile-center"><strong>' . implode(",<br>", $obfuscated) . '</strong></div>
                        </div>
                    </div>';




            $idRollList = "";
            $data['names'] = "";

            if ($nId[0]->ID && !empty($nId[0]->ID)) {
                $idRoll = $this->frontend_model->getSomeNamesByID($nId[0]->ID);
                if ($idRoll) {
                    foreach ($idRoll as $ir) {
                        $idRollList .= "<div class='col-md-3'><a href='/" . $ir->state . "/" . $ir->city_slug . "/" . $ir->name_slug . "'>" . ucwords(strtolower($ir->name)) . "</a></div>";
                    }
                    $data['names'] .= '
                                            <div class="col-md-12">
                                                <h4>Other Popular People & Businesses</h4>
                                                    <div class="separator"></div>
                                                ' . $idRollList . '
                                            </div>
                                        ';
                }
            }

            //$data['domains'] .= "</div>";
        } else {
            redirect("https://dexr.io/" . $state . "/" . $city, 'location', 301);
            //show_404();
        }

        if (count($siteList) > 0) {
            $siteList = implode(', ', $siteList);
        } else {
            $siteList = $siteList[0];
        }

        $data['name'] = ucwords($domains['results'][0]->registrant_name);

        if (empty($data['names'])) {
            //header('Location: /' . $state);
        }

        //$data['showAds'] = true;

        $data['metaTitle'] = "Webmaster: " . ucwords(str_replace('-', ' ', strtolower($name))) . " in " . $data['city'] . ", " . strtoupper($state);
        $data['metaDescription'] = "Contact webmaster " . ucwords(str_replace('-', ' ', strtolower($name))) . " in " . $data['city'] . ", " . strtoupper($state) . " by owner name, email, phone or address. They've registered " . $siteList . ".";

        $this->load->view('frontend/header', $data);
        $this->load->view('frontend/name_report');
        $this->load->view('frontend/footer-states');
    }

    public function sitemap_index() {

        $this->load->helper('url');
        $this->load->helper('general');

        $countSitemapPages = ceil(12170098 / 25000);

        $urlset = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1" /><!--?xml version="1.0" encoding="UTF-8"?-->');

        $i = 1;
        while ($i <= $countSitemapPages) {
            $url = $urlset->addChild('sitemap');
            $url->addChild('loc', 'https://dexr.io/sitemap/' . $i);
            //$url->addChild('lastmod', $item->LASTMOD );
            //$url->addChild('changefreq', 'monthly');
            //$url->addChild('priority', '1.0');
            $i++;
        }

        $dom = new DomDocument();
        $dom->loadXML($urlset->asXML());

        $dom->formatOutput = true;
        $data['map'] = $dom->saveXML();

        $this->load->view('sitemapxml', $data);
    }

    public function sitemap($page) {

        $this->load->helper('url');
        $this->load->helper('general');

        $urlBatch = $this->frontend_model->getSitemapBatch($page);

        function utf8_for_xml($string) {
            return preg_replace('/[^\x{0009}\x{000a}\x{000d}\x{0020}-\x{D7FF}\x{E000}-\x{FFFD}]+/u', ' ', $string);
        }

        if ($urlBatch) {
            $urlset = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1" /><!--?xml version="1.0" encoding="UTF-8"?-->');

            foreach ($urlBatch as $uri) {

                $city = $uri->city_slug;
                $state = $uri->state;
                $url = $urlset->addChild('url');
                $url->addChild('loc', 'https://dexr.io/' . $state . '/' . $city . '/' . utf8_for_xml($uri->name_slug));

                //$url->addChild('lastmod', $item->LASTMOD );
                //$url->addChild('changefreq', 'monthly');
                //$url->addChild('priority', '1.0');
            }


            $dom = new DomDocument();
            $dom->loadXML($urlset->asXML());

            $dom->formatOutput = true;
            $data['map'] = $dom->saveXML();

            $this->load->view('sitemapxml', $data);
        } else {
            show_404();
        }
    }

    public function city_letter($state, $city, $letter, $page = false) {

        if ($page == '1') {
            header('Location: /' . $state . '/' . $city . '/' . $letter);
        }

        $statesArray = statesArray();
        $data['state'] = $statesArray[strtoupper($state)];

        $data['state_abr'] = $state;
        $data['city'] = ucwords(str_replace('-', ' ', $city));
        $data['city_slug'] = $city;
        $data['letter'] = $letter;

        $data['names'] = "";
        $names = $this->frontend_model->getNamesFromLetterCityState($city, $state, $letter, $page);
        if ($names['results']) {
            foreach ($names['results'] as $n) {
                $data['names'] .= "<div class='col-md-4 col-xs-6'><a href='/" . $state . "/" . $city . "/" . $n->name_slug . "'>" . ucwords(strtolower($n->name)) . "</a></div>";
            }
        } else {
            redirect("https://dexr.io/", 'location', 301);
            //show_404();
        }

        $data['count'] = $names['total'];
        $data['maxPerPage'] = 200;
        $data['lastPage'] = ($data['count'] / $data['maxPerPage']);
        $data['thisPage'] = $page;

        $data['url'] = $url = explode("/", $_SERVER['REQUEST_URI']);
        if (!isset($url[4]) || empty($url[4])) {
            $data['url'][4] = $url[4] = 1;
            $data['thisPage'] = $thisPage = 1;
        }
        $next = $url[4] + 1;
        $previous = $url[4] - 1;

        $data['prev'] = "/" . $url[1] . "/" . $url[2] . "/" . $url[3] . "/" . $previous;
        $data['next'] = "/" . $url[1] . "/" . $url[2] . "/" . $url[3] . "/" . $next;

        $metaPage = "";
        if ($page > 1) {
            $metaPage = " - Page " . $page;
        }

        $data['metaTitle'] = "List of " . $data['city'] . ", " . strtoupper($state) . " Business Owners & Web Site Owners - Letter " . strtoupper($letter) . $metaPage;
        $data['metaDescription'] = "Dexr is the leading provider for " . $data['city'] . ", " . $statesArray[strtoupper($state)] . " business owner & web site owner lists. Our database contains full contact info such as owner name, email, phone and address - Letter " . strtoupper($letter) . $metaPage . ".";

        $this->load->view('frontend/header', $data);
        $this->load->view('frontend/letter');
        $this->load->view('frontend/footer-fixed-pagination');
    }

    private function get_fresh_results($stats) {
        $data = new STDclass;

        $data->google_members = $this->user_model->get_oauth_count("google");
        $data->facebook_members = $this->user_model->get_oauth_count("facebook");
        $data->twitter_members = $this->user_model->get_oauth_count("twitter");
        $data->total_members = $this->user_model->get_total_members_count();
        $data->new_members = $this->user_model->get_new_today_count();
        $data->active_today = $this->user_model->get_active_today_count();

        return $data;
    }

    public function change_language() {
        $languages = $this->config->item("available_languages");
        if (!isset($_COOKIE['language'])) {
            $lang = "";
        } else {
            $lang = $_COOKIE["language"];
        }
        $this->template->loadContent("home/change_language.php", array(
            "languages" => $languages,
            "user_lang" => $lang
                )
        );
    }

    public function change_language_pro() {
        $lang = $this->common->nohtml($this->input->post("language"));
        $languages = $this->config->item("available_languages");
        if (!in_array($lang, $languages, TRUE)) {
            $this->template->error(lang("error_25"));
        }

        setcookie("language", $lang, time() + 3600 * 7, "/");
        $this->session->set_flashdata("globalmsg", lang("success_14"));
        redirect(site_url());
    }

}

?>