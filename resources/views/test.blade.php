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
            const response = await fetch('http://localhost:8000/api/user/phoneLogin', {
                method: 'POST',
            });
            //const result = await response.json();
            console.log(response);
        }
        test();
    </script>
</body>

</html>