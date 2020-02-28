<?php

$key = new \advor\module\SessionVar(UID . 'key');
$key->popValue();
$id_current_user->popValue();

header('Location: ' . BASE_URL);
exit();

