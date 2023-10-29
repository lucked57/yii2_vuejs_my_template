<?php
 $_POST = json_decode(file_get_contents('php://input'), true);


                    $email = $_POST['email'];
                    $name = $_POST['name'];
                    $text = $_POST['text'];
                    $subject5 = $_POST['subject'];

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

                      echo mail($to, $subject, $message, $headers);