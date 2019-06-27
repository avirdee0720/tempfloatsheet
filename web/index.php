<?
require_once("./inc/mysql.inc.php");
//require_once("./inc/securitycheck.inc.php");

session_start();

/*
SimpleQueryA($adb, $sql, &$arr)
Execute $sql query over connection $adb and return results as an array in $arr.
$adb must be pre-initialized and connection opened before calling the function.
No checks for validity of $sql are made.
Array $arr must be pre-initialized.
*/
function SimpleQueryA($adb, $sql, &$arr) {
    if (!$adb->Query($sql)) $adb->Kill();
    $arr = array(); // reinitialize array to make sure it's empty
    while ($row = $adb->RowA()) {
          $arr[] = $row;        
    }
    return $arr;
}

/*
OutputHTMLOptionTags($arr, $id_field, ...$name_fields)
Outputs HTML <option> tags intended for <select> tag.
Expects an array of arrays representing a DB table as input as $arr, $id_field string for the value
of ID field in <option> tag, and one ore more $name_fields strings for putting together display value.
The display name is a concatenation of $name_fields with spaces in between.
*/
function OutputHTMLOptionTags($arr, $id_field, $selected_id, ...$name_fields) {
    for ($i = 0; $i < count($arr); $i++) {
        $name = "";
        for ($j = 0; $j < count($name_fields); $j++) {
            if ($name)
                $name .= " ";
            $name .= $arr[$i][$name_fields[$j]];
        }        
        if ($selected_id == $arr[$i][$id_field])
            $selected = " selected";
        else
            $selected = "";
        echo '<option value="'.$name.'" id="'.$arr[$i][$id_field].'"'.$selected.'>'.$name.'</option>';
    }
}

// Initialize and open main DB connection
$db = new CMySQL;
if (!$db->Open()) $db->Kill();

// Get locations
$q = "SELECT id, loc_name, loc_address, loc_floor
      FROM locations
      ORDER BY loc_name, loc_floor;
     ";
$locations = array();
SimpleQueryA($db, $q, $locations);

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Float Sheet</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="sidemenu.css">
    <link href="./lightbox/lightbox/lightbox.min.css" rel="stylesheet">
  </head>
  <body>
      <div id="main">
      <h1 id="sheetHeaderTitle">Float Sheet</h1>
    <div id="sheetHeaderContainer">
        <span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776; History</span>
        <div id="mySidenav" class="sidenav">
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
            <input list="shops" name="shops" id="shopList" placeholder="Shop Name">
              <datalist id="shops">
                <?
                    OutputHTMLOptionTags($locations, "id", 2, "loc_name", "loc_floor");
                ?>
              </datalist>
              <input type="date" name="selectDate" id="selectDate">
              <a href="#">10/04/19 - 20PR Retro Woman</a>
              <a href="#">10/04/19 - 28PR Retro Home</a>
              <a href="#">10/04/19 - 30PR Book Shop</a>
              <a href="#">10/04/19 - 32PR Comic Shop</a>
              <a href="#">10/04/19 - 34PR Retro Man</a>
              <a href="#">10/04/19 - 38NHG Records Shop</a>
          </div>
      
      <h3 id="shopName">20PR Retro Woman ground floor</h3>
      <!-- <h3 id="shopFloor"> </h3> -->
      <h3 id="date">19/01/19 Saturday</h3>
      <!-- <h3 id="day">Saturday</h3> -->
      <div class="help">
          <a href=#modal1 data-lightbox> Things not adding up?</a>
            <div id="modal1" hidden>
              <div class="modal-content">
                <ul>
                  <li>Ask if anyone remembers transfers or over-rings 
                    that may not have been written down.</li>
                  <li>Check that you have used the correct figures 
                    from the till and PDQ reports.</li>
                  <li>Have any of the reserves changed at all?</li>
                  <li>Check that Morning Count & Evening Count addition is correct.</li>
                </ul><br>
                <p>If you have done these checks and there still appears to be a 
                  discrepancy, then there is nothing else that you can do. 
                  Leave it for Accounts.</p>
              </div>
            </div>
          </div>
    </div>

    <div id="modal2" hidden>
      <div class="modal-content">
    </div>

    </div>
       <div class="twoColumnLayout">
        <div class="sheetBodyContainer">
          <div id="morningCount">
          <h3 class="countHeadingLabel">Morning Count</h3>
          <span class="countQuantitylabel">Quantity</span>
          <span class="countCashLabel">Cash</span>
          <span class="countQuantityLabel">Quantity</span>
          <span class="countVouchersLabel">Vouchers</span>

          <span class="morningCountLabel">£50</span>
          <input type="number" class="numberInput" id="cur50PoundQuantity">
          <input type="number" class="numberInput" id="cur50PoundAmount"disabled>
          <input type="number" class="numberInput">
          <input type="number" class="numberInput" disabled>
          <span class="morningCountLabel">£20</span>
          <input type="number" class="numberInput">
          <input type="number" class="numberInput" disabled>
          <input type="number" class="numberInput">
          <input type="number" class="numberInput" disabled>
          <span>£10</span>
          <input type="number" class="numberInput">
          <input type="number" class="numberInput" disabled>
          <input type="number" class="numberInput">
          <input type="number" class="numberInput" disabled>
          <span>£5</span>
          <input type="number" class="numberInput">
          <input type="number" class="numberInput" disabled>
          <input type="number" class="numberInput">
          <input type="number" class="numberInput" disabled>
          <span>£2</span>
          <input type="number" class="numberInput">
          <input type="number" class="numberInput" disabled>
          <input type="number" class="numberInput">
          <input type="number" class="numberInput" disabled>
          <span>£1</span>
          <input type="number" class="numberInput">
          <input type="number" class="numberInput" disabled>
          <input type="number" class="numberInput">
          <input type="number" class="numberInput" disabled>
          <span>50p</span>
          <input type="number" class="numberInput">
          <input type="number" class="numberInput" disabled>
          <input type="number" class="numberInput">
          <input type="number" class="numberInput" disabled>
          
          <span>Change</span>
          <input type="number" class="hideIt">
          <input type="number" class="numberInput">
          <input type="number" class="hideIt">
          <input type="number" class="hideIt">
          <span>Sub Total</span>
          <input type="number" class="numberInput hideIt">
          <input type="number" class="numberInput">
          <input type="number" class="numberInput hideIt">
          <input type="number" class="numberInput">
          <span>Reserve</span>
          <input type="number" class="numberInput hideIt">
          <input type="number" class="numberInput">
          <input type="number" class="numberInput hideIt">
          <input type="number" class="numberInput">
          <span>Change Reserve</span>
          <input type="number" class="numberInput hideIt">
          <input type="number" class="numberInput">
          <input type="number" class="numberInput hideIt">
          <input type="number" class="numberInput">
          <span>Total</span>
          <input type="number" class="numberInput hideIt">
          <input type="number" class="numberInput">
          <input type="number" class="numberInput hideIt">
          <input type="number" class="numberInput">
          </div>
          <p class="morningCountMessage">Check that what you have counted 
              matches what was counted last night,
              less banking and cards. Recount if there is a difference.</p>
      </div>

        <div class="sheetBodyContainer">
            <div id="eveningCount">
              <h3 class="countHeadingLabel">Evening Count</h3>
              <span class="countQuantitylabel">Quantity</span>
              <span class="countCashLabel">Cash</span>
              <span class="countQuantityLabel">Quantity</span>
              <span class="countVouchersLabel">Vouchers</span>

              <span class="morningCountLabel">Total from PDQ</span>
              <input type="number" class="numberInput" disabled>
              <input type="number" class="numberInput">
              <input type="number" class="numberInput" disabled>
              <input type="number" class="numberInput numberInputWidth" 
              placeholder="VouchersClaimed">


              <span class="morningCountLabel">£50</span>
              <input type="number" class="numberInput" id="cur50PoundQuantity">
              <input type="number" class="numberInput" id="cur50PoundAmount"disabled>
              <input type="number" class="numberInput">
              <input type="number" class="numberInput" disabled>
              <span class="morningCountLabel">£20</span>
              <input type="number" class="numberInput">
              <input type="number" class="numberInput" disabled>
              <input type="number" class="numberInput">
              <input type="number" class="numberInput" disabled>
              <span>£10</span>
              <input type="number" class="numberInput">
              <input type="number" class="numberInput" disabled>
              <input type="number" class="numberInput">
              <input type="number" class="numberInput" disabled>
              <span>£5</span>
              <input type="number" class="numberInput">
              <input type="number" class="numberInput" disabled>
              <input type="number" class="numberInput">
              <input type="number" class="numberInput" disabled>
              <span>£2</span>
              <input type="number" class="numberInput">
              <input type="number" class="numberInput" disabled>
              <input type="number" class="numberInput">
              <input type="number" class="numberInput" disabled>
              <span>£1</span>
              <input type="number" class="numberInput">
              <input type="number" class="numberInput" disabled>
              <input type="number" class="numberInput">
              <input type="number" class="numberInput" disabled>
              <span>50p</span>
              <input type="number" class="numberInput">
              <input type="number" class="numberInput" disabled>
              <input type="number" class="numberInput">
              <input type="number" class="numberInput" disabled>
              
              <span>Change</span>
              <input type="number" class="hideIt">
              <input type="number" class="numberInput">
              <input type="number" class="hideIt">
              <input type="number" class="hideIt">
              <span>Sub Total</span>
              <input type="number" class="numberInput hideIt">
              <input type="number" class="numberInput">
              <input type="number" class="numberInput hideIt">
              <input type="number" class="numberInput">
              <span>Reserve</span>
              <input type="number" class="numberInput hideIt">
              <input type="number" class="numberInput">
              <input type="number" class="numberInput hideIt">
              <input type="number" class="numberInput">
              <span>Change Reserve</span>
              <input type="number" class="numberInput hideIt">
              <input type="number" class="numberInput">
              <input type="number" class="numberInput hideIt">
              <input type="number" class="numberInput">
              <span>Total</span>
              <input type="number" class="hideIt">
              <input type="number" class="numberInput">
              <input type="number" class="numberInput hideIt">
              <input type="number" class="numberInput">
              <span>Current Total From PDQ</span>
              <input type="number" class="hideIt">
              <input type="number" id="evenCountCurTotalPDQCash" class="numberInput">
              <input type="number" class="numberInput hideIt">
              <input type="number" id="evenCountCurTotalPDQVouch" class="numberInput" placeholder="VouchersClaimed">
            </div>
        </div>
       </div>
      
      <div class="twoColumnLayout">
        <div class="sheetBodyContainer">
          <div id="tillCheck1">
          <h3>Till Check 1</h3>
          <span>Cash</span>
          <span>Vouchers</span>
          <span>Evening Count</span>
          <input type="number" class="numberInput">
          <input type="number" class="numberInput">
          <span>Less Banking</span>
          <input type="number" class="numberInput">
          <input type="number" class="lessBanking2">
          <span>Less CC's/Vouchers claimed</span>
          <input type="number" class="numberInput" 
            id="pdqCurTotal" placeholder="PDQCurrentTotal">
          <input type="number" class="numberInput" 
            id="vouchClaimed" placeholder="VouchClaimed">
          <span>Tomorrow's Float</span>
          <input type="number" class="numberInput">
          <input type="number" class="numberInput">
          </div>
        </div>
      
        <div class="sheetBodyContainer">
          <div class="tillCheck2">
            <h3>Till Check 2</h3>
            <span>Cash</span>
            <span>Vouchers</span>
            <span>Morning Count</span>
            <input type="number" class="numberInput">
            <input type="number" class="numberInput">
            <span>Add transfers in</span>
            <input type="number" class="numberInput">
            <input type="number" class="numberInput">
            <span>Less transfers out</span>
            <input type="number" class="numberInput">
            <input type="number" class="numberInput">
            <span class="zReportInfo">Add figures from the till Z report</span>
            <input type="number" class="numberInput" placeholder="Cash">
            <input type="number" class="numberInput" placeholder="Check">
            <input type="number" class="numberInput" placeholder="Charge">
          </div>
    
        <div class="tillCheck2">
          <span>Less sales over-rings</span>
          <input type="number" class="numberInput">
          <input type="number" class="numberInput">
          <span>Add other over-rings</span>
          <input type="number" class="numberInput">
          <input type="number" class="numberInput">
          <h4>CHECK TOTAL (should match evening count)</h4>
          <input type="number" class="numberInput">
          <input type="number" class="numberInput">
        </div>
      </div>
    </div>

    <h3>Over-Ring record</h3>
    <p class="additionalInfo">Any incorrect transction rung through the 
        till should be rung through again correctly, and the 
        incorrect receipt stapled here to be accounted 
        for at the end of the day. Write transactions down too, 
        in case receipts get lost.</p>
        <div class="twoColumnLayout">
            
          <div class="sheetBodyContainer">
              
              
              <h4>Sales Over-rings</h4>
            <div class="salesOverRing">
              <span>Till Dept</span>
              <span>C/V</span>
              <span>Amount</span>
              <select name="tillDept" id="">
                  <option value=""></option>
                <option value="&#8593;">&#8593;</option>
                <option value="&#8595;">&#8595;</option>
              </select>
              <select name="cOrV" id="">
                  <option value=""></option>
                <option value="C">C</option>
                <option value="V">V</option>
              </select>
              <input type="number" class="numberInput">
              <select name="tillDept" id="">
                  <option value=""></option>
                <option value="&#8593;">&#8593;</option>
                <option value="&#8595;">&#8595;</option>
              </select>
              <select name="cOrV" id="">
                  <option value=""></option>
                <option value="C">C</option>
                <option value="V">V</option>
              </select>
              <input type="number" class="numberInput">
              <select name="tillDept" id="">
                  <option value=""></option>
                <option value="&#8593;">&#8593;</option>
                <option value="&#8595;">&#8595;</option>
              </select>
              <select name="cOrV" id="">
                  <option value=""></option>
                <option value="C">C</option>
                <option value="V">V</option>
              </select>
              <input type="number" class="numberInput">
              <select name="tillDept" id="">
                  <option value=""></option>
                <option value="&#8593;">&#8593;</option>
                <option value="&#8595;">&#8595;</option>
              </select>
              <select name="cOrV" id="">
                  <option value=""></option>
                <option value="C">C</option>
                <option value="V">V</option>
              </select>
              <input type="number" class="numberInput">
              <select name="tillDept" id="">
                  <option value=""></option>
                <option value="&#8593;">&#8593;</option>
                <option value="&#8595;">&#8595;</option>
              </select>
              <select name="cOrV" id="">
                  <option value=""></option>
                <option value="C">C</option>
                <option value="V">V</option>
              </select>
              <input type="number" class="numberInput">
              <select name="tillDept" id="">
                  <option value=""></option>
                <option value="&#8593;">&#8593;</option>
                <option value="&#8595;">&#8595;</option>
              </select>
              <select name="cOrV" id="">
                  <option value=""></option>
                <option value="C">C</option>
                <option value="V">V</option>
              </select>
              <input type="number" class="numberInput">
          </div>
        </div>

        <div class="sheetBodyContainer">
        <h4>Other Over-rings</h4>
        <div class="otherOverRing">
            <span>Till Dept</span>
            <span>C/V</span>
            <span>Amount</span>
            <select name="tillDept" id="">
                <option value=""></option>
              <option value="&#8593;">&#8593;</option>
              <option value="&#8595;">&#8595;</option>
            </select>
            <select name="cOrV" id="">
                <option value=""></option>
              <option value="C">C</option>
              <option value="V">V</option>
            </select>
            <input type="number" class="numberInput">
            <select name="tillDept" id=""> 
                <option value=""></option>
              <option value="&#8593;">&#8593;</option>
              <option value="&#8595;">&#8595;</option>
            </select>
            <select name="cOrV" id="">
                <option value=""></option>
              <option value="C">C</option>
              <option value="V">V</option>
            </select>
            <input type="number" class="numberInput">
            <select name="tillDept" id="">
                <option value=""></option>
              <option value="&#8593;">&#8593;</option>
              <option value="&#8595;">&#8595;</option>
            </select>
            <select name="cOrV" id="">
                <option value=""></option>
              <option value="C">C</option>
              <option value="V">V</option>
            </select>
            <input type="number" class="numberInput">
            <select name="tillDept" id="">
                <option value=""></option>
              <option value="&#8593;">&#8593;</option>
              <option value="&#8595;">&#8595;</option>
            </select>
            <select name="cOrV" id="">
                <option value=""></option>
              <option value="C">C</option>
              <option value="V">V</option>
            </select>
            <input type="number" class="numberInput">
            <select name="tillDept" id="">
                <option value=""></option>
              <option value="&#8593;">&#8593;</option>
              <option value="&#8595;">&#8595;</option>
            </select>
            <select name="cOrV" id="">
                <option value=""></option>
              <option value="C">C</option>
              <option value="V">V</option>
            </select>
            <input type="number" class="numberInput">
            <select name="tillDept" id="">
                <option value=""></option>
              <option value="&#8593;">&#8593;</option>
              <option value="&#8595;">&#8595;</option>
            </select>
            <select name="cOrV" id="">
                <option value=""></option>
              <option value="C">C</option>
              <option value="V">V</option>
            </select>
            <input type="number" class="numberInput">
        </div>
      
      </div>  
    </div>

      <div class="sheetBodyContainer">
        <div class="payouts">
          <h3>Payouts</h3>
          <p class="additionalInfo">Add up totals from buying sheets</p>
          <span>Cash</span>
          <input type="number" class="numberInput">
          <span>Vouchers</span>
          <input type="number" class="numberInput">
          <span>Total</span>
          <input type="number" class="numberInput">
        </div>
      </div>

      <div class="sheetBodyContainer">
        <h3>Transfers</h3>
        <p class="additionalInfo">Record any movement of money or vouchers from or to another department or Accounts</p>
          <div class="transfers">
            <span>From</span>
            <span>To</span>
            <span>C/V</span>
            <span>Transfer In</span>
            <span>Transfer Out</span>
            <span>Time</span>
            <span>Initials</span>
            <select name="tillDept" id="tillDeptFrom1">
                <option value=""></option>
              <option value="&#8593;">&#8593;</option>
              <option value="&#8595;">&#8595;</option>
              <option value="shop_1">Shop 1</option>
              <option value="shop_2">Shop 2</option>
              <option value="shop_3">Shop 3</option>
              <option value="shop_4">Shop 4</option>
            </select>
            <select name="tillDept" id="tillDeptTo1">
                <option value=""></option>
              <option value="&#8593;">&#8593;</option>
              <option value="&#8595;">&#8595;</option>
            </select>
            <select name="cOrV" id="">
                <option value=""></option>
              <option value="C">C</option>
              <option value="V">V</option>
            </select>
            <input type="number" class="numberInput">
            <input type="number" class="numberInput">
            <input type="time">
            <input type="text">
            <select name="tillDept" id="tillDeptFrom2">
                <option value=""></option>
              <option value="&#8593;">&#8593;</option>
              <option value="&#8595;">&#8595;</option>
            </select>
            <select name="tillDept" id="tillDeptTo2">
                <option value=""></option>
              <option value="&#8593;">&#8593;</option>
              <option value="&#8595;">&#8595;</option>
            </select>
            <select name="cOrV" id="">
                <option value=""></option>
              <option value="C">C</option>
              <option value="V">V</option>
            </select>
            <input type="number" class="numberInput">
            <input type="number" class="numberInput">
            <input type="time">
            <input type="text">
            <select name="tillDept" id="tillDeptFrom3">
                <option value=""></option>
              <option value="&#8593;">&#8593;</option>
              <option value="&#8595;">&#8595;</option>
            </select>
            <select name="tillDept" id="tillDeptTo3">
                <option value=""></option>
              <option value="&#8593;">&#8593;</option>
              <option value="&#8595;">&#8595;</option>
            </select>
            <select name="cOrV" id="">
                <option value=""></option>
              <option value="C">C</option>
              <option value="V">V</option>
            </select>
            <input type="number" class="numberInput">
            <input type="number" class="numberInput">
            <input type="time">
            <input type="text">
            <select name="tillDept" id="tillDeptFrom4">
                <option value=""></option>
              <option value="&#8593;">&#8593;</option>
              <option value="&#8595;">&#8595;</option>
            </select>
            <select name="tillDept" id="tillDeptTo4">
                <option value=""></option>
              <option value="&#8593;">&#8593;</option>
              <option value="&#8595;">&#8595;</option>
            </select>
            <select name="cOrV" id="">
                <option value=""></option>
              <option value="C">C</option>
              <option value="V">V</option>
            </select>
            <input type="number" class="numberInput">
            <input type="number" class="numberInput">
            <input type="time">
            <input type="text">
            <select name="tillDept" id="tillDeptFrom5">
                <option value=""></option>
              <option value="&#8593;">&#8593;</option>
              <option value="&#8595;">&#8595;</option>
            </select>
            <select name="tillDept" id="tillDeptTo5">
                <option value=""></option>
              <option value="&#8593;">&#8593;</option>
              <option value="&#8595;">&#8595;</option>
            </select>
            <select name="cOrV" id="">
                <option value=""></option>
              <option value="C">C</option>
              <option value="V">V</option>
            </select>
            <input type="number" class="numberInput">
            <input type="number" class="numberInput">
            <input type="time">
            <input type="text">
            <select name="tillDept" id="tillDeptFrom6">
                <option value=""></option>
              <option value="&#8593;">&#8593;</option>
              <option value="&#8595;">&#8595;</option>
            </select>
            <select name="tillDept" id="tillDeptTo6">
                <option value=""></option>
              <option value="&#8593;">&#8593;</option>
              <option value="&#8595;">&#8595;</option>
            </select>
            <select name="cOrV" id="">
                <option value=""></option>
              <option value="C">C</option>
              <option value="V">V</option>
            </select>
            <input type="number" class="numberInput">
            <input type="number" class="numberInput">
            <input type="time">
            <input type="text">
            <select name="tillDept" id="tillDeptFrom7">
                <option value=""></option>
              <option value="&#8593;">&#8593;</option>
              <option value="&#8595;">&#8595;</option>
            </select>
            <select name="tillDept" id="tillDeptTo7">
                <option value=""></option>
              <option value="&#8593;">&#8593;</option>
              <option value="&#8595;">&#8595;</option>
            </select>
            <select name="cOrV" id="">
                <option value=""></option>
              <option value="C">C</option>
              <option value="V">V</option>
            </select>
            <input type="number" class="numberInput">
            <input type="number" class="numberInput">
            <input type="time">
            <input type="text">
            <select name="tillDept" id="tillDeptFrom8">
                <option value=""></option>
              <option value="&#8593;">&#8593;</option>
              <option value="&#8595;">&#8595;</option>
            </select>
            <select name="tillDept" id="tillDeptTo8">
                <option value=""></option>
              <option value="&#8593;">&#8593;</option>
              <option value="&#8595;">&#8595;</option>
            </select>
            <select name="cOrV" id="">
                <option value=""></option>
              <option value="C">C</option>
              <option value="V">V</option>
            </select>
            <input type="number" class="numberInput">
            <input type="number" class="numberInput">
            <input type="time">
            <input type="text">
          </div>
      </div>

      <div class="sheetBodyContainer">
        <h3>Expenses</h3>
        <p class="additionalInfo">Ring through the till and staple both receipts on back, then write in description and cost here</p>
        <div class="expenses">
          <span>Description</span>
          <span>Cost</span>
          <input type="text">
          <input type="number" class="numberInput">
          <input type="text">
          <input type="number" class="numberInput">
          <input type="text">
          <input type="number" class="numberInput">
          <input type="text">
          <input type="number" class="numberInput">
        </div>

        <div class="comments">
            <h3>Comments</h3>
            <p class="additionalInfo"><strong>Note</strong> clearly any unusual activity about today's transactions here, as well as your name. Give
              the name of each person claiming vouchers and the amount taken.</p>
            <textarea class="commentsTextArea" name="comments" id="comments" cols="48" rows="7"></textarea>
        </div>
        </div>
      </div>
    
      <script src="./lightbox/lightbox/lightbox.min.js"></script>
    <script src="main.js"></script>
  </body>
</html>