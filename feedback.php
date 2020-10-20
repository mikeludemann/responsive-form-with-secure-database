<?php

$salutation = $_POST["salutation"];
$firstName = $_POST["firstName"];
$lastName = $_POST["lastname"];
$email = $_POST["email"];
$comments = $_POST["comments"];

// Helper Functions

include "./src/helper/secureContent.php";

// Mail informations

$recipient = "admin@test.com";
$cc = ""; // "carbon copy"
$transmitter = $email;
$subject = "Contact";
$headers = "";
$message = "";

$message .= '
<html>
    <head>
        <title>Feedback</title>
    </head>
    <body>
        <div class="container-fluid">
            <div class="row">
                <h2 class="title">Feedback</h2>
            </div>
            <div class="row">
                <div class="col-12 content">Dear Sir or Madame</div>
                <div class="col-12 content">';

                echo "My name is, " . $salutation . " " . $firstName . " " . $lastName . "\n\n";

                echo "I hope that my following feedback will be helpful.  \n\n";

                echo $comments;

                echo '</div>
                <div class="col-12 content">Sincerely yours</div>
            </div>
        </div>
    </body>
</html>
';

$headers .= "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

$headers .= 'From: <' . $transmitter . '>' . "\r\n";
$headers .= 'Cc: <' . $cc . '>' . "\r\n";

if(isset($_POST["submit"])){

    mail($recipient,$subject,$message,$headers);

    echo '
    <!DOCTYPE html>
    <html>
        <head>
            <title>Feedback Site</title>';
            
            include './src/init/init.php';
    
        echo '</head>
    <body>
    ';
    
    include "./src/content/header.php";
    
    echo '
    <section>
        <div class="container-fluid">
            <div class="row">
                <h2 class="title">Thank you for your feedback</h2>
            </div>
            <div class="row">
                <div class="col-12 content">Your data has arrived with us.</div>
                <div class="col-12 content">';
    
                echo "Thanks, " . $salutation . " " . $firstName . " " . $lastName;
    
                echo '</div>
                <div class="col-12 content">With their feedback, we can continue to improve our processes and processes.</div>
            </div>
        </div>
    </section>
    ';
    
    include "./src/content/footer.php";
    
    echo '</body>
    </html>';

    // SQL with secure informations and data validation [SQL-Injection, XSS, CSRF (See 'View files')]

    $sql = "INSERT INTO data (form, salutation, firstname, lastname, email, comments) VALUES ('Feedback', ?, ?, ?, ?, ?)";

    $stmt;

    if($stmt = $conn->prepare($sql)){

        $stmt->bind_param("sflec", validationContent($salutation), validationContent($firstName), validationContent($lastName), validationContent($email), validationContent($comments));

        $stmt->execute(array());

        while ($row = $statement->fetch()) {
            echo validationContent($row['salutation']);
            echo validationContent($row['firstname']);
            echo validationContent($row['lastname']);
            echo validationContent($row['email']);
            echo validationContent($row['comments']);
        }

        consoleLog("Created successfully a new entry: " . $stmt->affected_rows);

        $stmt->close();

    } else {

        consoleLog("Error: ");
        consoleLog($sql);
        consoleLog("<br/>");
        consoleLog($conn->error);

    }

} else {

    header("Location: /");
    exit;

}

?>