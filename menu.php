<html>
<head>
    <title>Two Owls Cafe</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <style>
        * { 
            color: #4D2D18; 
        }
        html, body { 
            margin: 0px;
            width: 100%; 
            height: 100%; 
        }
        p { 
            margin: 0px; 
        }
        .content { 
            top: 0px; 
            display: flex; 
            flex-direction: column; 
            width: 100%; 
            min-height: 100%; 
            justify-content: space-between; 
            align-items: center;
            margin-top: 40px; 
            padding-bottom: 20px;
        }
        form { 
            width: 100%; 
            height: 100%; 
            display: flex; 
            flex-direction: column; 
            justify-content: center; 
            align-item: center; 
            flex-grow: 1;
            border: solid #112821 8px; 
            border-radius: 20px; 
        }
        .questions { 
            width: 100%; 
            display: flex; 
            justify-content: center; 
            align-items: center; 
            flex-direction: column; 
            margin-top: 60px; 
            margin-bottom: 20px; 
        }
        .fullname { 
            display: flex; 
            width: 50%; 
            margin-top: 10px; 
        }
        .questions input, .questions label { 
            margin-right: 10px; 
        }
        .questions textarea, .questions input { 
            width: 50%; 
        }
        .questions textarea { 
            height: 50%; 
        }
        .items { 
            display: grid; 
            grid-template-columns: auto auto auto;
            gap: 20px; 
            max-height: 100vh; 
            margin-bottom: 5px;
        }
        .one-item { 
            width: 350px; 
            height: 400px; 
            display: flex; 
            justify-content: flex-start; 
            align-items: center; 
            flex-direction: column; 
        }
        .one-item img { 
            width: 200px; 
            height: 200px; 
            margin-top: 20px; 
            margin-bottom: 20px; 
            border: 5px solid #8B6341; 
        }
        .one-item p { 
            margin: 0px 0px 10px; 
            text-align: center; 
        }
        input[type="submit"] { 
            margin: 0px 0px 10px 0px; 
            width: 20%; 
            height: 25%; 
        }
        input[type="submit"]:hover { 
            cursor: pointer; 
            background-color: #4D6343; 
            color: #CBB99D; 
        }
        .item-name { 
            font-size: 20px; 
        }
        h2 { 
           color: #4D6343; 
        }
        h1 { 
            margin-bottom: 0px; 
        }
    </style>
</head>
<body>
    <div class="content">
        <?php require 'header.php'; ?>
        <div class = "form"> 
            <form onsubmit="return validateForm()" method="get" action="process_order.php" id="menu-form">
                <?php 
                    //  sever information 
                    require('dbinfo.inc'); 

                    // connect to the database 
                    $conn = new mysqli($servername, $username, $password, $dbname); 
                    // check the collection
                    if ($conn->connect_error) { 
                        die("Connection failed: " . $conn->connect_error); 
                    }

                    // get the things that we want 
                    $sql = "SELECT * FROM menu"; 
                    $result = $conn->query($sql); 

                    // counter initialization 
                    $id = 0; 
                    
                    echo "<div class='items'>"; // open div 
                    // get the data from each row, and display it how we please 
                    if ($result->num_rows > 0) { 
                        while($row = $result->fetch_assoc()) { 
                            $id++; 
                            extract($row); 
                            echo "<div class = 'one-item'>"; // open div 2
                            echo "<img src='images/$Image' <br>"; 
                            echo "<p class='item-name'> $Name </p>"; 
                            echo "<p> $Desciption </p>"; 
                            echo "<p> $ $Price </p>"; 
                            echo "<select name= '$id-item' class='num-item'>"; 
                            for ($i = 0; $i <= 10; $i++) { 
                                echo "<option value = '$i'> $i </option>"; 
                            }    
                            echo "</select>"; 
                            echo "</div>"; // close div 2
                        }
                    }
                    echo "</div>"; // close div 

                    // close the connection 
                    $conn->close();
                ?>
                <div class = "questions"> 
                <h2> Order Details </h2> 
                    <div class = "fullname">
                        <label for="first-name"> Name: </label>
                        <input type = "text" name = "first-name" id="first-name" placeholder = "First Name"> </input> 
                        <input type = "text" name = "last-name" id="last-name" placeholder = "Last Name"> </input> 
                    </div> 
                    <br> 
                    <textarea name="special-instructions" id="special-instructions"> Place Any Special Instructions Here </textarea>
                    <br> 
                    <input name="pickup-time" type="hidden" id="order-time">
                    <br>
                    <input type="submit" value = "Submit Order">
                </div> 
            </form>
        </div>
    </div>

    <!-- JAVASCRIPT -->
    <script> 
        at_least_one_item = false; 

        function validateForm() { 
            // validate that an item was chosen 
            items = document.getElementsByClassName("num-item"); 
            for (let i = 0; i < items.length; i++)
            { 
                selectedValue = items[i].selectedIndex; 
                console.log(selectedValue); 
                if (selectedValue != 0) at_least_one_item = true; 
            }

            if(at_least_one_item == false) 
            { 
                alert("Please select an item before placing your order."); 
                return at_least_one_item; 
            }

            // validate first name 
            firstName = document.getElementsByName("first-name")[0].value.trim(); 
            if(firstName == "") { 
                at_least_one_item = false; 
            }

            // validate last name 
            lastName = document.getElementsByName("last-name")[0].value.trim(); 
            if(lastName == "") { 
                at_least_one_item = false; 
            } 

            if(at_least_one_item) orderTime(); 
            else 
            { 
                alert("Please print your name before you place your order."); 
            }

            return at_least_one_item; 
        }

        function orderTime() { 
            today = new Date(); 
            curr_hour = today.getHours(); 
            console.log(curr_hour); 
            curr_mins = today.getMinutes(); 

            curr_mins = curr_mins + 20; 
            if (curr_mins > 60) { 
                curr_mins = curr_mins % 60; 
                curr_hour++; 
            }
            if (curr_hour > 12) curr_hour = curr_hour % 12;
            if(curr_hour == 0) curr_hour = 12; 

            timeString = "PickUp Time: " + curr_hour + ":" + curr_mins; 
            document.getElementById("order-time").value = timeString; 

            console.log(timeString);
        }

    </script>
</body>
</html>