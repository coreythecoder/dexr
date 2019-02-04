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

        $data['metaTitle'] = "dexr";
        $data['metaDescription'] = "";

        $this->load->view('frontend/header', $data);
        $this->load->view('frontend/index');
        $this->load->view('frontend/footer-states');
    }

    public function pricing() {

        $data['metaTitle'] = "dexr";
        $data['metaDescription'] = "";

        $this->load->view('frontend/header', $data);
        $this->load->view('frontend/pricing');
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
                $data['cities'] .= "<div class='col-md-4'><a href='/" . $state . "/" . $c->slug . "'>" . ucwords(strtolower($c->city)) . "</a></div>";
            }
        } else {
            show_404();
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
        foreach (range('a', 'z') as $v) {
            $index_link = "";
            $names = $this->frontend_model->getSomeNamesFromLetterCityState($city, $state, $v, 12);
            if (count($names) >= 12) {
                $index_link = "<a href='/" . $state . "/" . $city . "/" . $v . "'>View " . strtoupper($v) . " Index...</a>";
            }
            if ($names) {
                $data['names'] .= "<div style='margin-bottom:30px;'><div class='col-md-12' style='border-bottom:1px solid #ddd;margin-bottom:15px;'><h2 style='display:inline-block;'>" . $v . "</h2><span class='pull-right' style='position:relative; top:40px;'>" . $index_link . "</span></div>";
                foreach ($names as $n) {
                    $data['names'] .= "<div class='col-md-4'><a href='/" . $state . "/" . $city . "/" . $n->name_slug . "'>" . ucwords(strtolower($n->name)) . "</a></div>";
                }
                $data['names'] .= "</div>";
            }
        }

        if (empty($data['names'])) {
            header('Location: /' . $state);
        }


        $data['metaTitle'] = "List of " . $statesArray[strtoupper($state)] . " Business Owners & Web Site Owners";
        $data['metaDescription'] = "Dexr is the leading provider for " . $statesArray[strtoupper($state)] . " Business Owner & Web Site Owner lists available for download. Our database contains full contact info such as owner name, email, phone and address.";

        $this->load->view('frontend/header', $data);
        $this->load->view('frontend/city');
        $this->load->view('frontend/footer-fixed-pagination');
    }

    public function name($state, $city, $name, $page = false) {

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

        $domains = $this->frontend_model->getDomainsByCityStateName($city, $state, $name);
        $nId = $this->frontend_model->getNameIdFromNameSlugCityState($city, $state, $name);
        $data['total'] = $domains['total'];
        if ($domains['results']) {
            foreach ($domains['results'] as $d) {
                $data['domains'] .= "<class='row domain'>";
                $data['domains'] .= "<div class='col-md-12'><h2>" . $d->domain_name . "</h2><div class='separator'></div>";
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
                    $data['domains'] .= "<div class='col-md-4'><div class='col-title'>Address</div><div class='col-info'>" . $d->registrant_address . "</div></div>";
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
                    $data['domains'] .= "<div class='col-md-4'><div class='col-title'>Email</div><div class='col-info'>" . obfuscate_email($d->registrant_email) . "</div></div>";
                } else {
                    $data['domains'] .= "<div class='col-md-4'><div class='col-title'>Email</div><div class='col-info'>-</div></div>";
                }

                if (!empty($d->registrant_phone)) {
                    $data['domains'] .= "<div class='col-md-4'><div class='col-title'>Phone</div><div class='col-info'>" . formatPhoneNumber($d->registrant_phone) . "</div></div>";
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

                $sim = $this->frontend_model->getSimilarDomains($d->num);
                if ($sim) {
                    $data['domains'] .= "<div class='row' style='margin-top:40px; margin-bottom:40px;'><div class='col-md-9'><h5>Similar Web Sites</h5></div><div class='col-md-12'>";
                    foreach ($sim as $s) {
                        if ($s->domain_name !== $d->domain_name)
                            $data['domains'] .= "<div class='col-md-4' style='margin-bottom:10px;'><a href='/" . strtolower($s->registrant_state) . "/" . $s->city_slug . "/" . $s->name_slug . "'>" . ucwords(strtolower($s->registrant_name)) . "</a><br><small>" . $s->domain_name . "</small></div>";
                    }
                    $data['domains'] .= "</div></div>";
                }
            }

            $idRollList = "";
            $data['names'] = "";
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

            //$data['domains'] .= "</div>";
        }

        $data['name'] = ucwords($domains['results'][0]->registrant_name);

        if (empty($data['names'])) {
            //header('Location: /' . $state);
        }


        $data['metaTitle'] = "Contact: ".ucwords(str_replace('-', ' ', strtolower($name)))." in ".$data['city']." ".$statesArray[strtoupper($state)] . " ";
        $data['metaDescription'] = "Dexr is the leading provider for " . $statesArray[strtoupper($state)] . " Business Owner & Web Site Owner lists available for download. Our database contains full contact info such as owner name, email, phone and address.";

        $this->load->view('frontend/header', $data);
        $this->load->view('frontend/name');
        $this->load->view('frontend/footer-fixed-pagination');
    }

    public function sitemapIndex() {
        exit();
        $this->load->helper('url');
        $this->load->helper('general');
        $this->load->model('Database_model');

        $countSitemapPagesTx = ceil(208849 / 25000);
        $countSitemapPagesFl = ceil(269805 / 25000);

        $urlset = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1" /><!--?xml version="1.0" encoding="UTF-8"?-->');

        $i = 1;
        while ($i <= $countSitemapPagesTx) {
            $url = $urlset->addChild('sitemap');
            $url->addChild('loc', 'https://www.3topagents.com/sitemaps/tx/' . $i);
            //$url->addChild('lastmod', $item->LASTMOD );
            $url->addChild('changefreq', 'monthly');
            $url->addChild('priority', '1.0');
            $i++;
        }

        $dom = new DomDocument();
        $dom->loadXML($urlset->asXML());

        $dom->formatOutput = true;
        $data['map'] = $dom->saveXML();

        $this->load->view('sitemapxml', $data);
    }

    public function sitemap() {
        exit();
        $this->load->helper('url');
        $this->load->helper('general');
        $this->load->model('Database_model');

        $url = explode('/', uri_string());
        $state = $url[1];
        $page = $url[2];

        $urlBatch = $this->Database_model->getSitemapBatch($state, $page);

        $urlset = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1" /><!--?xml version="1.0" encoding="UTF-8"?-->');

        foreach ($urlBatch as $uri) {
            $city = slugify($uri->listings_city);
            $url = $urlset->addChild('url');
            $url->addChild('loc', 'https://www.3topagents.com/' . $state . '/' . $city . '/' . $uri->listings_slug);
            //$url->addChild('lastmod', $item->LASTMOD );
            $url->addChild('changefreq', 'monthly');
            $url->addChild('priority', '1.0');
        }

        $dom = new DomDocument();
        $dom->loadXML($urlset->asXML());

        $dom->formatOutput = true;
        $data['map'] = $dom->saveXML();

        $this->load->view('sitemapxml', $data);
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
                $data['names'] .= "<div class='col-md-4'><a href='/" . $state . "/" . $city . "/" . $n->name_slug . "'>" . ucwords(strtolower($n->name)) . "</a></div>";
            }
        } else {
            show_404();
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

        $data['metaTitle'] = "List of " . $statesArray[strtoupper($state)] . " Business Owners & Web Site Owners" . $metaPage;
        $data['metaDescription'] = "Dexr is the leading provider for " . $statesArray[strtoupper($state)] . " Business Owner & Web Site Owner lists available for download. Our database contains full contact info such as owner name, email, phone and address." . $metaPage;

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