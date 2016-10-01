<?php

return [

    'services' => [

        'github' => [
            'name'  =>  'Github',
        ],

        'google' => [
            'name'  =>  'Google',
        ],
    ],

    'events'    =>  [

        'github'    =>  [

            'created'   =>  \larashop\Events\Social\GithubAccountWasLinked::class,
        ],

        'google'    =>  [

            'created'   =>  \larashop\Events\Social\GoogleAccountWasLinked::class,
        ]
    ]
];