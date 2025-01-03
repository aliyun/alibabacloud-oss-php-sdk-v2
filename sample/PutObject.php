<?php

require_once __DIR__ . '/../vendor/autoload.php';

use AlibabaCloud\Oss\V2 as Oss;

// parse args
$optsdesc = [
    "region" => ['help'=>'The region in which the bucket is located.', 'required' => True],
    "endpoint" => ['help'=>'The domain names that other services can use to access OSS.', 'required' => False],
    "bucket" => ['help'=>'The name of the bucket', 'required' => True],
    "key" => ['help'=>'The name of the object', 'required' => True],
];
$longopts = \array_map(function($key){return "$key:";}, array_keys($optsdesc));
$options = getopt("", $longopts);
foreach ($optsdesc as $key => $value) {
    if ($value['required'] === True && empty($options[$key])) {
        $help = $value['help'];
        echo "Error: the following arguments are required: --$key, $help";
        exit(1);
    }
}

$region = $options["region"];
$bucket = $options["bucket"];
$key = $options["key"];

// Loading credentials values from the environment variables
$credentialsProvider = new Oss\Credentials\EnvironmentVariableCredentialsProvider();

// Using the SDK's default configuration
$cfg = Oss\Config::loadDefault();
$cfg->setCredentialsProvider($credentialsProvider);
$cfg->setRegion($region);
if (isset($options["endpoint"])) {
    $cfg->setEndpoint($options["endpoint"]);
}

$client = new Oss\Client($cfg);

$data = 'Hello OSS';

$request = new Oss\Models\PutObjectRequest($bucket, $key);
$request->body = Oss\Utils::streamFor($data);

$result = $client->putObject($request);

printf(
    'status code:'. $result->statusCode .PHP_EOL.
    'request id:'. $result->requestId .PHP_EOL.
    'etag:'. $result->etag. PHP_EOL
);