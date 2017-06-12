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

// *CMD
$test_type = "CLCommand - addlible $testLib";
$output = $tkit->CLCommand("addlible $testLib");
check_result($output, $tkit);
$test_type = "CLInteractiveCommand - DSPLIBL";
$output = $tkit->CLInteractiveCommand("DSPLIBL");
check_result($output, $tkit);
$test_type = "CLCommandWithOutput - RTVJOBA CCSID(?N) OUTQ(?) USRLIBL(?) SYSLIBL(?)";
$output = $tkit->CLCommandWithOutput("RTVJOBA CCSID(?N) OUTQ(?) USRLIBL(?) SYSLIBL(?)");
check_result($output, $tkit);

// QSH (could not get working)
//$test_type = "qshellCommand - db2";
//$output = $tkit->qshellCommand('/QSYS.LIB/QZDFMDB2.PGM "select * from QIWS.QCUSTCDT"');
//check_result($output, $tkit);

// PASE
$test_type = "paseCommand - ls /qsys.lib/$testLib.lib";
$output = $tkit->paseCommand("ls /qsys.lib/$testLib.lib");
check_result($output, $tkit);
$test_type = "paseCommand - env";
$output = $tkit->paseCommand("env");
check_result($output, $tkit);

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



// *SRVPGM
//     D ARRAYMAX        c                   const(999)
//     D dcRec_t         ds                  qualified based(Template)
//     D  dcMyName                     10A
//     D  dcMyJob                    4096A
//     D  dcMyRank                     10i 0
//     D  dcMyPay                      12p 2
//      *+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//      * zzarray: check return array aggregate 
//      *+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//     P zzarray         B                   export
//     D zzarray         PI                  likeds(dcRec_t) dim(ARRAYMAX)
//     D  myName                       10A
//     D  myMax                        10i 0
//     D  myCount                      10i 0
$test_type = "*SRVPGM - ZZSRV(ZZARRAY)";
$max       = 10;
$param     = array(); // reset array
$result    = array(); // reset array
$dcRec_t   = array(); // reset array
$param[]   = $tkit->AddParameterChar   ('both',    10,  "name",     "myName",      "nada");
$param[]   = $tkit->AddParameterInt32  ('both',          "max",      "myMax",        $max);
$param[]   = $tkit->AddParameterInt32  ('both',        "count",    "myCount",           0)
                  ->setParamLabelCounter('myCounter');
$dcRec_t[] = $tkit->AddParameterChar   ('both',    10,  "name",   "dcMyName",         'A');
$dcRec_t[] = $tkit->AddParameterChar   ('both',  4096,   "job",    "dcMyJob",         'B');
$dcRec_t[] = $tkit->AddParameterInt32  ('both',         "rank",   "dcMyRank",           1);
$dcRec_t[] = $tkit->AddParameterPackDec('both', 12, 2,   "pay",    "dcMyPay",         9.2);
$result[]  = $tkit->AddDataStruct($dcRec_t)
                  ->setParamDimension(999)
                  ->setParamLabelCounted('myCounter');
$output = $tkit->PgmCall("ZZSRV", $testLib, $param, $result, array('func'=>"ZZARRAY"));
check_result($output, $tkit);


// *SRVPGM
//      *+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//      * zzvary: check return varying 
//      *+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//     P zzvary          B                   export
//     D zzvary          PI            20A   varying
//     D  myName                       10A   varying
$test_type = "*SRVPGM - ZZSRV(ZZVARY)";
$param     = array(); // reset array
$result    = array(); // reset array
// 6th parameter--'on'--is for varying 2
$param[]   = $tkit->AddParameterChar('both', 10, 'ZZVARY', 'myVary', 'Ace Vary2', 'on'); 
$result[]  = $tkit->AddParameterChar('both', 20, 'ZZVARY', 'retVary',      'Mud', 'on');
$output    = $tkit->PgmCall('ZZSRV', $testLib, $param, $result, array('func'=>'ZZVARY'));
check_result($output, $tkit);

// *SRVPGM
//      *+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//      * zzvary4: check return varying(4) 
//      *+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//     P zzvary4         B                   export
//     D zzvary4         PI            20A   varying(4)
//     D  myName                       10A   varying(4)
$test_type = "*SRVPGM - ZZSRV6(ZZVARY4)";
$param     = array(); // reset array
$result    = array(); // reset array
// 6th parameter--'on'--is for varying 2
$param[]   = $tkit->AddParameterChar('both', 10, 'ZZVARY', 'myVary', 'Ace Vary4', '4'); 
$result[]  = $tkit->AddParameterChar('both', 20, 'ZZVARY', 'retVary',      'Mud', '4');
$output    = $tkit->PgmCall('ZZSRV6', $testLib, $param, $result, array('func'=>'ZZVARY4'));
check_result($output, $tkit);

// *SRVPGM
//      *+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//      * zztimeUSA: check time parm
//      *+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//     P zztimeUSA       B                   export
//     D zztimeUSA       PI              T   timfmt(*USA)
//     D  myTime                         T   timfmt(*USA)
$test_type = "*SRVPGM - ZZSRV(ZZTIMEUSA)";
$param     = array(); // reset array
$result    = array(); // reset array
$param[]   = $tkit->AddParameterChar('both',  8,  'ZZTIMEUSA',  'myTime', '09:45 AM');
$result[]  = $tkit->AddParameterChar('both',  8,  'ZZTIMEUSA', 'retTime', '02:02 PM');
$output    = $tkit->PgmCall('ZZSRV', $testLib, $param, $result, array('func'=>'ZZTIMEUSA'));
check_result($output, $tkit);

// *SRVPGM
//      *+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//      * zzdateUSA: check date parm
//      *+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//     P zzdateUSA       B                   export
//     D zzdateUSA       PI              D   datfmt(*USA)
//     D  myDate                         D   datfmt(*USA)
$test_type = "*SRVPGM - ZZSRV(ZZDATEUSA)";
$param     = array(); // reset array
$result    = array(); // reset array
$param[]   = $tkit->AddParameterChar   ('both',  10,  'ZZDATEUSA',  'myDate', '05/11/2009');
$result[]  = $tkit->AddParameterChar   ('both',  10,  'ZZDATEUSA', 'retDate', '2002-02-02');
$output    = $tkit->PgmCall('ZZSRV', $testLib, $param, $result, array('func'=>'ZZDATEUSA'));
check_result($output, $tkit);

// *SRVPGM
//      *+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//      * zzstamp: check timestamp parm
//      *+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//     P zzstamp         B                   export
//     D zzstamp         PI              Z
//     D  myStamp                        Z
$test_type = "*SRVPGM - ZZSRV(ZZSTAMP)";
$param     = array(); // reset array
$result    = array(); // reset array
$param[]   = $tkit->AddParameterChar('both',  26,  'ZZSTAMP',  'myStamp', '2011-12-29-12.45.29.000000');
$result[]  = $tkit->AddParameterChar('both',  26,  'ZZSTAMP', 'retStamp', '2002-02-02-02.02.02.000000');
$output    = $tkit->PgmCall('ZZSRV', $testLib, $param, $result, array('func'=>'ZZSTAMP'));
check_result($output, $tkit);

// *PGM
//     D $vevsfi         s              1
//     D $vevsrj         s              2
//     D $vevsob         s              7s 0
//     D $vevsve         s              5s 0
//     D*Ergebnisdaten:
//     D $vevsods        ds                  occurs(200)
//     D $vsukz                  1      1
//     D $vpos                   2      9
//     D $vtxt                  10     39
//     D $vkalw                 40    174  2 dim(15)
//     D $vvsw                 175    309  2 dim(15)
//     D $vvsk                 310    324  0 dim(15)
//     d*
//     D i               S             10i 0 inz(0)
//     D j               S             10i 0 inz(0)
//      *+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//      * main(): Control flow
//      *+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//     C     *Entry        PLIST
//     c                   parm                    $vevsfi
//     c                   parm                    $vevsrj
//     c                   parm                    $vevsob
//     c                   parm                    $vevsve
//     c                   parm                    $vevsods
$test_type = "*PGM - ZZERICH";
$param       = array(); // reset array
$result      = array(); // reset array
$vevsods_t   = array(); // reset array
$vkalw_t     = array(); // reset array
$vvsw_t      = array(); // reset array
$vvsk_t      = array(); // reset array
$param[]     = $tkit->AddParameterChar  ('both',   1, 'vevsfi',   'var1',    'a');
$param[]     = $tkit->AddParameterChar  ('both',   2, 'vevsrj',   'var2',    'bb');
$param[]     = $tkit->AddParameterZoned ('both', 7,0, 'vevsob',   'var3',   '1.0');
$param[]     = $tkit->AddParameterZoned ('both', 5,0, 'vevsve',   'var4',   '1.0');
$vevsods_t[] = $tkit->AddParameterChar  ('both',   1,  "vsukz",    "ds1",     'A');
$vevsods_t[] = $tkit->AddParameterChar  ('both',   8,   "vpos",    "ds2",     'B');
$vevsods_t[] = $tkit->AddParameterChar  ('both',  30,   "vtxt",    "ds3",     'C');
$vkalw_t[]   = $tkit->AddParameterZoned ('both', 9,2,  "vkalw",    "ds4",   '9.2');
$vevsods_t[] = $tkit->AddDataStruct($vkalw_t)
                    ->setParamDimension(15);
$vvsw_t[]    = $tkit->AddParameterZoned ('both', 9,2,   "vvsw",    "ds5",   '9.2');
$vevsods_t[] = $tkit->AddDataStruct($vvsw_t)
                    ->setParamDimension(15);
$vvsk_t[]    = $tkit->AddParameterZoned ('both', 1,0,   "vvsk",    "ds6",   '1.0');
$vevsods_t[] = $tkit->AddDataStruct($vvsk_t)
                    ->setParamDimension(15);
$param[]     = $tkit->AddDataStruct($vevsods_t)
                    ->setParamDimension(200);
$output = $tkit->PgmCall('ZZERICH', $testLib, $param, null, null);
check_result($output, $tkit);

// sendXml(xml,disconnect)
//
// At times PHP toolkit just does not have API/method juice to call something
// really complex, so, you can by-pass toolkit and sendXml(xml) to XMLSERVICE.
//
// XMLSERVICE 1.9.2 is required for setnext='nextoff'/next='nextoff'.
// Unfortunatly, ZENDSVR6 copy XMLSERVICE is too old.
// Therefore, i close connection ZENDSVR6 lib (older xmlservice),
// open a new connection to XMLSERVICE lib (newer 1.9.2 xmlservice),
// and very complex system API calls work.
$test_type = "API - QSZRTVPR";
$QSZRTVPR_raw_xml = <<<ENDPROC
<?xml version="1.0"?>
<script>
<pgm name='QSZRTVPR'>
 <parm io="both" comment='Receiver variable'>
  <ds comment='PRDR0200 Format' len='rec1'>
   <data type='10i0' comment='Bytes returned'>0</data>
   <data type='10i0' comment='Bytes available' >8000</data>
   <data type='10i0' comment='Reserved'>0</data>
   <data type='7A' comment='Product ID'> </data>
   <data type='6A' comment='Release level'> </data>
   <data type='4A' comment='Product option'> </data>
   <data type='4A' comment='Load ID'> </data>
   <data type='10A' comment='Load type'> </data>
   <data type='10A' comment='Symbolic load state'> </data>
   <data type='10A' comment='Load error indicator'> </data>
   <data type='2A' comment='Load state'> </data>
   <data type='1A' comment='Supported flag'> </data>
   <data type='2A' comment='Registration type'> </data>
   <data type='14A' comment='Registration value'> </data>
   <data type='2A' comment='Reserved'> </data>
   <data type='10i0' offset='myOffset' comment='beyond size of PRDR0100'></data>
   <data type='4A' comment='Primary language load identifier'> </data>
   <data type='6A' comment='Minimum target release'> </data>
   <data type='6A' comment='Minimum VRM of *BASE required'> </data>
   <data type='1A' comment='Requirements met between base'> </data>
   <data type='3A' comment='Level'> </data>
   <data type='2048h' comment='leave some space for PRDR0200'/>
 </ds>   
</parm>   
 <parm  comment='Length of receiver variable'>
   <data type='10i0' setlen='rec1'>0</data>
 </parm>
 <parm  comment='Format name'>
   <data type='8A'>PRDR0200</data>
 </parm>
 <parm  comment='Product information'>
   <data type='100A'>*OPSYS *CUR  0021*CODE</data>
 </parm>
 <parm  io="both" comment='Error code'>
  <ds comment='Format ERRC0100' len='rec2'>
   <data type='10i0' comment='Bytes returned'>0</data>
   <data type='10i0' comment='Bytes available' setlen='rec2'>0</data>
   <data type='7A' comment='Exception ID'> </data>
   <data type='1A' comment='Reserved'> </data>
  </ds>
 </parm>
 
 <overlay io="out" top="1" offset='myOffset'>  
 <ds>
  <data type='10A' comment='Second language library'></data>
  <data type='2A' comment='Reserved'></data>
  <data type='10i0' enddo='prim' comment='Number of Primary languages'></data>
  <data type='10i0' offset="myOffset2" comment='Offset to library records'></data>
 </ds>
 </overlay>  

 <overlay io="out" top="1" offset="myOffset2" dim='10' dou='prim' setnext='nextoff'>
 <ds>
  <data type='10i0' next='nextoff' comment='Offset to next library record'></data>
  <data type='10A' comment='Primary library name'></data>
  <data type='10A' comment='Installed library name'></data>
  <data type='10A' comment='Library type'></data>
  <data type='10A' comment='Library authority'></data>
  <data type='10A' comment='Library create authority'></data>
  <data type='10A' comment='Postoperation exit program name'></data>
  <data type='10i0' comment='Number of preoperation exit program names'></data>
  <data type='10A' comment='Preoperation exit program names'></data>
 </ds>
 </overlay> 
  
</pgm>
</script>
ENDPROC;
db2_close($db);
$db = db2_connect("*LOCAL", $user, $pass);
$tkit2 = ToolkitService::getInstance($db);
$tkit2->setToolkitServiceParams(array('stateless'=>true, 'plug'=>"iPLUG5M", 'XMLServiceLib'=>'XMLSERVICE')); 
$output = $tkit2->sendXml($QSZRTVPR_raw_xml,$disconnect=false);
check_result($output, $tkit2);


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