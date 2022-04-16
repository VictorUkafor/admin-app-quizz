<html>
<head></head>
<body>
<h1>Reset Your  Password</h1>
<p>You have requested to reset your password. To reset your password, click below:</p>
<p> <a href="{{route('auth.password.verification',['token'=>$user['user_token']])}}">CLICK HERE</a></p>
<p>if you did not request to reset your password, please disregard this email and your account will not be modified.</p>
<p>Regards,</p>
<p>List Grow Team</p>
</body>
</html>
