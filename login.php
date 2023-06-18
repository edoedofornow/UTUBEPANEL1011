<?php
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username === 'Anas' && $password === 'a124') {
        // Redirect to the dashboard if login is successful
        header('Location: dashboard.html');

        // Log the login activity
        $log = "User: $username | IP: ".$_SERVER['REMOTE_ADDR']." | Date/Time: ".date('Y-m-d H:i:s')."\n";
        file_put_contents('login_log.txt', $log, FILE_APPEND);

        // Send login information to Discord
        $webhookUrl = "https://discord.com/api/webhooks/1119981371830579260/zIOsn59JZqEcGlVUdaypTZcRGAX9W1pb8rC5S1YGBGgMFB9ICREtqm8br0zS2G0bpR0q";
        $message = "User: $username logged in\nIP: ".$_SERVER['REMOTE_ADDR']."\nDate/Time: ".date('Y-m-d H:i:s');
        
        $data = array('content' => $message);
        $options = array(
            'http' => array(
                'header'  => "Content-type: application/json",
                'method'  => 'POST',
                'content' => json_encode($data)
            )
        );
        $context = stream_context_create($options);
        $result = file_get_contents($webhookUrl, false, $context);

        // Alternative cURL method
        /*
        $ch = curl_init($webhookUrl);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        */
    } else {
        // Redirect back to the login page with an error message
        header('Location: login.html?error=1');
    }
?>
