<?php
      session_start();
      (string) $fname = dirname(__FILE__) . '/../' . (string)$_SESSION['filename'];
      highlight_file($fname);
?>