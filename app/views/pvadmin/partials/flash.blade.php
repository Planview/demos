@if (Session::has('message'))
    <div class="session-message">
        {{ Session::get('message') }}
        @if (Session::has('emailIsr') && true === Session::get('emailIsr'))
            {{-- email new user info to the ISR --}}
            <p>*This information will be automatically emailed to you.</p>
            <?php
            $to = Auth::user()->email;
            $subject = "Access to the Planview Product Demo site";

            $message = "
            <html>
            <head>
            <title>Access to the Planview Product Demo site</title>
            </head>
            <body style=\"font-family: 'Avenir W01',Arial,sans-serif;\">
            <p>Hello,</p>
            <p>You now have access to the Planview Product Demo site:</p>
            <ul>
                <li>Login Email: " . Session::get('userEmail') . "</li>
                <li>Password: " . Session::get('userPassword') . "</li>
                <li>Expiration Date: " . Session::get('userExpirationDate') . "</li>
                <li>URL: <a href=\"http://demos.planview.com/\" title=\"Planview Product Demos\">http://demos.planview.com/</a></li>
            </ul>
            </body>
            </html>
            ";

            // Always set content-type when sending HTML email
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

            // More headers
            $headers .= 'From: <webmaster@planview.com>' . "\r\n";
            // $headers .= 'Cc: myboss@planview.com' . "\r\n";

            mail($to,$subject,$message,$headers);
            ?>
        @endif
    </div>
@elseif (Session::has('error'))
    {{ Button::danger(Session::get('error')) }}
@endif
