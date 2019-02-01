<?php

defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting(-1);  // Have PHP complain about absolutely everything 
//$conf['error_level'] = 2;  // Show all messages on your screen, 2 = ERROR_REPORTING_DISPLAY_ALL.
ini_set('display_errors', TRUE);  // These lines just give you content on WSOD pages.
ini_set('display_startup_errors', TRUE);
ini_set("memory_limit", "-1");
//ini_set("post_max_size", "2048M");
ini_set('max_execution_time', 0);
date_default_timezone_set('America/New_York');
/**
 * User class.
 * 
 * @extends CI_Controller
 */
class Data extends CI_Controller {

    /**
     * __construct function.
     * 
     * @access public
     * @return void
     */
    public function __construct() {

        parent::__construct();
        $this->load->helper(array('url', 'general'));
        $this->load->library('Awslib');
        //$this->load->model('user_model');
    }

    public function upload() {

        $data['metaTitle'] = "Upload";
        $data['metaDescription'] = "";
        
        $this->load->view('data/header', $data);
        $this->load->view('data/upload', $data);
        $this->load->view('footer', $data);
    }

    public function files() {
        $data['metaTitle'] = "Files";
        $data['metaDescription'] = "";

        $data['uploadedFiles'] = "";

        $path = $_SERVER['DOCUMENT_ROOT'] . '/uploads';
        $files = scandir($path);
        $files = array_diff(scandir($path), array('.', '..'));

        foreach ($files as $file) {
            $data['uploadedFiles'] .= "<tr><td><a href='/uploads/" . $file . "' target='_blank'>" . $file . "</a></td></tr>";
        }

        //$this->load->helper('aws');
        //getName('patricia_gilmartin');

        $data['footerLetters'] = getFooterLetters();

        $this->load->view('admin/header', $data);
        $this->load->view('admin/files', $data);
        $this->load->view('footer', $data);
    }

    public function datasets() {
        $this->load->helper('aws');
        $data['metaTitle'] = "Datasets";
        $data['metaDescription'] = "";
        date_default_timezone_set('America/New_York');

        $data['datasets'] = "";

        if (isset($_POST['newDatasetSubmit'])) {
            insertDataset($_POST);
        }

        $datasets = getAllDatasets();
        $i = 1;

        $path = $_SERVER['DOCUMENT_ROOT'] . '/uploads';
        $files = scandir($path);
        $files = array_diff(scandir($path), array('.', '..'));
        $uploadedFiles = "";
        foreach ($files as $file) {
            $uploadedFiles .= "<option value='" . $file . "'>" . $file . "</option>";
        }

        foreach ($datasets as $dataset) {

            $data['datasets'] .= '<tr><td>' . $dataset['ID']['S'] . '</td>';
            $data['datasets'] .= '<td>' . $dataset['name']['S'] . '</td>';
            $data['datasets'] .= '<td>' . $dataset['description']['S'] . '</td>';
            $data['datasets'] .= '<td>' . $dataset['fileName']['S'] . '</td>';
            $data['datasets'] .= '<td><a href="' . $dataset['source']['S'] . '" target="_blank">' . $dataset['source']['S'] . '</a></td><td><form method="GET" action="/admin/data/import"><input type="hidden" name="datasetID" value="' . $dataset['ID']['S'] . '"><select class="form-control" name="file"><option value="">Choose Import File...</option>' . $uploadedFiles . '</select></td><td><button name="import" type="submit" class="btn btn-sm btn-success pull-right">Import</button></form></td></tr>';

            $i++;
        }

        $data['footerLetters'] = getFooterLetters();

        $this->load->view('admin/header', $data);
        $this->load->view('admin/datasets', $data);
        $this->load->view('footer', $data);
    }

    public function import() { 
        $this->load->helper('general');
        $this->load->helper('aws');
        $this->load->helper('url');
        $data['metaTitle'] = "Import";
        $data['metaDescription'] = "";
        ini_set('memory_limit', '-1');
        $data['errors'] = "";
        $data['alerts'] = "";
        //session_start();
        
        if(isset($_SESSION['importAll'])){
            foreach($_SESSION as $k=>$v){
                    $_POST["".str_replace('key-', '', $k).""] = $v;
                }
        }

        if (isset($_GET['importAll']) && isset($_SESSION['key-state'])) {
            $_SESSION['importAll'] = 1;
            $importPath = $_SERVER['DOCUMENT_ROOT'] . '/uploads/splits';
            $importFiles = scandir($importPath);
            $importFiles = array_diff(scandir($importPath), array('.', '..'));

            if (isset($importFiles[2])) {
                redirect('/admin/data/import?load=' . $importFiles[2] , 'refresh');
            } else {
                unset($_SESSION['importAll']);
                redirect('/admin/data/import');
            }
        }

        $path = $_SERVER['DOCUMENT_ROOT'] . '/uploads';
        $files = scandir($path);
        $files = array_diff(scandir($path), array('.', '..'));

        if (isset($_GET['split'])) {
            splitFile($_GET['split'], 10000, getFileDelimiter($path . "/" . $_GET['split']));
            redirect('/admin/data/import');
        }

        if (isset($_GET['delete'])) {
            unlink($path . "/" . $_GET['delete']);
            unlink($path . "/splits/" . $_GET['delete']);

            if (isset($_SESSION['importAll'])) {
                redirect('/admin/data/import?importAll=true', 'refresh');
            } else {
                redirect('/admin/data/import');
            }
        }

        $data['uploadedFiles'] = "";
        foreach ($files as $file) {
            if ($file !== 'splits') {
                $data['uploadedFiles'] .= "<div class='col-md-4' style='margin-bottom:4px;'><b>" . $file . "</b> (" . formatSizeUnits(filesize($_SERVER['DOCUMENT_ROOT'] . "/uploads/" . $file)) . ") &nbsp; <a class='btn btn-info btn-xs' href='/admin/data/import?split=" . $file . "'>Split</a> <a class='btn btn-success btn-xs' href='/admin/data/import?load=" . $file . "'>Load</a> <a class='btn btn-danger btn-xs' href='/admin/data/import?delete=" . $file . "'>Delete</a></div>";
            }
        }

        $splitPath = $_SERVER['DOCUMENT_ROOT'] . '/uploads/splits';
        $splitFiles = scandir($splitPath);
        $splitFiles = array_diff(scandir($splitPath), array('.', '..'));

        $data['splitFiles'] = "";
        foreach ($splitFiles as $file) {
            $data['splitFiles'] .= "<div class='col-md-4' style='margin-bottom:4px;'><b>" . $file . "</b> (" . formatSizeUnits(filesize($_SERVER['DOCUMENT_ROOT'] . "/uploads/splits/" . $file)) . ") &nbsp; <a class='btn btn-success btn-xs' href='/admin/data/import?load=" . $file . "'>Load</a> <a class='btn btn-danger btn-xs' href='/admin/data/import?delete=" . $file . "'>Delete</a></div>";
        }

        if (isset($_GET['load'])) {
            $filePath = $_SERVER['DOCUMENT_ROOT'] . "/uploads/" . $_GET['load'];
            if (!file_exists($filePath)) {
                $filePath = $_SERVER['DOCUMENT_ROOT'] . "/uploads/splits/" . $_GET['load'];
            }

            $courtTableColumns = array("");

            // DETECT CSV OR TAB
            $data['delimiter'] = $delimiter = getFileDelimiter($filePath);

            $fp = file($filePath, FILE_SKIP_EMPTY_LINES);
            $data['total'] = number_format(count($fp));
            
            if(isset($_POST['saveMap'])){
                foreach ($_POST as $k => $v) {
                    if (!empty($v)) {
                        $_SESSION['key-' . $k] = $v;
                    } elseif($v == '') {
                        unset($_SESSION['key-' . $k]);
                    }
                }
            }

            $row = 1;
            $data['columns'] = "";
            if (($handle = fopen($filePath, "r")) !== FALSE) {
                while (($stuff = fgetcsv($handle, 1000, $delimiter)) !== FALSE) {
                    $num = count($stuff);
                    $row++;
                    for ($c = 0; $c < $num; $c++) {
                        if (isset($_POST['attributeName'][$c])) {
                            $attributeValue = $_POST['attributeName'][$c];
                        } else {
                            $attributeValue = "";
                        }
                        if (isset($_POST['prettyName'][$c])) {
                            $prettyValue = $_POST['prettyName'][$c];
                        } else {
                            $prettyValue = "";
                        }

                        $first = "";
                        $last = "";
                        $middle = "";
                        $dob = "";
                        $gender = "";
                        $address = "";
                        $apartment = "";
                        $city = "";
                        $state = "";
                        $zip = "";
                        $phone = "";
                        $county = "";
                        $voterID = "";
                        $mailingAddress = "";
                        $mailingAddressLineTwo = "";
                        $mailingCity = "";
                        $mailingState = "";
                        $mailingZip = "";
                        $race = "";
                        $registrationDate = "";
                        $partyAffiliation = "";
                        $precinct = "";
                        $precinctGroup = "";
                        $precinctSplit = "";
                        $precinctSuffix = "";
                        $voterStatus = "";
                        $congressionalDistrict = "";
                        $houseDistrict = "";
                        $senateDistrict = "";
                        $countyCommissionDistrict = "";
                        $schoolBoardDistrict = "";
                        $email = "";
                        $areaCode = "";
                        $houseNumber = "";
                        $streetDirection = "";
                        $street = "";
                        $streetType = "";

                        if (isset($_POST[$c]) && $_POST[$c] == 'first' || isset($_SESSION['key-' . $c]) && $_SESSION['key-' . $c] == 'first') {
                            $first = "selected";
                        }
                        if (isset($_POST[$c]) && $_POST[$c] == 'last' || isset($_SESSION['key-' . $c]) && $_SESSION['key-' . $c] == 'last') {
                            $last = "selected";
                        }
                        if (isset($_POST[$c]) && $_POST[$c] == 'middle' || isset($_SESSION['key-' . $c]) && $_SESSION['key-' . $c] == 'middle') {
                            $middle = "selected";
                        }
                        if (isset($_POST[$c]) && $_POST[$c] == 'dob' || isset($_SESSION['key-' . $c]) && $_SESSION['key-' . $c] == 'dob') {
                            $dob = "selected";
                        }
                        if (isset($_POST[$c]) && $_POST[$c] == 'gender' || isset($_SESSION['key-' . $c]) && $_SESSION['key-' . $c] == 'gender') {
                            $gender = "selected";
                        }
                        if (isset($_POST[$c]) && $_POST[$c] == 'address' || isset($_SESSION['key-' . $c]) && $_SESSION['key-' . $c] == 'address') {
                            $address = "selected";
                        }
                        if (isset($_POST[$c]) && $_POST[$c] == 'apartment' || isset($_SESSION['key-' . $c]) && $_SESSION['key-' . $c] == 'apartment') {
                            $apartment = "selected";
                        }
                        if (isset($_POST[$c]) && $_POST[$c] == 'city' || isset($_SESSION['key-' . $c]) && $_SESSION['key-' . $c] == 'city') {
                            $city = "selected";
                        }
                        if (isset($_POST[$c]) && $_POST[$c] == 'state' || isset($_SESSION['key-' . $c]) && $_SESSION['key-' . $c] == 'state') {
                            $state = "selected";
                        }
                        if (isset($_POST[$c]) && $_POST[$c] == 'zip' || isset($_SESSION['key-' . $c]) && $_SESSION['key-' . $c] == 'zip') {
                            $zip = "selected";
                        }
                        if (isset($_POST[$c]) && $_POST[$c] == 'phone' || isset($_SESSION['key-' . $c]) && $_SESSION['key-' . $c] == 'phone') {
                            $phone = "selected";
                        }
                        if (isset($_POST[$c]) && $_POST[$c] == 'county' || isset($_SESSION['key-' . $c]) && $_SESSION['key-' . $c] == 'county') {
                            $county = "selected";
                        }                        
                        if (isset($_POST[$c]) && $_POST[$c] == 'voterID' || isset($_SESSION['key-' . $c]) && $_SESSION['key-' . $c] == 'voterID') {
                            $voterID = "selected";
                        }
                        if (isset($_POST[$c]) && $_POST[$c] == 'mailingAddress' || isset($_SESSION['key-' . $c]) && $_SESSION['key-' . $c] == 'mailingAddress') {
                            $mailingAddress = "selected";
                        }
                        if (isset($_POST[$c]) && $_POST[$c] == 'mailingAddressLineTwo' || isset($_SESSION['key-' . $c]) && $_SESSION['key-' . $c] == 'mailingAddressLineTwo') {
                            $mailingAddressLineTwo = "selected";
                        }
                        if (isset($_POST[$c]) && $_POST[$c] == 'mailingCity' || isset($_SESSION['key-' . $c]) && $_SESSION['key-' . $c] == 'mailingCity') {
                            $mailingCity = "selected";
                        }
                        if (isset($_POST[$c]) && $_POST[$c] == 'mailingState' || isset($_SESSION['key-' . $c]) && $_SESSION['key-' . $c] == 'mailingState') {
                            $mailingState = "selected";
                        }
                        if (isset($_POST[$c]) && $_POST[$c] == 'mailingZip' || isset($_SESSION['key-' . $c]) && $_SESSION['key-' . $c] == 'mailingZip') {
                            $mailingZip = "selected";
                        }
                        if (isset($_POST[$c]) && $_POST[$c] == 'race' || isset($_SESSION['key-' . $c]) && $_SESSION['key-' . $c] == 'race') {
                            $race = "selected";
                        }
                        if (isset($_POST[$c]) && $_POST[$c] == 'registrationDate' || isset($_SESSION['key-' . $c]) && $_SESSION['key-' . $c] == 'registrationDate') {
                            $registrationDate = "selected";
                        }
                        if (isset($_POST[$c]) && $_POST[$c] == 'partyAffiliation' || isset($_SESSION['key-' . $c]) && $_SESSION['key-' . $c] == 'partyAffiliation') {
                            $partyAffiliation = "selected";
                        }
                        if (isset($_POST[$c]) && $_POST[$c] == 'precinct' || isset($_SESSION['key-' . $c]) && $_SESSION['key-' . $c] == 'precinct') {
                            $precinct = "selected";
                        }
                        if (isset($_POST[$c]) && $_POST[$c] == 'precinctGroup' || isset($_SESSION['key-' . $c]) && $_SESSION['key-' . $c] == 'precinctGroup') {
                            $precinctGroup = "selected";
                        }
                        if (isset($_POST[$c]) && $_POST[$c] == 'precinctSplit' || isset($_SESSION['key-' . $c]) && $_SESSION['key-' . $c] == 'precinctSplit') {
                            $precinctSplit = "selected";
                        }
                        if (isset($_POST[$c]) && $_POST[$c] == 'precinctSuffix' || isset($_SESSION['key-' . $c]) && $_SESSION['key-' . $c] == 'precinctSuffix') {
                            $precinctSuffix = "selected";
                        }
                        if (isset($_POST[$c]) && $_POST[$c] == 'voterStatus' || isset($_SESSION['key-' . $c]) && $_SESSION['key-' . $c] == 'voterStatus') {
                            $voterStatus = "selected";
                        }
                        if (isset($_POST[$c]) && $_POST[$c] == 'congressionalDistrict' || isset($_SESSION['key-' . $c]) && $_SESSION['key-' . $c] == 'congressionalDistrict') {
                            $congressionalDistrict = "selected";
                        }
                        if (isset($_POST[$c]) && $_POST[$c] == 'houseDistrict' || isset($_SESSION['key-' . $c]) && $_SESSION['key-' . $c] == 'houseDistrict') {
                            $houseDistrict = "selected";
                        }
                        if (isset($_POST[$c]) && $_POST[$c] == 'senateDistrict' || isset($_SESSION['key-' . $c]) && $_SESSION['key-' . $c] == 'senateDistrict') {
                            $senateDistrict = "selected";
                        }
                        if (isset($_POST[$c]) && $_POST[$c] == 'countyCommissionDistrict' || isset($_SESSION['key-' . $c]) && $_SESSION['key-' . $c] == 'countyCommissionDistrict') {
                            $countyCommissionDistrict = "selected";
                        }
                        if (isset($_POST[$c]) && $_POST[$c] == 'schoolBoardDistrict' || isset($_SESSION['key-' . $c]) && $_SESSION['key-' . $c] == 'schoolBoardDistrict') {
                            $schoolBoardDistrict = "selected";
                        }
                        if (isset($_POST[$c]) && $_POST[$c] == 'email' || isset($_SESSION['key-' . $c]) && $_SESSION['key-' . $c] == 'email') {
                            $email = "selected";
                        }
                        if (isset($_POST[$c]) && $_POST[$c] == 'areaCode' || isset($_SESSION['key-' . $c]) && $_SESSION['key-' . $c] == 'areaCode') {
                            $areaCode = "selected";
                        }
                        if (isset($_POST[$c]) && $_POST[$c] == 'houseNumber' || isset($_SESSION['key-' . $c]) && $_SESSION['key-' . $c] == 'houseNumber') {
                            $houseNumber = "selected";
                        }
                        if (isset($_POST[$c]) && $_POST[$c] == 'streetDirection' || isset($_SESSION['key-' . $c]) && $_SESSION['key-' . $c] == 'streetDirection') {
                            $streetDirection = "selected";
                        }
                        if (isset($_POST[$c]) && $_POST[$c] == 'street' || isset($_SESSION['key-' . $c]) && $_SESSION['key-' . $c] == 'street') {
                            $street = "selected";
                        }
                        if (isset($_POST[$c]) && $_POST[$c] == 'streetType' || isset($_SESSION['key-' . $c]) && $_SESSION['key-' . $c] == 'streetType') {
                            $streetType = "selected";
                        }
                                                
                        $data['columns'] .= "<tr><td><b>" . $c . ".</b> " . $stuff[$c] . "</td><td><select class='form-control' name='" . $c . "'>"
                                . "<option value=''></option>"
                                . "<option value='first' " . $first . ">First</option>"
                                . "<option value='last' " . $last . ">Last</option>"
                                . "<option value='middle' " . $middle . ">Middle</option>"
                                . "<option value='dob' " . $dob . ">DOB</option>"
                                . "<option value='gender' " . $gender . ">Gender</option>"
                                . "<option value='address' " . $address . ">Full Address (eg. 123 main st)</option>"
                                . "<option value='houseNumber' " . $houseNumber . ">House Number (partial address)</option>"
                                . "<option value='streetDirection' " . $streetDirection . ">Street Direction (partial address)</option>"
                                . "<option value='street' " . $street . ">Street Name (partial address)</option>"
                                . "<option value='streetType' " . $streetType . ">Street Type (partial address)</option>"
                                . "<option value='apartment' " . $apartment . ">Apartment</option>"
                                . "<option value='city' " . $city . ">City</option>"
                                . "<option value='state' " . $state . ">State</option>"
                                . "<option value='zip' " . $zip . ">Zip</option>"
                                . "<option value='phone' " . $phone . ">Phone</option>"
                                . "<option value='county' " . $county . ">County</option>"
                                . "<option value=''>----------------</option>"
                                . "<option value='voterID' " . $voterID . ">voterID</option>"
                                . "<option value='mailingAddress' " . $mailingAddress . ">Mailing Address</option>"
                                . "<option value='mailingAddressLineTwo' " . $mailingAddressLineTwo . ">Mailing Address Line 2</option>"
                                . "<option value='mailingCity' " . $mailingCity . ">Mailing Address City</option>"
                                . "<option value='mailingState' " . $mailingState . ">Mailing State</option>"
                                . "<option value='mailingZip' " . $mailingZip . ">Mailing Zip</option>"
                                . "<option value='race' " . $race . ">Race</option>"
                                . "<option value='registrationDate' " . $registrationDate . ">Registration Date</option>"
                                . "<option value='partyAffiliation' " . $partyAffiliation . ">Party Affiliation</option>"
                                . "<option value='precinct' " . $precinct . ">Precinct</option>"
                                . "<option value='precinctGroup' " . $precinctGroup . ">Precinct Group</option>"
                                . "<option value='precinctSplit' " . $precinctSplit . ">Precinct Split</option>"
                                . "<option value='precinctSuffix' " . $precinctSuffix . ">Precinct Suffix</option>"
                                . "<option value='voterStatus' " . $voterStatus . ">Voter Status</option>"
                                . "<option value='congressionalDistrict' " . $congressionalDistrict . ">Congressional District</option>"
                                . "<option value='houseDistrict' " . $houseDistrict . ">House District</option>"
                                . "<option value='senateDistrict' " . $senateDistrict . ">Senate District</option>"
                                . "<option value='countyCommissionDistrict' " . $countyCommissionDistrict . ">County Commission District</option>"
                                . "<option value='schoolBoardDistrict' " . $schoolBoardDistrict . ">School Board District</option>"
                                . "<option value='email' " . $email . ">Email</option>"
                                . "<option value='areaCode' " . $areaCode . ">areaCode</option>"
                                . "</select></td></tr>";
                    }



                    if ($row > 0)
                        break;
                }
                fclose($handle);
            }

            if (isset($_POST['submitImport']) || isset($_SESSION['importAll'])) {

                foreach ($_POST as $k => $v) {
                    if (!empty($v)) {
                        $_SESSION['key-' . $k] = $v;
                    }
                }
                $throttle = 0;

                $data['alerts'] .= "<div class='alert alert-success'>Import started. " . date('h:i:s') . "</div>";

                $res = importFileToDB($_GET['load'], $_POST, $throttle);
                                
                if (count($res) > 0) {
                    foreach ($res as $r) {
                        if (!empty($r))
                            $data['errors'] .= "<div class='alert alert-danger'>" . $r . "</div>";
                        $data['alerts'] = "";
                    }
                } elseif (isset($_SESSION['importAll'])) {
                    redirect('/admin/data/import?delete=' . $_GET['load'], 'refresh');
                }
            }

            $states = array(
                'AL' => 'ALABAMA',
                'AK' => 'ALASKA',
                'AS' => 'AMERICAN SAMOA',
                'AZ' => 'ARIZONA',
                'AR' => 'ARKANSAS',
                'CA' => 'CALIFORNIA',
                'CO' => 'COLORADO',
                'CT' => 'CONNECTICUT',
                'DE' => 'DELAWARE',
                'DC' => 'DISTRICT OF COLUMBIA',
                'FM' => 'FEDERATED STATES OF MICRONESIA',
                'FL' => 'FLORIDA',
                'GA' => 'GEORGIA',
                'GU' => 'GUAM GU',
                'HI' => 'HAWAII',
                'ID' => 'IDAHO',
                'IL' => 'ILLINOIS',
                'IN' => 'INDIANA',
                'IA' => 'IOWA',
                'KS' => 'KANSAS',
                'KY' => 'KENTUCKY',
                'LA' => 'LOUISIANA',
                'ME' => 'MAINE',
                'MH' => 'MARSHALL ISLANDS',
                'MD' => 'MARYLAND',
                'MA' => 'MASSACHUSETTS',
                'MI' => 'MICHIGAN',
                'MN' => 'MINNESOTA',
                'MS' => 'MISSISSIPPI',
                'MO' => 'MISSOURI',
                'MT' => 'MONTANA',
                'NE' => 'NEBRASKA',
                'NV' => 'NEVADA',
                'NH' => 'NEW HAMPSHIRE',
                'NJ' => 'NEW JERSEY',
                'NM' => 'NEW MEXICO',
                'NY' => 'NEW YORK',
                'NC' => 'NORTH CAROLINA',
                'ND' => 'NORTH DAKOTA',
                'MP' => 'NORTHERN MARIANA ISLANDS',
                'OH' => 'OHIO',
                'OK' => 'OKLAHOMA',
                'OR' => 'OREGON',
                'PW' => 'PALAU',
                'PA' => 'PENNSYLVANIA',
                'PR' => 'PUERTO RICO',
                'RI' => 'RHODE ISLAND',
                'SC' => 'SOUTH CAROLINA',
                'SD' => 'SOUTH DAKOTA',
                'TN' => 'TENNESSEE',
                'TX' => 'TEXAS',
                'UT' => 'UTAH',
                'VT' => 'VERMONT',
                'VI' => 'VIRGIN ISLANDS',
                'VA' => 'VIRGINIA',
                'WA' => 'WASHINGTON',
                'WV' => 'WEST VIRGINIA',
                'WI' => 'WISCONSIN',
                'WY' => 'WYOMING',
                'AE' => 'ARMED FORCES AFRICA \ CANADA \ EUROPE \ MIDDLE EAST',
                'AA' => 'ARMED FORCES AMERICA (EXCEPT CANADA)',
                'AP' => 'ARMED FORCES PACIFIC'
            );

            $flip = array_flip($states);
            $data['states'] = "";

            foreach ($states as $state) {
                $selected = "";
                if (isset($_POST['state']) && $_POST['state'] == $flip[$state] || isset($_SESSION['key-state']) && $_SESSION['key-state'] == $flip[$state]) {
                    $selected = "selected";
                }
                $data['states'] .= "<option value='" . $flip[$state] . "' " . $selected . ">" . $state . "</option>";
            }
        }
        
        $this->load->view('data/header', $data);
        $this->load->view('data/import', $data);
        $this->load->view('footer', $data);
    }

}
