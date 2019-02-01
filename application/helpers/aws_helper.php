<?php

$CI = get_instance();
$CI->load->library('Awslib');
set_time_limit(0);
date_default_timezone_set('America/New_York');

use Aws\Ses\SesClient;
use Aws\DynamoDb\DynamoDbClient;
use Aws\S3\S3Client;

function getS3Bucket($bucket) {
    $client = S3Client::factory([
                'region' => 'us-east-1',
                'version' => 'latest',
                'credentials' => [
                    'key' => 'AKIAI4RS42NYAMBCFO4Q',
                    'secret' => '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',
                ]
    ]);

    $iterator = $client->getIterator('ListObjects', array(
        'Bucket' => $bucket
    ));

    return $iterator;
}

function transferImportFile($key, $name) {
    $client = S3Client::factory([
                'region' => 'us-east-1',
                'version' => 'latest',
                'credentials' => [
                    'key' => 'AKIAI4RS42NYAMBCFO4Q',
                    'secret' => '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',
                ]
    ]);

    $result = $client->getObject(array(
        'Bucket' => 'yoliya_importer',
        'Key' => $key,
        'SaveAs' => $_SERVER['DOCUMENT_ROOT'] . '/uploads/' . $name
    ));

    return true;
}

function deleteObject($bucket, $key) {
    $client = S3Client::factory([
                'region' => 'us-east-1',
                'version' => 'latest',
                'credentials' => [
                    'key' => 'AKIAI4RS42NYAMBCFO4Q',
                    'secret' => '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',
                ]
    ]);

    $result = $client->deleteObject(array(
        'Bucket' => $bucket,
        'Key' => $key
    ));

    return true;
}

function getCurrentTables() {

    $client = DynamoDbClient::factory([
                'region' => 'us-east-1',
                'version' => 'latest',
                'credentials' => [
                    'key' => 'AKIAI4RS42NYAMBCFO4Q',
                    'secret' => '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',
                ]
    ]);

    $result = $client->listTables();

    return $result;
}

function getCapacity($tableName, $lsi = "", $gsi = "") {

    $client = DynamoDbClient::factory([
                'region' => 'us-east-1',
                'version' => 'latest',
                'credentials' => [
                    'key' => 'AKIAI4RS42NYAMBCFO4Q',
                    'secret' => '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',
                ]
    ]);

    if (!isset($lsi) && !isset($gsi)) {

        $result = $client->describeTable([
            'TableName' => $tableName
        ]);
    } elseif (isset($gsi) && !empty($gsi)) {

        $result = $client->describeTable([
            'TableName' => $tableName,
            'GlobalSecondaryIndex' => $gsi
        ]);
    } else {
        $result = $client->describeTable([
            'TableName' => $tableName,
            'LocalSecondaryIndex' => $lsi
        ]);
    }

    return $result;
}

function updateCapacity($table, $readCapacity, $writeCapacity, $gsi = "") {

    $client = DynamoDbClient::factory([
                'region' => 'us-east-1',
                'version' => 'latest',
                'credentials' => [
                    'key' => 'AKIAI4RS42NYAMBCFO4Q',
                    'secret' => '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',
                ]
    ]);

    if (isset($gsi) && !empty($gsi)) {
        $result = $client->updateTable([
            'GlobalSecondaryIndexUpdates' => [
                [
                    'Update' => [
                        'IndexName' => str_replace('_', '.', $gsi), // REQUIRED
                        'ProvisionedThroughput' => [ // REQUIRED
                            'ReadCapacityUnits' => (int) $readCapacity, // REQUIRED
                            'WriteCapacityUnits' => (int) $writeCapacity, // REQUIRED
                        ],
                    ],
                ],
            ],
            'TableName' => $table, // REQUIRED
        ]);
    } else {
        $result = $client->updateTable([
            'ProvisionedThroughput' => [
                'ReadCapacityUnits' => (int) $readCapacity, // REQUIRED
                'WriteCapacityUnits' => (int) $writeCapacity, // REQUIRED
            ],
            'TableName' => $table, // REQUIRED
        ]);
    }

    return true;
}

function getAllDatasets() {

    $sdk = new Aws\Sdk([
        'region' => 'us-east-1',
        'version' => 'latest',
        'credentials' => [
            'key' => 'AKIAI4RS42NYAMBCFO4Q',
            'secret' => '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',
        ]
    ]);

    $dynamodb = $sdk->createDynamoDb();

    $result = $dynamodb->scan(array(
        'TableName' => 'yoliya_voterRecords',
    ));

    $startKey = array();

    do {
        $args = array('TableName' => 'yoliya_datasets') + $startKey;
        $result = $dynamodb->scan($args);

        $startKey['ExclusiveStartKey'] = $result['LastEvaluatedKey'];
    } while ($startKey['ExclusiveStartKey']);

    return $result['Items'];
}

function countDatasetItems() {

    $sdk = new Aws\Sdk([
        'region' => 'us-east-1',
        'version' => 'latest',
        'credentials' => [
            'key' => 'AKIAI4RS42NYAMBCFO4Q',
            'secret' => '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',
        ]
    ]);

    $dynamodb = $sdk->createDynamoDb();

    $result = $dynamodb->scan(array(
        'TableName' => 'yoliya_voterRecords',
    ));

    $startKey = array();

    do {
        $args = array('TableName' => 'yoliya_voterRecords') + $startKey;
        $result = $dynamodb->scan($args);

        $startKey['ExclusiveStartKey'] = $result['LastEvaluatedKey'];
    } while ($startKey['ExclusiveStartKey']);

    return count($result['Items']);
}

function insertDataset($POST) {

    $sdk = new Aws\Sdk([
        'region' => 'us-east-1',
        'version' => 'latest',
        'credentials' => [
            'key' => 'AKIAI4RS42NYAMBCFO4Q',
            'secret' => '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',
        ]
    ]);

    $dynamodb = $sdk->createDynamoDb();

    $stamp = date("Ymdhis");

    $response = $dynamodb->putItem([
        'TableName' => 'yoliya_datasets',
        'Item' => [
            'ID' => ['S' => $stamp], // Primary Key
            'name' => ['S' => $POST['name']],
            'description' => ['S' => $POST['description']],
            'fileName' => ['S' => $POST['fileName']],
            'source' => ['S' => $POST['source']],
            'created' => ['S' => date("m-d-Y")]
    ]]);

    return $response;
}

function insertCity($city, $state) {

    $sdk = new Aws\Sdk([
        'region' => 'us-east-1',
        'version' => 'latest',
        'credentials' => [
            'key' => 'AKIAI4RS42NYAMBCFO4Q',
            'secret' => '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',
        ]
    ]);

    $dynamodb = $sdk->createDynamoDb();

    $stamp = date("Ymdhis");

    $response = $dynamodb->putItem([
        'TableName' => 'yoliya_datasets',
        'Item' => [
            'state' => ['S' => $state], // Primary Key
            'city' => ['S' => $city],
            'created' => ['S' => date("m-d-Y")]
    ]]);

    return $response;
}

function insertToCatalog($data) {
    $sdk = new Aws\Sdk([
        'region' => 'us-east-1',
        'version' => 'latest',
        'credentials' => [
            'key' => 'AKIAI4RS42NYAMBCFO4Q',
            'secret' => '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',
        ]
    ]);

    $apt = "";
    $city = "";
    $cityState = "";
    $county = "";
    $dob = "";
    $first = "";
    $firstLast = "";
    $fullAddress = "";
    $fullAddressLastFirstMiddle = "";
    $gender = "";
    $id = "";
    $last = "";
    $middle = "";
    $state = "";
    $streetName = "";
    $zip = "";

    $dynamodb = $sdk->createDynamoDb();
    $stamp = date("Ymdhis");
    $id = trim(uniqid("", true));

    if (isset($data[0]['apt']['S']) && !empty($data[0]['apt']['S'])) {
        $apt = trim($data[0]['apt']['S']);
    }
    if (isset($data[0]['city']['S']) && !empty($data[0]['city']['S'])) {
        $city = trim($data[0]['city']['S']);
    }
    if (isset($data[0]['fullAddress.city.state']['S']) && !empty($data[0]['fullAddress.city.state']['S']) && isset($data[0]['city']['S']) && !empty($data[0]['city']['S'])) {
        $ex = explode('.', $data[0]['fullAddress.city.state']['S']);
        $cityState = trim(formatForSearch($data[0]['city']['S']) . '.' . $ex[2]);
    }
    if (isset($data[0]['county']['S']) && !empty($data[0]['county']['S'])) {
        $county = trim($data[0]['county']['S']);
    }
    if (isset($data[0]['dob']['S']) && !empty($data[0]['dob']['S'])) {
        $dob = trim($data[0]['dob']['S']);
    }
    if (isset($data[0]['first']['S']) && !empty($data[0]['first']['S'])) {
        $first = trim($data[0]['first']['S']);
    }
    if (isset($data[0]['first']['S']) && !empty($data[0]['first']['S']) && isset($data[0]['last']['S']) && !empty($data[0]['last']['S'])) {
        $firstLast = trim(formatForSearch($data[0]['first']['S']) . '.' . formatForSearch($data[0]['last']['S']));
    }
    if (isset($data[0]['address']['S']) && !empty($data[0]['address']['S'])) {
        $fullAddress = trim($data[0]['address']['S']);
    }
    if (isset($data[0]['first']['S']) && !empty($data[0]['first']['S']) && isset($data[0]['last']['S']) && !empty($data[0]['last']['S']) && isset($data[0]['address']['S']) && !empty($data[0]['address']['S']) && !empty($data[0]['middle']['S'])) {
        $fullAddressLastFirstMiddle = formatForSearch(trim($data[0]['address']['S'])) . '.' . formatForSearch(trim($data[0]['last']['S'])) . '.' . formatForSearch(trim($data[0]['first']['S'])) . '.' . formatForSearch(trim($data[0]['middle']['S']));
    } else {
        $fullAddressLastFirstMiddle = formatForSearch(trim($data[0]['address']['S'])) . '.' . formatForSearch(trim($data[0]['last']['S'])) . '.' . formatForSearch(trim($data[0]['first']['S']));
    }
    if (isset($data[0]['gender']['S']) && !empty($data[0]['gender']['S'])) {
        $gender = trim($data[0]['gender']['S']);
    }
    if (isset($data[0]['last']['S']) && !empty($data[0]['last']['S'])) {
        $last = trim($data[0]['last']['S']);
    }
    if (isset($data[0]['middle']['S']) && !empty($data[0]['middle']['S'])) {
        $middle = trim($data[0]['middle']['S']);
    }
    if (isset($data[0]['phone']['S']) && !empty($data[0]['phone']['S'])) {
        $phone = trim($data[0]['phone']['S']);
    }
    if (isset($data[0]['fullAddress.city.state']['S']) && !empty($data[0]['fullAddress.city.state']['S'])) {
        $ex = explode('.', $data[0]['fullAddress.city.state']['S']);
        $state = trim($ex[2]);
    }
    if (empty($fullAddress) && isset($data[0]['street']['S']) && !empty($data[0]['street']['S'])) {
        $fullAddress = str_replace('  ', ' ', trim($data[0]['houseNumber']['S'] . ' ' . $data[0]['streetDirection']['S'] . ' ' . $data[0]['street']['S'] . ' ' . $data[0]['streetType']['S']));
    } elseif (empty($fullAddress) && isset($data[0]['fullAddress.city.state']['S']) && !empty($data[0]['fullAddress.city.state']['S'])) {
        $peices = explode('.', $data[0]['fullAddress.city.state']['S']);
        $fullAddress = $peices[0];
    }

    if (empty($state)) {
        $peices = explode('.', $data[0]['fullAddress.city.state']['S']);
        $state = $peices[2];
    }

    if (empty($first)) {
        $parts = explode('.', $data[0]['first.last']['S']);
        $first = unformatForSearch($parts[0]);
    }

    if (empty($last)) {
        $parts = explode('.', $data[0]['first.last']['S']);
        $last = unformatForSearch($parts[1]);
    }

    if (empty($firstLast) && !empty($first) && !empty($last)) {
        $firstLast = formatForSearch(trim($first)) . '.' . formatForSearch(trim($last));
    }

    if (empty($cityState) && !empty($city) && !empty($state)) {
        $cityState = formatForSearch(trim($city)) . '.' . formatForSearch(trim($state));
    }

    $fullAddress = str_replace('  ', ' ', $fullAddress);
    $addyParts = explode(' ', $fullAddress);

    if (is_numeric($addyParts[0])) {
        array_shift($addyParts);
        $streetName = trim(implode(' ', $addyParts));
    }

    if (isset($data[0]['zip']['S']) && !empty($data[0]['zip']['S'])) {
        $zip = trim($data[0]['zip']['S']);
    }

    $array['TableName'] = "yoliya_main";

    if (!empty($apt))
        $fields['apt']['S'] = $apt;

    if (!empty($gender))
        $fields['gender']['S'] = $gender;

    if (!empty($middle))
        $fields['middle']['S'] = $middle;

    if (!empty($county))
        $fields['county']['S'] = $county;

    if (!empty($dob))
        $fields['dob']['S'] = $dob;

    if (!empty($zip))
        $fields['zip']['S'] = $zip;

    if (!empty($phone)) {
        $fields['phone']['S'] = "";
        if (isset($data[0]['area']['S']) && !empty($data[0]['area']['S'])) {
            $fields['phone']['S'] .= $data[0]['area']['S'];
        }
        $fields['phone']['S'] .= $phone;
    }

    if (!empty($city) && !empty($state) && !empty($first) && !empty($last) && !empty($fullAddress)) {

        $fields['city']['S'] = $city;
        $fields['city.state']['S'] = $cityState;
        $fields['created']['S'] = $stamp;
        $fields['first']['S'] = $first;
        $fields['first.last']['S'] = $firstLast;
        $fields['fullAddress']['S'] = $fullAddress;
        $fields['fullAddress.last.first.middle']['S'] = $fullAddressLastFirstMiddle;
        $fields['id']['S'] = $id;
        $fields['last']['S'] = $last;
        $fields['state']['S'] = $state;
        $fields['streetName']['S'] = $streetName;
        $fields['zip']['S'] = $zip;

        $array['Item'] = $fields;
        $response = $dynamodb->putItem($array);
    }

    if ($response) {
        return $response;
    } else {
        return false;
    }
}

function insertAttributeMap($datasetID, $attributeKey, $attributeValue) {
    $sdk = new Aws\Sdk([
        'region' => 'us-east-1',
        'version' => 'latest',
        'credentials' => [
            'key' => 'AKIAI4RS42NYAMBCFO4Q',
            'secret' => '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',
        ]
    ]);

    $dynamodb = $sdk->createDynamoDb();

    $stamp = date("Ymdhis");

    $response = $dynamodb->putItem([
        'TableName' => 'yoliya_dataMaps',
        'Item' => [
            'datasetID' => ['S' => $datasetID],
            'attributeKey' => ['S' => "-" . $attributeKey],
            'attributePrettyName' => ['S' => $attributeValue],
            'created' => ['S' => date("m-d-Y")]
    ]]);

    return $response;
}

function insertSearchableFields($datasetID, $POST) {
    $sdk = new Aws\Sdk([
        'region' => 'us-east-1',
        'version' => 'latest',
        'credentials' => [
            'key' => 'AKIAI4RS42NYAMBCFO4Q',
            'secret' => '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',
        ]
    ]);

    $dynamodb = $sdk->createDynamoDb();

    $stamp = date("Ymdhis");

    $response = $dynamodb->putItem([
        'TableName' => 'yoliya_searchableFields',
        'Item' => [
            'ID' => ['S' => $stamp . rand(1, 9999)], // Primary Key
            'datasetID' => ['S' => $datasetID],
            'fNameAttributeKey' => ['S' => '-' . $POST['fName']],
            'lNameAttributeKey' => ['S' => '-' . $POST['lName']],
            'dobAttributeKey' => ['S' => '-' . $POST['dob']],
            'phoneAttributeKey' => ['S' => '-' . $POST['phone']],
            'created' => ['S' => date("m-d-Y")]
    ]]);

    return $response;
}

function importFileToDB($fileName, $POSTS, $throttle) {

    $file = $_SERVER['DOCUMENT_ROOT'] . "/uploads/" . $fileName;
    if (!file_exists($file)) {
        $file = $_SERVER['DOCUMENT_ROOT'] . "/uploads/splits/" . $fileName;
    }

    $sdk = new Aws\Sdk([
        'region' => 'us-east-1',
        'version' => 'latest',
        'credentials' => [
            'key' => 'AKIAI4RS42NYAMBCFO4Q',
            'secret' => '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',
        ]
    ]);

    $dynamoDB = $sdk->createDynamoDb();
    $stamp = date("Ymdhis");

    $id = 0;
    $string = "";
    //echo var_dump($POSTS);
    foreach ($POSTS as $k => $v) {
        if (!empty($v)) {
            $string .= $k . "-" . $v . " ";
        }
        $id++;
    }
    //echo 'php ' . $_SERVER['DOCUMENT_ROOT'] . '/cli.php ' . $file . ' ' . $POSTS['state'] . ' ' . $string;
    exec('php ' . $_SERVER['DOCUMENT_ROOT'] . '/cli.php ' . $fileName . ' ' . $POSTS['state'] . ' ' . $throttle . ' ' . $string, $res);

    return $res;
}

function insertVoterRecord($array) {
    $sdk = new Aws\Sdk([
        'region' => 'us-east-1',
        'version' => 'latest',
        'credentials' => [
            'key' => 'AKIAI4RS42NYAMBCFO4Q',
            'secret' => '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',
        ]
    ]);

    $dynamoDB = $sdk->createDynamoDb();

    $dynamoDB->putItem($array);
}

function insertDMACity($array) {

    $sdk = new Aws\Sdk([
        'region' => 'us-east-1',
        'version' => 'latest',
        'credentials' => [
            'key' => 'AKIAI4RS42NYAMBCFO4Q',
            'secret' => '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',
        ]
    ]);

    $dynamodb = $sdk->createDynamoDb();

    $response = $dynamodb->putItem([
        'TableName' => 'yoliya_dmas',
        'Item' => [
            'city.state' => ['S' => strtolower(str_replace("'", "", str_replace(' ', '_', str_replace('.', '', $array['dmas_city']) . '_' . $array['dmas_state'])))], // Primary Key
            'city' => ['S' => strtolower($array['dmas_city'])],
            'criteriaID' => ['S' => strtolower($array['dmas_criteriaID'])],
            'state' => ['S' => strtolower($array['dmas_state'])],
            'region' => ['S' => strtolower($array['dmas_region'])],
            'regionCode' => ['S' => strtolower($array['dmas_regionCode'])],
    ]]);




    return $response;
}

function getName($first, $last, $state = "", $city = "") {

    $sdk = new Aws\Sdk([
        'region' => 'us-east-1',
        'version' => 'latest',
        'credentials' => [
            'key' => 'AKIAI4RS42NYAMBCFO4Q',
            'secret' => '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',
            'scheme' => 'http'
        ]
    ]);

    $dynamodb = $sdk->createDynamoDb();
    $tableName = 'yoliya_main';

    if (!empty($city) && !empty($state)) {
        $response = $dynamodb->query([
            'TableName' => $tableName,
            'IndexName' => 'first.last-city.state-index',
            'KeyConditionExpression' => '#firstlast = :v_firstlast AND #citystate = :v_citystate',
            'ExpressionAttributeNames' => ['#firstlast' => 'first.last', '#citystate' => 'city.state'],
            'ExpressionAttributeValues' => [
                ':v_firstlast' => ['S' => formatForSearch($first) . '.' . formatForSearch($last)],
                ':v_citystate' => ['S' => formatForSearch($city) . '.' . formatForSearch($state)],
            ],
            'Limit' => 20
                //'Select' => 'ALL_ATTRIBUTES',
                //'ScanIndexForward' => true,
        ]);
    } elseif (!empty($state)) {
        $response = $dynamodb->query([
            'TableName' => $tableName,
            'IndexName' => 'first.last-state-index',
            'KeyConditionExpression' => '#firstlast = :v_firstlast AND #state = :v_state',
            'ExpressionAttributeNames' => ['#firstlast' => 'first.last', '#state' => 'state'],
            'ExpressionAttributeValues' => [
                ':v_firstlast' => ['S' => formatForSearch($first) . '.' . formatForSearch($last)],
                ':v_state' => ['S' => formatForSearch($state)],
            ],
            'Limit' => 20
                //'Select' => 'ALL_ATTRIBUTES',
                //'ScanIndexForward' => true,
        ]);
    } else {
        $response = $dynamodb->query([
            'TableName' => $tableName,
            'IndexName' => 'first.last-city.state-index',
            'KeyConditionExpression' => '#firstlast = :v_firstlast',
            'ExpressionAttributeNames' => ['#firstlast' => 'first.last'],
            'ExpressionAttributeValues' => [
                ':v_firstlast' => ['S' => formatForSearch($first) . '.' . formatForSearch($last)],
            ],
            'Limit' => 20
                //'Select' => 'ALL_ATTRIBUTES',
                //'ScanIndexForward' => true,
        ]);
    }

    /*
      foreach ($response['Items'] as $item) {
      echo "fname_lname ---> " . $item['fName_lName']['S'] . "\n";
      echo "Voter ID ---> " . $item['-1']['S'] . "\n";
      echo "DOB ---> " . $item['-21']['S'] . "\n";
      echo "\n";
      }
     * 
     */
    return $response['Items'];
}

function getNameById($id) {

    $sdk = new Aws\Sdk([
        'region' => 'us-east-1',
        'version' => 'latest',
        'credentials' => [
            'key' => 'AKIAI4RS42NYAMBCFO4Q',
            'secret' => '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',
            'scheme' => 'http'
        ]
    ]);

    $dynamodb = $sdk->createDynamoDb();
    $tableName = 'yoliya_main';

    $response = $dynamodb->query([
        'TableName' => $tableName,
        'IndexName' => 'id-index',
        'KeyConditionExpression' => '#id = :v_id',
        'ExpressionAttributeNames' => ['#id' => 'id'],
        'ExpressionAttributeValues' => [
            ':v_id' => ['S' => $id]
        ],
        'Select' => 'ALL_ATTRIBUTES',
            //'ScanIndexForward' => true,
    ]);

    /*
      foreach ($response['Items'] as $item) {
      echo "fname_lname ---> " . $item['fName_lName']['S'] . "\n";
      echo "Voter ID ---> " . $item['-1']['S'] . "\n";
      echo "DOB ---> " . $item['-21']['S'] . "\n";
      echo "\n";
      }
     * 
     */
    if (isset($response['Items'][0])) {
        return $response['Items'][0];
    }
}

function getAllFromAddress($address, $city, $state) {

    $sdk = new Aws\Sdk([
        'region' => 'us-east-1',
        'version' => 'latest',
        'credentials' => [
            'key' => 'AKIAI4RS42NYAMBCFO4Q',
            'secret' => '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',
            'scheme' => 'http'
        ]
    ]);

    $dynamodb = $sdk->createDynamoDb();
    $tableName = 'yoliya_main';

    $response = $dynamodb->query([
        'TableName' => $tableName,
        'IndexName' => 'city.state-fullAddress-index',
        'KeyConditionExpression' => '#citystate = :v_city and fullAddress = :v_address',
        'ExpressionAttributeNames' => ['#citystate' => 'city.state', '#first' => 'first', '#last' => 'last', '#fullAddress' => 'fullAddress', '#dob' => 'dob', '#id' => 'id', '#firstlast' => 'first.last', '#city' => 'city', '#state' => 'state'],
        'ExpressionAttributeValues' => [
            ':v_city' => ['S' => strtolower($city . '.' . $state)],
            ':v_address' => ['S' => strtolower($address)],
        //':v_address' => ['S' => $address]
        ],
        'Select' => 'SPECIFIC_ATTRIBUTES',
        'ProjectionExpression' => '#first, #last, #fullAddress, #dob, #id, #firstlast, #city, #state',
        'ScanIndexForward' => true,
        'Limit' => 5
    ]);

    return $response['Items'];
}

function getNeighbors($streetName, $city, $state) {

    $sdk = new Aws\Sdk([
        'region' => 'us-east-1',
        'version' => 'latest',
        'credentials' => [
            'key' => 'AKIAI4RS42NYAMBCFO4Q',
            'secret' => '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',
            'scheme' => 'http'
        ]
    ]);

    $dynamodb = $sdk->createDynamoDb();
    $tableName = 'yoliya_main';

    $response = $dynamodb->query([
        'TableName' => $tableName,
        'IndexName' => 'city.state-streetName-index',
        'KeyConditionExpression' => '#citystate = :v_city and streetName = :v_street',
        'ExpressionAttributeNames' => ['#citystate' => 'city.state', '#first' => 'first', '#last' => 'last', '#fullAddress' => 'fullAddress', '#dob' => 'dob', '#id' => 'id', '#firstlast' => 'first.last', '#city' => 'city', '#state' => 'state'],
        'ExpressionAttributeValues' => [
            ':v_city' => ['S' => strtolower($city . '.' . $state)],
            ':v_street' => ['S' => strtolower($streetName)],
        //':v_address' => ['S' => $address]
        ],
        'Select' => 'SPECIFIC_ATTRIBUTES',
        'ProjectionExpression' => '#first, #last, #fullAddress, #dob, #id, #firstlast, #city, #state',
        //'ScanIndexForward' => true,
        'Limit' => 4
    ]);

    return $response['Items'];
}

function getNameByCity($first, $last, $city, $state, $limit = 10) {

    $sdk = new Aws\Sdk([
        'region' => 'us-east-1',
        'version' => 'latest',
        'credentials' => [
            'key' => 'AKIAI4RS42NYAMBCFO4Q',
            'secret' => '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',
            'scheme' => 'http'
        ]
    ]);

    $dynamodb = $sdk->createDynamoDb();
    $tableName = 'yoliya_main';

    $response = $dynamodb->query([
        'TableName' => $tableName,
        'IndexName' => 'city.state-first.last-index',
        'KeyConditionExpression' => '#firstlast = :v_firstlast and #citystate = :v_citystate',
        'ExpressionAttributeNames' => ['#firstlast' => 'first.last', '#citystate' => 'city.state'],
        'ExpressionAttributeValues' => [
            ':v_firstlast' => ['S' => formatForSearch($first) . '.' . formatForSearch($last)],
            ':v_citystate' => ['S' => formatForSearch($city) . '.' . formatForSearch($state)],
        ],
        'Select' => 'ALL_ATTRIBUTES',
        'Limit' => $limit
            //'ScanIndexForward' => true,
    ]);

    if ($response['Items']) {
        return $response['Items'];
    } else {
        return false;
    }
}

function getVoterRecord($firstLast, $fullAddressCityState) {

    $sdk = new Aws\Sdk([
        'region' => 'us-east-1',
        'version' => 'latest',
        'credentials' => [
            'key' => 'AKIAI4RS42NYAMBCFO4Q',
            'secret' => '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',
            'scheme' => 'http'
        ]
    ]);

    $dynamodb = $sdk->createDynamoDb();
    $tableName = 'yoliya_voterRecords';

    $response = $dynamodb->query([
        'TableName' => $tableName,
        'IndexName' => 'first.last-fullAddress.city.state-index',
        'KeyConditionExpression' => '#firstlast = :v_firstlast and #fulladdresscitystate = :v_fulladdresscitystate',
        'ExpressionAttributeNames' => ['#firstlast' => 'first.last', '#fulladdresscitystate' => 'fullAddress.city.state'],
        'ExpressionAttributeValues' => [
            ':v_firstlast' => ['S' => $firstLast],
            ':v_fulladdresscitystate' => ['S' => $fullAddressCityState],
        ],
        'Select' => 'ALL_ATTRIBUTES',
            //'ScanIndexForward' => true,
    ]);

    if ($response['Items']) {
        return $response['Items'];
    } else {
        return false;
    }
}

function recordSearch($first, $last, $city) {

    $sdk = new Aws\Sdk([
        'region' => 'us-east-1',
        'version' => 'latest',
        'credentials' => [
            'key' => 'AKIAI4RS42NYAMBCFO4Q',
            'secret' => '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',
            'scheme' => 'http'
        ]
    ]);

    $dynamodb = $sdk->createDynamoDb();
    $tableName = 'yoliya_voterRecords';

    $fl = formatForSearch(trim($first)) . '.' . formatForSearch(trim($last));
    $c = formatForSearch(trim($city));

    $response = $dynamodb->query([
        'TableName' => $tableName,
        'IndexName' => 'first.last-city-index',
        'KeyConditionExpression' => '#firstlast = :v_firstlast AND #city = :v_city',
        'ExpressionAttributeNames' => ['#firstlast' => 'first.last', '#city' => 'city'],
        'ExpressionAttributeValues' => [
            ':v_firstlast' => ['S' => $fl],
            ':v_city' => ['S' => $c]
        ]
    ]);

    if ($response['Items']) {
        return $response['Items'];
    } else {
        return false;
    }
}

function getNameByCities($first, $last, $cities, $state) {

    $sdk = new Aws\Sdk([
        'region' => 'us-east-1',
        'version' => 'latest',
        'credentials' => [
            'key' => 'AKIAI4RS42NYAMBCFO4Q',
            'secret' => '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',
            'scheme' => 'http'
        ]
    ]);

    $dynamodb = $sdk->createDynamoDb();
    $array2 = array();
    $i = 0;
    $uniqueArray = array();

    foreach ($cities as $city) {
        if (!in_array(formatForSearch($city['city']['S']), $uniqueArray)) {
            $array2['RequestItems']['yoliya_sitemaps']['Keys'][$i]['state']['S'] = strtolower($state);
            $array2['RequestItems']['yoliya_sitemaps']['Keys'][$i]['first.last.city']['S'] = formatForSearch($first) . '.' . formatForSearch($last) . '.' . formatForSearch($city['city']['S']);
            $uniqueArray[] = formatForSearch($city['city']['S']);
            $i++;
        }
        if ($i > 99) {
            break;
        }
    }

    $response = $dynamodb->batchGetItem($array2);

    if ($response['Responses']) {
        return $response['Responses'];
    } else {
        return false;
    }
}

function insertSitemaps($maps) {

    $sdk3 = new Aws\Sdk([
        'region' => 'us-east-1',
        'version' => 'latest',
        'credentials' => [
            'key' => 'AKIAI4RS42NYAMBCFO4Q',
            'secret' => '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',
        ]
    ]);

    $dynamoDB3 = $sdk3->createDynamoDb();
    $dynamoDB3->batchWriteItem($maps);

    return true;
}

function deleteSitmemapItem($first, $last, $city, $state) {

    $sdk = new Aws\Sdk([
        'region' => 'us-east-1',
        'version' => 'latest',
        'credentials' => [
            'key' => 'AKIAI4RS42NYAMBCFO4Q',
            'secret' => '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',
        ]
    ]);

    $dynamodb = $sdk->createDynamoDb();
    $tableName = 'yoliya_sitemaps';

    $flc = formatForSearch($first) . '.' . formatForSearch($last) . '.' . formatForSearch($city);

    $response = $dynamodb->deleteItem([
        'TableName' => $tableName,
        'Key' => [
            'state' => [
                'S' => $state
            ],
            'first.last.city' => [
                'S' => $flc
            ]
        ]
    ]);

    return true;
}

function deleteSitemapZip($state, $zip) {

    $sdk = new Aws\Sdk([
        'region' => 'us-east-1',
        'version' => 'latest',
        'credentials' => [
            'key' => 'AKIAI4RS42NYAMBCFO4Q',
            'secret' => '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',
        ]
    ]);

    $dynamodb = $sdk->createDynamoDb();
    $tableName = 'yoliya_zips';

    $response = $dynamodb->deleteItem([
        'TableName' => $tableName,
        'Key' => [
            'state' => [
                'S' => $state
            ],
            'zip' => [
                'S' => $zip
            ]
        ]
    ]);

    return true;
}

function removeName($cityState, $fullAddressLastFirstMiddle) {

    $sdk = new Aws\Sdk([
        'region' => 'us-east-1',
        'version' => 'latest',
        'credentials' => [
            'key' => 'AKIAI4RS42NYAMBCFO4Q',
            'secret' => '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',
        ]
    ]);

    $dynamodb = $sdk->createDynamoDb();
    $tableName = 'yoliya_main';

    $response = $dynamodb->deleteItem([
        'TableName' => $tableName,
        'Key' => [
            'city.state' => [
                'S' => $cityState
            ],
            'fullAddress.last.first.middle' => [
                'S' => $fullAddressLastFirstMiddle
            ]
        ]
    ]);

    return true;
}

function getNamesByAlpha($letter, $city, $state) {

    $sdk = new Aws\Sdk([
        'region' => 'us-east-1',
        'version' => 'latest',
        'credentials' => [
            'key' => 'AKIAI4RS42NYAMBCFO4Q',
            'secret' => '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',
            'scheme' => 'http'
        ]
    ]);

    $dynamodb = $sdk->createDynamoDb();
    $tableName = 'yoliya_main';
    //echo $city.' '.$state;
    $response = $dynamodb->query([
        'TableName' => $tableName,
        'IndexName' => 'city.state-first-index',
        'KeyConditionExpression' => '#citystate = :v_citystate and begins_with(#first, :v_letter)',
        'ExpressionAttributeNames' => ['#first' => 'first', '#citystate' => 'city.state', '#last' => 'last', '#city' => 'city', '#state' => 'state', '#firstlast' => 'first.last'],
        'ExpressionAttributeValues' => [
            ':v_letter' => ['S' => strtolower($letter)],
            ':v_citystate' => ['S' => strtolower(formatForSearch($city) . '.' . $state)],
        ],
        'Select' => 'SPECIFIC_ATTRIBUTES',
        'ProjectionExpression' => '#first, #last, #city, #state, #firstlast',
        'Limit' => 5,
            //'ScanIndexForward' => true,
    ]);
    return $response['Items'];
}

function getAllCities($state) {

    $sdk = new Aws\Sdk([
        'region' => 'us-east-1',
        'version' => 'latest',
        'credentials' => [
            'key' => 'AKIAI4RS42NYAMBCFO4Q',
            'secret' => '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',
        ]
    ]);

    $dynamodb = $sdk->createDynamoDb();
    $tableName = 'yoliya_cities';

    $response = $dynamodb->query([
        'TableName' => $tableName,
        //'IndexName' => 'fName_lName',
        'KeyConditionExpression' => '#state = :v_state',
        'ExpressionAttributeNames' => ['#state' => 'state'],
        'ExpressionAttributeValues' => [
            ':v_state' => ['S' => $state],
        ],
            //'Select' => 'ALL_ATTRIBUTES',
            //'ScanIndexForward' => true,
    ]);

    return $response['Items'];
}

function getFirstByCityState($first, $city, $state) {

    $sdk = new Aws\Sdk([
        'region' => 'us-east-1',
        'version' => 'latest',
        'credentials' => [
            'key' => 'AKIAI4RS42NYAMBCFO4Q',
            'secret' => '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',
        ]
    ]);

    $dynamodb = $sdk->createDynamoDb();
    $tableName = 'yoliya_main';

    $response = $dynamodb->query([
        'TableName' => $tableName,
        'IndexName' => 'city.state-first-index',
        'KeyConditionExpression' => '#citystate = :v_citystate AND #first = :v_first',
        'ExpressionAttributeNames' => ['#citystate' => 'city.state', '#first' => 'first'],
        'ExpressionAttributeValues' => [
            ':v_citystate' => ['S' => formatForSearch($city) . '.' . formatForSearch($state)],
            ':v_first' => ['S' => formatForSearch($first)],
        ],
            //'Select' => 'ALL_ATTRIBUTES',
            //'ScanIndexForward' => true,
    ]);

    return $response['Items'];
}

function getLastByCityState($last, $city, $state) {

    $sdk = new Aws\Sdk([
        'region' => 'us-east-1',
        'version' => 'latest',
        'credentials' => [
            'key' => 'AKIAI4RS42NYAMBCFO4Q',
            'secret' => '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',
        ]
    ]);

    $dynamodb = $sdk->createDynamoDb();
    $tableName = 'yoliya_main';

    $response = $dynamodb->query([
        'TableName' => $tableName,
        'IndexName' => 'city.state-last-index',
        'KeyConditionExpression' => '#citystate = :v_citystate AND #last = :v_last',
        'ExpressionAttributeNames' => ['#citystate' => 'city.state', '#last' => 'last'],
        'ExpressionAttributeValues' => [
            ':v_citystate' => ['S' => formatForSearch($city) . '.' . formatForSearch($state)],
            ':v_last' => ['S' => formatForSearch($last)],
        ],
            //'Select' => 'ALL_ATTRIBUTES',
            //'ScanIndexForward' => true,
    ]);

    return $response['Items'];
}

function getDMAId($city, $state) {

    $sdk = new Aws\Sdk([
        'region' => 'us-east-1',
        'version' => 'latest',
        'credentials' => [
            'key' => 'AKIAI4RS42NYAMBCFO4Q',
            'secret' => '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',
        ]
    ]);

    $dynamodb = $sdk->createDynamoDb();
    $tableName = 'yoliya_dmas';
    $statesArray = statesArray();
    if (strlen($state) == 2) {
        $state = strtolower($statesArray[strtoupper($state)]);
    }
    $city = strtolower(str_replace('.', '', str_replace(' ', '_', $city)));
    $cityState = strtolower($city . '_' . $state);

    $response = $dynamodb->query([
        'TableName' => $tableName,
        'KeyConditionExpression' => '#state = :v_state',
        'ExpressionAttributeNames' => ['#state' => 'city.state'],
        'ExpressionAttributeValues' => [
            ':v_state' => ['S' => $cityState]
        ],
            //'Select' => 'ALL_ATTRIBUTES',
            //'ScanIndexForward' => true,
    ]);

    if ($response['Items']) {
        return $response['Items'][0]['regionCode']['S'];
    } else {
        return false;
    }
}

function getCitiesByDmaId($DmaId, $limit = 100) {

    $sdk = new Aws\Sdk([
        'region' => 'us-east-1',
        'version' => 'latest',
        'credentials' => [
            'key' => 'AKIAI4RS42NYAMBCFO4Q',
            'secret' => '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',
        ]
    ]);

    $dynamodb = $sdk->createDynamoDb();
    $tableName = 'yoliya_dmas';
    $statesArray = statesArray();

    $response = $dynamodb->query([
        'TableName' => $tableName,
        'IndexName' => 'regionCode-index',
        'KeyConditionExpression' => '#code = :v_code',
        'ExpressionAttributeNames' => ['#code' => 'regionCode'],
        'ExpressionAttributeValues' => [
            ':v_code' => ['S' => $DmaId]
        ],
        //'Select' => 'ALL_ATTRIBUTES',
        //'ScanIndexForward' => true,
        'Limit' => $limit
    ]);

    if ($response['Items']) {
        return $response['Items'];
    } else {
        return false;
    }
}

function getNearByCities($city, $state) {
    $id = getDMAId($city, $state);
    $cities = false;
    if ($id) {
        $cities = getCitiesByDmaId($id);
    }

    if ($cities) {
        return $cities;
    } else {
        return false;
    }
}

function getZips($state) {

    $sdk = new Aws\Sdk([
        'region' => 'us-east-1',
        'version' => 'latest',
        'credentials' => [
            'key' => 'AKIAI4RS42NYAMBCFO4Q',
            'secret' => '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',
        ]
    ]);

    $dynamodb = $sdk->createDynamoDb();
    $tableName = 'yoliya_zips';

    $response = $dynamodb->query([
        'TableName' => $tableName,
        //'IndexName' => 'fName_lName',
        'KeyConditionExpression' => '#state = :v_state',
        'ExpressionAttributeNames' => ['#state' => 'state'],
        'ExpressionAttributeValues' => [
            ':v_state' => ['S' => $state],
        ],
            //'Select' => 'ALL_ATTRIBUTES',
            //'ScanIndexForward' => true,
            //'Limit' => 1000
    ]);

    return $response['Items'];
}

function getListPages($zip, $state) {

    $client = DynamoDbClient::factory([
                'region' => 'us-east-1',
                'version' => 'latest',
                'credentials' => [
                    'key' => 'AKIAI4RS42NYAMBCFO4Q',
                    'secret' => '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',
                ]
    ]);

    $tableName = 'yoliya_sitemaps';

    $iterator = $client->getIterator('Query', array(
        'TableName' => $tableName,
        'IndexName' => 'state-zip-index',
        'KeyConditionExpression' => '#zip = :v_zip and #state = :v_state',
        'ExpressionAttributeNames' => ['#state' => 'state', '#zip' => 'zip', '#firstlastcity' => 'first.last.city', '#firstlast' => 'first.last'],
        'ExpressionAttributeValues' => [
            ':v_state' => ['S' => $state],
            ':v_zip' => ['S' => $zip],
        ],
        'Select' => 'SPECIFIC_ATTRIBUTES',
        'ProjectionExpression' => '#firstlast, #state, #firstlastcity')
    );

    return $iterator;
}

function checkZip($zip, $state) {

    $sdk = new Aws\Sdk([
        'region' => 'us-east-1',
        'version' => 'latest',
        'credentials' => [
            'key' => 'AKIAI4RS42NYAMBCFO4Q',
            'secret' => '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',
            'scheme' => 'http'
        ]
    ]);

    $dynamodb = $sdk->createDynamoDb();
    $tableName = 'yoliya_sitemaps';


    $request = [
        'TableName' => $tableName,
        'IndexName' => 'state-zip-index',
        'KeyConditionExpression' => '#zip = :v_zip and #state = :v_state',
        'ExpressionAttributeNames' => ['#state' => 'state', '#zip' => 'zip'],
        'ExpressionAttributeValues' => [
            ':v_state' => ['S' => $state],
            ':v_zip' => ['S' => $zip]
        ],
        'Limit' => 1
    ];

    $response = $dynamodb->query($request);

    return $response['Items'];
}

function searchVoterRecords($first, $last, $fullAddress, $city, $state) {

    $sdk = new Aws\Sdk([
        'region' => 'us-east-1',
        'version' => 'latest',
        'credentials' => [
            'key' => 'AKIAI4RS42NYAMBCFO4Q',
            'secret' => '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',
        ]
    ]);

    $dynamodb = $sdk->createDynamoDb();
    $tableName = 'yoliya_voterRecords';

    $response = $dynamodb->query([
        'TableName' => $tableName,
        'IndexName' => 'first.last-fullAddress.city.state-index',
        'KeyConditionExpression' => '#firstlast = :v_fl and #addresscitystate = :v_fcs',
        'ExpressionAttributeNames' => ['#firstlast' => 'first.last', '#addresscitystate' => 'fullAddress.city.state'],
        'ExpressionAttributeValues' => [
            ':v_fcs' => ['S' => formatForSearch(trim($fullAddress)) . '.' . formatForSearch(trim($city)) . '.' . trim($state)],
            ':v_fl' => ['S' => formatForSearch($first) . '.' . formatForSearch($last)],
        ],
            //'Select' => 'ALL_ATTRIBUTES',
            //'ScanIndexForward' => true,
    ]);

    return $response['Items'];
}

function getNamesByLetter($city, $state, $letter) {

    $sdk = new Aws\Sdk([
        'region' => 'us-east-1',
        'version' => 'latest',
        'credentials' => [
            'key' => 'AKIAI4RS42NYAMBCFO4Q',
            'secret' => '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',
        ]
    ]);

    $dynamodb = $sdk->createDynamoDb();
    $tableName = 'yoliya_main';

    $response = $dynamodb->query([
        'TableName' => $tableName,
        'IndexName' => 'city-index',
        'KeyConditionExpression' => '#city = :v_city and #state = :v_state and begins_with(#first, ' . $letter . ')',
        'ExpressionAttributeNames' => ['#city' => 'city'],
        'ExpressionAttributeNames' => ['#state' => 'state'],
        'ExpressionAttributeNames' => ['#first' => 'first'],
        'ExpressionAttributeValues' => [
            ':v_city' => ['S' => $city],
            ':v_state' => ['S' => $state],
            ':v_letter' => ['S' => $letter],
        ],
            //'Select' => 'ALL_ATTRIBUTES',
            //'ScanIndexForward' => true,
    ]);

    return $response['Items'];
}

function getLabels($datasetID) {

    $sdk = new Aws\Sdk([
        'region' => 'us-east-1',
        'version' => 'latest',
        'credentials' => [
            'key' => 'AKIAI4RS42NYAMBCFO4Q',
            'secret' => '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',
        ]
    ]);

    $dynamodb = $sdk->createDynamoDb();
    $tableName = 'yoliya_dataMaps';

    $response = $dynamodb->query([
        'TableName' => $tableName,
        //'IndexName' => 'fName_lName',
        'KeyConditionExpression' => '#dt = :v_dt',
        'ExpressionAttributeNames' => ['#dt' => 'datasetID'],
        'ExpressionAttributeValues' => [
            ':v_dt' => ['S' => $datasetID],
        ],
            //'Select' => 'ALL_ATTRIBUTES',
            //'ScanIndexForward' => true,
    ]);

    return $response['Items'];
}

function getAllPrimaryKeys() {

    $sdk = new Aws\Sdk([
        'region' => 'us-east-1',
        'version' => 'latest',
        'credentials' => [
            'key' => 'AKIAI4RS42NYAMBCFO4Q',
            'secret' => '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',
        ]
    ]);

    $dynamodb = $sdk->createDynamoDb();
    $tableName = "yoliya_voterRecords";
    $num = 1;
    do {
        echo "Scanning table $tableName\n";

        $request = [
            'TableName' => 'yoliya_voterRecords',
            'ProjectionExpression' => 'ID',
            'Limit' => 8000
        ];

        # Add the ExclusiveStartKey if we got one back in the previous response
        if (isset($response) && isset($response['LastEvaluatedKey'])) {
            $request['ExclusiveStartKey'] = $response['LastEvaluatedKey'];
        }

        $response = $dynamodb->scan($request);

        foreach ($response['Items'] as $key => $value) {
            echo $num . '. ID: ' . $value['ID']['S'] . "\n";
            $num++;
            echo "\n";
        }
    }
# If there is no LastEvaluatedKey in the response, there are no more items matching this Scan
    while (isset($response['LastEvaluatedKey']) && $num < 100000);
}

function updateName($id) {

    $info = getNameById($id);
    $key = $info['city.state']['S'];
    $hash = $info['fullAddress.last.first.middle']['S'];

    $sdk = new Aws\Sdk([
        'region' => 'us-east-1',
        'version' => 'latest',
        'credentials' => [
            'key' => 'AKIAI4RS42NYAMBCFO4Q',
            'secret' => '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',
        ]
    ]);

    $dynamodb = $sdk->createDynamoDb();

    $response = $dynamodb->updateItem([
        'TableName' => 'yoliya_main',
        'Key' => [
            'city.state' => [
                'S' => $key
            ],
            'fullAddress.last.first.middle' => [
                'S' => $hash
            ]
        ],
        'ExpressionAttributeValues' => [
            ':val' => ['S' => 'true'],
        ],
        'UpdateExpression' => 'set optOut = :val',
            //'ReturnValues' => 'ALL_NEW'
    ]);

    return true;
}

function sendEmail($to, $from, $subject, $text = "", $html = "") {

    $client = SesClient::factory(array(
                'version' => 'latest',
                'region' => 'us-east-1',
                'credentials' => [
                    'key' => 'AKIAI4RS42NYAMBCFO4Q',
                    'secret' => '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',
                ]
    ));

    $request = array();
    $request['Source'] = $from;
    $request['Destination']['ToAddresses'] = array($to);
    $request['Message']['Subject']['Data'] = $subject;
    $request['Message']['Body']['Text']['Data'] = $text;
    $request['Message']['Body']['Html']['Data'] = $html;

    try {
        $result = $client->sendEmail($request);
        $messageId = $result->get('MessageId');
    } catch (Exception $e) {
        
    }
}
