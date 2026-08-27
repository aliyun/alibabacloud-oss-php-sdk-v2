<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use AlibabaCloud\Oss\V2 as Oss;
use AlibabaCloud\Oss\V2\Agentic\BucketSpaceClient;

// parse args
$optsdesc = [
    "region" => ['help' => 'The region in which the bucket is located.', 'required' => True],
    "endpoint" => ['help' => 'The domain names that other services can use to access OSS.', 'required' => False],
    "account-id" => ['help' => 'The ID of the Alibaba Cloud account that owns the bucket.', 'required' => True],
    "bucket" => ['help' => 'The name of the bucket space.', 'required' => True],
    "key" => ['help' => 'The name of the object.', 'required' => True],
];
$longopts = \array_map(function ($key) {
    return "$key:";
}, array_keys($optsdesc));
$options = getopt("", $longopts);
foreach ($optsdesc as $key => $value) {
    if ($value['required'] === True && empty($options[$key])) {
        $help = $value['help'];
        echo "Error: the following arguments are required: --$key, $help";
        exit(1);
    }
}

$region = $options["region"];
$accountId = $options["account-id"];
$bucket = $options["bucket"];
$key = $options["key"];

// Loading credentials values from the environment variables
$credentialsProvider = new Oss\Credentials\EnvironmentVariableCredentialsProvider();

// Using the SDK's default configuration. Both region and account id are required
// because the bucket space client resolves the logical bucket name to its physical form.
$cfg = Oss\Config::loadDefault();
$cfg->setCredentialsProvider($credentialsProvider);
$cfg->setRegion($region);
$cfg->setAccountId($accountId);
if (isset($options["endpoint"])) {
    $cfg->setEndpoint($options["endpoint"]);
}

$client = BucketSpaceClient::newClient($cfg);

try {
    $request = new Oss\Models\PutObjectRequest($bucket, $key);
    $request->body = Oss\Utils::streamFor('Hello OSS');

    $result = $client->putObject($request);

    printf(
        'status code: %d' . PHP_EOL . 'request id: %s' . PHP_EOL . 'etag: %s' . PHP_EOL,
        $result->statusCode,
        $result->requestId,
        $result->etag
    );
} catch (\Throwable $e) {
    $se = null;
    for ($cause = $e; $cause !== null; $cause = $cause->getPrevious()) {
        if ($cause instanceof Oss\Exception\ServiceException) {
            $se = $cause;
            break;
        }
    }
    if ($se !== null) {
        printf('error code: %s' . PHP_EOL . 'error message: %s' . PHP_EOL, $se->getErrorCode(), $se->getErrorMessage());
    } else {
        printf('error: %s' . PHP_EOL, $e->getMessage());
    }
    exit(1);
}
