<?php

    function options()
    {
        printf("%s\n\t-h DBHOST\n\t-u DBUSER\n\t-p DBPASSWORD\n\t-d DB",
            basename(__FILE__)
        );
    }

    // get the command line options

    $options = getopt("h:u:p:d:");

    if (FALSE == $options)
    {
        options();
        exit();
    }

    if (!array_key_exists('h', $options) ||  !array_key_exists('u', $options) || !array_key_exists('p', $options) || !array_key_exists('d', $options))
    {
        options();
        exit();
    }

    // define the connection params

    define("DBHOST", $options['h']);
    define("DBUSER", $options['u']);
    define("DBPASSWD", $options['p']);
    define("DATABASE", $options['d']);
    define("ROWS", 1000);

    // check for mysqli extension
    if (! extension_loaded('mysqli'))
    {
        echo "mysqli extension not available.";
        exit();
    }

    // record start time
    $start = hrtime();

    // attempt connection
    $mysqli = new mysqli(DBHOST, DBUSER, DBPASSWD, DATABASE);

    if ($mysqli->connect_errno) {
        echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
        exit();
    }

    echo $mysqli->host_info . "\n";

    // clear table
    if (! $mysqli->query("DROP TABLE IF EXISTS test"))
    {
        echo "Table deletion failed: (" . $mysqli->errno . ") " . $mysqli->error;
        exit();
    }

    // create a table
    if (! $mysqli->query("CREATE TABLE test(id INT)"))
    {
        echo "Table creation failed: (" . $mysqli->errno . ") " . $mysqli->error;
        exit();
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