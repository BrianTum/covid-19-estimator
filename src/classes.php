<?php

class estimator {
    public $regName;
    public $regAvgAge;
    public $regAvgDailyIncomeInUSD;
    public $regAvgDailyIncomePopulation;
  
    public $periodType;
    public $timeToElapse;
    public $reportedCases;
    public $population;
    public $totalHospitalBeds;
  
    public $input;
    public $impact;
    public $severeImpact;
  
    
  
    public function __construct(array $data){
      $this->regName = $data['region']['name'];
      $this->regAvgAg = $data['region']['avgAge'];
      $this->regAvgDailyIncomeInUSD = $data['region']['avgDailyIncomeInUSD'];
      $this->regAvgDailyIncomePopulation = $data['region']['avgDailyIncomePopulation'];
  
      $this->periodType = $data['periodType'];
      $this->timeToElapse = $data['timeToElapse'];
      $this->reportedCases = $data['reportedCases'];
      $this->population = $data['population'];
      $this->totalHospitalBeds = $data['totalHospitalBeds'];    
    }
  
    public function getData() {    
       $this->input = array(
          'region' => array(
              'name' => $this->regName,
              'avgAge' => $this->regAvgAg,
              'avgDailyIncomeInUSD' => $this->regAvgDailyIncomeInUSD,
              'avgDailyIncomePopulation' => $this->regAvgDailyIncomePopulation
          ),
          'periodType' => $this->periodType,
          'timeToElapse' => $this->timeToElapse,
          'reportedCases' => $this->reportedCases,
          'population' => $this->population,
          'totalHospitalBeds' => $this->totalHospitalBeds,
      );
      return $this->input;
    } 
    
    public function getDays(){
        return $this->timeToElapse;
    }
    
  }



  class impact extends estimator{
    public function __construct(array $data){
        parent :: __construct( $data);   
    }
      
    public function impact() {
        if ($this->periodType == 'weeks') {
              $days = $this->timeToElapse * 7;
          }elseif($this->periodType == 'months'){
              $days = $this->timeToElapse * 30;
          }else{
            $days = $this->timeToElapse;
        }
    
        $currentlyInfected = $this->reportedCases * 10;
        
        $infectionsByRequestedTime = intval($currentlyInfected * pow(2, intval($days / 3))) ;
        
        $severeCasesByRequestedTime = intval($infectionsByRequestedTime * 0.15) ;
        
        $hospitalBedsByRequestedTime = intval($this->totalHospitalBeds-(($this->totalHospitalBeds *0.65) + $severeCasesByRequestedTime));
        
        $casesForICUByRequestedTime = intval($infectionsByRequestedTime * 0.05) ;
        
        $casesForVentilatorsByRequestedTime = intval($infectionsByRequestedTime * 0.02);
        
        
        $dollarsInFlight = intval(($infectionsByRequestedTime * $this->regAvgDailyIncomePopulation * $this->regAvgDailyIncomeInUSD) / $days); 
        
    
        $this->impact = array(
          'currentlyInfected' => $currentlyInfected,
          'infectionsByRequestedTime' => $infectionsByRequestedTime,
          'severeCasesByRequestedTime' => $severeCasesByRequestedTime,
          'hospitalBedsByRequestedTime' => $hospitalBedsByRequestedTime,
          'casesForICUByRequestedTime' => $casesForICUByRequestedTime,
          'casesForVentilatorsByRequestedTime' => $casesForVentilatorsByRequestedTime,
          'dollarsInFlight' => $dollarsInFlight
        );
    
        return $this->impact;
    
      }
    
  }




  class severeImpact extends estimator{
    public function __construct(array $data){
        parent :: __construct( $data);   
    }

    public function severeImpact()
    {
      if ($this->periodType == 'weeks') {
            $days = $this->timeToElapse * 7;
        }elseif($this->periodType == 'months'){
            $days = $this->timeToElapse * 30;
        }else{
          $days = $this->timeToElapse;
      }
  
      $currentlyInfected = $this->reportedCases * 50;
  
      $infectionsByRequestedTime = intval($currentlyInfected * pow(2, intval($days / 3))) ;
  
      $severeCasesByRequestedTime = intval($infectionsByRequestedTime * 0.15) ;
  
      $hospitalBedsByRequestedTime = intval($this->totalHospitalBeds-(($this->totalHospitalBeds *0.65) + $severeCasesByRequestedTime));
  
      $casesForICUByRequestedTime = intval($infectionsByRequestedTime * 0.05) ;
  
      $casesForVentilatorsByRequestedTime = intval($infectionsByRequestedTime * 0.02);
  
  
      $dollarsInFlight = intval(($infectionsByRequestedTime * $this->regAvgDailyIncomePopulation * $this->regAvgDailyIncomeInUSD) / $days); 
  
  
      $this->severeImpact = array(
        'currentlyInfected' => $currentlyInfected,
        'infectionsByRequestedTime' => $infectionsByRequestedTime,
        'severeCasesByRequestedTime' => $severeCasesByRequestedTime,
        'hospitalBedsByRequestedTime' => $hospitalBedsByRequestedTime,
        'casesForICUByRequestedTime' => $casesForICUByRequestedTime,
        'casesForVentilatorsByRequestedTime' => $casesForVentilatorsByRequestedTime,
        'dollarsInFlight' => $dollarsInFlight,
        'days' => $days,
      );
  
      return $this->severeImpact;
    }    
}