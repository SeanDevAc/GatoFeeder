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
        <p> food_now_flag in food_status: {{$food_status->food_now_flag}} </p>
        <br>
        <p> Current stock: {{$stock_info->stock_weight_grams}} grams. 
            last updated: {{$stock_info->created_at}}</p>
        <br>
        <p> tray_info: {{'hoi'}}</p>
        <br>

        <table>
            <tr>
                <th>Time</th>
                <th>How much?</th>
            </tr>
        @foreach ($food_timers as $timer) 
            <tr> 
                <td> {{Illuminate\Support\Str::substr($timer->time_to_execute, 0,5)}} </td>
                <td> {{$timer->amount_in_grams}} grams </td>
            </tr>
        @endforeach

        </table>

        <br><br>
        <a href="/food_now_true">FEED NOW!!!</a>
        <br> <br>
        <a href="/food_is_given">set food_now_flag to 0. returns 0.</a>
    </section>
</body>
</html>