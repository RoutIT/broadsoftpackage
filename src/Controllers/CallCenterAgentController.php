<?php

namespace jvleeuwen\broadsoft;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use jvleeuwen\broadsoft\CallCenterAgentEvent;



class CallCenterAgentController extends Controller
{

    public function TestPage()
    {
        return view('broadsoft::callcenteragent');
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
            return json_encode($data);
            
            # implement logging here, so a log file will be genereated and these kind of events can be converted to methods.
        }
        
    }

    /*
        Parse the Agent State Events
    */
    protected function AgentStateEvent($xml)
    {
        $AgentStateEvent = array(
            "eventID" => (string)$xml->eventID,
            "sequenceNumber" => (int)$xml->sequenceNumber,
            "subscriptionId" => (string)$xml->subscriptionId,
            "targetId" => (string)$xml->targetId,
            "state" => (string)$xml->eventData->agentStateInfo->state,
            "stateTimestamp" => (int)$xml->eventData->agentStateInfo->stateTimestamp->value,
            "signInTimestamp" => (int)$xml->eventData->agentStateInfo->signInTimestamp,
            "totalAvailableTime" => (int)$xml->eventData->agentStateInfo->totalAvailableTime,
            "averageWrapUpTime" => (int)$xml->eventData->agentStateInfo->averageWrapUpTime->value,
        );
        event(new Events\CallCenterAgentEvent($AgentStateEvent));
        // return json_encode($AgentStateEvent);
        return Null;
    }

    protected function AgentSubscriptionEvent($xml)
    {
        return json_encode($xml);
    }

    protected function SubscriptionTerminatedEvent($xml)
    {
        return json_encode($xml);   
    }

    protected function ACDAgentJoinUpdateEvent($xml)
    {
        return json_encode($xml);  
    }
}
