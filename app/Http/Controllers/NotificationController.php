<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DateTime;
use Illuminate\Support\Str;
use onesignal\client\api\DefaultApi;
use onesignal\client\Configuration;
use onesignal\client\model\GetNotificationRequestBody;
use onesignal\client\model\Notification;
use onesignal\client\model\StringMap;
use onesignal\client\model\Player;
use onesignal\client\model\UpdatePlayerTagsRequestBody;
use onesignal\client\model\ExportPlayersRequestBody;
use onesignal\client\model\Segment;
use onesignal\client\model\FilterExpressions;
use PHPUnit\Framework\TestCase;
use GuzzleHttp;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;

class NotificationController extends Controller
{
    protected $appId;
    protected $appKeyToken;
    protected $userKeyToken;

    function __construct()
    {
        $this->appId = "e823f973-90b2-4374-8123-b7ed222fac7b";
        $this->appKeyToken = "OWI1ZTI4ZTgtNTQ1Yi00YTJmLWE3YzUtNWJkNzhmMzlkY2Fm";
        $this->userKeyToken = "MjdkOWE0MDEtN2VjNy00N2RlLWJiNzMtOGI4MTgzZmUyNWJi";
    }


    public function sendNotification(Request $request)
    {
        $config = Configuration::getDefaultConfiguration()
            ->setAppKeyToken($this->appKeyToken)
            ->setUserKeyToken($this->userKeyToken);
    
        $apiInstance = new DefaultApi(new GuzzleHttp\Client(), $config);
    
        $content = new StringMap();
        $content->setEn('Hello, this is a test notification.');
    
        $notification = new Notification();
        $notification->setAppId($this->appId);
        // $notification->setExternalId(Str::uuid('123456')->toString());
        $notification->setContents($content);
        $notification->setIncludedSegments(['Subscribed Users', 'Active Users']);
        
        // Attach the image to the notification
        $imageUrl = asset('banana.jpg'); // Replace with the URL of your image
        $notification->setBigPicture($imageUrl);    // for android
        $notification->setChromeWebImage($imageUrl); //for chrome
        $notification->setIosAttachments('{"id1": "https://domain.com/image.jpg\"}');
    
        // Set the URL to redirect on click
        $url = 'https://www.google.com'; // Replace with the URL you want to redirect to
        $notification->setUrl($url);
    
        $result = $apiInstance->createNotification($notification);
        print_r($result);
    }

    function getUserDetails($playerId)
    {
        $response = Http::withHeaders([
        'Authorization' => "Basic " . base64_encode("$this->userKeyToken:")
        ])->get("https://onesignal.com/api/v1/players/{$playerId}");
    
        if ($response->successful()) {
            $userData = $response->json();
            return $userData;
        } else {
            // Handle unsuccessful request
            dd($response);
        }
    }
    
}
