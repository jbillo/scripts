<?
class VoIPms{
    /*******************************************\
     *  VoIPms - API Credentials
    \*******************************************/
    var $api_username   = 'john.doe@mydomain.com';
    var $api_password   = 'johnspassword';
    
    
    
    /*******************************************\
     *  VoIPms - SoapClient / SoapCall
    \*******************************************/
    var $soap_client;
    function soapClient(){
        $this->soap_client = new SoapClient(null, array(
                'location'      => "https://voip.ms/api/v1/server.php",
                'uri'           => "urn://voip.ms",
                'soap_version'  => SOAP_1_2,
                'trace'         => 1 
            )
        );
    }

    function soapCall($function, $params){
        if(!$this->soap_client){$this->soapClient();}
        try { return $this->soap_client->__soapCall($function, $params);}
        catch (SoapFault $e) { trigger_error("SOAP Fault: [{$e->faultcode}] {$e->faultstring}", E_USER_ERROR); }
    }
    

    
    /*******************************************\
     *  VoIPms - API Functions
    \*******************************************/
    
    function addCharge($client, $charge, $description, $test=0){
        $function = "addCharge";
        $params = array(
            "params" => array(
                "api_username"  => $this->api_username,
                "api_password"  => $this->api_password,
                "client"        => $client,
                "charge"        => $charge,
                "description"   => $description,
                "test"			=> $test
                
            )
        );
        return $this->soapCall($function,$params);
    }

    function addPayment($client, $payment, $description, $test=0){
        $function = "addPayment";
        $params = array(
            "params" => array(
                "api_username"  => $this->api_username,
                "api_password"  => $this->api_password,
                "client"        => $client,
                "payment"       => $payment,
                "description"   => $description,
                "test"			=> $test
                
            )
        );
        return $this->soapCall($function,$params);
    }
	
    function cancelDID($did, $cancelcomment, $portout, $test = 0){
        $function = "cancelDID";
        $params = array(
            "params" => array(
                "api_username"  => $this->api_username,
                "api_password"  => $this->api_password,
                "did"           => $did,
                "cancelcomment" => $cancelcomment,
                "portout"       => $portout,
                "test"          => $test
            )
        );
        return $this->soapCall($function,$params);
    }
    
    function connectDID($did, $account, $monthly, $setup, $minute){
        $function = "connectDID";
        $params = array(
            "params" => array(
                "api_username"  => $this->api_username,
                "api_password"  => $this->api_password,
                "did"           => $did,
                "account"       => $account,
                "monthly"       => $monthly,
                "setup"         => $setup,
                "minute"        => $minute
            )
        );
        return $this->soapCall($function,$params);
    }
    
    function createSubAccount(
        $username, $protocol, $description, $auth_type, $password, $ip, $device_type, $callerid_number,
        $lock_international, $international_route, $music_on_hold, $allowed_codecs, $dtmf_mode, $nat, 
        $internal_extension, $internal_voicemail, $internal_dialtime,
        $reseller_client, $reseller_package, $reseller_nextbilling, $reseller_chargesetup
    ){
        $function = "createSubAccount";
        $params = array(
            "params" => array(
                "api_username"          => $this->api_username,
                "api_password"          => $this->api_password,
                "username"              => $username,
                "protocol"              => $protocol,
                "description"           => $description,
                "auth_type"             => $auth_type,
                "password"              => $password,
                "ip"                    => $ip,
                "device_type"           => $device_type,
                "callerid_number"       => $callerid_number,
                "lock_international"    => $lock_international,
                "international_route"   => $international_route,
                "music_on_hold"         => $music_on_hold,
                "allowed_codecs"        => $allowed_codecs,
                "dtmf_mode"             => $dtmf_mode,
                "nat"                   => $nat,
                "internal_extension"    => $internal_extension,
                "internal_voicemail"    => $internal_voicemail, 
                "internal_dialtime"     => $internal_dialtime,
                "reseller_client"       => $reseller_client,
                "reseller_package"      => $reseller_package,
                "reseller_nextbilling"  => $reseller_nextbilling,
                "reseller_chargesetup"  => $reseller_chargesetup
            )
        );
        return $this->soapCall($function,$params);
    }
	
	function createVoicemail(
        $digits, $name, $password, $skip_password, $email, $attach_message, $delete_message, 
        $say_time, $timezone, $say_callerid, $play_instructions, $language
    ){
        $function = "createVoicemail";
        $params = array(
            "params" => array(
                "api_username"      => $this->api_username,
                "api_password"      => $this->api_password,
                "digits"            => $digits,
                "name"              => $name,
                "password"          => $password,
                "skip_password"     => $skip_password,
                "email"             => $email,
                "attach_message"    => $attach_message,
                "delete_message"    => $delete_message,
                "say_time"          => $say_time,
                "timezone"          => $timezone,
                "say_callerid"      => $say_callerid,
                "play_instructions" => $play_instructions,
                "language"          => $language
            )
        );
        return $this->soapCall($function,$params);
    }
    
    function delCallback($callback){
        $function = "delCallback";
        $params = array(
            "params" => array(
                "api_username"  => $this->api_username,
                "api_password"  => $this->api_password,
				"callback"      => $callback
            )
        );
        return $this->soapCall($function,$params);
    }
    
    function delCallerIDFiltering($filtering){
        $function = "delCallerIDFiltering";
        $params = array(
            "params" => array(
                "api_username"  => $this->api_username,
                "api_password"  => $this->api_password,
				"filtering"		=> $filtering
            )
        );
        return $this->soapCall($function,$params);
    }
    
    function delDISA($disa){
        $function = "delDISA";
        $params = array(
            "params" => array(
                "api_username"  => $this->api_username,
                "api_password"  => $this->api_password,
				"disa"          => $disa
            )
        );
        return $this->soapCall($function,$params);
    }
    
    function delForwarding($forwarding){
        $function = "delForwarding";
        $params = array(
            "params" => array(
                "api_username"  => $this->api_username,
                "api_password"  => $this->api_password,
                "forwarding"    => $forwarding
            )
        );
        return $this->soapCall($function,$params);
    }
    
    function delIVR($ivr){
        $function = "delIVR";
        $params = array(
            "params" => array(
                "api_username"  => $this->api_username,
                "api_password"  => $this->api_password,
				"ivr"           => $ivr
            )
        );
        return $this->soapCall($function,$params);
    }
    
	function delMessages($mailbox){
        $function = "delMessages";
        $params = array(
            "params" => array(
                "api_username"  => $this->api_username,
                "api_password"  => $this->api_password,
				"mailbox"       => $mailbox
            )
        );
        return $this->soapCall($function,$params);
    }
	
    function delPhonebook($phonebook){
        $function = "delPhonebook";
        $params = array(
            "params" => array(
                "api_username"  => $this->api_username,
                "api_password"  => $this->api_password,
				"phonebook"		=> $phonebook
            )
        );
        return $this->soapCall($function,$params);
    }
    
    function delRecording($recording){
        $function = "delRecording";
        $params = array(
            "params" => array(
                "api_username"  => $this->api_username,
                "api_password"  => $this->api_password,
				"recording"	    => $recording
            )
        );
        return $this->soapCall($function,$params);
    }
    
    function delRingGroup($ringgroup){
        $function = "delRingGroup";
        $params = array(
            "params" => array(
                "api_username"  => $this->api_username,
                "api_password"  => $this->api_password,
				"ringgroup"     => $ringgroup
            )
        );
        return $this->soapCall($function,$params);
    }
    
    function delSIPURI($sipuri){
        $function = "delSIPURI";
        $params = array(
            "params" => array(
                "api_username"  => $this->api_username,
                "api_password"  => $this->api_password,
				"sipuri"        => $sipuri
            )
        );
        return $this->soapCall($function,$params);
    }
    
    function delSubAccount($id){
        $function = "delSubAccount";
        $params = array(
            "params" => array(
                "api_username"  => $this->api_username,
                "api_password"  => $this->api_password,
                "id"            => $id
            )
        );
        return $this->soapCall($function,$params);
    }
    
    function delTimeCondition($timecondition){
        $function = "delTimeCondition";
        $params = array(
            "params" => array(
                "api_username"  => $this->api_username,
                "api_password"  => $this->api_password,
                "timecondition" => $timecondition
                
            )
        );
        return $this->soapCall($function,$params);
    }
	
	function delVoicemail($mailbox){
        $function = "delVoicemail";
        $params = array(
            "params" => array(
                "api_username"  => $this->api_username,
                "api_password"  => $this->api_password,
				"mailbox"       => $mailbox
            )
        );
        return $this->soapCall($function,$params);
    }
    
    function getAllowedCodecs($codec){
        $function = "getAllowedCodecs";
        $params = array(
            "params" => array(
                "api_username"  => $this->api_username,
                "api_password"  => $this->api_password,
                "codec"         => $codec
            )
        );
        return $this->soapCall($function,$params);
    }
    
    function getAuthTypes($type){
        $function = "getAuthTypes";
        $params = array(
            "params" => array(
                "api_username"  => $this->api_username,
                "api_password"  => $this->api_password,
                "type"          => $type
            )
        );
        return $this->soapCall($function,$params);
    }
    
    function getBalance($advanced){
        $function = "getBalance";
        $params = array(
            "params" => array(
                "api_username"  => $this->api_username,
                "api_password"  => $this->api_password,
                "advanced"      => $advanced
            )
        );
        return $this->soapCall($function,$params);
    }
    
    function getBalanceManagement($balance_management){
        $function = "getBalanceManagement";
        $params = array(
            "params" => array(
                "api_username"          => $this->api_username,
                "api_password"          => $this->api_password,
                "balance_management"    => $balance_management
            )
        );
        return $this->soapCall($function,$params);
    }
    
    function getCallAccounts($client){
        $function = "getCallAccounts";
        $params = array(
            "params" => array(
                "api_username"  => $this->api_username,
                "api_password"  => $this->api_password,
                "client"        => $client
            )
        );
        return $this->soapCall($function,$params);
    }
    
    function getCallbacks($callback){
        $function = "getCallbacks";
        $params = array(
            "params" => array(
                "api_username"  => $this->api_username,
                "api_password"  => $this->api_password,
				"callback"	    => $callback
            )
        );
        return $this->soapCall($function,$params);
    }
    
    function getCallBilling(){
        $function = "getCallBilling";
        $params = array(
            "params" => array(
                "api_username"  => $this->api_username,
                "api_password"  => $this->api_password
            )
        );
        return $this->soapCall($function,$params);
    }
    
    function getCallerIDFiltering($filtering){
        $function = "getCallerIDFiltering";
        $params = array(
            "params" => array(
                "api_username"  => $this->api_username,
                "api_password"  => $this->api_password,
				"filtering"		=> $filtering
            )
        );
        return $this->soapCall($function,$params);
    }
    
    function getCallTypes($client){
        $function = "getCallTypes";
        $params = array(
            "params" => array(
                "api_username"  => $this->api_username,
                "api_password"  => $this->api_password,
                "client"        => $client
            )
        );
        return $this->soapCall($function,$params);
    }
    
    function getCarriers($carrier){
        $function = "getCarriers";
        $params = array(
            "params" => array(
                "api_username"  => $this->api_username,
                "api_password"  => $this->api_password,
                "carrier"       => $carrier
            )
        );
        return $this->soapCall($function,$params);
    }
    
    function getCDR(
        $date_from, $date_to, $answered, $noanswer, $busy, 
        $failed, $timezone, $calltype, $callbilling, $account
    ){
        $function = "getCDR";
        $params = array(
            "params" => array(
                "api_username"  => $this->api_username,
                "api_password"  => $this->api_password,
                "date_from"     => $date_from,
                "date_to"       => $date_to,
                "answered"      => $answered,
                "noanswer"      => $noanswer,
                "busy"          => $busy,
                "failed"        => $failed,
                "timezone"      => $timezone,
                "calltype"      => $calltype,
                "callbilling"   => $callbilling,
                "account"       => $account
            )
        );
        return $this->soapCall($function,$params);
    }
    
    function getCharges($client){
        $function = "getCharges";
        $params = array(
            "params" => array(
                "api_username"  => $this->api_username,
                "api_password"  => $this->api_password,
                "client"        => $client
            )
        );
        return $this->soapCall($function,$params);
    }
    
    function getClientPackages($client){
        $function = "getClientPackages";
        $params = array(
            "params" => array(
                "api_username"  => $this->api_username,
                "api_password"  => $this->api_password,
                "client"        => $client
            )
        );
        return $this->soapCall($function,$params);
    }
    
    function getClients($client){
        $function = "getClients";
        $params = array(
            "params" => array(
                "api_username"  => $this->api_username,
                "api_password"  => $this->api_password,
                "client"        => $client
            )
        );
        return $this->soapCall($function,$params);
    }
    
    function getCountries($country){
        $function = "getCountries";
        $params = array(
            "params" => array(
                "api_username"  => $this->api_username,
                "api_password"  => $this->api_password,
                "country"       => $country
            )
        );
        return $this->soapCall($function,$params);
    }
    
    function getDeposits($client){
        $function = "getDeposits";
        $params = array(
            "params" => array(
                "api_username"  => $this->api_username,
                "api_password"  => $this->api_password,
                "client"        => $client
            )
        );
        return $this->soapCall($function,$params);
    }
    
    function getDeviceTypes($device_type){
        $function = "getDeviceTypes";
        $params = array(
            "params" => array(
                "api_username"  => $this->api_username,
                "api_password"  => $this->api_password,
                "device_type"   => $device_type
            )
        );
        return $this->soapCall($function,$params);
    }
    
    function getDIDCountries($country_id,$type){
        $function = "getDIDCountries";
        $params = array(
            "params" => array(
                "api_username"  => $this->api_username,
                "api_password"  => $this->api_password,
				"country_id"    => $country_id,
				"type"		    => $type
            )
        );
        return $this->soapCall($function,$params);
    }
    
    function getDIDsCAN($province, $ratecenter){
        $function = "getDIDsCAN";
        $params = array(
            "params" => array(
                "api_username"  => $this->api_username,
                "api_password"  => $this->api_password,
                "province"      => $province,
                "ratecenter"    => $ratecenter
            )
        );
        return $this->soapCall($function,$params);
    }
    
    function getDIDsInfo($client, $did){
        $function = "getDIDsInfo";
        $params = array(
            "params" => array(
                "api_username"  => $this->api_username,
                "api_password"  => $this->api_password,
                "client"        => $client,
                "did"           => $did
            )
        );
        return $this->soapCall($function,$params);
    }
    
    function getDIDsInternationalGeographic($country_id){
        $function = "getDIDsInternationalGeographic";
        $params = array(
            "params" => array(
                "api_username"  => $this->api_username,
                "api_password"  => $this->api_password,
				"country_id"    => $country_id
            )
        );
        return $this->soapCall($function,$params);
    }
    
    function getDIDsInternationalNational($country_id){
        $function = "getDIDsInternationalNational";
        $params = array(
            "params" => array(
                "api_username"  => $this->api_username,
                "api_password"  => $this->api_password,
				"country_id"       => $country_id
            )
        );
        return $this->soapCall($function,$params);
    }
    
    function getDIDsInternationalTollFree($country_id){
        $function = "getDIDsInternationalTollFree";
        $params = array(
            "params" => array(
                "api_username"  => $this->api_username,
                "api_password"  => $this->api_password,
				"country_id"    => $country_id
            )
        );
        return $this->soapCall($function,$params);
    }
    
    function orderDIDVirtual(
        $digits, $routing, $failover_busy, $failover_unreachable, $failover_noanswer, 
        $voicemail, $pop, $dialtime, $cnam, $callerid_prefix, $note, $account, $monthly, $setup, $minute, $test
    ){
        $function = "orderDIDVirtual";
        $params = array(
            "params" => array(
                "api_username"  => $this->api_username,
                "api_password"  => $this->api_password,
                "digits"                => $digits,
                "routing"               => $routing,
                "failover_busy"         => $failover_busy,
                "failover_unreachable"  => $failover_unreachable,
                "failover_noanswer"     => $failover_noanswer,
                "voicemail"             => $voicemail,
                "pop"                   => $pop,
                "dialtime"              => $dialtime,
                "cnam"                  => $cnam,
                "callerid_prefix"       => $callerid_prefix,
                "note"                  => $note,
                "account"               => $account,
                "monthly"               => $monthly,
                "setup"                 => $setup,
                "minute"                => $minute,
                "test"                  => $test               
            )
        );
        return $this->soapCall($function,$params);
    }
    
    function getDIDsUSA($state, $ratecenter){
        $function = "getDIDsUSA";
        $params = array(
            "params" => array(
                "api_username"  => $this->api_username,
                "api_password"  => $this->api_password,
                "state"         => $state,
                "ratecenter"    => $ratecenter
            )
        );
        return $this->soapCall($function,$params);
    }
    
    function getDISAs($disa){
        $function = "getDISAs";
        $params = array(
            "params" => array(
                "api_username"  => $this->api_username,
                "api_password"  => $this->api_password,
				"disa"			=> $disa
            )
        );
        return $this->soapCall($function,$params);
    }
    
    function getDTMFModes($dtmf_mode){
        $function = "getDTMFModes";
        $params = array(
            "params" => array(
                "api_username"  => $this->api_username,
                "api_password"  => $this->api_password,
                "dtmf_mode"     => $dtmf_mode
            )
        );
        return $this->soapCall($function,$params);
    }
    
    function getForwardings($forwarding){
        $function = "getForwardings";
        $params = array(
            "params" => array(
                "api_username"  => $this->api_username,
                "api_password"  => $this->api_password,
                "forwarding"    => $forwarding
            )
        );
        return $this->soapCall($function,$params);
    }
    
        function getInternationalTypes($type){
        $function = "getInternationalTypes";
        $params = array(
            "params" => array(
                "api_username"  => $this->api_username,
                "api_password"  => $this->api_password,
				"type"		    => $type
            )
        );
        return $this->soapCall($function,$params);
    }
    
    function getIP(){
        $function = "getIP";
        $params = array(
            "params" => array(
                "api_username"      => $this->api_username,
                "api_password"      => $this->api_password
            )
        );
        return $this->soapCall($function,$params);
    }
    
    function getIVRs($ivr){
        $function = "getIVRs";
        $params = array(
            "params" => array(
                "api_username"  => $this->api_username,
                "api_password"  => $this->api_password,
				"ivr"		    => $ivr
            )
        );
        return $this->soapCall($function,$params);
    }
    
    function getLanguages($language){
        $function = "getLanguages";
        $params = array(
            "params" => array(
                "api_username"  => $this->api_username,
                "api_password"  => $this->api_password,
                "language"      => $language
            )
        );
        return $this->soapCall($function,$params);
    }
    
    function getLockInternational($lock_international){
        $function = "getLockInternational";
        $params = array(
            "params" => array(
                "api_username"          => $this->api_username,
                "api_password"          => $this->api_password,
                "lock_international"    => $lock_international
            )
        );
        return $this->soapCall($function,$params);
    }
    
    function getMusicOnHold($music_on_hold){
        $function = "getMusicOnHold";
        $params = array(
            "params" => array(
                "api_username"  => $this->api_username,
                "api_password"  => $this->api_password,
                "music_on_hold" => $music_on_hold
            )
        );
        return $this->soapCall($function,$params);
    }
    
    function getNAT($nat){
        $function = "getNAT";
        $params = array(
            "params" => array(
                "api_username"  => $this->api_username,
                "api_password"  => $this->api_password,
                "nat"           => $nat
            )
        );
        return $this->soapCall($function,$params);
    }
    
    function getPackages($package){
        $function = "getPackages";
        $params = array(
            "params" => array(
                "api_username"  => $this->api_username,
                "api_password"  => $this->api_password,
                "package"       => $package
            )
        );
        return $this->soapCall($function,$params);
    }
    
    function getPhonebook($phonebook,$name){
        $function = "getPhonebook";
        $params = array(
            "params" => array(
                "api_username"  => $this->api_username,
                "api_password"  => $this->api_password,
				"phonebook"     => $phonebook,
                "name"          => $name
            )
        );
        return $this->soapCall($function,$params);
    }
    
    function getPlayInstructions($play_instructions){
        $function = "getPlayInstructions";
        $params = array(
            "params" => array(
                "api_username"      => $this->api_username,
                "api_password"      => $this->api_password,
                "play_instructions" => $play_instructions
            )
        );
        return $this->soapCall($function,$params);
    }
    
    function getProtocols($protocol){
        $function = "getProtocols";
        $params = array(
            "params" => array(
                "api_username"  => $this->api_username,
                "api_password"  => $this->api_password,
                "protocol"      => $protocol
            )
        );
        return $this->soapCall($function,$params);
    }
    
    function getProvinces(){
        $function = "getProvinces";
        $params = array(
            "params" => array(
                "api_username"  => $this->api_username,
                "api_password"  => $this->api_password
            )
        );
        return $this->soapCall($function,$params);
    }
    
    function getRateCentersCAN($province){
        $function = "getRateCentersCAN";
        $params = array(
            "params" => array(
                "api_username"  => $this->api_username,
                "api_password"  => $this->api_password,
                "province"      => $province
            )
        );
        return $this->soapCall($function,$params);
    }
    
    function getRateCentersUSA($state){
        $function = "getRateCentersUSA";
        $params = array(
            "params" => array(
                "api_username"  => $this->api_username,
                "api_password"  => $this->api_password,
                "state"         => $state
            )
        );
        return $this->soapCall($function,$params);
    }
    
    function getRates($package, $query){
        $function = "getRates";
        $params = array(
            "params" => array(
                "api_username"  => $this->api_username,
                "api_password"  => $this->api_password,
                "package"       => $package,
                "query"         => $query
            )
        );
        return $this->soapCall($function,$params);
    }
    
    function getRecordings($recording){
        $function = "getRecordings";
        $params = array(
            "params" => array(
                "api_username"  => $this->api_username,
                "api_password"  => $this->api_password,
				"recording"     => $recording
            )
        );
        return $this->soapCall($function,$params);
    }
    
    function getRegistrationStatus($account){
        $function = "getRegistrationStatus";
        $params = array(
            "params" => array(
                "api_username"  => $this->api_username,
                "api_password"  => $this->api_password,
                "account"       => $account
            )
        );
        return $this->soapCall($function,$params);
    }
    
    function getResellerBalance($client){
        $function = "getResellerBalance";
        $params = array(
            "params" => array(
                "api_username"  => $this->api_username,
                "api_password"  => $this->api_password,
                "client"        => $client
            )
        );
        return $this->soapCall($function,$params);
    }
    
    function getResellerCDR(
        $date_from, $date_to, $client, $answered, $noanswer, $busy, 
        $failed, $timezone, $calltype, $callbilling, $account
    ){
        $function = "getResellerCDR";
        $params = array(
            "params" => array(
                "api_username"  => $this->api_username,
                "api_password"  => $this->api_password,
                "date_from"     => $date_from,
                "date_to"       => $date_to,
                "client"        => $client,
                "answered"      => $answered,
                "noanswer"      => $noanswer,
                "busy"          => $busy,
                "failed"        => $failed,
                "timezone"      => $timezone,
                "calltype"      => $calltype,
                "callbilling"   => $callbilling,
                "account"       => $account
            )
        );
        return $this->soapCall($function,$params);
    }
    
    function getRingGroups($ring_group){
        $function = "getRingGroups";
        $params = array(
            "params" => array(
                "api_username"  => $this->api_username,
                "api_password"  => $this->api_password,
				"ring_group"    => $ring_group
            )
        );
        return $this->soapCall($function,$params);
    }
    
    function getRoutes($route){
        $function = "getRoutes";
        $params = array(
            "params" => array(
                "api_username"  => $this->api_username,
                "api_password"  => $this->api_password,
                "route"         => $route
            )
        );
        return $this->soapCall($function,$params);
    }
    
    function getServersInfo($server_pop){
        $function = "getServersInfo";
        $params = array(
            "params" => array(
                "api_username"  => $this->api_username,
                "api_password"  => $this->api_password,
                "server_pop"    => $server_pop
            )
        );
        return $this->soapCall($function,$params);
    }
    
    function getSIPURIs($sipuri){
        $function = "getSIPURIs";
        $params = array(
            "params" => array(
                "api_username"  => $this->api_username,
                "api_password"  => $this->api_password,
				"sipuri"        => $sipuri
            )
        );
        return $this->soapCall($function,$params);
    }
    
    function getStates(){
        $function = "getStates";
        $params = array(
            "params" => array(
                "api_username"  => $this->api_username,
                "api_password"  => $this->api_password
            )
        );
        return $this->soapCall($function,$params);
    }
    
    function getSubAccounts($account){
        $function = "getSubAccounts";
        $params = array(
            "params" => array(
                "api_username"  => $this->api_username,
                "api_password"  => $this->api_password,
                "account"       => $account
            )
        );
        return $this->soapCall($function,$params);
    }
    
    function getTimeConditions($timecondition){
        $function = "getTimeConditions";
        $params = array(
            "params" => array(
                "api_username"  => $this->api_username,
                "api_password"  => $this->api_password,
                "timecondition" => $timecondition
                
            )
        );
        return $this->soapCall($function,$params);
    }
    
    function getTimezones($timezone){
        $function = "getTimezones";
        $params = array(
            "params" => array(
                "api_username"  => $this->api_username,
                "api_password"  => $this->api_password,
                "timezone"      => $timezone
            )
        );
        return $this->soapCall($function,$params);
    }
    
    function getVoicemails($mailbox){
        $function = "getVoicemails";
        $params = array(
            "params" => array(
                "api_username"  => $this->api_username,
                "api_password"  => $this->api_password,
                "mailbox"       => $mailbox
            )
        );
        return $this->soapCall($function,$params);
    }
    
    function getVoicemailSetups($voicemailsetup){
        $function = "getVoicemailSetups";
        $params = array(
            "params" => array(
                "api_username"   => $this->api_username,
                "api_password"   => $this->api_password,
				"voicemailsetup" => $voicemailsetup
            )
        );
        return $this->soapCall($function,$params);
    }
    
    function orderDID(
        $did, $routing, $failover_busy, $failover_unreachable, $failover_noanswer, 
        $voicemail, $pop, $dialtime, $cnam, $callerid_prefix, $note, $billing_type,
        $account, $monthly, $setup, $minute, $test = 0
    ){
        $function = "orderDID";
        $params = array(
            "params" => array(
                "api_username"  => $this->api_username,
                "api_password"  => $this->api_password,
                "did"                   => $did,
                "routing"               => $routing,
                "failover_busy"         => $failover_busy,
                "failover_unreachable"  => $failover_unreachable,
                "failover_noanswer"     => $failover_noanswer,
                "voicemail"             => $voicemail,
                "pop"                   => $pop,
                "dialtime"              => $dialtime,
                "cnam"                  => $cnam,
                "callerid_prefix"       => $callerid_prefix,
                "note"                  => $note,
                "billing_type"          => $billing_type,
                "account"               => $account,
                "monthly"               => $monthly,
                "setup"                 => $setup,
                "minute"                => $minute,                
                "test"                  => $test
            )
        );
        return $this->soapCall($function,$params);
    }
    
    function orderDIDInternationalGeographic(
        $location_id, $quantity, $routing, $failover_busy, $failover_unreachable, $failover_noanswer, 
        $voicemail, $pop, $dialtime, $cnam, $callerid_prefix, $note, $account, $monthly, $setup, $minute, $test
    ){
        $function = "orderDIDInternationalGeographic";
        $params = array(
            "params" => array(
                "api_username"  => $this->api_username,
                "api_password"  => $this->api_password,
                "location_id"           => $location_id,
				"quantity"              => $quantity,
                "routing"               => $routing,
                "failover_busy"         => $failover_busy,
                "failover_unreachable"  => $failover_unreachable,
                "failover_noanswer"     => $failover_noanswer,
                "voicemail"             => $voicemail,
                "pop"                   => $pop,
                "dialtime"              => $dialtime,
                "cnam"                  => $cnam,
                "callerid_prefix"       => $callerid_prefix,
                "note"                  => $note,
                "account"               => $account,
                "monthly"               => $monthly,
                "setup"                 => $setup,
                "minute"                => $minute,
                "test"                  => $test               
            )
        );
        return $this->soapCall($function,$params);
    }
    
    function orderDIDInternationalNational(
        $location_id, $quantity, $routing, $failover_busy, $failover_unreachable, $failover_noanswer, 
        $voicemail, $pop, $dialtime, $cnam, $callerid_prefix, $note, $account, $monthly, $setup, $minute, $test
    ){
        $function = "orderDIDInternationalNational";
        $params = array(
            "params" => array(
                "api_username"  => $this->api_username,
                "api_password"  => $this->api_password,
                "location_id"           => $location_id,
				"quantity"              => $quantity,
                "routing"               => $routing,
                "failover_busy"         => $failover_busy,
                "failover_unreachable"  => $failover_unreachable,
                "failover_noanswer"     => $failover_noanswer,
                "voicemail"             => $voicemail,
                "pop"                   => $pop,
                "dialtime"              => $dialtime,
                "cnam"                  => $cnam,
                "callerid_prefix"       => $callerid_prefix,
                "note"                  => $note,
                "account"               => $account,
                "monthly"               => $monthly,
                "setup"                 => $setup,
                "minute"                => $minute,
                "test"                  => $test               
            )
        );
        return $this->soapCall($function,$params);
    }
    
    function orderDIDInterntionalTollFree(
        $location_id, $quantity, $routing, $failover_busy, $failover_unreachable, $failover_noanswer, 
        $voicemail, $pop, $dialtime, $cnam, $callerid_prefix, $note, $account, $monthly, $setup, $minute, $test
    ){
        $function = "orderDIDInterntionalTollFree";
        $params = array(
            "params" => array(
                "api_username"  => $this->api_username,
                "api_password"  => $this->api_password,
                "location_id"           => $location_id,
				"quantity"              => $quantity,
                "routing"               => $routing,
                "failover_busy"         => $failover_busy,
                "failover_unreachable"  => $failover_unreachable,
                "failover_noanswer"     => $failover_noanswer,
                "voicemail"             => $voicemail,
                "pop"                   => $pop,
                "dialtime"              => $dialtime,
                "cnam"                  => $cnam,
                "callerid_prefix"       => $callerid_prefix,
                "note"                  => $note,
                "account"               => $account,
                "monthly"               => $monthly,
                "setup"                 => $setup,
                "minute"                => $minute,
                "test"                  => $test               
            )
        );
        return $this->soapCall($function,$params);
    }
    
    function orderTollFree(
        $did, $routing, $failover_busy, $failover_unreachable, $failover_noanswer, 
        $voicemail, $pop, $dialtime, $cnam, $callerid_prefix, $note,
        $account, $monthly, $setup, $minute, $test = 0
    ){
        $function = "orderTollFree";
        $params = array(
            "params" => array(
                "api_username"  => $this->api_username,
                "api_password"  => $this->api_password,
                "did"                   => $did,
                "routing"               => $routing,
                "failover_busy"         => $failover_busy,
                "failover_unreachable"  => $failover_unreachable,
                "failover_noanswer"     => $failover_noanswer,
                "voicemail"             => $voicemail,
                "pop"                   => $pop,
                "dialtime"              => $dialtime,
                "cnam"                  => $cnam,
                "callerid_prefix"       => $callerid_prefix,
                "note"                  => $note,
                "account"               => $account,
                "monthly"               => $monthly,
                "setup"                 => $setup,
                "minute"                => $minute,                
                "test"                  => $test
            )
        );
        return $this->soapCall($function,$params);
    }
    
    function orderVanity(
        $did, $routing, $failover_busy, $failover_unreachable, $failover_noanswer, 
        $voicemail, $pop, $dialtime, $cnam, $callerid_prefix, $note, $carrier,
        $account, $monthly, $setup, $minute, $test = 0
    ){
        $function = "orderVanity";
        $params = array(
            "params" => array(
                "api_username"  => $this->api_username,
                "api_password"  => $this->api_password,
                "did"                   => $did,
                "routing"               => $routing,
                "failover_busy"         => $failover_busy,
                "failover_unreachable"  => $failover_unreachable,
                "failover_noanswer"     => $failover_noanswer,
                "voicemail"             => $voicemail,
                "pop"                   => $pop,
                "dialtime"              => $dialtime,
                "cnam"                  => $cnam,
                "callerid_prefix"       => $callerid_prefix,
                "note"                  => $note,
                "carrier"               => $carrier,
                "account"               => $account,
                "monthly"               => $monthly,
                "setup"                 => $setup,
                "minute"                => $minute,                
                "test"                  => $test
            )
        );
        return $this->soapCall($function,$params);
    }
    
    function searchDIDsCAN($type, $query, $province){
        $function = "searchDIDsCAN";
        $params = array(
            "params" => array(
                "api_username"  => $this->api_username,
                "api_password"  => $this->api_password,
                "province"      => $province,
                "type"          => $type,
                "query"         => $query
            )
        );
        return $this->soapCall($function,$params);
    }
    
    function searchDIDsUSA($type, $query, $state){
        $function = "searchDIDsUSA";
        $params = array(
            "params" => array(
                "api_username"  => $this->api_username,
                "api_password"  => $this->api_password,
                "state"         => $state,
                "type"          => $type,
                "query"         => $query
            )
        );
        return $this->soapCall($function,$params);
    }
    
    function searchTollFreeCanUS($type,$query){
        $function = "searchTollFreeCanUS";
        $params = array(
            "params" => array(
                "api_username"      => $this->api_username,
                "api_password"      => $this->api_password,
                "type"              => $type,
                "query"             => $query
            )
        );
        return $this->soapCall($function,$params);
    }
    
    function searchTollFreeUSA($type,$query){
        $function = "searchTollFreeUSA";
        $params = array(
            "params" => array(
                "api_username"      => $this->api_username,
                "api_password"      => $this->api_password,
                "type"              => $type,
                "query"             => $query
            )
        );
        return $this->soapCall($function,$params);
    }
    
    function searchVanity($type,$query){
        $function = "searchVanity";
        $params = array(
            "params" => array(
                "api_username"      => $this->api_username,
                "api_password"      => $this->api_password,
                "type"              => $type,
                "query"             => $query
            )
        );
        return $this->soapCall($function,$params);
    }
    
    function setCallback($callback,$description,$number,$delay_before,$response_timeout,$digit_timeout,$callerid_number){
        $function = "setCallback";
        $params = array(
            "params" => array(
                "api_username"    => $this->api_username,
                "api_password"    => $this->api_password,
				"callback"		  => $callback,
				"description"	  => $description,
				"number"		  => $number,
				"delay_before"	  => $delay_before,
				"response_timeout"=> $response_timeout,
				"digit_timeout"   => $digit_timeout,
				"callerid_number" => $callerid_number
            )
        );
        return $this->soapCall($function,$params);
    }
    
    function setCallerIDFiltering($filter,$callerid,$did,$routing,$failover_unreachable,$failover_busy,$failover_noanswer,$note){
        $function = "setCallerIDFiltering";
        $params = array(
            "params" => array(
                "api_username"        => $this->api_username,
                "api_password"        => $this->api_password,
				"filter"		      => $filter,
				"callerid"		      => $callerid,
				"did"			      => $did,
				"routing"	   	      => $routing,
				"failover_unreachable"=> $failover_unreachable,
				"failover_busy"	      => $failover_busy,
				"failover_noanswer"   => $failover_noanswer,
				"note"   			  => $note
				
            )
        );
        return $this->soapCall($function,$params);
    }
    
    function setClient(
        $client, $email, $password, $company, $firstname, $lastname, $address,
        $city, $state, $country, $zip, $phone_number, $balance_management
    ){
        $function = "setClient";
        $params = array(
            "params" => array(
                "api_username"          => $this->api_username,
                "api_password"          => $this->api_password,
                "client"                => $client,
                "email"                 => $email,
                "password"              => $password,
                "company"               => $company,
                "firstname"             => $firstname,
                "lastname"              => $lastname,
                "address"               => $address,
                "city"                  => $city,
                "state"                 => $state,
                "country"               => $country,
                "zip"                   => $zip,
                "phone_number"          => $phone_number,
                "balance_management"    => $balance_management
            )
        );
        return $this->soapCall($function,$params);
    }
    
    function setDIDInfo(
        $did, $routing, $failover_busy, $failover_unreachable, $failover_noanswer, 
        $voicemail, $pop, $dialtime, $cnam, $callerid_prefix, $note
    ){
        $function = "setDIDInfo";
        $params = array(
            "params" => array(
                "api_username"  => $this->api_username,
                "api_password"  => $this->api_password,
                "did"                   => $did,
                "routing"               => $routing,
                "failover_busy"         => $failover_busy,
                "failover_unreachable"  => $failover_unreachable,
                "failover_noanswer"     => $failover_noanswer,
                "voicemail"             => $voicemail,
                "pop"                   => $pop,
                "dialtime"              => $dialtime,
                "cnam"                  => $cnam,
                "callerid_prefix"       => $callerid_prefix,
                "note"                  => $note
            )
        );
        return $this->soapCall($function,$params);
    }
    
    function setDIDPOP($did, $pop){
        $function = "setDIDPOP";
        $params = array(
            "params" => array(
                "api_username"  => $this->api_username,
                "api_password"  => $this->api_password,
                "did"           => $did,
                "pop"    => $pop
            )
        );
        return $this->soapCall($function,$params);
    }
    
    function setDIDRouting($did, $routing){
        $function = "setDIDRouting";
        $params = array(
            "params" => array(
                "api_username"  => $this->api_username,
                "api_password"  => $this->api_password,
                "did"           => $did,
                "routing"       => $routing
            )
        );
        return $this->soapCall($function,$params);
    }
    
    function setDIDVoicemail($did, $voicemail){
        $function = "setDIDVoicemail";
        $params = array(
            "params" => array(
                "api_username"  => $this->api_username,
                "api_password"  => $this->api_password,
                "did"           => $did,
                "voicemail"     => $voicemail
            )
        );
        return $this->soapCall($function,$params);
    }
    
    function setDISA($disa,$name,$pin,$digit_timeout,$callerid_override){
        $function = "setDISA";
        $params = array(
            "params" => array(
                "api_username"     => $this->api_username,
                "api_password"     => $this->api_password,
				"disa"			   => $disa,
				"name"			   => $name,
				"pin"			   => $pin,
				"digit_timeout"	   => $digit_timeout,
				"callerid_override"=> $callerid_override,
            )
        );
        return $this->soapCall($function,$params);
    }
    
    function setForwarding($forwarding, $phone_number, $callerid_override, $description){
        $function = "setForwarding";
        $params = array(
            "params" => array(
                "api_username"  => $this->api_username,
                "api_password"  => $this->api_password,
                "forwarding"        => $forwarding,
                "phone_number"      => $phone_number,
                "callerid_override" => $callerid_override,
                "description"       => $description
            )
        );
        return $this->soapCall($function,$params);
    }
    
    function setIVR($ivr,$name,$recording,$timeout,$language,$voicemailsetup,$choices){
        $function = "setIVR";
        $params = array(
            "params" => array(
                "api_username"   => $this->api_username,
                "api_password"   => $this->api_password,
				"ivr"			 => $ivr,
                "name"		 	 => $name,
				"recording"		 => $recording,
                "timeout"		 => $timeout,
				"language"		 => $language,
				"voicemailsetup" => $voicemailsetup,
                "choices"		 => $choices
            )
        );
        return $this->soapCall($function,$params);
    }
    
    function setPhonebook($phonebook, $speed_dial, $name, $number, $callerid, $note){
        $function = "setPhonebook";
        $params = array(
            "params" => array(
                "api_username"  => $this->api_username,
                "api_password"  => $this->api_password,
				"phonebook"     => $phonebook,
                "speed_dial"    => $speed_dial,
                "name"          => $name,
                "number"        => $number,
                "callerid"      => $callerid,
                "note"          => $note
                
            )
        );
        return $this->soapCall($function,$params);
    }
    
    function setRingGroup($ring_group,$name,$members,$voicemail){
        $function = "setRingGroup";
        $params = array(
            "params" => array(
                "api_username"  => $this->api_username,
                "api_password"  => $this->api_password,
				"ring_group"	=> $ring_group,
				"name"          => $name,
				"members"		=> $members,
				"voicemail"		=> $voicemail
            )
        );
        return $this->soapCall($function,$params);
    }
    
    function setSIPURI($sipuri,$uri,$description){
        $function = "setSIPURI";
        $params = array(
            "params" => array(
                "api_username"  => $this->api_username,
                "api_password"  => $this->api_password,
				"sipuri"        => $sipuri,
				"uri"			=> $uri,
				"description"	=> $description
				
            )
        );
        return $this->soapCall($function,$params);
    }
    
    function setSubAccount(
        $id, $description, $auth_type, $password, $ip, $device_type, $callerid_number, $lock_international,
        $international_route, $music_on_hold, $allowed_codecs, $dtmf_mode, $nat, $internal_extension, $internal_voicemail,
        $internal_dialtime, $reseller_client, $reseller_package, $reseller_nextbilling, $reseller_chargesetup
    ){
        $function = "setSubAccount";
        $params = array(
            "params" => array(
                "api_username"          => $this->api_username,
                "api_password"          => $this->api_password,
                "id"                    => $id,
                "description"           => $description,
                "auth_type"             => $auth_type,
                "password"              => $password,
                "ip"                    => $ip,
                "device_type"           => $device_type,
                "callerid_number"       => $callerid_number,
                "lock_international"    => $lock_international,
                "international_route"   => $international_route,
                "music_on_hold"         => $music_on_hold,
                "allowed_codecs"        => $allowed_codecs,
                "dtmf_mode"             => $dtmf_mode,
                "nat"                   => $nat,
                "internal_extension"    => $internal_extension,
                "internal_voicemail"    => $internal_voicemail, 
                "internal_dialtime"     => $internal_dialtime,
                "reseller_client"       => $reseller_client,
                "reseller_package"      => $reseller_package,
                "reseller_nextbilling"  => $reseller_nextbilling,
                "reseller_chargesetup"  => $reseller_chargesetup
            )
        );
        return $this->soapCall($function,$params);
    }
    
    function setTimeCondition(
        $timecondition, $name, $routing_match, $routing_nomatch, 
        $starthour, $startminute, $endhour, $endminute, $weekdaystart, $weekdayend
    ){
        $function = "setTimeCondition";
        $params = array(
            "params" => array(
                "api_username"      => $this->api_username,
                "api_password"      => $this->api_password,
                "timecondition"     => $timecondition,
                "name"              => $name,
                "routing_match"     => $routing_match,
                "routing_nomatch"   => $routing_nomatch,
                "starthour"         => $starthour,
                "startminute"       => $startminute,
                "endhour"           => $endhour,
                "endminute"         => $endminute,
                "weekdaystart"      => $weekdaystart,
                "weekdayend"        => $weekdayend
            )
        );
        return $this->soapCall($function,$params);
    }
	
    function setVoicemail(
        $mailbox, $name, $password, $skip_password, $email, $attach_message, $delete_message, 
        $say_time, $timezone, $say_callerid, $play_instructions, $language
    ){
        $function = "setVoicemail";
        $params = array(
            "params" => array(
                "api_username"      => $this->api_username,
                "api_password"      => $this->api_password,
                "mailbox"           => $mailbox,
                "name"              => $name,
                "password"          => $password,
                "skip_password"     => $skip_password,
                "email"             => $email,
                "attach_message"    => $attach_message,
                "delete_message"    => $delete_message,
                "say_time"          => $say_time,
                "timezone"          => $timezone,
                "say_callerid"      => $say_callerid,
                "play_instructions" => $play_instructions,
                "language"          => $language
            )
        );
        return $this->soapCall($function,$params);
    }
    
    function signupClient(
        $firstname, $lastname, $company, $address, $city, $state, $country, $zip, $phone_number, 
        $email, $confirm_email, $password, $confirm_password, $activate, $balance_management
    ){
        $function = "signupClient";
        $params = array(
            "params" => array(
                "api_username"      => $this->api_username,
                "api_password"      => $this->api_password,
                "firstname"         => $firstname,
                "lastname"          => $lastname,
                "company"           => $company,
                "address"           => $address,
                "city"              => $city,
                "state"             => $state,
                "country"           => $country,
                "zip"               => $zip,
                "phone_number"      => $phone_number,
                "email"             => $email,
                "confirm_email"     => $confirm_email,
                "password"          => $password,
                "confirm_password"  => $confirm_password,
                "activate"          => $activate,
                "balance_management"=> $balance_management
            )
        );
        return $this->soapCall($function,$params);
    }
   
    function unconnectDID($did, $routing){
        $function = "unconnectDID";
        $params = array(
            "params" => array(
                "api_username"  => $this->api_username,
                "api_password"  => $this->api_password,
                "did"           => $did
            )
        );
        return $this->soapCall($function,$params);
    }
	
    
}
?>