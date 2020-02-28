<?php

$id_current_user->popValue();

$key = new \advor\module\SessionVar(UID . 'key');
$key->popValue();

header('Location: ' . BASE_URL);
exit();

