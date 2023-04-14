<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Archivo:wght@400;500&family=Eater&family=Syne+Mono&family=Syne:wght@400;500;600;700&family=Unica+One&display=swap" rel="stylesheet">
    <title>GatoFeeder</title>
    <!-- <link rel="stylesheet" href="css/app.css"> -->
    <link href="{{ URL::asset('/css/styles.css') }}" rel="stylesheet" type="text/css" >
    <script src="{{ URL::asset('/js/addtimer.js') }}" type="text/javascript" ></script>
</head>
<body>
<section class="nav"> 
    <section class="logo"><a href="index.html" class="title"><h1 data-content="Gato">feeder</h1></a></section>
    <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')" class="logoutbtn"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                <img class = "logout" src="{{ URL::asset('/img/door.png') }}"></img>
                            </x-dropdown-link>
                        </form>
    </section>
    <section>
    <br>
    @isset($message)


    <div class="alert">
        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
        {{$message}}
    </div> 

    @endisset
        <div class="ubercard">
            <section class="Schedule">
                <section class="dule">
                <a onclick="showForm()"><img class="menu" src="{{ URL::asset('/img/menu.png') }}"></img></a>
                <section class="scheds">
                    <h2 class="schema">Schedule:</h2>
                </section>
                </section>
            <table>
                <tr class="toptime">
                    <th>Time</th>
                    <th>How much?</th>
                    <th></th>
                </tr>
            @foreach ($food_timers as $timer) 
                <tr> 
                    <td> {{Illuminate\Support\Str::substr($timer->time_to_execute, 0,5)}} </td>
                    <td> {{$timer->amount_in_grams}} grams </td>
                    <td>
                        <form action="{{ route('food_timer.remove', $timer->id)}}" method="post" >
                            @csrf 
                            @method('delete')
                            <button type="submit" class="deletebutton" title="Delete"><img class = "deletebutton"src="{{ URL::asset('/img/delete.png') }}"></img></button>
                        </form>
                    </td>
                </tr>
            @endforeach
                <tr id="formElement" style="display:none";>
                <form action="/set_new_timer" method="post">
                  <td><input type="time" id="time_to_execute" name="time_to_execute" value="08:00"></td>
                  <td><input type="number" id="amount_in_grams" name="amount_in_grams" value="0"></td>
                  <td><input type="submit" id="submitbutton" value="submit"></td>
                <form>
                </tr>
            </table>
        </section>

            <section class="card">
            <a href="/food_now_true" class="button">Feed Gato (15 grams)</a>
            
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
        </div>

        <br><br>
        <a href="/food_is_given">set food_now_flag to 0. returns 0.</a>
        </section>

        <form action="/set_tray_weight" method="post">
            @csrf
            <label for="tray_weight">set tray weight</label>
            <input type="text" id="tray_weight" name="tray_weight">
        </form>

       <form action="/set_stock_weight" method="post">
            @csrf
            <label for="stock_weight">set stock weight</label>
            <input type="text" id="stock_weight" name="stock_weight">
        </form>


        <br><br>
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
        <br>
        <p>last fed: {{ $food_status->updated_at}}</p>
        <br>
        <a href="{{ route('login') }}">login</a>
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
