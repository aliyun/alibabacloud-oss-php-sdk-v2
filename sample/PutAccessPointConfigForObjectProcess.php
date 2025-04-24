<?php

require_once __DIR__ . '/../vendor/autoload.php';

use AlibabaCloud\Oss\V2 as Oss;

// parse args
$optsdesc = [
    "region" => ['help' => 'The region in which the bucket is located.', 'required' => True],
    "endpoint" => ['help' => 'The domain names that other services can use to access OSS.', 'required' => False],
    "bucket" => ['help' => 'The name of the bucket', 'required' => True],
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
$bucket = $options["bucket"];

// Loading credentials values from the environment variables
$credentialsProvider = new Oss\Credentials\EnvironmentVariableCredentialsProvider();

// Using the SDK's default configuration
$cfg = Oss\Config::loadDefault();
$cfg->setCredentialsProvider($credentialsProvider);
$cfg->setRegion($region);
if (isset($options["endpoint"])) {
    $cfg->setEndpoint($options["endpoint"]);
}

$accountId = "your account id";
$objectProcessName = "access point for object process name";

$client = new Oss\Client($cfg);

$arn = "acs:fc:" . $region . ":" . $accountId . ":services/test-oss-fc.LATEST/functions/" . $objectProcessName;
$roleArn = "acs:ram::" . $accountId . ":role/aliyunfcdefaultrole";
$result = $client->putAccessPointConfigForObjectProcess(new Oss\Models\PutAccessPointConfigForObjectProcessRequest(
    bucket: $bucket,
    accessPointForObjectProcessName: $objectProcessName,
    putAccessPointConfigForObjectProcessConfiguration: new Oss\Models\PutAccessPointConfigForObjectProcessConfiguration(
        publicAccessBlockConfiguration: new Oss\Models\PublicAccessBlockConfiguration(
        blockPublicAccess: true
    ),
        objectProcessConfiguration: new Oss\Models\ObjectProcessConfiguration(
            allowedFeatures: new Oss\Models\AllowedFeatures(['GetObject-Range']),
            transformationConfigurations: new Oss\Models\TransformationConfigurations(
                [
                    new Oss\Models\TransformationConfiguration(
                        actions: new Oss\Models\AccessPointActions(['GetObject']),
                        contentTransformation: new Oss\Models\ContentTransformation(
                            functionCompute: new Oss\Models\FunctionCompute(
                                functionAssumeRoleArn: $roleArn,
                                functionArn: $arn
                            )
                        )
                    )
                ]
            )
        )
    )
));
printf(
    'status code:' . $result->statusCode . PHP_EOL .
    'request id:' . $result->requestId
);