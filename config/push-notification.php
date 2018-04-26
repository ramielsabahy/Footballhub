<?php

return array(

    'MONTO'     => array(
        'environment' =>'development',
        // 'environment' =>'production',
        // 'cretificate' =>app_path().'/productionCertificate.pem',
        'certificate' =>app_path().'/developmentCertificate.pem',
        'passPhrase'  =>'',
        'service'     =>'apns'
    ),
    'MTC' => array(
        // 'environment' =>'production',
        'environment' =>'development',
        'apiKey'      =>'AAAANK6X3qc:APA91bEx_DwyTkdGEe6LDUP6E4MzFllcCOuCI1Agm0WXDdItjOps-mlJw8Q9AEpVFU8CnzVG90Qv4SAhxP7wUgRtKGlB3rPCanjSy0pja2_4x2ICQNRq5JJskHkG2hwzF50P8pszupPO',
        'service'     =>'gcm'
    )

);
