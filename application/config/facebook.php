<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


    $config['facebook']['api_id'] = '793550200780191';
    $config['facebook']['app_secret'] = 'e62daaf52572fc062c6bd4c9a36f47fd';
    $config['facebook']['redirect_url'] = 'http://app.casadopirogue.com.br/delivery/login/facebook';
    $config['facebook']['next'] = 'http://app.casadopirogue.com.br/delivery/logout/facebook';
    $config['facebook']['permissions'] = array(
        'email',
        'user_location',
        'user_birthday'
    );

?>
