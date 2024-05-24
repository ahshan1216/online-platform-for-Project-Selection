<?php

function notify($topic,$data){

    $api_key="AAAA5ayq89k:APA91bE7C9kkXT5XHmLZlEiBSokA38VDLgTzRjb0TgT60TNVj1aorOFet97_VHqL01wcZa7-IaI09IsjBL9yPy19KR-M8nIZmHwNSY2b8FQ85IkN2AeeMtqKvHJGabQuUcSgCpTDjiDb";
    $url="https://fcm.googleapis.com/fcm/send";
    // Prepare the payload
    $fields = array(
        'to' => '/topics/' . $topic,
        'notification' => array(
            'title' => $data['title'],
            'body' => $data['body'],
            'image' => 'https://nubps.xyz/images/apple-touch-icon-114x114.png', // Replace with URL of your custom image
        ),
        'data' => $data, // If you want to include additional data
    );

    $fields = json_encode($fields);
    // Generated by curl-to-PHP: http://incarnate.github.io/curl-to-php/
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, ($fields));

    $headers = array();
    $headers[] = 'Authorization: key ='.$api_key;
    $headers[] = 'Content-Type: application/json';
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $result = curl_exec($ch);
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    }
    curl_close($ch);
}

//$to="fli3jYIsR_2m1uSj78DPKw:APA91bHD03M6NRjpM2gzmQQ5P_sh8w13jAeXeXHmkd7THUUHrk2ZQ5EGVhXzKcN4I-RB8I87fs2ty_Dy1At0NRlO8G0wULQxIeRrgfuXlDvjVyafI8a8VeHPJc2CtwkJhOcM-QUxCB8V";
//fSUSh72IQGOLG2UeJ5R8MY:APA91bE35f9RZg_7FlotFN80l9J0Gdlp3duq5ilVnfXiky9vql273Kc_EVdxzUE4AAYumms-KiI65cZQlW-k2h8jnoKlbP0xX6FygO0N-EzNquY-uf-OP3dY69eJYxJFdcXDQPFxvchS
//fli3jYIsR_2m1uSj78DPKw:APA91bHD03M6NRjpM2gzmQQ5P_sh8w13jAeXeXHmkd7THUUHrk2ZQ5EGVhXzKcN4I-RB8I87fs2ty_Dy1At0NRlO8G0wULQxIeRrgfuXlDvjVyafI8a8VeHPJc2CtwkJhOcM-QUxCB8V

$topic ="weather";


?>