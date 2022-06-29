<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Untitled Document</title>
    <style>
        body {
            margin:0;
            padding:0;
            font-family:Gotham, "Helvetica Neue", Helvetica, Arial, sans-serif;
            font-size:10pt;
        }

        .greenblock {
            width:100%;
            height:30px;
            background:#7fb920;
        }
        .blueblock {
            width:100%;
            height:160px;
            background:#001d45;
        }
        .logo {
            margin-top:12px;
        }
        .wrapper {
            padding:10px;
        }
    </style>
</head>

<body>
<div class="greenblock"></div>
<div class="blueblock">
    <center><img src="{{URL::asset('img/email/logo.png')}}" class="logo"></center>
</div>
<div class="wrapper">
    <table border="0">
        <tr>
            <td><strong>Date: </strong></td>
            <td>{{$data["date"]}}</td>
        </tr>
    </table>
    <p><strong>Message/Query:</strong><br /><br />
        {{$data["message"]}}</p>
    <br />
    <div class="footer">
        <p><strong>Kindest regards,</strong></p>
        <p>The Mega Leads team<br />
            For all Queries contact Rita: 062 472 0770<br />
            rita@megaleads.co.za<br />
            Terms and Conditions</p>
    </div>
</div>

</body>
</html>
