<?php
include_once "src/estimator.php";

if (isset($_POST['data-go-estimate'])) {
    $population = $_POST['data-population'];
    $time = $_POST['data-time-to-elapse'];
    $period = $_POST['data-period-type'];
    $repotedCases = $_POST['data-reported-cases'];
    $totalHospitalBeds = $_POST['data-total-hospital-beds'];

   $data = array(
        'region' => array(
            'name' => 'Africa',
            'avgAge' => 19.7,
            'avgDailyIncomeInUSD' => 5,
            'avgDailyIncomePopulation' => 0.71
        ),
        'periodType' => $period,
        'timeToElapse' => $time,
        'reportedCases' => $repotedCases,
        'population' => $population,
        'totalHospitalBeds' => $totalHospitalBeds,
    );    
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Estimator</title>
</head>
<body>
    <div class="main">
        <h1 class="headText">
          Estimator
        </h1>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <input type="number" name="data-population" placeholder="Population">
            <input type="number" name="data-time-to-elapse" placeholder="Time">
            <select name="data-period-type">
                <option value="days">Days</option>
                <option value="weeks">Weeks</option>
                <option value="months">Months</option>
            </select>
            <input type="number" name="data-reported-cases" placeholder="Repoted Cases">
            <input type="number" name="data-total-hospital-beds" placeholder="Hospital Beds">
            <button type="submit" name="data-go-estimate">Submit</button>
        </form>

        <br>

        <?php 
        if (isset($_POST['data-go-estimate'])){
            $estimator = covid19ImpactEstimator($data);        
            print_r($estimator);
        }
        ?>
    </div>  
</body>
</html>

