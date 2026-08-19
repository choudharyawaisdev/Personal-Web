<?php
/**
 * Secure SMTP Mailer using PHP Sockets
 * Connects directly to Gmail SMTP (smtp.gmail.com) on port 465 using SSL.
 */
function send_smtp_email($to, $subject, $body, $from_name = 'Portfolio Contact') {
    $host = 'smtp.gmail.com';
    $port = 465;
    $username = 'chawaisdev92@gmail.com';
    $password = 'drznjqguxqzpqzec'; // Cleaned Gmail App Password

    $timeout = 15;
    
    // Connect to Gmail SMTP Server over SSL
    $socket = @fsockopen('ssl://' . $host, $port, $errno, $errstr, $timeout);
    if (!$socket) {
        error_log("SMTP connection failed: $errstr ($errno)");
        return false;
    }
    
    // Helper to read SMTP responses
    $read_response = function($socket, $expected) {
        $response = '';
        while ($line = fgets($socket, 515)) {
            $response .= $line;
            if (substr($line, 3, 1) === ' ') {
                break;
            }
        }
        $code = intval(substr($response, 0, 3));
        return $code === $expected;
    };
    
    // Read Welcome message
    if (!$read_response($socket, 220)) { fclose($socket); return false; }
    
    // HELO/EHLO
    fwrite($socket, "EHLO localhost\r\n");
    if (!$read_response($socket, 250)) { fclose($socket); return false; }
    
    // AUTH LOGIN
    fwrite($socket, "AUTH LOGIN\r\n");
    if (!$read_response($socket, 334)) { fclose($socket); return false; }
    
    // Username authentication
    fwrite($socket, base64_encode($username) . "\r\n");
    if (!$read_response($socket, 334)) { fclose($socket); return false; }
    
    // Password authentication
    fwrite($socket, base64_encode($password) . "\r\n");
    if (!$read_response($socket, 235)) { fclose($socket); return false; }
    
    // MAIL FROM
    fwrite($socket, "MAIL FROM: <$username>\r\n");
    if (!$read_response($socket, 250)) { fclose($socket); return false; }
    
    // RCPT TO
    fwrite($socket, "RCPT TO: <$to>\r\n");
    if (!$read_response($socket, 250)) { fclose($socket); return false; }
    
    // DATA
    fwrite($socket, "DATA\r\n");
    if (!$read_response($socket, 354)) { fclose($socket); return false; }
    
    // Email body headers
    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
    $headers .= "To: $to\r\n";
    $headers .= "From: =?UTF-8?B?" . base64_encode($from_name) . "?= <$username>\r\n";
    $headers .= "Subject: =?UTF-8?B?" . base64_encode($subject) . "?=\r\n";
    $headers .= "Date: " . date('r') . "\r\n";
    
    // Content body format
    $message = $headers . "\r\n" . $body . "\r\n.\r\n";
    
    fwrite($socket, $message);
    if (!$read_response($socket, 250)) { fclose($socket); return false; }
    
    // QUIT
    fwrite($socket, "QUIT\r\n");
    fclose($socket);
    
    return true;
}
?>
