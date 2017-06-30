<?php

namespace jvleeuwen\broadsoft;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use jvleeuwen\broadsoft\CallCenterAgentEvent;

class CallCenterAgentController extends Controller
{
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
        Parse ACD Agent Join Update Events
    */
    protected function ACDAgentJoinUpdateEvent($xml)
    {
        $ACDAgentJoinUpdateEvent = array(
            "eventType" => (string)"ACDAgentJoinUpdateEvent",
            "eventID" => (string)$xml->eventID,
            "sequenceNumber" => (int)$xml->sequenceNumber,
            "subscriptionId" => (string)$xml->subscriptionId,
            "targetId" => (string)$xml->targetId,
            "acdUserId" => (string)$xml->eventData->ccAgentJoinUpdateData->joinInfo->acdUserId,
            "skillLevel" => (int)$xml->eventData->ccAgentJoinUpdateData->joinInfo->skillLevel
        );
        event(new Events\CallCenterAgentEvent($ACDAgentJoinUpdateEvent));
        return Null;
    }

    /*
        Parse Agent State Events
    */
    protected function AgentStateEvent($xml)
    {
        $AgentStateEvent = array(
            "eventType" => (string)"AgentStateEvent",
            "eventID" => (string)$xml->eventID,
            "sequenceNumber" => (int)$xml->sequenceNumber,
            "subscriptionId" => (string)$xml->subscriptionId,
            "targetId" => (string)$xml->targetId,
            "state" => (string)$xml->eventData->agentStateInfo->state,
            "stateTimestamp" => (int)$xml->eventData->agentStateInfo->stateTimestamp->value,
            "signInTimestamp" => (int)$xml->eventData->agentStateInfo->signInTimestamp,
            "totalAvailableTime" => (int)$xml->eventData->agentStateInfo->totalAvailableTime,
            "averageWrapUpTime" => (int)$xml->eventData->agentStateInfo->averageWrapUpTime->value
        );
        event(new Events\CallCenterAgentEvent($AgentStateEvent));
        return Null;
    }

    /*
        Parse Agent Subscription Events
    */
    protected function AgentSubscriptionEvent($xml)
    {
        $joins = array(); // create empty array and fill it with parsed joinData
        $joinInfos = $xml->eventData->joinData->joinInfos; // this is an array that needs to be parsed
        foreach($joinInfos as $x)
        {
            $acdUserId = (string)$x->joinInfo->acdUserId;
            $skillLevel = (int)$x->joinInfo->skillLevel;
            array_push($joins, array("acdUserId" => $acdUserId, "skillLevel" => $skillLevel));
            
        }
        $AgentSubscriptionEvent = array(
            "eventType" => (string)"AgentSubscriptionEvent",
            "eventID" => (string)$xml->eventID,
            "sequenceNumber" => (int)$xml->sequenceNumber,
            "subscriptionId" => (string)$xml->subscriptionId,
            "targetId" => (string)$xml->targetId,
            "joinData" => $joins,
            "state" => (string)$xml->eventData->stateInfo->state,
            "stateTimestamp" => (int)$xml->eventData->stateInfo->stateTimestamp->value
        );
        event(new Events\CallCenterAgentEvent($AgentSubscriptionEvent));
        return Null;
    }
    
    /*
        Parse Subscription Terminated Events
    */
    protected function SubscriptionTerminatedEvent($xml)
    {   
        $SubscriptionTerminatedEvent = array(
            "eventType" => (string)"SubscriptionTerminatedEvent",
            "eventID" => (string)$xml->eventID,
            "sequenceNumber" => (int)$xml->sequenceNumber,
            "subscriptionId" => (string)$xml->subscriptionId,
            "userId" => (string)$xml->userId,
            "externalApplicationId" => (string)$xml->externalApplicationId,
            "targetId" => (string)$xml->targetId,
            "httpContactUri" => (string)$xml->httpContact->uri
        );
        event(new Events\CallCenterAgentEvent($SubscriptionTerminatedEvent));
        return Null;
    }
}
