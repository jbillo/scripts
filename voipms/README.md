# voip.ms account/subaccount registration - Nagios plugin

## Purpose
Check the registration status of a given voip.ms account, then return a status code that can be used by Nagios.

## Testing
Was tested on a Debian 6.0 installation with PHP5 (php5-cli) and Nagios 3.2.1. May need SOAP extensions for PHP.

## Usage
* Place the .php files into your Nagios plugins directory. On my Debian install it was `/usr/lib/nagios/plugins`.
* Edit `check_voipms_regstatus.php` and provide `api_username` and `api_password` variables where indicated.
* Review the .cfg files and configure Nagios to your specifications. 
	* `voipms.cfg` provides a suggested command definition
	* `voip_service.cfg` provides a suggested service definition
* Reload your Nagios installation. 

