<?php

return [
    'login_path' => env('LDAP_LOGIN_PATH', 'https://auth-gw.int.batman.sevima.dev/api/v2/login'),
    'timeout'    => (int) env('LDAP_TIMEOUT', 6),
];
