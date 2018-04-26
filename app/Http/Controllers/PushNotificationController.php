<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PushNotificationController extends Controller
{
	public function __construct() {
		return $this->middleware('auth', ['except' => ['pushToken', 'sendPushNotification']]);
	}
   // Adding push token
   public function pushToken(Request $request)
   {
        $pushToken = request()->pushToken;
        $mobileTypeId = request()->mobileTypeId;
        $userId = request()->userId;

        $device = new \App\Device();
        $device->pushToken = $pushToken;
        $device->mobileTypeId = $mobileTypeId;
        $device->userId = $userId;

        try {
            $device->save();
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "Device Token Created Successfully";
            $resp->Status = true;
            $resp->InnerData = $device;
            return response()->json($resp, 200);
        } catch(\Exception $e) {
            $resp = new \App\Http\Helpers\ServiceResponse;
            $resp->Message = "Error While Creating The Device Token";
            $resp->Status = true;
            $resp->InnerData = (object)[];
            return response()->json($resp, 200);
        }
   }

   public function sendPushNotification(\Illuminate\Support\Facades\Request $request)
   {
        $users = $request::get('users');
        $message = $request::get('message');
        $devices = \App\Device::whereIn('userId', $users)->get();

        foreach($devices as $device) {
            try {
                if ($device->mobileTypeId == 2) {
                    // Send the notification to IOS
                    $pushManager    = new \Sly\NotificationPusher\PushManager(\Sly\NotificationPusher\PushManager::ENVIRONMENT_DEV);
                    $apnsAdapter = new \Sly\NotificationPusher\Adapter\Apns(array(
                        'certificate' => app_path().'/developmentCertificate.pem',
                    ));
                    // $feedback = $pushManager->getFeedback($apnsAdapter);
                    // return response()->json($feedback, 200);
                    $devices = new \Sly\NotificationPusher\Collection\DeviceCollection(array(
                        new \Sly\NotificationPusher\Model\Device($device->pushToken),
                    ));
                    $messageToSend = new \Sly\NotificationPusher\Model\Message($message, array(
                        'badge' => 1,
                        'sound' => 'default'
                    ));
                    $push = new \Sly\NotificationPusher\Model\Push($apnsAdapter, $devices, $messageToSend);
                    $pushManager->add($push);
                    $pushManager->push();

                    // foreach($push->getResponses() as $token => $response) {
                    //     return response()->json($response, 200);
                    // }
                    // return response()->json(PushNotification::app('MONTO')->getFeedback(), 200);

                    // \Davibennun\LaravelPushNotification\Facades\PushNotification::app('MONTO')
                    //     ->to($device->pushToken)
                    //     ->send($message);
                }
                else if ($device->mobileTypeId == 1) {
                    // Send the notification to Android
                    $pushManager = new \Sly\NotificationPusher\PushManager(\Sly\NotificationPusher\PushManager::ENVIRONMENT_DEV);
                    $gcmAdapter = new \Sly\NotificationPusher\Adapter\Gcm(array(
                        'apiKey' => 'AAAANK6X3qc:APA91bEx_DwyTkdGEe6LDUP6E4MzFllcCOuCI1Agm0WXDdItjOps-mlJw8Q9AEpVFU8CnzVG90Qv4SAhxP7wUgRtKGlB3rPCanjSy0pja2_4x2ICQNRq5JJskHkG2hwzF50P8pszupPO',
                    ));
                    $devices = new \Sly\NotificationPusher\Collection\DeviceCollection(array(
                        new \Sly\NotificationPusher\Model\Device($device->pushToken),
                    ));
                    $messageToSend = new \Sly\NotificationPusher\Model\Message($message, array(
                        'badge' => 1,
                        'sound' => 'default'
                    ));
                    // $messageToSend = new \Sly\NotificationPusher\Model\Message($message);
                    $push = new \Sly\NotificationPusher\Model\Push($gcmAdapter, $devices, $messageToSend);
                    $pushManager->add($push);
                    $pushManager->push();

                    foreach($push->getResponses() as $token => $response) {
                        return response()->json($response, 200);
                    }

                    // \Davibennun\LaravelPushNotification\Facades\PushNotification::app('MTC')
                    //     ->to($device->pushToken)
                    //     ->send($message);
                }
            } catch (\Exception $e) {
                $resp = new \App\Http\Helpers\ServiceResponse;
                $resp->Message = $e->getMessage();
                $resp->Status = false;
                $resp->InnerData = (object)[];
                return response()->json($resp, 200);
            }
        }

        $resp = new \App\Http\Helpers\ServiceResponse;
        $resp->Message = "Message Sent Successfully";
        $resp->Status = true;
        $resp->InnerData = (object)[];
        return response()->json($resp, 200);
   }
}
