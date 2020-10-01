<?php

    // define the connection params

    define("DBHOST", "");
    define("DBUSER", "");
    define("DBPASSWD", "");
    define("DATABASE", "");
    define("ROWS", 1000);

    // check for mysqli extension
    if (! extension_loaded('mysqli'))
    {
        echo "mysqli extension not available.";
        die();
    }

    // record start time
    $start = hrtime();

    // attempt connection
    $mysqli = new mysqli(DBHOST, DBUSER, DBPASSWD, DATABASE);

    if ($mysqli->connect_errno) {
        echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
        die();
    }

    echo $mysqli->host_info . "\n";

    // clear table
    if (! $mysqli->query("DROP TABLE IF EXISTS test"))
    {
        echo "Table deletion failed: (" . $mysqli->errno . ") " . $mysqli->error;
    }

    // create a table
    if (! $mysqli->query("CREATE TABLE test(id INT)"))
    {
        echo "Table creation failed: (" . $mysqli->errno . ") " . $mysqli->error;
    }

    // insert 100,000 rows
    for ($i = 1; $i <= ROWS; $i++) {
        $mysqli->query("INSERT INTO test(id) VALUES ($i)");
    }

    // retrieve all rows, ordered
    $mysqli->real_query("SELECT id FROM test ORDER BY id ASC");
    $res = $mysqli->use_result();
    while ($row = $res->fetch_assoc()) {
    }

    // record stop time
    $stop = hrtime(); 

    // calculate time taken
    $seconds_diff = $stop[0] - $start[0];

    echo "$seconds_diff\n";

?>