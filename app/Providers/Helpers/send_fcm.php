<?php
use LaravelFCM\Facades\FCM;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use LaravelFCM\Message\PayloadDataBuilder;

function send_fcm($token, $title, $body, $link)
{
    try {
        $optionBuilder = new OptionsBuilder();
        $optionBuilder->setTimeToLive(60);

        $notificationBuilder = new PayloadNotificationBuilder($title);
        $notificationBuilder->setBody($body)
            ->setClickAction($link)
            ->setSound('default');

        $option = $optionBuilder->build();
        $notification = $notificationBuilder->build();

        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->addData(['a_data' => 'my_data']);
        $data = $dataBuilder->build();

        $downstreamResponse = FCM::sendTo($token, $option, $notification, $data);
        $downstreamResponse->numberSuccess();
        $downstreamResponse->numberFailure();
        $downstreamResponse->numberModification();

        //return Array - you must remove all this tokens in your database
        $downstreamResponse->tokensToDelete();

        //return Array (key : oldToken, value : new token - you must change the token in your database )
        $downstreamResponse->tokensToModify();

        //return Array - you should try to resend the message to the tokens in the array
        $downstreamResponse->tokensToRetry();
        return true;

        // return Array (key:token, value:errror) - in production you should remove from your database the tokens
    } catch (\Exception$exception) {
        // logger(['service' => 'FCM Notification', 'content' => $exception->getMessage()]);
        return false;
    }
}
