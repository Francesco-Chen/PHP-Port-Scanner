<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Port Scanner</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }
        h1 {
            font-size: 24px;
            margin-bottom: 10px;
        }
        form,div{
            background-color: #fff;
            border: 1px solid #ccc;
            padding: 20px;
            margin: 20px auto;
            max-width: 600px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }
        label {
            display: inline-block;
            width: 100px;
            margin-bottom: 10px;
        }
        input[type="text"] {
            padding: 8px;
            margin: 4px 0;
            border: 1px solid #ccc;
            border-radius: 3px;
            font-size: 16px;
            width: calc(100% - 105px);
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 3px;
            font-size: 16px;
            cursor: pointer;
            width: 100%
        }
        input[type="submit"]:hover {
            background-color: #3e8e41;
        }
        .result {
            margin-top: 20px;
        }
        .result h2 {
            font-size: 18px;
            margin-bottom: 10px;
        }
        .result p {
            margin: 5px 0;
        }
        .result .open {
            color: green;
            font-weight: bold;
        }
        .result .closed {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h1 style="text-align: center;">Scan ports</h1>
    <div>You can scan multiple ports at once, separated by commas, such as 80,443.
        <p><strong>Common ports:</strong> 21, 22, 25, 53, 80, 443, 445, 3389, 5000</p>
            <p><strong>Mail server ports:</strong> 25, 110, 143, 465, 587, 993, 995, 2525, 4190, 5222, 6010, 9025, 10019</p>  
            <p><strong>CF HTTP & HTTPS ports:</strong> 80, 443, 2052, 2053, 2082, 2083, 2086, 2087, 2095, 2096, 8080, 8443</p>
    </div>
    <!-- comon ports 21,22,25,53,80,443,445,3389,5000 
    mail server 25, 110, 143, 465, 587, 993, 995, 2525, 4190, 5222, 6010, 9025, 10019 
    CF http&https 80, 443, 2052, 2053, 2082, 2083, 2086, 2087, 2095, 2096, 8080, 8443 -->
    <form method="post">
        <label>Domain/IP:</label>
        <input type="text" name="domain" />
        <br />
        <label>Ports:</label>
        <input type="text" name="port" />
        <br />
        <input type="submit" value="Scan" />
    </form>
    <?php
    if(!empty($_POST['domain']) && !empty($_POST['port'])) {
        $domain = $_POST['domain'];
        echo "<div class=\"result\"><h2>Results for $domain:</h2>";
        
        $ports = explode(",", $_POST['port']);
        
        foreach ($ports as $port) {
            $port = trim($port);
            $prot = getservbyport($port, "tcp");
            echo "<p>Port $port ($prot): ";

            if (filter_var($domain, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
                $domain = "[" . $domain . "]";
            }
            
            if ($pf = @fsockopen($domain, $port, $err, $err_string, 1)) {
                echo "<span class=\"open\">open</span></p>";
                fclose($pf);
            } else {
                echo "<span class=\"closed\">closed</span></p>";
            }
        }
        
        echo "</div>";
    }
    ?>
</body>
</html>
