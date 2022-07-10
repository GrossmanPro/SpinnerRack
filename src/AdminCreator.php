<?php
require_once 'Setup.php';
print drawHeader('Admin');
print '<div class="container">';
print Creator::getCreatorTable($pdo);
print '</div>';
print drawFooter(array('AdminCreator.js'));

