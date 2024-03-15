<?php
$user = [
    $email = '1',
    $fullName = 2,
    $password = 3,
    $passwordConfirm = 4,
    $date = 5,
];
//print_r($user[$email]);
//print_r($user[$date]); /// почему так
///

$user[$email] = 'a';
$user[$fullName] = 'S';
$user[$password] = 'd';
$user[$passwordConfirm] = 'f';
$user[$date] = 'g';
//print_r($user);

$user2 = [
    $email => 'a',
    $fullName => 's',
    $password => 'd',
    $passwordConfirm => 'f',
    $date => 'g'
];
print_r($user2);
echo $email;


