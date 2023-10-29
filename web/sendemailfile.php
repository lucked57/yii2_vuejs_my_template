<?php

                    $email = $_POST['email'];
                    $name = $_POST['name'];
                    $text = $_POST['text'];
                    $subject5 = $_POST['subject'];
                    $doc = $_FILES;
                    $doc_tmp_name = $doc['doc_file']['tmp_name'];
                    $doc_name = $doc['doc_file']['name'];
                    $doc_size = $doc['doc_file']['size'];

    $from_email      = 'week@examole.com'; //from mail, sender email address
    $recipient_email = 'ip557799@gmail.com'; //recipient email address
    //nova.group@weekapp.ru

    //Load POST data from HTML form
    $sender_name = $name; //sender name
    $reply_to_email = $email; //sender email, it will be used in "reply-to" header
    $subject     = $subject5; //subject for the email
    $message     = $text; //body of the email

    /*Always remember to validate the form fields like this
    if(strlen($sender_name)<1)
    {
        die('Name is too short or empty!');
    }
    */
    //Get uploaded file data using $_FILES array
    $tmp_name = $_FILES['doc_file']['tmp_name']; // get the temporary file name of the file on the server
    $name    = $_FILES['doc_file']['name']; // get the name of the file
    $size    = $_FILES['doc_file']['size']; // get size of the file for size validation
    $type    = $_FILES['doc_file']['type']; // get type of the file
    $error   = $_FILES['doc_file']['error']; // get the error (if any)

    //validate form field for attaching the file
    if($error > 0)
    {
        die('Upload error or No files uploaded');
    }

    //read from the uploaded file & base64_encode content
    $handle = fopen($tmp_name, "r"); // set the file handle only for reading the file
    $content = fread($handle, $size); // reading the file
    fclose($handle);                 // close upon completion

    $encoded_content = chunk_split(base64_encode($content));
    $boundary = md5("random"); // define boundary with a md5 hashed value

    //header
    $headers = "MIME-Version: 1.0\r\n"; // Defining the MIME version
    $headers .= "From:".$from_email."\r\n"; // Sender Email
    $headers .= "Reply-To: ".$reply_to_email."\r\n"; // Email address to reach back
    $headers .= "Content-Type: multipart/mixed;"; // Defining Content-Type
    $headers .= "boundary = $boundary\r\n"; //Defining the Boundary
        
    //plain text
    $body = "--$boundary\r\n";
    $body .= "Content-Type: text/html; charset=UTF-8\r\n";
    $body .= "Content-Transfer-Encoding: base64\r\n\r\n";
    $body .= chunk_split(base64_encode($message));
        
    //attachment
    $body .= "--$boundary\r\n";
    $body .="Content-Type: $type; name=".$name."\r\n";
    $body .="Content-Disposition: attachment; filename=".$name."\r\n";
    $body .="Content-Transfer-Encoding: base64\r\n";
    $body .="X-Attachment-Id: ".rand(1000, 99999)."\r\n\r\n";
    $body .= $encoded_content; // Attaching the encoded file with email
    
    $sentMailResult = mail($recipient_email, $subject, $body, $headers);

    if($sentMailResult )
    {
    echo "Данные успешно отправлены";
    // unlink($name); // delete the file after attachment sent.
    }
    else
    {
    die("Sorry but the email could not be sent.
                    Please go back and try again!");
    }



/*

                    $email = $_POST['email'];
                    $name = $_POST['name'];
                    $text = $_POST['text'];
                    $subject5 = $_POST['subject'];
                    $doc = $_FILES;
                    $doc_tmp_name = $doc['doc_file']['tmp_name'];
                    $doc_name = $doc['doc_file']['name'];
                    $doc_size = $doc['doc_file']['size'];
                    //echo $doc['doc_file']['tmp_name'];
                    //echo var_dump($_POST);

                    /*
                    array(1) {
  ["doc_file"]=>
  array(5) {
    ["name"]=>
    string(30) "Певнев ИСТЗ-20-2.pdf"
    ["type"]=>
    string(15) "application/pdf"
    ["tmp_name"]=>
    string(28) "W:\userdata\temp\php7AA6.tmp"
    ["error"]=>
    int(0)
    ["size"]=>
    int(114447)
  }
}*/

                  /*  $_SESSION['last_access'] = 'now';

                    $service = 'week вопрос по сайту';

                    $email_send = 'ip557799@gmail.com';

                    //nova.group@weekapp.ru

                    $to  = "<".$email_send.">" ;

                        $subject = $subject5; 

                        $message = '
                            <html>
                            <head>
                              <title>'.$subject5.'</title>
                            </head>
                            <body>
                              <p>Текст: '.$text.';</p> 
                              <p>От: '.$email.';</p>
                              <p>Имя: '.$name.';</p>
                            </body>
                            </html>
                            ';

                        $headers = 'From: week@example.com' . "\r\n" .
                        'Content-type: text/html; charset=UTF-8' . "\r\n" .
                        'Reply-To: '.$email . "\r\n" .
                        'X-Mailer: PHP/' . phpversion();

                      //echo mail($to, $subject, $message, $headers);*/