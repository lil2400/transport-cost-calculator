<!DOCTYPE html>
<html lang="en">

<head>
    <title>Transport Cost Calculator from A to B</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="./style.css">
    <script async src="https://maps.googleapis.com/maps/api/js?key=api_key-7ThMDQ&libraries=places&callback=autoComplete">
    </script>
    <script src="./main.js"></script>
</head>

<body>
    <div class="container">
        <h3>Transport Cost Calculator from A to B</h3>
        <p>Use this tool to calculate the cost of the transport.</p>
        <div class="row">
            <div class="col-md-6">
                <form class="form-horizontal " role="form">
                    <div class="row ">
                        <div class="col-xs-4">
                            <img src="./assets/car.png" class="img-responsive img-radio">
                            <button type="button" class="btn btn-primary btn-radio">Car</button>
                            <input type="checkbox" id="left-item" class="hidden">
                        </div>
                        <div class="col-xs-4">
                            <img src="./assets/van.png" class="img-responsive img-radio">
                            <button type="button" class="btn btn-primary btn-radio">Van</button>
                            <input type="checkbox" id="middle-item" class="hidden">
                        </div>
                        <div class="col-xs-4">
                            <img src="./assets/truck.png" class="img-responsive img-radio">
                            <button type="button" class="btn btn-primary btn-radio">Truck</button>
                            <input type="checkbox" id="right-item" class="hidden">
                        </div>
                    </div>
                    <div class="row space-20">
                    </div>
                </form>
            </div>
        </div>
        <form action="index.php" method="post">
            <div class="input-group">
                <span class="input-group-addon">From where?</span>
                <input id="searchTextField1" type="text" class="form-control" name="from" placeholder="Write pickup address">
            </div>
            <br>
            <div class="input-group">
                <span class="input-group-addon"> &nbsp; &nbsp;&nbsp;&nbsp;To where?</span>
                <input id="searchTextField2" type="text" class="form-control" name="to" placeholder="Write the address to">
            </div>
            <br>
            <button type="submit" class="btn btn-default">Calculate</button>
        </form>
        <br>

<?php
$momsp = 25;
$time = 0;
$distance = 0;
$price_km = "8.75";
$start_price = "100";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $from = $_POST["from"];

    $to = $_POST["to"];

    $from = urlencode($from);
    $to = urlencode($to);

    $data = file_get_contents(
        "https://maps.googleapis.com/maps/api/distancematrix/json?origins=" .
            $from .
            "&destinations=" .
            $to .
            "&units=km&key=api_key"
    );
    $data = json_decode($data);

    
    foreach ($data->rows[0]->elements as $road) {
        $time += $road->duration->value;
        $distance += $road->distance->value;
    }

    $km = $distance / 1000;
    $km = round($km, 0, PHP_ROUND_HALF_UP);

    echo '<div class="well">';

    echo "<dl>";
    echo "<dt>From</dt>";
    echo "<dd>- " . urldecode($from) . "</dd>";
    echo "<dt>To</dt>";
    echo "<dd>- " . urldecode($to) . "</dd>";
    echo "<dt>Time</dt>";
    echo "<dd>- " . gmdate("H:i", $time) . "</dd>";
    echo "<dt>Distance</dt>";
    echo "<dd>- " . $km . " km</dd><br>";

    echo "</dl>";

    $tot = ($km * $price_km) + $start_price; //calculate the price by km and start price!
    echo "price ex moms: " . number_format($tot, 2);
    echo "<br>moms: " . number_format($tot * ($momsp / 100) );
    $moms = $tot * ($momsp / 100); //calculate VAT
    $tot = $tot * ((100 + $momsp) / 100);


    
        echo '<h1>Total: <span class="label label-success">' .
            number_format($tot, 2).
            " dkk</span></h1>";
    
}
?>


</div>
</body>
</html>
