<!DOCTYPE html>
<html>
<head>
<title>Password Change Notification!</title>
</head>
<body>
<p style="text-align: justify">
    Dear <strong>{{ $details['employee_full_name'] }}</strong>,<br>
    You are receiving this email because the change password is required for the security purpose of 
    your account associated with <strong>{{$details['email'] }}</strong> for the <BILERP> BIL LMS System </strong>.
    To change your password, click on change password:<br><br>
    <button><a class="btn btn-primary" href="{{url('api/forgot-password')}}"><strong>Change Password</strong></a></button><br><br>
    If you did not change the password,you are not able to login system.
    <br><br>
</p>
<p>
    Thank you,<br>
    Bhutan Insurance Limited,<br>
    Providing Security, Building Confidence.
</p>
</body>
</html>