<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Reports extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (defined('REQUEST') && REQUEST == "external") {
            return;
        }
        $this->template->loadData("activeLink", array("archive" => array("general" => 1)));
        $this->load->model("user_model");
        $this->load->model("home_model");
        $this->load->model("Db_model");
        $this->load->helper('general');
        $this->load->library('Awslib');
        $this->load->helper('aws');
    }

    public function index() {
        if (defined('REQUEST') && REQUEST == "external") {
            return;
        }

        require_once(APPPATH . 'third_party/stripe/init.php');
        $stripe = array(
            "secret_key" => $this->settings->info->stripe_secret_key,
            "publishable_key" => $this->settings->info->stripe_publish_key
        );
        //echo var_dump($_SESSION);

        \Stripe\Stripe::setApiKey($stripe['secret_key']);

        if ($this->user->loggedin) {
            $totalReports = $this->Db_model->countReports($this->user->info->ID);

            $this->template->loadContent("reports/index.php", array(
                "stripe" => $stripe,
                "totalReports" => $totalReports
                    )
            );
        } else {
            $this->template->loadContent("reports/index.php", array(
                "stripe" => $stripe
                    )
            );
        }
        
        $this->load->view('footer');
    }

    public function full($id) {

        if (defined('REQUEST') && REQUEST == "external") {
            return;
        }
        if (!$this->user->loggedin) {
            redirect("/login", 301);
        }

        // DEFAULTS
        $data['sameAddressCount'] = 0;
        $data['neighborCount'] = 0;
        $data['sameAddressCount'] = 0;
        $data['voterRecordCountByNameAddress'] = 0;
        $streetName = "";
        $addresses[] = "america";

        $report = $this->Db_model->getReport($id);
        if ($this->user->info->ID !== '1' && $report[0]->uid !== $this->user->info->ID) {
            redirect("/archive", 301);
            exit();
        }

        $totalReports = $this->Db_model->countReports($this->user->info->ID);

        $data['voterRecordListByNameAddress'] = "";
        if (!empty($report[0]->first) && !empty($report[0]->last) && !empty($report[0]->city) && !empty($report[0]->street) && !empty($report[0]->state)) {
            $voterSearch = searchVoterRecords(strtolower($report[0]->first), strtolower($report[0]->last), strtolower(streetAbr($report[0]->street)), strtolower($report[0]->city), strtolower($report[0]->state));
            $data['voterRecordCountByNameAddress'] = count($voterSearch);
            foreach ($voterSearch as $record) {
                if (isset($record['registrationDate']['S'])) {
                    $data['voterRecordListByNameAddress'] .= "<div class='col-md-1 text-center'>" . date('F d, Y', $record['registrationDate']['S']) . "</div>";
                } else {
                    $data['voterRecordListByNameAddress'] .= "<div class='col-md-1 text-center'></div>";
                }
                $data['voterRecordListByNameAddress'] .= "<div class='col-md-11'><div class='row'>";
                if (isset($record['first']['S'])) {
                    $data['voterRecordListByNameAddress'] .= "<div class='col-md-2 info'>First Name<br><b>" . ucwords($record['first']['S']) . "</b></div>";
                }
                if (isset($record['middle']['S'])) {
                    $data['voterRecordListByNameAddress'] .= "<div class='col-md-2 info'>Middle<br><b>" . ucwords($record['middle']['S']) . "</b></div>";
                }
                if (isset($record['last']['S'])) {
                    $data['voterRecordListByNameAddress'] .= "<div class='col-md-2 info'>Last Name<br><b>" . ucwords($record['last']['S']) . "</b></div>";
                }
                if (isset($record['address']['S'])) {
                    $data['voterRecordListByNameAddress'] .= "<div class='col-md-2 info'>Street Address<br><b>" . ucwords($record['address']['S']) . "</b></div>";
                }
                if (isset($record['city']['S'])) {
                    $data['voterRecordListByNameAddress'] .= "<div class='col-md-2 info'>City<br><b>" . ucwords($record['city']['S']) . "</b></div>";
                }
                if (isset($record['state']['S'])) {
                    $data['voterRecordListByNameAddress'] .= "<div class='col-md-2 info'>State<br><b>" . ucwords($record['state']['S']) . "</b></div>";
                }
                if (isset($record['zip']['S'])) {
                    $data['voterRecordListByNameAddress'] .= "<div class='col-md-2 info'>Zip<br><b>" . ucwords($record['zip']['S']) . "</b></div>";
                }
                if (isset($record['county']['S'])) {
                    $data['voterRecordListByNameAddress'] .= "<div class='col-md-2 info'>County<br><b>" . ucwords($record['county']['S']) . "</b></div>";
                }
                if (isset($record['gender']['S'])) {
                    $data['voterRecordListByNameAddress'] .= "<div class='col-md-2 info'>Gender<br><b>" . ucwords($record['gender']['S']) . "</b></div>";
                }
                if (isset($record['race']['S'])) {
                    $data['voterRecordListByNameAddress'] .= "<div class='col-md-2 info'>Race<br><b>" . ucwords($record['race']['S']) . "</b></div>";
                }
                if (isset($record['voterID']['S'])) {
                    $data['voterRecordListByNameAddress'] .= "<div class='col-md-2 info'>Voter ID<br><b>" . ucwords($record['voterID']['S']) . "</b></div>";
                }
                if (isset($record['mailingAddress']['S'])) {
                    $data['voterRecordListByNameAddress'] .= "<div class='col-md-2 info'>Mailing Address<br><b>" . ucwords($record['mailingAddress']['S']) . "</b></div>";
                }
                if (isset($record['mailingCity']['S'])) {
                    $data['voterRecordListByNameAddress'] .= "<div class='col-md-2 info'>Mailing City<br><b>" . ucwords($record['mailingCity']['S']) . "</b></div>";
                }
                if (isset($record['mailingState']['S'])) {
                    $data['voterRecordListByNameAddress'] .= "<div class='col-md-2 info'>Mailing State<br><b>" . ucwords($record['mailingState']['S']) . "</b></div>";
                }
                if (isset($record['mailingZip']['S'])) {
                    $data['voterRecordListByNameAddress'] .= "<div class='col-md-2 info'>Mailing Zip<br><b>" . ucwords($record['mailingZip']['S']) . "</b></div>";
                }
                if (isset($record['dob']['S'])) {
                    $data['voterRecordListByNameAddress'] .= "<div class='col-md-2 info'>Birth Date<br><b>" . date('F d, Y', $record['dob']['S']) . "</b></div>";
                }
                if (isset($record['partyAffiliation']['S'])) {
                    $data['voterRecordListByNameAddress'] .= "<div class='col-md-2 info'>Party Affiliation<br><b>" . ucwords($record['partyAffiliation']['S']) . "</b></div>";
                }
                if (isset($record['precinct']['S'])) {
                    $data['voterRecordListByNameAddress'] .= "<div class='col-md-2 info'>Precinct<br><b>" . ucwords($record['precinct']['S']) . "</b></div>";
                }
                if (isset($record['precinctGroup']['S'])) {
                    $data['voterRecordListByNameAddress'] .= "<div class='col-md-2 info'>Precinct Group<br><b>" . ucwords($record['precinctGroup']['S']) . "</b></div>";
                }
                if (isset($record['precinctSplit']['S'])) {
                    $data['voterRecordListByNameAddress'] .= "<div class='col-md-2 info'>Precinct Split<br><b>" . ucwords($record['precinctSplit']['S']) . "</b></div>";
                }
                if (isset($record['precinctSuffix']['S'])) {
                    $data['voterRecordListByNameAddress'] .= "<div class='col-md-2 info'>Precinct Suffix<br><b>" . ucwords($record['precinctSuffix']['S']) . "</b></div>";
                }
                if (isset($record['voterStatus']['S'])) {
                    $data['voterRecordListByNameAddress'] .= "<div class='col-md-2 info'>Voter Status (as of " . date('m/d/y', $record['created']['S']) . ")<br><b>" . ucwords($record['voterStatus']['S']) . "</b></div>";
                }
                if (isset($record['congressionalDistrict']['S'])) {
                    $data['voterRecordListByNameAddress'] .= "<div class='col-md-2 info'>Congressional District<br><b>" . ucwords($record['congressionalDistrict']['S']) . "</b></div>";
                }
                if (isset($record['houseDistrict']['S'])) {
                    $data['voterRecordListByNameAddress'] .= "<div class='col-md-2 info'>House District<br><b>" . ucwords($record['houseDistrict']['S']) . "</b></div>";
                }
                if (isset($record['senateDistrict']['S'])) {
                    $data['voterRecordListByNameAddress'] .= "<div class='col-md-2 info'>Senate District<br><b>" . ucwords($record['senateDistrict']['S']) . "</b></div>";
                }
                if (isset($record['countyCommissionDistrict']['S'])) {
                    $data['voterRecordListByNameAddress'] .= "<div class='col-md-2 info'>County Commission District<br><b>" . ucwords($record['countyCommissionDistrict']['S']) . "</b></div>";
                }
                if (isset($record['schoolBoardDistrict']['S'])) {
                    $data['voterRecordListByNameAddress'] .= "<div class='col-md-2 info'>School Board District<br><b>" . ucwords($record['schoolBoardDistrict']['S']) . "</b></div>";
                }
                if (isset($record['areaCode']['S'])) {
                    $data['voterRecordListByNameAddress'] .= "<div class='col-md-2 info'>Area Code<br><b class=''>" . ucwords($record['areaCode']['S']) . "</b></div>";
                }
                if (isset($record['phone']['S'])) {
                    $data['voterRecordListByNameAddress'] .= "<div class='col-md-2 info'>Phone<br><b class=''>" . ucwords($record['phone']['S']) . "</b></div>";
                }
                if (isset($record['email']['S'])) {
                    $data['voterRecordListByNameAddress'] .= "<div class='col-md-2 info'>Email Address<br><b>" . ucwords($record['email']['S']) . "</b></div>";
                }
                $data['voterRecordListByNameAddress'] .= "</div></div>";
            }
        }
        if (!empty($report[0]->city) && !empty($report[0]->street) && !empty($report[0]->state)) {
            $sameAddress = getAllFromAddress($report[0]->street, $report[0]->city, $report[0]->state);
            if (!empty($report[0]->street)) {
                $parts = explode(" ", $report[0]->street);
                if (is_numeric($parts[0])) {
                    $streetName = str_replace($parts[0] . " ", "", $report[0]->street);
                } else {
                    $streetName = "";
                }
            }
            $atAddress = "";
            $sameAddressArray = array();
            $i = 1;
            $data['sameAddressCount'] = (count($sameAddress) - 1);
            if (isset($data['name'])) {
                foreach ($sameAddress as $address) {
                    if ($data['name']['id']['S'] !== $address['id']['S']) {
                        $sameAddressArray[] = $address['first']['S'] . ' ' . $address['last']['S'];
                        if (isset($address['middle']['S'])) {
                            $atAddress .= '<div class="col-md-6"><a href="/' . slugify($address['state']['S']) . '/' . slugify($address['city']['S']) . '/' . $address['first.last']['S'] . '/' . $address['id']['S'] . '">' . ucwords($address['first']['S'] . ' ' . $address['middle']['S'] . ' ' . $address['last']['S']) . '</a> (' . CurrentAge($address['dob']['S']) . ' yrs)</div>';
                        } else {
                            $atAddress .= '<div class="col-md-6"><a href="/' . slugify($address['state']['S']) . '/' . slugify($address['city']['S']) . '/' . $address['first.last']['S'] . '/' . $address['id']['S'] . '">' . ucwords($address['first']['S'] . ' ' . $address['last']['S']) . '</a> (' . CurrentAge($address['dob']['S']) . ' yrs)</div>';
                        }
                        $i++;
                    }
                    if ($i > 10) {
                        if (count($sameAddress) > 10) {
                            $atAddress .= "<div class='col-md-12'><small><i>+" . (count($sameAddress) - 10) . " more...</i></small></div>";
                        }
                        break;
                    }
                }
            }
        }
        if (!empty($report[0]->city) && !empty($report[0]->street) && !empty($report[0]->state)) {
            $neighbors = getNeighbors(strtolower(streetAbr($streetName)), strtolower($report[0]->city), strtolower($report[0]->state));
            $neighborList = "";
            $data['neighborCount'] = (count($neighbors) - 1);
            $data['neighborCount'] = ($data['neighborCount'] - count($sameAddressArray));
            $i = 1;
            foreach ($neighbors as $neighbor) {
                if ($report[0]->first . ' ' . $report[0]->last !== $neighbor['first']['S'] . ' ' . $neighbor['last']['S'] && !in_array($neighbor['first']['S'] . ' ' . $neighbor['last']['S'], $sameAddressArray)) {
                    if (isset($neighbor['middle']['S'])) {
                        $neighborList .= '<div class="col-md-6"><a href="/' . slugify($neighbor['state']['S']) . '/' . slugify($neighbor['city']['S']) . '/' . $neighbor['first.last']['S'] . '/' . $neighbor['id']['S'] . '">' . ucwords($neighbor['first']['S'] . ' ' . $neighbor['middle']['S'] . ' ' . $neighbor['last']['S']) . '</a> (' . CurrentAge($neighbor['dob']['S']) . ' yrs)<br>@ ' . ucwords($neighbor['fullAddress']['S']) . '.</div>';
                    } else {
                        $neighborList .= '<div class="col-md-6"><a href="/' . slugify($neighbor['state']['S']) . '/' . slugify($neighbor['city']['S']) . '/' . $neighbor['first.last']['S'] . '/' . $neighbor['id']['S'] . '">' . ucwords($neighbor['first']['S'] . ' ' . $neighbor['last']['S']) . '</a> (' . CurrentAge($neighbor['dob']['S']) . ' yrs)<br>@ ' . ucwords($neighbor['fullAddress']['S']) . '.</div>';
                    }
                    $i++;
                }
                if ($i > 20) {
                    if (count($sameAddress) > 20) {
                        $neighborList .= "<div class='col-md-6'><small><i>+" . (count($neighborList) - 20) . " more...</i></small></div>";
                    }
                    break;
                }
            }
        }

        $name = $report[0]->first . ' ' . $report[0]->last;

        $data['atList'] = "";
        if (!empty($atAddress)) {
            $data['atList'] .= '<div class="col-md-12">
                                <div class="other-title"><i class="fa fa-user"></i> At This Address</div>
                                    <div class="col-md-12">
                                        ' . $atAddress . '
                                    </div>
                            </div>';
        }
        $data['neighborList'] = "";
        if (!empty($neighborList)) {
            $data['neighborList'] .= '<div class="col-md-12">
                                <div class="other-title"><i class="fa fa-home"></i> ' . ucwords($report[0]->first) . '\'s Neighbors On ' . ucwords($streetName) . '</div>
                                    <div class="col-md-12">
                                        ' . $neighborList . '
                                    </div>
                            </div>
            ';
        }

        if ($data['sameAddressCount'] < 1) {
            $data['sameAddressCount'] = 0;
        }
        if ($data['neighborCount'] < 1) {
            $data['neighborCount'] = 0;
        }

        $piplResponse = $this->Db_model->getAPIResponse($report[0]->nid, "pipl_premium_business");
        $responseData = "";
        if (isset($piplResponse[0]) && !empty($piplResponse[0])) {
            $pipl = json_decode($piplResponse[0]->response);
        }
        //echo $pipl->person->{'@id'};

        $contactInfoTotal = 0;
        // NAMES & ALIASES
        $namesList = "";

        if (!empty($pipl->person->names)) {
            $middle = "";
            foreach ($pipl->person->names as $name) {
                if (isset($name->middle)) {
                    $middle = ucwords(strtolower($name->middle));
                }
                $namesList .= "<tr><td>" . ucwords(strtolower($name->first)) . "</td><td>" . $middle . "</td><td>" . ucwords(strtolower($name->last)) . "</td></tr>";

                $contactInfoTotal++;
            }
        } else {
            $namesList .= '<div class="no-data col-md-12">No data available</div>';
        }

        // EMAIL ADDRESSES
        $emailList = "";
        if (!empty($pipl->person->emails)) {
            foreach ($pipl->person->emails as $email) {
                $emailList .= '<a href="mailto:' . $email->address . '"><li class="list-group-item bold"><span class="">' . $email->address . '</span> <div class="pull-right"><button class="btn btn-success btn-xs">Send Message</button></div></li></a>';

                $contactInfoTotal++;
            }
        } else {
            $emailList .= '<div class="no-data col-md-12">No data available</div>';
        }

        // PHONE
        $phoneList = "";
        if (!empty($pipl->person->phones)) {
            foreach ($pipl->person->phones as $phone) {
                $phoneList .= '<li class="list-group-item bold ">' . formatPhoneNumber($phone->number) . ' <div class="pull-right"></div></li>';

                $contactInfoTotal++;
            }
        } else {
            $phoneList .= '<div class="no-data col-md-12">No data available</div>';
        }

        // ADDRESS HISTORY
        $addressList = "";
        if (!empty($pipl->person->addresses)) {
            foreach ($pipl->person->addresses as $address) {
                $house = "";
                $street = "";
                $apt = "";
                $city = "";
                $state = "";
                $zip = "";
                $country = "";
                if (isset($address->house)) {
                    $house = $address->house;
                }
                if (isset($address->street)) {
                    $street = $address->street;
                }
                if (isset($address->apartment)) {
                    $apt = $address->apartment;
                }
                if (isset($address->city)) {
                    $city = $address->city;
                }
                if (isset($address->state)) {
                    $state = $address->state;
                }
                if (isset($address->zip_code)) {
                    $zip = $address->zip_code;
                }
                if (isset($address->country)) {
                    $country = $address->country;
                }
                $addressList .= '<tr class=""><td>' . $house . ' ' . $street . '</td><td>' . $apt . '</td><td>' . $city . '</td><td>' . $state . '</td><td>' . $zip . '</td><td>' . $country . '</td><td><a href="http://maps.google.com/?q=' . $house . ' ' . $street . ' ' . $city . ' ' . $state . ' ' . $zip . '" target="_blank" rel="nofollow">Map <i class="fa fa-external-link"></i></a></td></tr>';

                $contactInfoTotal++;
            }
        } else {
            $addressList .= '<div class="no-data col-md-12">No data available</div>';
        }

        $carreerTotal = 0;
        // EMPLOYER HISTORY
        $employerList = "";
        if (!empty($pipl->person->jobs)) {
            foreach ($pipl->person->jobs as $job) {
                $employerList .= '<a href="#"><li class="list-group-item bold"><span class="">' . $job->display . '</span> <div class="pull-right"></div></li></a>';
                $carreerTotal++;
            }
        } else {
            $employerList .= '<div class="no-data col-md-12">No data available</div>';
        }

        // EDUCATION
        $educationList = "";
        if (!empty($pipl->person->educations)) {
            foreach ($pipl->person->educations as $education) {
                $educationList .= '<li class="list-group-item bold ">' . $education->display . '<div class="pull-right"></div></li>';
                $carreerTotal++;
            }
        } else {
            $educationList .= '<div class="no-data col-md-12">No data available</div>';
        }

        // RELATIONSHIPS
        $relationshipList = "";
        $relationshipTotal = 0;
        if (!empty($pipl->person->relationships)) {
            foreach ($pipl->person->relationships as $relationship) {
                $email = "";
                if (isset($relationship->emails->address)) {
                    $email = $relationship->emails->address;
                }
                $relationshipList .= '<li class="list-group-item bold ">' . $relationship->names->display . '<div class="pull-right">' . $email . '</div></li>';

                $relationshipTotal++;
            }
        } else {
            $relationshipList .= '<tr><td><div class="no-data">No data available</div></td></tr>';
        }

        // IMAGES
        $imageList = "";
        $onlineProfilesTotal = 0;
        if (!empty($pipl->person->images)) {
            foreach ($pipl->person->images as $image) {
                $imageList .= '<div class="col-md-4 text-center">
                                    <img src="' . $image->url . '" class="img-circle big-circle-img">
                               </div>';

                $onlineProfilesTotal++;
            }
        } else {
            $imageList .= '<div class="no-data col-md-12">No data available</div>';
        }

        // USERNAMES
        $usernameList = "";
        if (!empty($pipl->person->usernames)) {
            foreach ($pipl->person->usernames as $username) {
                $usernameList .= '<div class="col-md-4 text-center">
                                    <div class="label label-info big-username">' . $username->content . '</div>
                                  </div>';

                $onlineProfilesTotal++;
            }
        } else {
            $usernameList .= '<div class="no-data col-md-12">No data available</div>';
        }

        // USERIDS
        $userIdList = "";
        if (!empty($pipl->person->user_ids)) {
            foreach ($pipl->person->user_ids as $userid) {
                $userIdList .= '<div class="col-md-4 text-center">
                                    <div class="label label-info big-username">' . $userid->content . '</div>
                                  </div>';

                $onlineProfilesTotal++;
            }
        } else {
            $userIdList .= '<div class="no-data col-md-12">No data available</div>';
        }

        // ONLINE PROFILES
        $profileList = "";
        if (!empty($pipl->person->urls)) {
            foreach ($pipl->person->urls as $url) {
                $profileList .= '<tr><td class="vert-align">' . ucwords($url->{'@domain'}) . '</td><td class="vert-align"><a href="' . $url->url . '" rel="nofollow" class="" target="_blank">' . $url->url . ' <i class="fa fa-external-link"></i></a></td></tr>';

                $onlineProfilesTotal++;
            }
        } else {
            $profileList .= '<div class="no-data col-md-12">No data available</div>';
        }

        $imsasFederalResponse = $this->Db_model->getAPIResponse($report[0]->nid, "imsas_federal_criminal");
        if ($imsasFederalResponse) {
            $imsasFederal = json_decode($imsasFederalResponse[0]->response);
        }

        // FEDERAL RECORDS
        $criminalTotal = 0;
        $federalList = "";
        if (!empty($imsasFederal->Results->Records[0])) {
            $i = 1;
            foreach ($imsasFederal->Results->Records as $record) {
                if ($i == 1) {
                    $collapsed = "";
                    $in = "in";
                    $fa = "fa-caret-down";
                } else {
                    $collapsed = "collapsed";
                    $in = "";
                    $fa = "fa-caret-right";
                }
                if ($record->Score > 95) {
                    $badge = "danger";
                } elseif ($record->Score > 80) {
                    $badge = "warning";
                } else {
                    $badge = "info";
                }
                $offenses = "";
                $o = 1;
                foreach ($record->Offenses as $offense) {

                    $offenses .= '<div class="col-md-12">';
                    $offenses .= '<div class="panel panel-default">
                                    <div class="panel-heading">
                                      <h3 class="panel-title">';
                    $offenses .= '<div class="row">';
                    $offenses .= "<div class='col-md-4'>Case Number: <b>" . $offense->CaseNumber . "</b></div>";
                    $offenses .= "<div class='col-md-4'>Charge Filing Date: <b>" . $offense->ChargeFilingDate . "</b></div>";
                    $offenses .= "<div class='col-md-4'>Jurisdiction: <b>" . $offense->Jurisdiction . "</b></div>";
                    $offenses .= "</div>";

                    $offenses .= '</h3>
                                    </div>
                                    <div class="panel-body">';

                    $offenses .= "<div class='col-md-12'>Description: <b>" . $offense->Description . "</b></div>";

                    $offenses .= '</div>
                                  </div></div>';



                    $o++;
                }
                $federalList .= "<div class='panel panel-default'>
                                    <div class='panel-heading' class='accordion-toggle " . $collapsed . "' data-parent='#accordion2' data-toggle='collapse' href='#accordion2-item-" . $i . "'>
                                        <div class='row'>
                                        <div class='col-md-6'>                                        
                                        <h4 class='panel-title'>
                                            <a ><span class='fa " . $fa . "'></span>
                                                " . ucwords(strtolower($record->FullName)) . "
                                            </a>
                                        </h4>
                                        </div>
                                        <div class='col-md-6 text-right'>  
                                        <span class='badge badge-" . $badge . "'>" . $record->Score . "</span>
                                            </div>
                                            </div>
                                    </div>
                                    <div class='panel-collapse collapse " . $in . "' id='accordion2-item-" . $i . "'>
                                        <div class='panel-body'>
                                        <div class='row'>
                                            " . $offenses . "
                                                </div>
                                        </div>
                                    </div>
                                </div>";

                $criminalTotal++;
                $i++;
            }
        } else {
            $federalList .= '<div class="no-data col-md-12">No criminal record found.</div>';
        }

        // CRIMINAL RECORDS
        $imsasCriminalResponse = $this->Db_model->getAPIResponse($report[0]->nid, "imsas_criminal_database");

        if ($imsasCriminalResponse) {
            $imsasCriminal = json_decode($imsasCriminalResponse[0]->response);
        }
        $criminalList = "";
        if (!empty($imsasCriminal->Results->Records[0])) {
            $i = 1;
            foreach ($imsasCriminal->Results->Records as $record) {
                if ($i == 1) {
                    $collapsed = "";
                    $in = "in";
                    $fa = "fa-caret-down";
                } else {
                    $collapsed = "collapsed";
                    $in = "";
                    $fa = "fa-caret-right";
                }
                if ($record->Score > 95) {
                    $badge = "danger";
                } elseif ($record->Score > 80) {
                    $badge = "warning";
                } else {
                    $badge = "info";
                }
                $offenses = "";
                $o = 1;

                $dat = "";
                $items = "";
                foreach ($record as $k => $v) {
                    if (!is_array($v)) {
                        $dat .= '<div class="col-md-6">' . $k . '<br><b>' . $v . '</b></div>';
                    }
                }
                $dat .= "<div class='col-md-12' style='margin-top:10px;'>Addresses</div>";
                foreach ($record->Addresses as $address) {
                    $dat .= '<div class="col-md-6"><b>' . $address->Address . ' ' . $address->City . ' ' . $address->State . ' ' . $address->Zip . ' ' . $address->County . '</b></div>';
                }

                $dat .= "<div class='col-md-12' style='margin-top:10px;'>Aliases</div>";
                foreach ($record->Aliases as $alias) {
                    $dat .= '<div class="col-md-6"><b>' . $alias->FullName . '</b></div>';
                }



                foreach ($record->Offenses as $offense) {

                    $offenses .= '<div class="col-md-12">';
                    $offenses .= '<div class="panel panel-default">
                                    <div class="panel-heading">
                                      <h3 class="panel-title">';
                    $offenses .= '<div class="row">';
                    $offenses .= "<div class='col-md-4'>Case Number: <b>" . $offense->CaseNumber . "</b></div>";
                    $offenses .= "<div class='col-md-4'>Charge Filing Date: <b>" . $offense->ChargeFilingDate . "</b></div>";
                    $offenses .= "<div class='col-md-4'>Jurisdiction: <b>" . $offense->Jurisdiction . "</b></div>";
                    $offenses .= "</div>";

                    $offenses .= '</h3>
                                    </div>
                                    <div class="panel-body">';

                    $offenses .= "<div class='col-md-12'>Description: <b>" . $offense->Description . "</b></div>";

                    $offenses .= '</div>
                                  </div></div>';



                    $o++;
                }
                $criminalList .= "<div class='panel panel-default'>
                                    <div class='panel-heading' class='accordion-toggle " . $collapsed . "' data-parent='#accordion1' data-toggle='collapse' href='#accordion1-item-" . $i . "'>
                                        <div class='row'>
                                        <div class='col-md-8'>                                        
                                        <h4 class='panel-title'>
                                            <a ><span class='fa " . $fa . "'></span>
                                                " . ucwords(strtolower($record->FullName)) . " DOB: " . $record->DOB . " Age: " . $record->Age . "
                                            </a>
                                        </h4>
                                        </div>
                                        <div class='col-md-4 text-right'>  
                                        <span class='badge badge-" . $badge . "'>" . $record->Score . "</span>
                                            </div>
                                            </div>
                                    </div>
                                    <div class='panel-collapse collapse " . $in . "' id='accordion1-item-" . $i . "'>
                                        <div class='panel-body'>
                                        <div class='row'>
                                            " . $dat . "<br><br>
                                            " . $offenses . "
                                                </div>
                                        </div>
                                    </div>
                                </div>";

                $criminalTotal++;
                $i++;
            }
        } else {
            $criminalList .= '<div class="no-data col-md-12">No criminal record found.</div>';
        }



        $this->template->loadContent("reports/full.php", array(
            "totalReports" => $totalReports,
            "mapAddresses" => $addresses,
            "report" => $report[0],
            "voterRecordListByNameAddress" => $data['voterRecordListByNameAddress'],
            "voterRecordCountByNameAddress" => $data['voterRecordCountByNameAddress'],
            "first" => $report[0]->first,
            "last" => $report[0]->last,
            "name" => $report[0]->first,
            "fullAddress" => $report[0]->street,
            "sameAddressCount" => $data['sameAddressCount'],
            "atList" => $data['atList'],
            "neighborCount" => $data['neighborCount'],
            "streetName" => $streetName,
            "neighborList" => $data['neighborList'],
            "responseData" => $responseData,
            "namesList" => $namesList,
            "emailList" => $emailList,
            "phoneList" => $phoneList,
            "addressList" => $addressList,
            "contactInfoTotal" => $contactInfoTotal,
            "employerList" => $employerList,
            "educationList" => $educationList,
            "carreerTotal" => $carreerTotal,
            "relationshipList" => $relationshipList,
            "relationshipTotal" => $relationshipTotal,
            "imageList" => $imageList,
            "onlineProfilesTotal" => $onlineProfilesTotal,
            "usernameList" => $usernameList,
            "userIdList" => $userIdList,
            "profileList" => $profileList,
            "publicRecordsTotal" => $data['voterRecordCountByNameAddress'],
            "criminalTotal" => $criminalTotal,
            "criminalList" => $criminalList,
            "federalList" => $federalList
                )
        );
        $this->load->view('footer');
    }

}

?>