<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <script>

        const test = async () => {
            const response = await fetch('https://bc96-102-184-145-158.ngrok.io/api/user/phoneLogin', {
                method: 'POST',
            });
            //const result = await response.json();
            console.log(response);
        }
        test();
    </script>
</body>

</html>