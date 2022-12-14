<!DOCTYPE html>
<html>
<head>
<title>Password Change Notification!</title>
</head>
<body>
<p style="text-align: justify">
    Dear <strong>{{ $details['employee_full_name'] }}</strong>,<br>
    You are receiving this email because the change password is required for the security purpose of 
    your account associated with <strong>{{$details['email'] }}</strong> for the<strong> BIL LMS System.</strong>
    <p>To change your password,click on <a class="btn btn-primary" href="{{url('/api/forgot-password')}}"><strong>Change Password.</strong></a>
    Therefore,you are request to change the password, if not you will not able to login.</p>
    <br>
</p>
<p>
    Thank you,<br>
    Bhutan Insurance Limited,<br>
    Providing Security, Building Confidence.
</p>
</body>
</html>