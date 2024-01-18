<?php return array (
  'app' =>
  array (
    'name' => 'Proapps',
    'env' => 'local',
    'debug' => true,
    'url' => 'http://localhost',
    'asset_url' => NULL,
    'timezone' => 'Asia/Jakarta',
    'locale' => 'id',
    'fallback_locale' => 'en',
    'faker_locale' => 'en_US',
    'key' => 'base64:RPae7CX5LvGAD7+Gzz95jsSVCQwsntyoLRSX+DoIyB4=',
    'cipher' => 'AES-256-CBC',
    'providers' =>
    array (
      0 => 'Illuminate\\Auth\\AuthServiceProvider',
      1 => 'Illuminate\\Broadcasting\\BroadcastServiceProvider',
      2 => 'Illuminate\\Bus\\BusServiceProvider',
      3 => 'Illuminate\\Cache\\CacheServiceProvider',
      4 => 'Illuminate\\Foundation\\Providers\\ConsoleSupportServiceProvider',
      5 => 'Illuminate\\Cookie\\CookieServiceProvider',
      6 => 'Illuminate\\Database\\DatabaseServiceProvider',
      7 => 'Illuminate\\Encryption\\EncryptionServiceProvider',
      8 => 'Illuminate\\Filesystem\\FilesystemServiceProvider',
      9 => 'Illuminate\\Foundation\\Providers\\FoundationServiceProvider',
      10 => 'Illuminate\\Hashing\\HashServiceProvider',
      11 => 'Illuminate\\Mail\\MailServiceProvider',
      12 => 'Illuminate\\Notifications\\NotificationServiceProvider',
      13 => 'Illuminate\\Pagination\\PaginationServiceProvider',
      14 => 'Illuminate\\Pipeline\\PipelineServiceProvider',
      15 => 'Illuminate\\Queue\\QueueServiceProvider',
      16 => 'Illuminate\\Redis\\RedisServiceProvider',
      17 => 'Illuminate\\Auth\\Passwords\\PasswordResetServiceProvider',
      18 => 'Illuminate\\Session\\SessionServiceProvider',
      19 => 'Illuminate\\Translation\\TranslationServiceProvider',
      20 => 'Illuminate\\Validation\\ValidationServiceProvider',
      21 => 'Illuminate\\View\\ViewServiceProvider',
      22 => 'SimpleSoftwareIO\\QrCode\\QrCodeServiceProvider',
      23 => 'App\\Providers\\AppServiceProvider',
      24 => 'App\\Providers\\AuthServiceProvider',
      25 => 'App\\Providers\\BroadcastServiceProvider',
      26 => 'App\\Providers\\EventServiceProvider',
      27 => 'App\\Providers\\RouteServiceProvider',
      28 => 'Barryvdh\\DomPDF\\ServiceProvider',
      29 => 'Intervention\\Image\\ImageServiceProvider',
      30 => 'Appy\\FcmHttpV1\\FcmProvider',
      31 => 'Tymon\\JWTAuth\\Providers\\LaravelServiceProvider',
    ),
    'aliases' =>
    array (
      'App' => 'Illuminate\\Support\\Facades\\App',
      'Arr' => 'Illuminate\\Support\\Arr',
      'Artisan' => 'Illuminate\\Support\\Facades\\Artisan',
      'Auth' => 'Illuminate\\Support\\Facades\\Auth',
      'Blade' => 'Illuminate\\Support\\Facades\\Blade',
      'Broadcast' => 'Illuminate\\Support\\Facades\\Broadcast',
      'Bus' => 'Illuminate\\Support\\Facades\\Bus',
      'Cache' => 'Illuminate\\Support\\Facades\\Cache',
      'Config' => 'Illuminate\\Support\\Facades\\Config',
      'Cookie' => 'Illuminate\\Support\\Facades\\Cookie',
      'Crypt' => 'Illuminate\\Support\\Facades\\Crypt',
      'Date' => 'Illuminate\\Support\\Facades\\Date',
      'DB' => 'Illuminate\\Support\\Facades\\DB',
      'Eloquent' => 'Illuminate\\Database\\Eloquent\\Model',
      'Event' => 'Illuminate\\Support\\Facades\\Event',
      'File' => 'Illuminate\\Support\\Facades\\File',
      'Gate' => 'Illuminate\\Support\\Facades\\Gate',
      'Hash' => 'Illuminate\\Support\\Facades\\Hash',
      'Http' => 'Illuminate\\Support\\Facades\\Http',
      'Js' => 'Illuminate\\Support\\Js',
      'Lang' => 'Illuminate\\Support\\Facades\\Lang',
      'Log' => 'Illuminate\\Support\\Facades\\Log',
      'Mail' => 'Illuminate\\Support\\Facades\\Mail',
      'Notification' => 'Illuminate\\Support\\Facades\\Notification',
      'Password' => 'Illuminate\\Support\\Facades\\Password',
      'Queue' => 'Illuminate\\Support\\Facades\\Queue',
      'RateLimiter' => 'Illuminate\\Support\\Facades\\RateLimiter',
      'Redirect' => 'Illuminate\\Support\\Facades\\Redirect',
      'Request' => 'Illuminate\\Support\\Facades\\Request',
      'Response' => 'Illuminate\\Support\\Facades\\Response',
      'Route' => 'Illuminate\\Support\\Facades\\Route',
      'Schema' => 'Illuminate\\Support\\Facades\\Schema',
      'Session' => 'Illuminate\\Support\\Facades\\Session',
      'Storage' => 'Illuminate\\Support\\Facades\\Storage',
      'Str' => 'Illuminate\\Support\\Str',
      'URL' => 'Illuminate\\Support\\Facades\\URL',
      'Validator' => 'Illuminate\\Support\\Facades\\Validator',
      'View' => 'Illuminate\\Support\\Facades\\View',
      'ConnectionDB' => 'App\\Helpers\\ConnectionDB',
      'QrCode' => 'SimpleSoftwareIO\\QrCode\\Facades\\QrCode',
      'Image' => 'Intervention\\Image\\Facades\\Image',
      'PDF' => 'Barryvdh\\DomPDF\\Facade',
      'JWTAuth' => 'Tymon\\JWTAuth\\Facades\\JWTAuth',
      'JWTFactory' => 'Tymon\\JWTAuth\\Facades\\JWTFactory',
    ),
  ),
  'auth' =>
  array (
    'defaults' =>
    array (
      'guard' => 'web',
      'passwords' => 'users',
    ),
    'guards' =>
    array (
      'web' =>
      array (
        'driver' => 'session',
        'provider' => 'users',
      ),
      'sanctum' =>
      array (
        'driver' => 'sanctum',
        'provider' => NULL,
      ),
    ),
    'providers' =>
    array (
      'users' =>
      array (
        'driver' => 'eloquent',
        'model' => 'App\\Models\\Login',
      ),
    ),
    'passwords' =>
    array (
      'users' =>
      array (
        'provider' => 'users',
        'table' => 'password_resets',
        'expire' => 60,
        'throttle' => 60,
      ),
    ),
    'password_timeout' => 10800,
  ),
  'broadcasting' =>
  array (
    'default' => 'pusher',
    'connections' =>
    array (
      'pusher' =>
      array (
        'driver' => 'pusher',
        'key' => '16261eeba4cdd90c12f2',
        'secret' => 'a55c01cbf5edf0782924',
        'app_id' => '1736018',
        'options' =>
        array (
          'cluster' => 'ap1',
          'encrypted' => true,
        ),
      ),
      'ably' =>
      array (
        'driver' => 'ably',
        'key' => NULL,
      ),
      'redis' =>
      array (
        'driver' => 'redis',
        'connection' => 'default',
      ),
      'log' =>
      array (
        'driver' => 'log',
      ),
      'null' =>
      array (
        'driver' => 'null',
      ),
    ),
  ),
  'cache' =>
  array (
    'default' => 'file',
    'stores' =>
    array (
      'apc' =>
      array (
        'driver' => 'apc',
      ),
      'array' =>
      array (
        'driver' => 'array',
        'serialize' => false,
      ),
      'database' =>
      array (
        'driver' => 'database',
        'table' => 'cache',
        'connection' => NULL,
        'lock_connection' => NULL,
      ),
      'file' =>
      array (
        'driver' => 'file',
        'path' => '/Users/akmalrifqi/Development/laravel/indoland/proapps/storage/framework/cache/data',
      ),
      'memcached' =>
      array (
        'driver' => 'memcached',
        'persistent_id' => NULL,
        'sasl' =>
        array (
          0 => NULL,
          1 => NULL,
        ),
        'options' =>
        array (
        ),
        'servers' =>
        array (
          0 =>
          array (
            'host' => '127.0.0.1',
            'port' => 11211,
            'weight' => 100,
          ),
        ),
      ),
      'redis' =>
      array (
        'driver' => 'redis',
        'connection' => 'cache',
        'lock_connection' => 'default',
      ),
      'dynamodb' =>
      array (
        'driver' => 'dynamodb',
        'key' => '',
        'secret' => '',
        'region' => 'us-east-1',
        'table' => 'cache',
        'endpoint' => NULL,
      ),
      'octane' =>
      array (
        'driver' => 'octane',
      ),
    ),
    'prefix' => 'proapps_cache',
  ),
  'cors' =>
  array (
    'paths' =>
    array (
      0 => 'api/*',
      1 => 'sanctum/csrf-cookie',
    ),
    'allowed_methods' =>
    array (
      0 => '*',
    ),
    'allowed_origins' =>
    array (
      0 => '*',
    ),
    'allowed_origins_patterns' =>
    array (
    ),
    'allowed_headers' =>
    array (
      0 => '*',
    ),
    'exposed_headers' =>
    array (
    ),
    'max_age' => 0,
    'supports_credentials' => false,
  ),
  'database' =>
  array (
    'default' => 'mysql',
    'connections' =>
    array (
      'sqlite' =>
      array (
        'driver' => 'sqlite',
        'url' => NULL,
        'database' => 'db_login',
        'prefix' => '',
        'foreign_key_constraints' => true,
      ),
      'mysql' =>
      array (
        'driver' => 'mysql',
        'url' => NULL,
        'host' => '127.0.0.1',
        'port' => '3306',
        'database' => 'db_login',
        'username' => 'root',
        'password' => 'root',
        'unix_socket' => '',
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'prefix' => '',
        'prefix_indexes' => true,
        'strict' => true,
        'engine' => NULL,
        'options' =>
        array (
        ),
      ),
      'park-royale' =>
      array (
        'driver' => 'mysql',
        'host' => '127.0.0.1',
        'database' => 'park-royale',
        'username' => 'root',
        'password' => 'root',
        'charset' => 'utf8',
        'midtrans_merchant_id' => 'G584029423G014143018',
      ),
      'central-point' =>
      array (
        'driver' => 'mysql',
        'host' => '127.0.0.1',
        'database' => 'central-point',
        'username' => 'root',
        'password' => 'root',
        'charset' => 'utf8',
      ),
      'pgsql' =>
      array (
        'driver' => 'pgsql',
        'url' => NULL,
        'host' => '127.0.0.1',
        'port' => '3306',
        'database' => 'db_login',
        'username' => 'root',
        'password' => 'root',
        'charset' => 'utf8',
        'prefix' => '',
        'prefix_indexes' => true,
        'schema' => 'public',
        'sslmode' => 'prefer',
      ),
      'sqlsrv' =>
      array (
        'driver' => 'sqlsrv',
        'url' => NULL,
        'host' => '127.0.0.1',
        'port' => '3306',
        'database' => 'db_login',
        'username' => 'root',
        'password' => 'root',
        'charset' => 'utf8',
        'prefix' => '',
        'prefix_indexes' => true,
      ),
    ),
    'migrations' => 'migrations',
    'redis' =>
    array (
      'client' => 'phpredis',
      'options' =>
      array (
        'cluster' => 'redis',
        'prefix' => 'proapps_database',
      ),
      'default' =>
      array (
        'url' => NULL,
        'host' => '127.0.0.1',
        'password' => NULL,
        'port' => '6379',
        'database' => '0',
      ),
      'cache' =>
      array (
        'url' => NULL,
        'host' => '127.0.0.1',
        'password' => NULL,
        'port' => '6379',
        'database' => '1',
      ),
    ),
  ),
  'fcm_config' =>
  array (
    'firebase_config' =>
    array (
      'apiKey' => 'AIzaSyCJyCzpSYcjJ1UD8-CpdvegcxKnYImavow',
      'authDomain' => 'proapps-d8080.appspot.com',
      'projectId' => 'proapps-d8080',
      'storageBucket' => 'proapps-d8080.appspot.com',
      'messagingSenderId' => '921000558886',
      'appId' => '1:921000558886:android:310a1e19e2fcb540e501e7',
    ),
    'fcm_api_url' => 'https://fcm.googleapis.com/v1/projects/proapps-d8080/messages:send',
    'fcm_api_server_key' => 'AAAA1m_pQSY:APA91bH02iTqdM75ca8Fvgn_O0AQYzHy6tmF0SYtlm5o5a4Iwt92qnXULLg6SmlOCEQL5Wdl0TE4MIk0Zu21cSU5vJY3iP1L5OdoNbNv66-Ht26DekJ-tCdLtf1vHJbnLPJYxRPCWF0p',
    'fcm_json_path' => '/Users/akmalrifqi/Development/laravel/indoland/proapps/proapps-d8080-b243c85ed937.json',
  ),
  'filesystems' =>
  array (
    'default' => 'local',
    'disks' =>
    array (
      'local' =>
      array (
        'driver' => 'local',
        'root' => '/Users/akmalrifqi/Development/laravel/indoland/proapps/storage/app',
      ),
      'public' =>
      array (
        'driver' => 'local',
        'root' => '/Users/akmalrifqi/Development/laravel/indoland/proapps/storage/app/public',
        'url' => 'http://localhost/storage',
        'visibility' => 'public',
      ),
      's3' =>
      array (
        'driver' => 's3',
        'key' => '',
        'secret' => '',
        'region' => 'us-east-1',
        'bucket' => '',
        'url' => NULL,
        'endpoint' => NULL,
        'use_path_style_endpoint' => false,
      ),
    ),
    'links' =>
    array (
      '/Users/akmalrifqi/Development/laravel/indoland/proapps/public/storage' => '/Users/akmalrifqi/Development/laravel/indoland/proapps/storage/app/public',
    ),
  ),
  'hashing' =>
  array (
    'driver' => 'bcrypt',
    'bcrypt' =>
    array (
      'rounds' => 10,
    ),
    'argon' =>
    array (
      'memory' => 65536,
      'threads' => 1,
      'time' => 4,
    ),
  ),
  'jwt' =>
  array (
    'secret' => 'kD3EB10a5GNFmO87Jd5FerrXWJXqNi1XlMLdpF6ZCeF8wZ2Q4svorKXmAfPV4Ohd',
    'keys' =>
    array (
      'public' => NULL,
      'private' => NULL,
      'passphrase' => NULL,
    ),
    'ttl' => NULL,
    'refresh_ttl' => 20160,
    'algo' => 'HS256',
    'required_claims' =>
    array (
      0 => 'iss',
      1 => 'sub',
      2 => 'iat',
      3 => 'jti',
    ),
    'persistent_claims' =>
    array (
    ),
    'lock_subject' => true,
    'leeway' => 0,
    'blacklist_enabled' => false,
    'blacklist_grace_period' => 0,
    'decrypt_cookies' => false,
    'providers' =>
    array (
      'jwt' => 'Tymon\\JWTAuth\\Providers\\JWT\\Lcobucci',
      'auth' => 'Tymon\\JWTAuth\\Providers\\Auth\\Illuminate',
      'storage' => 'Tymon\\JWTAuth\\Providers\\Storage\\Illuminate',
    ),
  ),
  'larafirebase' =>
  array (
    'authentication_key' => 'AAAA7hjlDzE:APA91bFmJUoGuDpWuw_IKucEtgPSQrYmlKWZ_yiMbWWzSaPGPW5rzoir7ToUeVmLezkjXzFcd__MxzeU2wdW_7aebRDOKGEbjcCLxNpNYxCWO3Yn2ob-UWykbVxF_jUMYZhP-xV5B50F',
  ),
  'logging' =>
  array (
    'default' => 'stack',
    'deprecations' => NULL,
    'channels' =>
    array (
      'stack' =>
      array (
        'driver' => 'stack',
        'channels' =>
        array (
          0 => 'single',
        ),
        'ignore_exceptions' => false,
      ),
      'single' =>
      array (
        'driver' => 'single',
        'path' => '/Users/akmalrifqi/Development/laravel/indoland/proapps/storage/logs/laravel.log',
        'level' => 'debug',
      ),
      'daily' =>
      array (
        'driver' => 'daily',
        'path' => '/Users/akmalrifqi/Development/laravel/indoland/proapps/storage/logs/laravel.log',
        'level' => 'debug',
        'days' => 14,
      ),
      'slack' =>
      array (
        'driver' => 'slack',
        'url' => NULL,
        'username' => 'Laravel Log',
        'emoji' => ':boom:',
        'level' => 'debug',
      ),
      'papertrail' =>
      array (
        'driver' => 'monolog',
        'level' => 'debug',
        'handler' => 'Monolog\\Handler\\SyslogUdpHandler',
        'handler_with' =>
        array (
          'host' => NULL,
          'port' => NULL,
        ),
      ),
      'stderr' =>
      array (
        'driver' => 'monolog',
        'level' => 'debug',
        'handler' => 'Monolog\\Handler\\StreamHandler',
        'formatter' => NULL,
        'with' =>
        array (
          'stream' => 'php://stderr',
        ),
      ),
      'syslog' =>
      array (
        'driver' => 'syslog',
        'level' => 'debug',
      ),
      'errorlog' =>
      array (
        'driver' => 'errorlog',
        'level' => 'debug',
      ),
      'null' =>
      array (
        'driver' => 'monolog',
        'handler' => 'Monolog\\Handler\\NullHandler',
      ),
      'emergency' =>
      array (
        'path' => '/Users/akmalrifqi/Development/laravel/indoland/proapps/storage/logs/laravel.log',
      ),
    ),
  ),
  'mail' =>
  array (
    'default' => 'smtp',
    'mailers' =>
    array (
      'smtp' =>
      array (
        'transport' => 'smtp',
        'host' => 'sandbox.smtp.mailtrap.io',
        'port' => '2525',
        'encryption' => NULL,
        'username' => 'd0ddc86577ec85',
        'password' => '477cf14b67f3f1',
        'timeout' => NULL,
        'auth_mode' => NULL,
      ),
      'ses' =>
      array (
        'transport' => 'ses',
      ),
      'mailgun' =>
      array (
        'transport' => 'mailgun',
      ),
      'postmark' =>
      array (
        'transport' => 'postmark',
      ),
      'sendmail' =>
      array (
        'transport' => 'sendmail',
        'path' => '/usr/sbin/sendmail -t -i',
      ),
      'log' =>
      array (
        'transport' => 'log',
        'channel' => NULL,
      ),
      'array' =>
      array (
        'transport' => 'array',
      ),
      'failover' =>
      array (
        'transport' => 'failover',
        'mailers' =>
        array (
          0 => 'smtp',
          1 => 'log',
        ),
      ),
    ),
    'from' =>
    array (
      'address' => 'proapps.idn@gmail.com',
      'name' => 'Proapps',
    ),
    'markdown' =>
    array (
      'theme' => 'default',
      'paths' =>
      array (
        0 => '/Users/akmalrifqi/Development/laravel/indoland/proapps/resources/views/vendor/mail',
      ),
    ),
  ),
  'mapbox' =>
  array (
    'mapbox_token' => 'pk.eyJ1IjoicmlmcWk0MzIwIiwiYSI6ImNsbWFhbzhwODB1N2ozZG81bTJpZWJwamoifQ.1MRlqW9smYuN1wIieOEg2w',
  ),
  'midtrans' =>
  array (
    'mercant_id' => NULL,
    'client_key' => NULL,
    'server_key' => NULL,
    'is_production' => false,
    'is_sanitized' => false,
    'is_3ds' => false,
  ),
  'queue' =>
  array (
    'default' => 'database',
    'connections' =>
    array (
      'sync' =>
      array (
        'driver' => 'sync',
      ),
      'database' =>
      array (
        'driver' => 'database',
        'table' => 'jobs',
        'queue' => 'default',
        'retry_after' => 9000,
      ),
      'beanstalkd' =>
      array (
        'driver' => 'beanstalkd',
        'host' => 'localhost',
        'queue' => 'default',
        'retry_after' => 90,
        'block_for' => 0,
        'after_commit' => false,
      ),
      'sqs' =>
      array (
        'driver' => 'sqs',
        'key' => '',
        'secret' => '',
        'prefix' => 'https://sqs.us-east-1.amazonaws.com/your-account-id',
        'queue' => 'default',
        'suffix' => NULL,
        'region' => 'us-east-1',
        'after_commit' => false,
      ),
      'redis' =>
      array (
        'driver' => 'redis',
        'connection' => 'default',
        'queue' => 'default',
        'retry_after' => 90,
        'block_for' => NULL,
        'after_commit' => false,
      ),
    ),
    'failed' =>
    array (
      'driver' => 'database-uuids',
      'database' => 'mysql',
      'table' => 'failed_jobs',
    ),
  ),
  'sanctum' =>
  array (
    'stateful' =>
    array (
      0 => 'localhost',
      1 => 'localhost:3000',
      2 => '127.0.0.1',
      3 => '127.0.0.1:8000',
      4 => '::1',
      5 => 'localhost',
    ),
    'guard' =>
    array (
      0 => 'web',
    ),
    'expiration' => NULL,
    'middleware' =>
    array (
      'verify_csrf_token' => 'App\\Http\\Middleware\\VerifyCsrfToken',
      'encrypt_cookies' => 'App\\Http\\Middleware\\EncryptCookies',
    ),
  ),
  'services' =>
  array (
    'mailgun' =>
    array (
      'domain' => NULL,
      'secret' => NULL,
      'endpoint' => 'api.mailgun.net',
    ),
    'postmark' =>
    array (
      'token' => NULL,
    ),
    'ses' =>
    array (
      'key' => '',
      'secret' => '',
      'region' => 'us-east-1',
    ),
  ),
  'session' =>
  array (
    'driver' => 'file',
    'lifetime' => '120',
    'expire_on_close' => false,
    'encrypt' => false,
    'files' => '/Users/akmalrifqi/Development/laravel/indoland/proapps/storage/framework/sessions',
    'connection' => NULL,
    'table' => 'sessions',
    'store' => NULL,
    'lottery' =>
    array (
      0 => 2,
      1 => 100,
    ),
    'cookie' => 'proapps_session',
    'path' => '/',
    'domain' => NULL,
    'secure' => NULL,
    'http_only' => true,
    'same_site' => 'lax',
  ),
  'sweetalert' =>
  array (
    'theme' => 'default',
    'cdn' => NULL,
    'alwaysLoadJS' => false,
    'neverLoadJS' => false,
    'timer' => 5000,
    'width' => '32rem',
    'height_auto' => true,
    'padding' => '1.25rem',
    'background' => '#fff',
    'animation' =>
    array (
      'enable' => false,
    ),
    'animatecss' => 'https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css',
    'show_confirm_button' => true,
    'show_close_button' => false,
    'button_text' =>
    array (
      'confirm' => 'OK',
      'cancel' => 'Cancel',
    ),
    'toast_position' => 'top-end',
    'timer_progress_bar' => false,
    'middleware' =>
    array (
      'autoClose' => false,
      'toast_position' => 'top-end',
      'toast_close_button' => true,
      'timer' => 6000,
      'auto_display_error_messages' => true,
    ),
    'customClass' =>
    array (
      'container' => NULL,
      'popup' => NULL,
      'header' => NULL,
      'title' => NULL,
      'closeButton' => NULL,
      'icon' => NULL,
      'image' => NULL,
      'content' => NULL,
      'input' => NULL,
      'actions' => NULL,
      'confirmButton' => NULL,
      'cancelButton' => NULL,
      'footer' => NULL,
    ),
    'confirm_delete_confirm_button_text' => 'Yes, delete it!',
    'confirm_delete_confirm_button_color' => NULL,
    'confirm_delete_cancel_button_color' => '#d33',
    'confirm_delete_cancel_button_text' => 'Cancel',
    'confirm_delete_show_cancel_button' => true,
    'confirm_delete_show_close_button' => false,
    'confirm_delete_icon' => 'warning',
    'confirm_delete_show_loader_on_confirm' => true,
  ),
  'view' =>
  array (
    'paths' =>
    array (
      0 => '/Users/akmalrifqi/Development/laravel/indoland/proapps/resources/views',
    ),
    'compiled' => '/Users/akmalrifqi/Development/laravel/indoland/proapps/storage/framework/views',
  ),
  'websockets' =>
  array (
    'dashboard' =>
    array (
      'port' => 6001,
    ),
    'apps' =>
    array (
      0 =>
      array (
        'id' => '1736018',
        'name' => 'Proapps',
        'key' => '16261eeba4cdd90c12f2',
        'secret' => 'a55c01cbf5edf0782924',
        'enable_client_messages' => true,
        'enable_statistics' => true,
        'encrypted' => true,
      ),
    ),
    'app_provider' => 'BeyondCode\\LaravelWebSockets\\Apps\\ConfigAppProvider',
    'max_request_size_in_kb' => 250,
    'path' => 'laravel-websockets',
    'middleware' =>
    array (
      0 => 'web',
      1 => 'BeyondCode\\LaravelWebSockets\\Dashboard\\Http\\Middleware\\Authorize',
    ),
    'statistics' =>
    array (
      'model' => 'BeyondCode\\LaravelWebSockets\\Statistics\\Models\\WebSocketsStatisticsEntry',
      'logger' => 'BeyondCode\\LaravelWebSockets\\Statistics\\Logger\\HttpStatisticsLogger',
      'interval_in_seconds' => 60,
      'delete_statistics_older_than_days' => 60,
      'perform_dns_lookup' => false,
    ),
    'ssl' =>
    array (
      'local_cert' => NULL,
      'local_pk' => NULL,
      'passphrase' => NULL,
    ),
    'channel_manager' => 'BeyondCode\\LaravelWebSockets\\WebSockets\\Channels\\ChannelManagers\\ArrayChannelManager',
  ),
  'dompdf' =>
  array (
    'show_warnings' => false,
    'public_path' => NULL,
    'convert_entities' => true,
    'options' =>
    array (
      'font_dir' => '/Users/akmalrifqi/Development/laravel/indoland/proapps/storage/fonts',
      'font_cache' => '/Users/akmalrifqi/Development/laravel/indoland/proapps/storage/fonts',
      'temp_dir' => '/var/folders/m7/5dv4dtpx6_j__sx_k8w27l7h0000gn/T',
      'chroot' => '/Users/akmalrifqi/Development/laravel/indoland/proapps',
      'allowed_protocols' =>
      array (
        'file://' =>
        array (
          'rules' =>
          array (
          ),
        ),
        'http://' =>
        array (
          'rules' =>
          array (
          ),
        ),
        'https://' =>
        array (
          'rules' =>
          array (
          ),
        ),
      ),
      'log_output_file' => NULL,
      'enable_font_subsetting' => false,
      'pdf_backend' => 'CPDF',
      'default_media_type' => 'screen',
      'default_paper_size' => 'a4',
      'default_paper_orientation' => 'portrait',
      'default_font' => 'serif',
      'dpi' => 96,
      'enable_php' => false,
      'enable_javascript' => true,
      'enable_remote' => true,
      'font_height_ratio' => 1.1,
      'enable_html5_parser' => true,
    ),
  ),
  'flare' =>
  array (
    'key' => NULL,
    'reporting' =>
    array (
      'anonymize_ips' => true,
      'collect_git_information' => false,
      'report_queries' => true,
      'maximum_number_of_collected_queries' => 200,
      'report_query_bindings' => true,
      'report_view_data' => true,
      'grouping_type' => NULL,
      'report_logs' => true,
      'maximum_number_of_collected_logs' => 200,
      'censor_request_body_fields' =>
      array (
        0 => 'password',
      ),
    ),
    'send_logs_as_events' => true,
    'censor_request_body_fields' =>
    array (
      0 => 'password',
    ),
  ),
  'ignition' =>
  array (
    'editor' => 'phpstorm',
    'theme' => 'light',
    'enable_share_button' => true,
    'register_commands' => false,
    'ignored_solution_providers' =>
    array (
      0 => 'Facade\\Ignition\\SolutionProviders\\MissingPackageSolutionProvider',
    ),
    'enable_runnable_solutions' => NULL,
    'remote_sites_path' => '',
    'local_sites_path' => '',
    'housekeeping_endpoint_prefix' => '_ignition',
  ),
  'image' =>
  array (
    'driver' => 'gd',
  ),
  'excel' =>
  array (
    'exports' =>
    array (
      'chunk_size' => 1000,
      'pre_calculate_formulas' => false,
      'strict_null_comparison' => false,
      'csv' =>
      array (
        'delimiter' => ',',
        'enclosure' => '"',
        'line_ending' => '
',
        'use_bom' => false,
        'include_separator_line' => false,
        'excel_compatibility' => false,
        'output_encoding' => '',
        'test_auto_detect' => true,
      ),
      'properties' =>
      array (
        'creator' => '',
        'lastModifiedBy' => '',
        'title' => '',
        'description' => '',
        'subject' => '',
        'keywords' => '',
        'category' => '',
        'manager' => '',
        'company' => '',
      ),
    ),
    'imports' =>
    array (
      'read_only' => true,
      'ignore_empty' => false,
      'heading_row' =>
      array (
        'formatter' => 'slug',
      ),
      'csv' =>
      array (
        'delimiter' => NULL,
        'enclosure' => '"',
        'escape_character' => '\\',
        'contiguous' => false,
        'input_encoding' => 'UTF-8',
      ),
      'properties' =>
      array (
        'creator' => '',
        'lastModifiedBy' => '',
        'title' => '',
        'description' => '',
        'subject' => '',
        'keywords' => '',
        'category' => '',
        'manager' => '',
        'company' => '',
      ),
    ),
    'extension_detector' =>
    array (
      'xlsx' => 'Xlsx',
      'xlsm' => 'Xlsx',
      'xltx' => 'Xlsx',
      'xltm' => 'Xlsx',
      'xls' => 'Xls',
      'xlt' => 'Xls',
      'ods' => 'Ods',
      'ots' => 'Ods',
      'slk' => 'Slk',
      'xml' => 'Xml',
      'gnumeric' => 'Gnumeric',
      'htm' => 'Html',
      'html' => 'Html',
      'csv' => 'Csv',
      'tsv' => 'Csv',
      'pdf' => 'Dompdf',
    ),
    'value_binder' =>
    array (
      'default' => 'Maatwebsite\\Excel\\DefaultValueBinder',
    ),
    'cache' =>
    array (
      'driver' => 'memory',
      'batch' =>
      array (
        'memory_limit' => 60000,
      ),
      'illuminate' =>
      array (
        'store' => NULL,
      ),
      'default_ttl' => 10800,
    ),
    'transactions' =>
    array (
      'handler' => 'db',
      'db' =>
      array (
        'connection' => NULL,
      ),
    ),
    'temporary_files' =>
    array (
      'local_path' => '/Users/akmalrifqi/Development/laravel/indoland/proapps/storage/framework/cache/laravel-excel',
      'local_permissions' =>
      array (
      ),
      'remote_disk' => NULL,
      'remote_prefix' => NULL,
      'force_resync_remote' => NULL,
    ),
  ),
  'sluggable' =>
  array (
    'source' => NULL,
    'maxLength' => NULL,
    'maxLengthKeepWords' => true,
    'method' => NULL,
    'separator' => '-',
    'unique' => true,
    'uniqueSuffix' => NULL,
    'firstUniqueSuffix' => 2,
    'includeTrashed' => false,
    'reserved' => NULL,
    'onUpdate' => false,
    'slugEngineOptions' =>
    array (
    ),
  ),
  'tinker' =>
  array (
    'commands' =>
    array (
    ),
    'alias' =>
    array (
    ),
    'dont_alias' =>
    array (
      0 => 'App\\Nova',
    ),
  ),
);
