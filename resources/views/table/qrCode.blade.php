<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Qr Code</title>
    <script type="text/javascript" src="{{asset('qrCode/qrcode.js')}}"></script>
</head>
<body>
    <div id="qrCode"></div>
    <script type="text/javascript">
    var qrcode = new QRCode(document.getElementById("qrCode"), {
        text: "{{$table->hash}}",
        width: 500,
        height: 500,
        colorDark : "#000000",
        colorLight : "#ffffff",
        correctLevel : QRCode.CorrectLevel.H
    });
    </script>
</body>
</html>
