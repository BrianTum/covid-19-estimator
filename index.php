<?php
include_once "src/estimator.php";
include_once "src/classes.php";

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
<title>Estimator - Covid-19 Estimator</title>
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="Covid-19 Estimator for Building SDG Challenge">
<meta name="author" content="BrianTum">
<link rel='stylesheet' href='src/css/main.css'>
<style>
html{scroll-behavior:smooth}body{font-family:Lato,'Helvetica Neue',Helvetica,Arial,sans-serif}h1,h2,h3,h4,h5,h6{font-family:Lato,'Helvetica Neue',Helvetica,Arial,sans-serif;font-weight:700}@font-face{font-family:Lato;font-style:italic;font-weight:700;src:local('Lato Bold Italic'),local('Lato-BoldItalic'),url(https://fonts.gstatic.com/s/lato/v16/S6u_w4BMUTPHjxsI5wq_FQftx9897sxZ.woff2) format('woff2');unicode-range:U+0100-024F,U+0259,U+1E00-1EFF,U+2020,U+20A0-20AB,U+20AD-20CF,U+2113,U+2C60-2C7F,U+A720-A7FF}header.masthead{position:relative;background-color:#008b8b;background:no-repeat center center;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;padding-top:8rem;padding-bottom:8rem;height:100vh}header.masthead .overlay{position:absolute;background-color:#212529;height:100%;width:100%;top:0;left:0}header.masthead h1{font-size:2rem}@media (min-width:768px){header.masthead{padding-top:12rem;padding-bottom:12rem}header.masthead h1{font-size:3rem}}.features-icons{position:relative;padding-top:7rem;padding-bottom:7rem; background-color:white;}.float{position:absolute;width:60px;height:60px;bottom:40px;right:40px;background-color:#0c9;color:#fff;border-radius:50px;text-align:center;box-shadow:2px 2px 3px #999}.my-float{margin-top:22px}
</style>
</head>
<body translate="no">
<html lang="en">
<body>
<header class="masthead text-white text-center">
    <div class="overlay"></div>
    <div class="container">
        <div class="row neumorphism-1">
            <div class="col-xl-9 mx-auto">
            <h2 class="mb-5">Covid-19 Estimator</h2><br>
            <h4>Kindly fill this form</h4>
            </div>
            <div class="col-md-10 col-lg-8 col-xl-7 mx-auto">
                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <div class="form-row" >
                        <label for="data-population" class="col-md-2">
                            Population
                            <input required readonly class="form-control form-control-sm" type="number" name="data-population" placeholder="Population">
                        </label>
                        <label for="data-time-to-elapse" class="col-md-2">
                            Time
                            <input required readonly class="form-control form-control-sm" type="number" name="data-time-to-elapse" placeholder="Time">
                        </label>
                        <label for="data-period-type" class="col-md-2">
                            Period
                            <select required readonly class="form-control form-control-sm" name="data-period-type">
                                <option value="days">Days</option>
                                <option value="weeks">Weeks</option>
                                <option value="months">Months</option>
                            </select>
                        </label>
                        <label for="data-reported-cases" class="col-md-3">
                            Reported Cases
                            <input required readonly class="form-control form-control-sm" type="number" name="data-reported-cases" placeholder="Repoted Cases">
                        </label>
                        <label for="data-total-hospital-beds" class="col-md-3">
                            Hospital Beds
                            <input required readonly class="form-control form-control-sm" type="number" name="data-total-hospital-beds" placeholder="Hospital Beds">
                        </label>
                    </div>
                    <div class="row">
                        <button type="submit" class="btn btn-block btn-md btn-primary col-md-12" name="data-go-estimate"><h4>Submit</h4></button>                        
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php
    if (isset($_POST['data-go-estimate'])){ ?>
    <a href="#section2" class="float">
      Scroll Down
    </a>
    <?php }  ?>
</header>

<?php 
  if (isset($_POST['data-go-estimate'])){
      $data = covid19ImpactEstimator($data);
  ?>
<section class="features-icons bg-light text-center" id="section2">
  <div class="container">
    <div class="row">
      <div class="table-responsive">
        <table class="table table-sm table-hover table-striped" style="width:75vw">
          <tbody>
            <thead>
              <td colspan="4"><h2>Input Data</h2></td>
            </thead>          
            <tr>
              <td scope="row"><h6>Region</h6></td>
              <td><?php echo $data['data']['region']['name']; ?></td>
              <td scope="row"><h6>estimation Period</h6></td>
              <td><?php echo $data['data']['timeToElapse'].' '.$data['data']['periodType']; ?></td>
            </tr>
            <tr>
              <td scope="row"><h6>Average Age</h6></td>
              <td><?php echo $data['data']['region']['avgAge']; ?></td>
              <td scope="row"><h6>Reported Cases</h6></td>
              <td><?php echo $data['data']['reportedCases']; ?></td>
            </tr>
            <tr>
              <td scope="row"><h6>Average Daily Income</h6></td>
              <td><?php echo $data['data']['region']['avgDailyIncomeInUSD']; ?></td>
              <td scope="row"><h6>Population</h6></td>
              <td><?php echo $data['data']['population']; ?></td>
            </tr>
            <tr>
              <td scope="row"><h6>Average Daily Income Population</h6></td>
              <td><?php echo $data['data']['region']['avgDailyIncomePopulation']; ?></td>
              <td scope="row"><h6>Total Hospital Beds</h6></td>
              <td><?php echo $data['data']['totalHospitalBeds'];?></td>
            </tr>
          </tbody>
        </table>
      </div>         
    </div>
    <hr>

    <div class="row">
    <div class="table-responsive">
          <h1>Results</h1>
          <table class="table table-sm table-striped table-hover table-dark" style="width:75vw">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Impact</th>
                <th scope="col">Severe Impact</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th scope="row">Currently Infected</th>
                <td><?php echo $data['impact']['currentlyInfected']; ?></td>
                <td><?php echo $data['severeImpact']['currentlyInfected']; ?></td>
              </tr>
              <tr>
                <th scope="row">Infections in <?php echo $data['data']['timeToElapse'].' '.$data['data']['periodType']; ?></th>
                <td><?php echo $data['impact']['infectionsByRequestedTime']; ?></td>
                <td><?php echo $data['severeImpact']['infectionsByRequestedTime']; ?></td>
              </tr>
              <tr>
                <th scope="row">Severe cases in <?php echo $data['data']['timeToElapse'].' '.$data['data']['periodType']; ?></th>
                <td><?php echo $data['impact']['severeCasesByRequestedTime']; ?></td>
                <td><?php echo $data['severeImpact']['severeCasesByRequestedTime']; ?></td>
              </tr>
              <tr>
                <th scope="row">Hospital Beds in <?php echo $data['data']['timeToElapse'].' '.$data['data']['periodType']; ?></th>
                <td><?php echo $data['impact']['hospitalBedsByRequestedTime']; ?></td>
                <td><?php echo $data['severeImpact']['hospitalBedsByRequestedTime']; ?></td>
              </tr>
              <tr>
                <th scope="row">ICU cases in <?php echo $data['data']['timeToElapse'].' '.$data['data']['periodType']; ?></th>
                <td><?php echo $data['impact']['casesForICUByRequestedTime']; ?></td>
                <td><?php echo $data['severeImpact']['casesForICUByRequestedTime']; ?></td>
              </tr>
              <tr>
                <th scope="row">Ventilation cases cases in <?php echo $data['data']['timeToElapse'].' '.$data['data']['periodType']; ?></th>
                <td><?php echo $data['impact']['casesForVentilatorsByRequestedTime']; ?></td>
                <td><?php echo $data['severeImpact']['casesForVentilatorsByRequestedTime']; ?></td>
              </tr>
              <tr>
                <th scope="row">Money to be lost in <?php echo $data['data']['timeToElapse'].' '.$data['data']['periodType']; ?></th>
                <td><?php echo $data['impact']['dollarsInFlight']; ?></td>
                <td><?php echo $data['severeImpact']['dollarsInFlight']; ?></td>
              </tr>
            </tbody>
          </table>
        </div>
    </div>
  </div>
  <a href="#" class="float"><h5>scroll up</h5></a>
</section>
<?php } ?>
<script>
     if ('serviceWorker' in navigator) {
        console.log('CLIENT: service worker registration in progress.');
        navigator.serviceWorker.register('/sw.js').then(function() {
            console.log('CLIENT: service worker registration complete.');
        }, function() {
            console.log('CLIENT: service worker registration failure.');
        });
        } else {
        console.log('CLIENT: service worker is not supported.');
    }
</script>
</body>
</html>