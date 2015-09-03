<!--#########################################################################-->
<!--# Copyright (c) 2015 Jonas Bjurel and others.                            -->
<!--# jonasbjurel@hotmail.com                                                -->
<!--# All rights reserved. This program and the accompanying materials       -->
<!--# are made available under the terms of the Apache License, Version 2.0  -->
<!--# which accompanies this distribution, and is available at               -->
<!--# http://www.apache.org/licenses/LICENSE-2.0                             -->
<!--#########################################################################-->
<html>
  <head>
    <title> OPNFV CI console output </title>
<!--    <meta http-equiv="refresh" content="2" /> -->
    <meta http-equiv="refresh" content="5" />  
  </head>
  <body>
    <p>
      <?php
        header( 'Content-type: text/html; charset=utf-8' );

        function follow($file)
        {
          $handle = popen("tail -f $file 2>&1", 'r');
          while(!feof($handle)) {
            $buffer = fgets($handle);
            echo "$buffer\n";
            flush();
            ob_flush();
          }
          pclose($handle);
        }


        $config_file="config.yaml";
        $config=yaml_parse_file($config_file);
        $repo_path=$config["ci_repo_path"];
        $status_file="/var/run/fuel/ci-status";
        $ci_status=get_metadata($status_file, $repo_path);
        echo "<pre>";
        echo "<b>OPNFV CI-console:</b> ";
        echo date('l jS \of F Y h:i:s A');
        echo "</br>";
        if ($ci_status["status"] != "IDLE") {
          follow($ci_status["log"]);
        }
        echo "</pre>";
      ?>
    </p>
  </body>
</html>
