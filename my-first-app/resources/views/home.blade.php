<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Archivo:wght@400;500&family=Eater&family=Syne+Mono&family=Syne:wght@400;500;600;700&family=Unica+One&display=swap" rel="stylesheet">
    <title>GatoFeeder</title>
    <!-- <link rel="stylesheet" href="css/app.css"> -->
    <style>

        /* section 
        {
            width: 40%;
            padding: 30px;
            margin: 0 auto;
            margin-top:200px;
            background-color: pink;
            border-radius: 12px;
        } */


        :root {
            --accent: #FFB800;
            --dark: #1E2730;
            --darker: #1D252D;
            --white: #ffffff;
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-weight: 500;
            font-family: 'Archivo', sans-serif;
            color: var(--accent);
            background-color: var(--dark);
            font-size: 18px;
        }

        .nav{
        background-color: var(--darker);
        box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
        }

        h1{
            color: var(--white);
            font-size: 2rem;
            font-weight: normal;
            display: flex;
            justify-content: center;
            margin: 0.5rem;
            text-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
        }

        h1:before {
            content: attr(data-content);
            display: flex;
            justify-content: center;
            top: 0;
            left: 0;
            font-size: 2rem;
            overflow: hidden;
            color: var(--accent);
        }

        h2{
            color: var(--dark);
            font-weight: 500;
            text-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
            font-size: 1.4em
        }

        .card{
            display: flex;
            justify-content: center;
            margin: 20px 0%;
        }

        .Schedule{
            display: flex;
            flex-direction: column;
            justify-content: center;
            text-align: center;
            align-items: center;
            background-color: var(--accent);
            border: 3px solid var(--white);
            border-radius: 16px;
            cursor: pointer;
            flex-grow: 1;
            margin: 0% 5%;
            max-width: 600px;
        }

        .Stats {
            display: flex;
            flex-direction: column;
            justify-content: center;
            text-align: center;
            align-items: center;
            background-color: var(--accent);
            border: 3px solid var(--white);
            border-radius: 16px;
            cursor: pointer;
            flex-grow: 1;
            margin: 0% 5%;
            max-width: 600px;
        }

        table{
            width: 100%;
            color: var(--dark);
            border-collapse: collapse;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-top: 3px solid var(--white);
            border-bottom: none;
        }

        .topstat {
            border-top: 3px solid var(--white);
        }

        .bottomstat {
            border-bottom: none;
        }

        .button {
            text-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
            background-color: var(--accent);
            border: 3px solid var(--white);
            border-radius: 16px;
            color: var(--dark);
            font-weight: 500;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: flex;
            flex-direction: column;
            justify-content: center;
            text-align: center;
            align-items: center;
            font-size: 1.5em;
            cursor: pointer;
            flex-grow: 1;
            margin: 0% 5%;
            max-width: 600px;
        }
    </style>
</head>
<body>
<section class="nav"> 
    <a href="index.html"><h1 data-content="Gato">feeder</h1></a>
    </section>
    <section>
        
        <!-- <form action="/set_stock_weight" method="post">
            <label for="weight">set stock weight</label>
            <input type="text" id="weight" name="weight">
            @csrf
        </form>
        
        <br>
        <br>
        <p> food_now_flag in food_status: {{$food_status->food_now_flag}} </p>
        <br>
        <p> Current stock: {{$stock_info->stock_weight_grams}} grams. </p>
        <p> last updated: {{$stock_info->created_at}}</p>
        <br>
        <p> Left in feeding tray: {{$tray_info->tray_weight_grams}} grams.</p>
        <p> last updated: {{$tray_info->created_at}} </p>
        <br> -->

        <br>
        <section class="Schedule">
        <h2>Schedule:</h2>
        <table>
            <tr class="toptime">
                <th>Time</th>
                <th>How much?</th>
                <th>Enabled</th>
                <th></th>
            </tr>
        @foreach ($food_timers as $timer) 
            <tr> 
                <td> {{Illuminate\Support\Str::substr($timer->time_to_execute, 0,5)}} </td>
                <td> {{$timer->amount_in_grams}} grams </td>
                <td> 
                    {{$timer->enabled}} 
                </td>
                <td>
                    <form action="{{ route('food_timer.remove', $timer->id)}}" method="post" >
                        @csrf 
                        @method('delete')
                        <button type="submit" title="Delete">delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </table>
      </section>

        <section class="card">
        <a href="/food_now_true" class="button">Feed Simba</a>
        </section>

        <section class="Stats">
        <h2 class="Statstext">Stats:</h2>
        <table>
        <tr class="topstat">
            <td>Stock: {{$stock_info->stock_weight_grams}}</td>
            <td id="valuestock"></td>  
        </tr>
        <tr class="bottomstat">
             <td class="bottomstat"><!--Fed:--> Remaining in feeding tray: {{$tray_info->tray_weight_grams}} grams</td>
            <td id="valuefed" class="bottomstat"></td>  
        </tr>   
        </table>
        </section>

        <br><br>
        <a href="/food_is_given">set food_now_flag to 0. returns 0.</a>
        </section>

        <form action="/set_stock_weight" method="post">
            @csrf
            <label for="weight">set stock weight</label>
            <input type="text" id="weight" name="weight">
        </form>

        <form action="/set_new_timer" method="post">
            @csrf
            <p>new timer</p>
            <label for="time_to_execute">Time:</label>
            <input type="time" id="time_to_execute" name="time_to_execute" value="08:00">
            <label for="amount_in_grams">Amount in grams:</label>
            <input type="number" id="amount_in_grams" name="amount_in_grams" value="0">
            <label for="timer_enabled">enable timer?</label>
            <input type="checkbox" name="timer_enabled" id="timer_enabled" checked>
        </form>
</body>
</html>
<!-- 
<body>
    <section class="nav"> 
    <a href="index.html"><h1 data-content="Gato">feeder</h1></a>
    </section>
    <section class="card">
    <section class="Schedule">
        <h2>Schedule:</h2>
    <table>
        <tr class="toptime">
            <td id="dawntime">7:30</td>
            <td id="dawnfood">20 kg</td>  
        </tr>
        <tr>
            <td id="noontime">12:30</td>
            <td id="noonfood">40 kg</td>  
        </tr>
        <tr class="bottomtime">
            <td id="dusktime" class="bottomtime">19:30</td>
            <td id="duskfood" class="bottomtime">30 kg</td>  
        </tr>    
    </table>
    </section>
    </section>
    <section class="card">
    <a href="#" class="button">Feed Simba</a>
    </section>
    <section class="card">

    <section class="Stats">
        <h2>Stats:</h2>
    <table>
        <tr class="topstat">
            <td>Stock: {{$stock_info->stock_weight_grams}}</td>
            <td id="valuestock"></td>  
        </tr>
        <tr class="bottomstat">
             <td class="bottomstat">Fed: {{$tray_info->tray_weight_grams}} grams</td>
            <td id="valuefed" class="bottomstat"></td>  
        </tr>   
    </table>
    </section>
</body>
</html> -->
