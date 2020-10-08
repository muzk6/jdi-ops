<?php

require __DIR__ . '/../init.php';

include PATH_ROUTES . '/index.php';

svc_router()->dispatch();