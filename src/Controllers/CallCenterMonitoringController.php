<?php

namespace jvleeuwen\broadsoft\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use jvleeuwen\broadsoft\Events\CallCenterAgentEvent;
use jvleeuwen\broadsoft\Controllers\EmailController;

class CallCenterMonitoringController extends Controller
{

    public function __construct($bsUser, EmailController $email)
    {
        $this->email = $email;
    }
    /*
        Handle incomming XML messages for the Call Center Agent
    */
    public function Incomming(Request $request)
    {
    	$req = $request->getContent();
        $xml = simplexml_load_string($req, null, 0, 'xsi', true);
        return $this->GetEventType($xml);
    }

    /*
        Get the event type from xml data
    */
    protected function GetEventType($xml)
    {
        $type = str_replace('xsi:','', (string)$xml->eventData[0]->attributes('xsi1', true)->type);

        try {
            return $this->$type($xml); # Call the type function like AgentStateEvent for further XML handling    
        }
        catch(\BadMethodCallException $e)
        {
            $data = array(
                'class' => __CLASS__,
                'method' => $type,
                'message'=> 'Invalid method, this incident will be reported',
                'data' => json_decode(json_encode($xml)),
                'trace' => (string)$e
            );
            $this->email->sendDebug( __CLASS__, $type, json_encode($xml), (string)$e);
            return json_encode($data);
            
            # implement logging here, so a log file will be genereated and these kind of events can be converted to methods.
        }
    }
}
