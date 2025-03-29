<?php  // David Paul, Import CSV file data into a mySQL database table, Useful for reciept data, handles large datasets and handles errors gracefully. Further improvements can bemade to the current method as required. Dependencies:- PHP, MySQL
require __DIR__ . '/autoload.php';

try {
    // Instantiate the mySQL class
    $db = new mySQL();

    // Get the connection
    $conn = $db->getConnection();

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    //return success message
    echo('sucess');
    // if _post, submit
    if (isset($_POST['submit'])) {
        // get the file and  temp name
        $file = $_FILES['file']['tmp_name'];
        // get the date from the _post variable
        $date = $_POST['date'];

        // Checks if the file was uploaded by http post request
        if (is_uploaded_file($file)) {
            // open the file 
            $handle = fopen($file, 'r');
            // Read the header row
            $header = fgetcsv($handle, 1000, ","); 
            // Counts the records
            $num_records = 0;
            // total records imported allows comparison to make sure all records are handled.
            $num_imported = 0;
            // store errors as an array 
            $errors = [];
            // while there is data.
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $num_records++;

                // Prepare the data and append the billing_period
                $data[] = $date;

                /*********************Adding a try statement for the database query can make sure any failed queries are redone, this is recommended for a busy database where the IO is high ***************************/

                // Construct the database query to store the data 
                $query = "INSERT INTO example_table (" . implode(",", $header) . ", date) VALUES ('" . implode("','", array_map([$conn, 'real_escape_string'], $data)) . "')";
                // if success add 1 to the number of records imported
                if ($conn->query($query) === TRUE) {
                    $num_imported++;
                    // record error on failure.
                } else {
                    $errors[] = "Error on record $num_records: " . $conn->error;
                }
            }
            // close the file 
            fclose($handle);

            // Return summary to the terminal/display/output this can be altered depending on the use case.
            echo "<h2>Import Summary</h2>";
            echo "Total records in CSV: $num_records<br>";
            echo "Successfully imported records: $num_imported<br>";
            echo "Errors encountered: " . count($errors) . "<br>";

            // loop through the errors return the errors if any are recorded. 
            if (!empty($errors)) {
                echo "<h3>Error Details</h3>";
                foreach ($errors as $error) {
                    echo $error . "<br>";
                }
            }
            // handle failed file parse/upload
        } else {
            echo "File upload error.";
        }
    }

    // Close the databse connection
    $db->closeConnection();
    // catch an errors or exceptions
} catch (Exception $e) {
    echo $e->getMessage();
}
?>
