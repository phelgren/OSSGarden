<?php

$ok = set_time_limit(300);
if ($ok) {
  echo "<h1>{$_SERVER['PHP_SELF']} - timeout 300 secs</h1>\n";
} else {
  echo "<h1>{$_SERVER['PHP_SELF']} - timeout default</h1>\n";
}
echo "<table border='1'>\n";
echo "<th>type</th>\n";
echo "<th>test</th>\n";
echo "<th>error</th>\n";

$test_type="db2_connect";
$testLib="XMLSERVICE";
require_once('authorization.php');
$db = db2_connect($db, $user, $pass);
check_conn($db);

$test_type="Toolkit";
require_once("ToolkitService.php");
$tkit = ToolkitService::getInstance($db);
$tkit->setToolkitServiceParams(array('stateless'=>true, 'plug'=>"iPLUG5M")); 
check_obj($tkit);


// *PGM
//     D  INCHARA        S              1a
//     D  INCHARB        S              1a
//     D  INDEC1         S              7p 4        
//     D  INDEC2         S             12p 2
//     D  INDS1          DS                  
//     D   DSCHARA                      1a
//     D   DSCHARB                      1a           
//     D   DSDEC1                       7p 4      
//     D   DSDEC2                      12p 2            
//      *+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//      * main(): Control flow
//      *+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//     C     *Entry        PLIST                   
//     C                   PARM                    INCHARA
//     C                   PARM                    INCHARB
//     C                   PARM                    INDEC1
//     C                   PARM                    INDEC2
//     C                   PARM                    INDS1
$test_type = "*PGM - ZZCALL";
$param     = array(); // reset array
$result    = array(); // reset array
$INDS1_t   = array(); // reset array
$param[]   = $tkit->AddParameterChar   ('both',    1, 'INCHARA', 'vara',             'Y');
$param[]   = $tkit->AddParameterChar   ('both',    1, 'INCHARB', 'varb',             'Z');
$param[]   = $tkit->AddParameterPackDec('both',  7,4,  'INDEC1', 'var1',      '001.0001');
$param[]   = $tkit->AddParameterPackDec('both', 12,2,  'INDEC2', 'var2', '0000000003.04');
$INDS1_t[] = $tkit->AddParameterChar   ('both',    1, 'DSCHARA',  'ds1',             'A');
$INDS1_t[] = $tkit->AddParameterChar   ('both',    1, 'DSCHARB',  'ds2',             'B');
$INDS1_t[] = $tkit->AddParameterPackDec('both',  7,4,  'DSDEC1',  'ds3',      '005.0007');
$INDS1_t[] = $tkit->AddParameterPackDec('both', 12,2,  'DSDEC1',  'ds4', '0000000006.08');
$param[]   = $tkit->AddDataStruct($INDS1_t);
$output    = $tkit->PgmCall('ZZCALL', $testLib, $param, null, null);
check_result($output, $tkit);


echo "</table>\n";


function check_conn($conn) {
  global $test_type;
  echo "<tr><td>$test_type</td><td>connection</td><td>".db2_conn_errormsg()."</td></tr>\n";
  if ($conn) return;
  echo "</table>\n";
  exit();
}

function check_obj($obj) {
  global $test_type;
  echo "<tr><td>$test_type</td><td><pre>".var_export($obj, true)."</pre></td><td></td></tr>\n";
  if ($obj) return;
  echo "</table>\n";
  exit();
}

function check_result($result, $obj) {
  global $test_type;
  $error = "";
  if (!$result) {
    $error = 'Error. Code: ' . $obj->getErrorCode() . ' Msg: ' . $obj->getErrorMsg();
  }
  echo "<tr><td>$test_type</td><td><pre>".var_export($result, true)."</pre></td><td>$error</td></tr>\n";
}
function check_result_xml($result, $obj) {
  global $test_type;
  $error = "";
  if (!$result) {
    $error = 'Error. Code: ' . $obj->getErrorCode() . ' Msg: ' . $obj->getErrorMsg();
  }
  $was = array('<','>');
  $now = array(' ',' ');
  echo "<tr><td>$test_type</td><td><pre>".str_replace($was,$now,$result)."</pre></td><td>$error</td></tr>\n";
}
?>