<?php

/*
  if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] !== 'https') {
  header("HTTP/1.1 301 Moved Permanently");
  header('Location: https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
  exit();
  }
 * 
 */

function obfuscate_email($email) {
    $em = explode("@", $email);
    $name = implode(array_slice($em, 0, count($em) - 1), '@');
    $len = floor(strlen($name) / 2);

    return substr($name, 0, $len) . str_repeat('*', $len) . "@" . end($em);
}

function slugify($text) {
    // replace non letter or digits by -
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);

    // transliterate
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

    // remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text);

    // trim
    $text = trim($text, '-');

    // remove duplicate -
    $text = preg_replace('~-+~', '-', $text);

    // lowercase
    $text = strtolower($text);

    if (empty($text)) {
        return 'n-a';
    }

    return $text;
}

function formatForSearch($text) {
    // replace non letter or digits by -
    $text = preg_replace('~[^\pL\d]+~u', '_', $text);

    // transliterate
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

    // remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text);

    // trim
    $text = trim($text, '-');

    // remove duplicate -
    $text = preg_replace('~-+~', '_', $text);

    // lowercase
    $text = strtolower($text);

    if (empty($text)) {
        return 'n-a';
    }

    return $text;
}

function unslugify($text) {
    // replace non letter or digits by -
    $text = str_replace('-', ' ', $text);

    // transliterate
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);


    // trim
    $text = trim($text, '-');

    // remove duplicate -
    $text = str_replace('  ', ' ', $text);

    // lowercase
    $text = strtolower($text);

    if (empty($text)) {
        return false;
    }

    return $text;
}

function formatPhoneNumber($phoneNumber) {
    $phoneNumber = preg_replace('/[^0-9]/', '', $phoneNumber);

    if (strlen($phoneNumber) > 10) {
        $countryCode = substr($phoneNumber, 0, strlen($phoneNumber) - 10);
        $areaCode = substr($phoneNumber, -10, 3);
        $nextThree = substr($phoneNumber, -7, 3);
        $lastFour = substr($phoneNumber, -4, 4);

        $phoneNumber = '+' . $countryCode . ' (' . $areaCode . ') ' . $nextThree . '-' . $lastFour;
    } else if (strlen($phoneNumber) == 10) {
        $areaCode = substr($phoneNumber, 0, 3);
        $nextThree = substr($phoneNumber, 3, 3);
        $lastFour = substr($phoneNumber, 6, 4);

        $phoneNumber = '(' . $areaCode . ') ' . $nextThree . '-' . $lastFour;
    } else if (strlen($phoneNumber) == 7) {
        $nextThree = substr($phoneNumber, 0, 3);
        $lastFour = substr($phoneNumber, 3, 4);

        $phoneNumber = $nextThree . '-' . $lastFour;
    }

    return $phoneNumber;
}

function statesArray($flip = '') {
    $states = array(
        'AL' => 'Alabama',
        'AK' => 'Alaska',
        'AZ' => 'Arizona',
        'AR' => 'Arkansas',
        'CA' => 'California',
        'CO' => 'Colorado',
        'CT' => 'Connecticut',
        'DE' => 'Delaware',
        'DC' => 'District of Columbia',
        'FL' => 'Florida',
        'GA' => 'Georgia',
        'HI' => 'Hawaii',
        'ID' => 'Idaho',
        'IL' => 'Illinois',
        'IN' => 'Indiana',
        'IA' => 'Iowa',
        'KS' => 'Kansas',
        'KY' => 'Kentucky',
        'LA' => 'Louisiana',
        'ME' => 'Maine',
        'MD' => 'Maryland',
        'MA' => 'Massachusetts',
        'MI' => 'Michigan',
        'MN' => 'Minnesota',
        'MS' => 'Mississippi',
        'MO' => 'Missouri',
        'MT' => 'Montana',
        'NE' => 'Nebraska',
        'NV' => 'Nevada',
        'NH' => 'New Hampshire',
        'NJ' => 'New Jersey',
        'NM' => 'New Mexico',
        'NY' => 'New York',
        'NC' => 'North Carolina',
        'ND' => 'North Dakota',
        'OH' => 'Ohio',
        'OK' => 'Oklahoma',
        'OR' => 'Oregon',
        'PA' => 'Pennsylvania',
        'RI' => 'Rhode Island',
        'SC' => 'South Carolina',
        'SD' => 'South Dakota',
        'TN' => 'Tennessee',
        'TX' => 'Texas',
        'UT' => 'Utah',
        'VT' => 'Vermont',
        'VA' => 'Virginia',
        'WA' => 'Washington',
        'WV' => 'West Virginia',
        'WI' => 'Wisconsin',
        'WY' => 'Wyoming',
    );
    if (empty($flip)) {
        return $states;
    } else {
        return array_flip($states);
    }
}

function getAlphabet() {
    $alphas = range('A', 'Z');
    $letters = "";
    foreach ($alphas as $letter) {
        $letters .= '<a href="/' . strtolower($letter) . '">' . $letter . '</a> ';
    }
    return $letters;
}

function getFileDelimiter($file, $checkLines = 2) {
    $file = new SplFileObject($file);
    $delimiters = array(
        ",",
        "\t",
        ";",
        "|",
        ":"
    );
    $results = array();
    $i = 0;
    while ($file->valid() && $i <= $checkLines) {
        $line = $file->fgets();
        foreach ($delimiters as $delimiter) {
            $regExp = '/[' . $delimiter . ']/';
            $fields = preg_split($regExp, $line);
            if (count($fields) > 1) {
                if (!empty($results[$delimiter])) {
                    $results[$delimiter] ++;
                } else {
                    $results[$delimiter] = 1;
                }
            }
        }
        $i++;
    }
    $results = array_keys($results, max($results));
    return $results[0];
}

function formatSizeUnits($bytes) {
    if ($bytes >= 1073741824) {
        $bytes = number_format($bytes / 1073741824, 2) . ' GB';
    } elseif ($bytes >= 1048576) {
        $bytes = number_format($bytes / 1048576, 2) . ' MB';
    } elseif ($bytes >= 1024) {
        $bytes = number_format($bytes / 1024, 2) . ' kB';
    } elseif ($bytes > 1) {
        $bytes = $bytes . ' bytes';
    } elseif ($bytes == 1) {
        $bytes = $bytes . ' byte';
    } else {
        $bytes = '0 bytes';
    }

    return $bytes;
}

function splitFile($fileName, $lines, $delimiter) {
    $inputFile = $_SERVER['DOCUMENT_ROOT'] . "/uploads/" . $fileName;
    $outputFolder = $_SERVER['DOCUMENT_ROOT'] . "/uploads/splits/";

    $splitSize = $lines;

    $in = fopen($inputFile, 'r');

    $rowCount = 0;
    $fileCount = 1;
    while (!feof($in)) {
        if (($rowCount % $splitSize) == 0) {
            if ($rowCount > 0) {
                fclose($out);
            }
            $out = fopen($outputFolder . $fileName . "_" . $fileCount++ . '.csv', 'w');
        }
        $data = fgetcsv($in, 10000, $delimiter);
        if ($data)
            fputcsv($out, $data, $delimiter);
        $rowCount++;
    }

    fclose($out);

    return true;
}

function unformatForSearch($string) {
    return str_replace('_', ' ', $string);
}

function CurrentAge($dob) {
    $years = date('Y', $dob);
    $months = date('m', $dob);
    $days = date('d', $dob);
    $now = date('Y');

    if (substr($months, 0, 1) == '-') {
        $years = $years - 1;
        $months = 12 - substr($months, 1);
    }

    if (substr($days, 0, 1) == '-') {
        $days = date('t') - substr($days, 1);
    }

    return ($now - $years);
}

function geocode($address, $userAgent = "") {
    if (!preg_match('/bot|spider|crawler|curl|^$/i', $userAgent)) {
        require_once($_SERVER['DOCUMENT_ROOT'] . '/mapbox/Mapbox.php');
        $mapbox = new Mapbox("pk.eyJ1IjoiY2RzaG93ZXJzMjMiLCJhIjoiZF9zUFY2cyJ9.75SOCtl7m15KMrxB8bvJoQ");
        $address = $address;
        $res = $mapbox->geocode($address);

        $r = $res->getData();
        $coor['long'] = $r[0]['geometry']['coordinates'][0];
        $coor['lat'] = $r[0]['geometry']['coordinates'][1];

        return $coor;
    } else {
        $coor['lat'] = '37.0902';
        $coor['long'] = '95.7129';

        return $coor;
    }
}

function getStateFromJson($stateAbr) {
    $json = '{
        "AL": "B",
        "AK": "A",
        "AZ": "D",
        "AR": "C",
        "CA": "E",
        "CO": "F",
        "CT": "G",
        "DE": "H",
        "DC": "y",
        "FL": "I",
        "GA": "J",
        "HI": "K",
        "ID": "M",
        "IL": "N",
        "IN": "O",
        "IA": "L",
        "KS": "P",
        "KY": "Q",
        "LA": "R",
        "ME": "U",
        "MD": "T",
        "MA": "S",
        "MI": "V",
        "MN": "W",
        "MS": "Y",
        "MO": "X",
        "MT": "Z",
        "NE": "c",
        "NV": "g",
        "NH": "d",
        "NJ": "e",
        "NM": "f",
        "NY": "h",
        "NC": "a",
        "ND": "b",
        "OH": "i",
        "OK": "j",
        "OR": "k",
        "PA": "l",
        "RI": "m",
        "SC": "n",
        "SD": "o",
        "TN": "p",
        "TX": "q",
        "UT": "r",
        "VT": "t",
        "VA": "s",
        "WA": "u",
        "WV": "w",
        "WI": "v",
        "WY": "x",
        "US": "z"
    }';

    $obj = json_decode($json);

    return $obj->{strtoupper($stateAbr)};
}

function streetAbr($rawAddress) {
    $rawAddress = strtolower($rawAddress);
    $list = array(
        'ave' => 'avenue',
        'blvd' => 'boulevard',
        'cir' => 'circle',
        'ct' => 'court',
        'ter' => 'terrace',
        'expy' => 'expressway',
        'fwy' => 'freeway',
        'ln' => 'lane',
        'pky' => 'parkway',
        'rd' => 'road',
        'sq' => 'square',
        'st' => 'street',
        'tpke' => 'turnpike',
        'n' => 'north',
        'e' => 'east',
        's' => 'south',
        'w' => 'west',
        'ne' => 'northeast',
        'se' => 'southeast',
        'sw' => 'southwest',
        'nw' => 'northwest',
    );
    $revList = array_flip($list);

    $rawAddress = str_replace('  ', ' ', $rawAddress);
    $addyParts = explode(' ', $rawAddress);
    $i = 0;
    foreach ($addyParts as $part) {
        if (in_array($part, $list)) {
            $addyParts[$i] = trim($revList[$part]);
        }
        $i++;
    }
    $rawAddress = trim(implode(' ', $addyParts));

    return $rawAddress;
}

function curl($filename) {
    set_time_limit(240);
    $url = "http://16-06-2018-D:GZISsV9TxcBE@members.whoisdatacenter.com/" . $filename;

    set_time_limit(0);
//This is the file where we save the    information
    //$fp = fopen($_SERVER['DOCUMENT_ROOT'] . '/localfile.tmp', 'w+');
//Here is the file we are downloading, replace spaces with %20
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_TIMEOUT, 50);
// write curl response to file
    //curl_setopt($ch, CURLOPT_FILE, $fp);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
// get curl response
    $c = curl_exec($ch);
    if (curl_errno($ch)) {
        throw new Exception(curl_error($ch));
    }
    echo $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    //fclose($fp);
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/downloads/" . $filename, $c);

    exit();
}

function deleteDir($dirPath) {
    if (!is_dir($dirPath)) {
        throw new InvalidArgumentException("$dirPath must be a directory");
    }
    if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
        $dirPath .= '/';
    }
    $files = glob($dirPath . '*', GLOB_MARK);
    foreach ($files as $file) {
        if (is_dir($file)) {
            deleteDir($file);
        } else {
            unlink($file);
        }
    }
    rmdir($dirPath);
}

function find_longer_value($first, $second) {
    return strlen($first) > strlen($second);
}

function longest_value($array) {
    usort($array, 'find_longer_value');
    return $array[count($array) - 1];
}
