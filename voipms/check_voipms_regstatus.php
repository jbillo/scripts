#!/usr/bin/php
<?php
# Modified from http://wiki.voip.ms/article/Registration_status_on_desktop
include ('class.voipms.php');

// Begin user editable settings block
$api_username = '';		// voip.ms email address
$api_password = '';     // voip.ms API password (not account password)
// End user editable settings block

function usage() {
	global $argv;
	echo <<<TXT
Provides account registration status for voip.ms using their API. Returns an exit code that is compatible with
a Nagios check command (0-3).

Usage: {$argv[0]} account_subaccount [--debug]

Where account_subaccount is the name of the full username at https://www.voip.ms/m/managesubaccount.php.

The --debug flag will output a dump of the response from voip.ms.

TXT;
	exit(3);
}

$argv = isset($_SERVER['argv']) ? $_SERVER['argv'] : array(__FILE__);

if (count($argv) < 2) {
	usage();
}

if (!$api_username or !$api_password) {
	echo "ERROR: please provide API username and password in {$argv[0]}\n";
	exit(3);
}

$voipms = new VoIPms();
$voipms->api_username = $api_username;
$voipms->api_password = $api_password;

// Check designated account from command line
$account = $argv[1];

$response = $voipms->getRegistrationStatus($account);
// Determine if we passed bad credentials
if ($response['status'] != 'success') {
	echo "UNKNOWN: could not connect to voip.ms API ($api_username); status '{$response['status']}'\n";
	exit(3);
}

// Otherwise we're OK; check for registration status
echo "voip.ms: account '$account' registered: '{$response['registered']}'\n";
if (isset($argv[2]) and $argv[2] == '--debug') {
	print_r($response);
}

if ($response['registered'] != 'yes') {
	exit(2);
}

exit(0);
