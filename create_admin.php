<?<?php

$password = "7654321";

echo password_hash(
    $password,
    PASSWORD_DEFAULT
);