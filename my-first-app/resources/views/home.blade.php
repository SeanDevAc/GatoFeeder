<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/app.css">
    <style>
        body
        {
            box-sizing: border-box;
            background-color: lightblue;
            color: brown;
            font-size: 24px;
            font-family: sans-serif;
            text-align: center;
        }

        a, a:visited, a:active
        {
            color: black;
            text-decoration: none;
        }

        section 
        {
            width: 40%;
            padding: 30px;
            margin: 0 auto;
            margin-top:200px;
            background-color: pink;
            border-radius: 12px;
        }
    </style>
</head>
<body>
    <section>
        
        <br>
        <p> food_now: {{$food_now_status->food_now_flag}}</p>
        <p> stock_info: {{}} </p>
    </section>
</body>
</html>