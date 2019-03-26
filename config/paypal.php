<?php
return [
    'client_id' => env('PAYPAL_SANDBOX_CLIENT_ID'),
    'secret' => env('PAYPAL_SANDBOX_SECRET'),

    /**
     * SDK configuration 
     */
    'settings' => [

        /**
         * Available option 'sandbox' or 'live'
         */
        'mode' => 'sandbox',

        /**
         * Specify the max request time in seconds
         */
        'http.ConnectionTimeOut' => 30,

        /**
         * Whether want to log to a file
         */
        'log.LogEnabled' => true,

        /**
         * Specify the file that want to write on
         */
        'log.FileName' => storage_path() . '/logs/paypal.log',

        /**
         * Available option 'FINE', 'INFO', 'WARN' or 'ERROR'
         *
         * Logging is most verbose in the 'FINE' level and decreases as you
         * proceed towards ERROR
         */
        'log.LogLevel' => 'FINE'
    ],
    'webhooks' => [
        'webhook_id' => env('PAYPAL_WEBHOOK_ID'),
    ],
    /**
     * RMT trading fee when transfer to seller
     */
    'rmt_fee' => 0.0864,
    'cancel_fining_fee' => 0.02,
];
