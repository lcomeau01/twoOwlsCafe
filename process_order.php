<html> 
<head>
<title>Two Owls Reciept</title>
<style>
    * { 
        color: #4D2D18; 
    }
    html, body { 
        margin: 0px;
        width: 100%; 
        height: 100%; 
    }
    h2 { 
        color: #4D6343; 
    }
    h1 { 
        margin-bottom: 0px; 
    }
    p { 
        margin: 0px; 
    }
    .content { 
        display: flex; 
        flex-direction: column; 
        width: 100%; 
        min-height: 100%; 
        justify-content: flex-start; 
        align-items: center;
    }
    .reciept-container { 
        height: 100%; 
        width: 100%; 
        display: flex; 
        justify-content: center; 
        align-items: center; 
        flex-grow: 1; 
        font-family: "Lucida Console", "Courier New", monospace;
        flex-direction: column; 
    }
    .reciept { 
        display: flex; 
        flex-direction: column;
        justify-content: flex-start; 
        align-items: center; 
        min-height: 70vh; 
        width: 25%; 
        border: #000000 2px; 
        border-style: dashed solid solid solid;
        font-size: 20px; 
        padding: 10px; 
    }
    .item-container { 
        width: 100%; 
        padding: 0px 0px 20px; 
    }
    .new-item, .totalprice, .holes { 
        width: 100%; 
        height: auto; 
        display: flex; 
        justify-content: space-between; 
    }
    #reciept-heading
    { 
        margin: 0px; 
    }
    .circle 
    { 
        background-color: black; 
        border-radius: 50%; 
        height: 15px;
        width: 15px; 
        margin-bottom: 20px; 
    }
    #time {margin-bottom: 20px;}
    #specialNote { margin-top: 20px; }
    #actualNote {text-align: center; }
</style>
</head>

<body> 
<div class="content">
    <?php require 'header.php'; ?>
    <div class = "reciept-container">
    <h2 id="reciept-heading"> Reciept for Order </h2> 
    <div class="reciept">
    <div class="holes"> 
        <div class="circle"> &nbsp; </div> 
        <div class="circle"> &nbsp; </div> 
        <div class="circle"> &nbsp; </div> 
    </div> 
    <!-- Based heavily on the example done in class, with a few changes for layout / aesthetic purposes -->
        <?php 
            $random_number = rand(1000, 2000);
            echo "<p id='orderNum'> Order Number $random_number </p>"; 
            $time = $_GET["pickup-time"]; 
            echo "<p id='time'> $time </p>"; 

            // database info file 
            require("dbinfo.inc"); 

            // connect to the database 
            $conn = new mysqli($servername, $username, $password, $dbname); 
            
            // check the collection
            if ($conn->connect_error) { 
                die("Connection failed: " . $conn->connect_error); 
            }

            // get Functions 
            function getName($id) 
            { 
                global $conn; 
                $sql = "SELECT Name FROM menu WHERE Id = $id"; 
                $result = $conn->query($sql); 
                $row = $result->fetch_array(); 
                return $row[0]; 
            }

            function getPrice($id) 
            { 
                global $conn; 
                $sql = "SELECT Price FROM menu WHERE Id = $id"; 
                $result = $conn->query($sql); 
                $row = $result->fetch_array();  
                return $row[0]; 
            }

            function getTotal($numItems, $itemPrice) 
            { 
                return $numItems * $itemPrice; 
            }


            $key = "item"; 
            $TOTAL = 0; 
            foreach($_GET as $k => $v) { 
                $pos = strpos($k, $key); 
                if((strpos($k, $key)) && ($v > 0))
                { 
                    // get different variables and quantities 
                    $i = strpos($k, "-"); 
                    $id = substr($k, 0, $i); 
                    $item = getName($id); 
                    $price = getPrice($id); 
                    $totalPrice = getTotal($v, $price); 
                    $TOTAL = $TOTAL + $totalPrice; 

                    // set up reciept 
                    echo "<div class='item-container'>"; 
                    echo "<div class = 'new-item'>"; // open new-item div 
                    echo "<p> $v $item </p>"; 
                    echo "<p> $$price </p>"; 
                    echo "</div>"; // close new-item div 

                    echo "<div class = 'totalprice'>"; // open total price for one item div 
                    echo "<p> Total for all $v: </p>"; 
                    echo "<p> $$totalPrice </p>"; 
                    echo "</div>"; // close total price 
                    echo "</div>"; 
                }
            }

            // close the connection 
            $conn->close();

            // bottom reciept stuff 

            // total 
            echo "<p style='color: red'> Total: $$TOTAL </p>"; 
            $TAX = $TOTAL * 0.0625;
            echo "<p style='color: red'> Tax: $" . number_format((float)$TAX, 2, '.', '') . "</p>"; 
            $TOTAL = $TOTAL + $TAX; 
            echo "<p style='color: red'> Total w/ Tax: $" . number_format((float)$TOTAL, 2, '.', '') . "</p>"; 

            // special notes 
            $special_notes = $_GET['special-instructions']; 
            $special_notes = trim($special_notes); 
            $hasSpecialNote = false; 
            if ($special_notes != "Place Any Special Instructions Here") $hasSpecialNote = true; 
            if ($special_notes == "") $hasSpecialNote = false; 

            if ($hasSpecialNote == true)
            { 
                echo "<p id='specialNote'> Special Notes: </p>"; 
                echo "<p id='actualNote'> $special_notes </p>"; 
            }
        ?> 
    </div> <!-- reciept div closer --> 
    <?php 
        echo "<h2> Thank You for your order, " . $_GET['first-name'] . " " . $_GET['last-name'] . " ! </h2>"; 
    ?>
    </div> <!-- container div closer -->
</div> <!-- content div closer --> 
</body>