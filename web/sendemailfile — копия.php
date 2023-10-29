<?php


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

                    $_SESSION['last_access'] = 'now';

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

                      //echo mail($to, $subject, $message, $headers);