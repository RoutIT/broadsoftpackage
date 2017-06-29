<?php

namespace jvleeuwen\broadsoft;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use jvleeuwen\broadsoft\CallCenterAgentEvent;

class AdvancedCallController extends Controller
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
        Parse Call Awnsered Events
    */
    protected function CallAnsweredEvent($xml)
    {
        $CallAnsweredEvent = array(
            "eventType" => (string)"CallAnsweredEvent",
            "eventID" => (string)$xml->eventID,
            "sequenceNumber" => (int)$xml->sequenceNumber,
            "subscriptionId" => (string)$xml->subscriptionId,
            "targetId" => (string)$xml->targetId,
            "callId" => (string)$xml->eventData->call->callId,
            "extTrackingId" => (string)$xml->eventData->call->extTrackingId,
            "personality" => (string)$xml->eventData->call->personality,
            "state" => (string)$xml->eventData->call->state,
            "remotePartyName" => (string)$xml->eventData->call->remoteParty->name,
            "remotePartyAddress" => (string)$xml->eventData->call->remoteParty->address,
            "remotePartyUserId" => (string)$xml->eventData->call->remoteParty->userId,
            "remotePartyUserDN" => (string)$xml->eventData->call->remoteParty->userDN,
            "remotePartyCallType" => (string)$xml->eventData->call->remoteParty->callType,
            "endpointAddressOfRecord" => (string)$xml->eventData->call->endpoint->addressOfRecord,
            "appearance" => (int)$xml->eventData->call->appearance,
            "startTime" => (int)$xml->eventData->call->startTime,
            "answerTime" => (int)$xml->eventData->call->answerTime,
            "allowedRecordingControls" => (string)$xml->eventData->call->allowedRecordingControls
        );
        event(new Events\AdvancedCallEvent($CallAnsweredEvent));
        return Null;
    }

    /*
        Parse Call Barged In Events
    */
    protected function CallBargedInEvent($xml)
    {
        $CallBargedInEvent = array(
            "eventType" => (string)"CallBargedInEvent",
            "eventID" => (string)$xml->eventID,
            "sequenceNumber" => (int)$xml->sequenceNumber,
            "subscriptionId" => (string)$xml->subscriptionId,
            "targetId" => (string)$xml->targetId,
            "callId" => (string)$xml->eventData->call->callId,
            "extTrackingId" => (string)$xml->eventData->call->extTrackingId,
            "personality" => (string)$xml->eventData->call->personality,
            "state" => (string)$xml->eventData->call->state,
            "remotePartyName" => (string)$xml->eventData->call->remoteParty->name,
            "remotePartyAddress" => (string)$xml->eventData->call->remoteParty->address,
            "remotePartyUserId" => (string)$xml->eventData->call->remoteParty->userId,
            "remotePartyUserDN" => (string)$xml->eventData->call->remoteParty->userDN,
            "remotePartyCallType" => (string)$xml->eventData->call->remoteParty->callType,
            "endpointAddressOfRecord" => (string)$xml->eventData->call->endpoint->addressOfRecord,
            "appearance" => (int)$xml->eventData->call->appearance,
            "startTime" => (int)$xml->eventData->call->startTime,
            "answerTime" => (int)$xml->eventData->call->answerTime,
            "acdUserId" => (string)$xml->eventData->call->acdCallInfo->acdUserId,
            "acdName" => (string)$xml->eventData->call->acdCallInfo->acdName,
            "acdNumber" => (string)$xml->eventData->call->acdCallInfo->acdNumber,
            "numCallsInQueue" => (int)$xml->eventData->call->acdCallInfo->numCallsInQueue,
            "waitTime" => (int)$xml->eventData->call->acdCallInfo->waitTime,
            "callingPartyInfoName" => (string)$xml->eventData->call->acdCallInfo->callingPartyInfo->name,
            "callingPartyInfoAddress" => (string)$xml->eventData->call->acdCallInfo->callingPartyInfo->address,
            "callingPartyInfoUserId" => (string)$xml->eventData->call->acdCallInfo->callingPartyInfo->userId,
            "callingPartyInfoUserDN" => (string)$xml->eventData->call->acdCallInfo->callingPartyInfo->userDN,
            "callingPartyInfoCallType" => (string)$xml->eventData->call->acdCallInfo->callingPartyInfo->callType,
            "allowedRecordingControls" => (string)$xml->eventData->call->allowedRecordingControls,
            "callType" => (string)$xml->eventData->call->recordingState
        );
        event(new Events\AdvancedCallEvent($CallBargedInEvent));
        return Null;
    }

    /*
        Parse Call Collecting Events
    */
    protected function CallCollectingEvent($xml)
    {
        $CallCollectingEvent = array(
            "eventType" => (string)"CallCollectingEvent",
            "eventID" => (string)$xml->eventID,
            "sequenceNumber" => (int)$xml->sequenceNumber,
            "subscriptionId" => (string)$xml->subscriptionId,
            "targetId" => (string)$xml->targetId,
            "callId" => (string)$xml->eventData->call->callId,
            "extTrackingId" => (string)$xml->eventData->call->extTrackingId,
            "personality" => (string)$xml->eventData->call->personality,
            "state" => (string)$xml->eventData->call->state,
            "remotePartyName" => (string)$xml->eventData->call->remoteParty->name,
            "remotePartyAddress" => (string)$xml->eventData->call->remoteParty->address,
            "remotePartyUserId" => (string)$xml->eventData->call->remoteParty->userId,
            "remotePartyUserDN" => (string)$xml->eventData->call->remoteParty->userDN,
            "remotePartyCallType" => (string)$xml->eventData->call->remoteParty->callType,
            "endpointAddressOfRecord" => (string)$xml->eventData->call->endpoint->addressOfRecord,
            "appearance" => (int)$xml->eventData->call->appearance,
            "startTime" => (int)$xml->eventData->call->startTime
        );
        event(new Events\AdvancedCallEvent($CallCollectingEvent));
        return Null;
    }
    
    /*
        Parse Call Forwarded Events
    */
    protected function CallForwardedEvent($xml)
    {
        $CallForwardedEvent = array(
            "eventType" => (string)"CallForwardedEvent",
            "eventID" => (string)$xml->eventID,
            "sequenceNumber" => (int)$xml->sequenceNumber,
            "subscriptionId" => (string)$xml->subscriptionId,
            "targetId" => (string)$xml->targetId,
            "callId" => (string)$xml->eventData->call->callId,
            "extTrackingId" => (string)$xml->eventData->call->extTrackingId,
            "personality" => (string)$xml->eventData->call->personality,
            "state" => (string)$xml->eventData->call->state,
            "remotePartyName" => (string)$xml->eventData->call->remoteParty->name,
            "remotePartyAddress" => (string)$xml->eventData->call->remoteParty->address,
            "remotePartyUserId" => (string)$xml->eventData->call->remoteParty->userId,
            "remotePartyUserDN" => (string)$xml->eventData->call->remoteParty->userDN,
            "remotePartyCallType" => (string)$xml->eventData->call->remoteParty->callType,
            "endpointAddressOfRecord" => (string)$xml->eventData->call->endpoint->addressOfRecord,
            "appearance" => (int)$xml->eventData->call->appearance,
            "startTime" => (int)$xml->eventData->call->startTime
        );
        event(new Events\AdvancedCallEvent($CallForwardedEvent));
        return Null;
    }

    /*
        Parse Call Held Events
    */
    protected function CallHeldEvent($xml)
    {
        $CallHeldEvent = array(
            "eventType" => (string)"CallHeldEvent",
            "eventID" => (string)$xml->eventID,
            "sequenceNumber" => (int)$xml->sequenceNumber,
            "subscriptionId" => (string)$xml->subscriptionId,
            "targetId" => (string)$xml->targetId,
            "callId" => (string)$xml->eventData->call->callId,
            "extTrackingId" => (string)$xml->eventData->call->extTrackingId,
            "personality" => (string)$xml->eventData->call->personality,
            "state" => (string)$xml->eventData->call->state,
            "remotePartyName" => (string)$xml->eventData->call->remoteParty->name,
            "remotePartyAddress" => (string)$xml->eventData->call->remoteParty->address,
            "remotePartyUserId" => (string)$xml->eventData->call->remoteParty->userId,
            "remotePartyUserDN" => (string)$xml->eventData->call->remoteParty->userDN,
            "remotePartyCallType" => (string)$xml->eventData->call->remoteParty->callType,
            "endpointAddressOfRecord" => (string)$xml->eventData->call->endpoint->addressOfRecord,
            "appearance" => (int)$xml->eventData->call->appearance,
            "startTime" => (int)$xml->eventData->call->startTime,
            "answerTime" => (int)$xml->eventData->call->answerTime,
            "heldTime" => (int)$xml->eventData->call->heldTime,
            "acdUserId" => (string)$xml->eventData->call->acdCallInfo->acdUserId,
            "acdName" => (string)$xml->eventData->call->acdCallInfo->acdName,
            "acdNumber" => (string)$xml->eventData->call->acdCallInfo->acdNumber,
            "numCallsInQueue" => (int)$xml->eventData->call->acdCallInfo->numCallsInQueue,
            "waitTime" => (int)$xml->eventData->call->acdCallInfo->waitTime,
            "callingPartyInfoName" => (string)$xml->eventData->call->acdCallInfo->callingPartyInfo->name,
            "callingPartyInfoAddress" => (string)$xml->eventData->call->acdCallInfo->callingPartyInfo->address,
            "callingPartyInfoCallType" => (string)$xml->eventData->call->acdCallInfo->callingPartyInfo->callType,
            "allowedRecordingControls" => (string)$xml->eventData->call->allowedRecordingControls,
            "recordingState" => (string)$xml->eventData->call->recordingState
        );
        event(new Events\AdvancedCallEvent($CallHeldEvent));
        return Null;
    }

    /*
        Parse Call Originated Events
    */
    protected function CallOriginatedEvent($xml)
    {
        $CallOriginatedEvent = array(
            "eventType" => (string)"CallOriginatedEvent",
            "eventID" => (string)$xml->eventID,
            "sequenceNumber" => (int)$xml->sequenceNumber,
            "subscriptionId" => (string)$xml->subscriptionId,
            "targetId" => (string)$xml->targetId,
            "callId" => (string)$xml->eventData->call->callId,
            "extTrackingId" => (string)$xml->eventData->call->extTrackingId,
            "personality" => (string)$xml->eventData->call->personality,
            "state" => (string)$xml->eventData->call->state,
            "remotePartyName" => (string)$xml->eventData->call->remoteParty->name,
            "remotePartyAddress" => (string)$xml->eventData->call->remoteParty->address,
            "remotePartyUserId" => (string)$xml->eventData->call->remoteParty->userId,
            "remotePartyUserDN" => (string)$xml->eventData->call->remoteParty->userDN,
            "remotePartyCallType" => (string)$xml->eventData->call->remoteParty->callType,
            "endpointAddressOfRecord" => (string)$xml->eventData->call->endpoint->addressOfRecord,
            "appearance" => (int)$xml->eventData->call->appearance,
            "startTime" => (int)$xml->eventData->call->startTime
        );
        event(new Events\AdvancedCallEvent($CallOriginatedEvent));
        return Null;
    }

    /*
        Parse Call Originating Events
    */
    protected function CallOriginatingEvent($xml)
    {
        $CallOriginatingEvent = array(
            "eventType" => (string)"CallOriginatingEvent",
            "eventID" => (string)$xml->eventID,
            "sequenceNumber" => (int)$xml->sequenceNumber,
            "subscriptionId" => (string)$xml->subscriptionId,
            "targetId" => (string)$xml->targetId,
            "callId" => (string)$xml->eventData->call->callId,
            "extTrackingId" => (string)$xml->eventData->call->extTrackingId,
            "personality" => (string)$xml->eventData->call->personality,
            "state" => (string)$xml->eventData->call->state,
            "remotePartyName" => (string)$xml->eventData->call->remoteParty->name,
            "remotePartyAddress" => (string)$xml->eventData->call->remoteParty->address,
            "remotePartyUserId" => (string)$xml->eventData->call->remoteParty->userId,
            "remotePartyUserDN" => (string)$xml->eventData->call->remoteParty->userDN,
            "remotePartyCallType" => (string)$xml->eventData->call->remoteParty->callType,
            "endpointAddressOfRecord" => (string)$xml->eventData->call->endpoint->addressOfRecord,
            "appearance" => (int)$xml->eventData->call->appearance,
            "startTime" => (int)$xml->eventData->call->startTime
        );
        event(new Events\AdvancedCallEvent($CallOriginatingEvent));
        return Null;
    }

    /*
        Parse Call Picked Up Events
    */
    protected function CallPickedUpEvent($xml)
    {
        $CallPickedUpEvent = array(
            "eventType" => (string)"CallPickedUpEvent",
            "eventID" => (string)$xml->eventID,
            "sequenceNumber" => (int)$xml->sequenceNumber,
            "subscriptionId" => (string)$xml->subscriptionId,
            "targetId" => (string)$xml->targetId,
            "callId" => (string)$xml->eventData->call->callId,
            "extTrackingId" => (string)$xml->eventData->call->extTrackingId,
            "personality" => (string)$xml->eventData->call->personality,
            "state" => (string)$xml->eventData->call->state,
            "remotePartyName" => (string)$xml->eventData->call->remoteParty->name,
            "remotePartyAddress" => (string)$xml->eventData->call->remoteParty->address,
            "remotePartyUserId" => (string)$xml->eventData->call->remoteParty->userId,
            "remotePartyUserDN" => (string)$xml->eventData->call->remoteParty->userDN,
            "remotePartyCallType" => (string)$xml->eventData->call->remoteParty->callType,
            "endpointAddressOfRecord" => (string)$xml->eventData->call->endpoint->addressOfRecord,
            "appearance" => (int)$xml->eventData->call->appearance,
            "startTime" => (int)$xml->eventData->call->startTime,
            "answerTime" => (int)$xml->eventData->call->answerTime,
            "allowedRecordingControls" => (string)$xml->eventData->call->allowedRecordingControls
        );
        event(new Events\AdvancedCallEvent($CallPickedUpEvent));
        return Null;
    }

    /*
        Parse Call Received Events
    */
    protected function CallReceivedEvent($xml)
    {
        $redirection = array();
        $redirections = $xml->eventData->call->redirections->redirection;

        foreach($redirections as $red)
        {
            $name = (string)$red->party->name;
            $address = (string)$red->party->address;
            $userId = (string)$red->party->userId;
            $callType = (string)$red->party->callType;
            $reason = (string)$red->reason;
            array_push($redirection, array(
                "name" => $name,
                "address" => $address,
                "userId" => $userId,
                "callType" => $callType,
                "reason" => $reason
            ));
        }

        $CallReceivedEvent = array(
            "eventType" => (string)"CallReceivedEvent",
            "eventID" => (string)$xml->eventID,
            "sequenceNumber" => (int)$xml->sequenceNumber,
            "subscriptionId" => (string)$xml->subscriptionId,
            "targetId" => (string)$xml->targetId,
            "callId" => (string)$xml->eventData->call->callId,
            "extTrackingId" => (string)$xml->eventData->call->extTrackingId,
            "personality" => (string)$xml->eventData->call->personality,
            "state" => (string)$xml->eventData->call->state,
            "remotePartyName" => (string)$xml->eventData->call->remoteParty->name,
            "remotePartyAddress" => (string)$xml->eventData->call->remoteParty->address,
            "remotePartyUserId" => (string)$xml->eventData->call->remoteParty->userId,
            "remotePartyUserDN" => (string)$xml->eventData->call->remoteParty->userDN,
            "remotePartyCallType" => (string)$xml->eventData->call->remoteParty->callType,
            "redirections" => $redirection,
            "startTime" => (int)$xml->eventData->call->startTime,
            "acdUserId" => (string)$xml->eventData->call->acdCallInfo->acdUserId,
            "acdName" => (string)$xml->eventData->call->acdCallInfo->acdName,
            "acdNumber" => (string)$xml->eventData->call->acdCallInfo->acdNumber,
            "numCallsInQueue" => (int)$xml->eventData->call->acdCallInfo->numCallsInQueue,
            "waitTime" => (int)$xml->eventData->call->acdCallInfo->waitTime,
            "callingPartyInfoName" => (string)$xml->eventData->call->acdCallInfo->callingPartyInfo->name,
            "callingPartyInfoAddress" => (string)$xml->eventData->call->acdCallInfo->callingPartyInfo->address,
            "callingPartyInfoCallType" => (string)$xml->eventData->call->acdCallInfo->callingPartyInfo->callType,
        );
        event(new Events\AdvancedCallEvent($CallReceivedEvent));
        return Null;
    }

    /*
        Parse Call Recording Started Events
    */
    protected function CallRecordingStartedEvent($xml)
    {
        $CallRecordingStartedEvent = array(
            "eventType" => (string)"CallRecordingStartedEvent",
            "eventID" => (string)$xml->eventID,
            "sequenceNumber" => (int)$xml->sequenceNumber,
            "subscriptionId" => (string)$xml->subscriptionId,
            "targetId" => (string)$xml->targetId,
            "callId" => (string)$xml->eventData->call->callId,
            "extTrackingId" => (string)$xml->eventData->call->extTrackingId,
            "personality" => (string)$xml->eventData->call->personality,
            "state" => (string)$xml->eventData->call->state,
            "remotePartyName" => (string)$xml->eventData->call->remoteParty->name,
            "remotePartyAddress" => (string)$xml->eventData->call->remoteParty->address,
            "remotePartyUserId" => (string)$xml->eventData->call->remoteParty->userId,
            "remotePartyUserDN" => (string)$xml->eventData->call->remoteParty->userDN,
            "remotePartyCallType" => (string)$xml->eventData->call->remoteParty->callType,
            "startTime" => (int)$xml->eventData->call->startTime,
            "answerTime" => (int)$xml->eventData->call->answerTime,
            "acdUserId" => (string)$xml->eventData->call->acdCallInfo->acdUserId,
            "acdName" => (string)$xml->eventData->call->acdCallInfo->acdName,
            "acdNumber" => (string)$xml->eventData->call->acdCallInfo->acdNumber,
            "numCallsInQueue" => (int)$xml->eventData->call->acdCallInfo->numCallsInQueue,
            "waitTime" => (int)$xml->eventData->call->acdCallInfo->waitTime,
            "callingPartyInfoName" => (string)$xml->eventData->call->acdCallInfo->callingPartyInfo->name,
            "callingPartyInfoAddress" => (string)$xml->eventData->call->acdCallInfo->callingPartyInfo->address,
            "callingPartyInfoCallType" => (string)$xml->eventData->call->acdCallInfo->callingPartyInfo->callType,
            "allowedRecordingControls" => (string)$xml->eventData->call->allowedRecordingControls,
            "recordingState" => (string)$xml->eventData->call->recordingState,
        );
        event(new Events\AdvancedCallEvent($CallRecordingStartedEvent));
        return Null;
    }

    /*
        Parse Call Recording Stopped Events
    */
    protected function CallRecordingStoppedEvent($xml)
    {
        $CallRecordingStoppedEvent = array(
            "eventType" => (string)"CallRecordingStoppedEvent",
            "eventID" => (string)$xml->eventID,
            "sequenceNumber" => (int)$xml->sequenceNumber,
            "subscriptionId" => (string)$xml->subscriptionId,
            "targetId" => (string)$xml->targetId,
            "callId" => (string)$xml->eventData->call->callId,
            "extTrackingId" => (string)$xml->eventData->call->extTrackingId,
            "personality" => (string)$xml->eventData->call->personality,
            "state" => (string)$xml->eventData->call->state,
            "remotePartyName" => (string)$xml->eventData->call->remoteParty->name,
            "remotePartyAddress" => (string)$xml->eventData->call->remoteParty->address,
            "remotePartyUserId" => (string)$xml->eventData->call->remoteParty->userId,
            "remotePartyUserDN" => (string)$xml->eventData->call->remoteParty->userDN,
            "remotePartyCallType" => (string)$xml->eventData->call->remoteParty->callType,
            "appearance" => (int)$xml->eventData->call->appearance,
            "startTime" => (int)$xml->eventData->call->startTime,
            "answerTime" => (int)$xml->eventData->call->answerTime,
            "acdUserId" => (string)$xml->eventData->call->acdCallInfo->acdUserId,
            "acdName" => (string)$xml->eventData->call->acdCallInfo->acdName,
            "acdNumber" => (string)$xml->eventData->call->acdCallInfo->acdNumber,
            "numCallsInQueue" => (int)$xml->eventData->call->acdCallInfo->numCallsInQueue,
            "waitTime" => (int)$xml->eventData->call->acdCallInfo->waitTime,
            "allowedRecordingControls" => (string)$xml->eventData->call->allowedRecordingControls,
            "recordingState" => (string)$xml->eventData->call->recordingState,
            "reason" => (string)$xml->eventData->reason,
        );
        event(new Events\AdvancedCallEvent($CallRecordingStoppedEvent));
        return Null;
    }
}
