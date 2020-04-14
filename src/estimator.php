<?php

include 'src/classes.php';

function covid19ImpactEstimator($data)
{

  $estimator = new estimator($data);
  $input = $estimator->getData();

  $impact = new impact($data);
  $imp = $impact->impact();

  $severeImpact = new severeImpact($data);
  $sev = $severeImpact->severeImpact();

  $data = array('data'=> $input, 'impact'=>$imp, 'severeImpact' => $sev);

  return $data;
}