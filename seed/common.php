<?php

/**
 * for csrf
 */


 /**
  * escape function
  */

function escape($html) {
    return htmlspecialchars($html, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8");
}

?>