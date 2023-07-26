@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
                <button id="allow-button">Click here to enable push notifications</button>
                <br>
                <a href="{{route('sendPlayer')}}"> add this device to one signal</a>
                
                <a href="{{route('getDeviceType')}}"> get device</a>
                
                <a href="{{route('sendNotification')}}"> sendNotification</a>
                
                <div class='onesignal-customlink-container'></div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" defer></script>
<script>
  window.OneSignal = window.OneSignal || [];
  OneSignal.push(function() {
    OneSignal.init({
      appId: "e823f973-90b2-4374-8123-b7ed222fac7b",
      safari_web_id: "web.onesignal.auto.668b47bc-14aa-4b15-bbce-a605ba29fca6",
      notifyButton: {
        // enable: true,
      },
      promptOptions: {
          customlink: {
            enabled: true, /* Required to use the Custom Link */
            style: "button", /* Has value of 'button' or 'link' */
            size: "medium", /* One of 'small', 'medium', or 'large' */
            color: {
              button: '#E12D30', /* Color of the button background if style = "button" */
              text: '#FFFFFF', /* Color of the prompt's text */
            },
            text: {
              subscribe: "Subscribe to push notifications", /* Prompt's text when not subscribed */
              unsubscribe: "Unsubscribe from push notifications", /* Prompt's text when subscribed */
            },
            unsubscribeEnabled: true, /* Controls whether the prompt is visible after subscription */
          }
      }
    });
    let externalUserId = "123456789"; // You will supply the external user id to the OneSignal SDK
    OneSignal.setExternalUserId(externalUserId);
    
    OneSignal.on('subscriptionChange', function (isSubscribed) {
        if (isSubscribed) {
          var userId = OneSignal.getUserId();
          console.log('User ID (player_id):', userId);
          // You can use the userId to identify the subscribed user
        } else {
          console.log('User is not subscribed to push notifications.');
        }
      });
  });
  


</script>
@endsection
