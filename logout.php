<?php

session_start();
unset($_SESSION['contacts']);

echo "<script>alert('You have been logged out');
window.location.href='Login.html'; </script>"

?>