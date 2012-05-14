<?php
# Utility page for resetting the form when things go wrong
session_start();
session_unset();
session_destroy();
?>
