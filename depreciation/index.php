<?php

require_once 'app/DoubleDecliningBalanceDepreciation.php';

$DoubleDecliningBalanceDepreciation = new DoubleDecliningBalanceDepreciation(2500, 45000, 6);
$DoubleDecliningBalanceDepreciation->calculateDepreciation();