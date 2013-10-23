<html>
    <head>
        <meta content="text/html; charset=ISO-8859-1"  http-equiv="content-type">
        <title>View Data</title>
        <link rel="stylesheet" type="text/css" href="table.css">
        <link rel="stylesheet" type="text/css" href="viewdata.css">
        <script src="js/jquery-2.0.3.min.js"></script>
        <script>
            //script to show and hide tables when clicking the nav menu
            $(document).ready(function()
            {
                $('.data').hide();

                $('li').click(function(event) {
                    $('.data').hide();
                    $('#' + $(this).text()).show();
                    console.log("clicked");
                });
            });
        </script>
     
    </head>
    <body>

        <br>


        <?php
//Connect to MySQL
        $mysqli = mysqli_connect("localhost", "home", "123456", "property");
        $query  = "SHOW TABLES";
        $result = mysqli_query($mysqli, $query);

        if (!$result) {
            echo "DB error, could not list tables";
            echo "MySQL Error: " . mysql_error();
            exit;
        }



//define side bar using table names========================
        $tableName  = array(); 
        $sidebar    = "<div id='sidebar'> " . "<ul>";
        while ($row = mysqli_fetch_row($result)) {
            
            $sidebar .= "<li>" . $row[0] . "</li>";
            array_push($tableName, $row[0]);
        }
        
        //$sidebar .= "<li onclick="."\"location.href='logger.html';\">Log Data</li>";
        $sidebar .= "</ul></div>";
        echo $sidebar;
        mysqli_close($mysqli);
//=========================================================

//define the table container div===========================
        echo "<div id='tableContainer'>";

        //loop through each tables and put into tables and then into the div
        for ($j = 0; $j < 4; $j++) {
            $table       = "<table class = 'data' id ='" . $tableName[$j] . "'>";
            $table      .= "<caption>" . $tableName[$j] . "</caption>";
            $mysqli2    = mysqli_connect("localhost", "home", "123456", "property");
            $query2     = "SELECT * FROM " . $tableName[$j];
            $result2    = mysqli_query($mysqli2, $query2);
            $fieldCount = mysqli_field_count($mysqli2);

            $finfo      = mysqli_fetch_fields($result2);
            $table      .="<tr>";
            for ($k = 1; $k < $fieldCount; $k++) {
                $table  .="<th>" . $finfo[$k]->name . "</th>";
            }

            $table .="</tr>";

            //populate the table with data
            while ($row = mysqli_fetch_array($result2)) {
                $table .="<tr>";
                
                for ($i = 1; $i < $fieldCount; $i++) {
                    $table .= "<td>" . $row[$i] . "</td>";
                }
            
                $table .="</tr>";
                
            }
            $table .= "</table>";
            echo $table;
        }

        echo "</div>";
//==================================================================
        ?>

        <br>
        
    </body>
</html>


