<?php
return [
    'MA_number'=>'MAXXXXXXXX',
    'establishment'=>[
        'code'=>'S3C',
        'label'=>'xxx',
        'postage_label'=>'xxx',
        'postal_code'=>'13700'
    ],
    'depositor'=>[
        'COCLICO'=>'depositor_coclico',
        'corp_name'=>'depositor_corpname',
        'phone'=>'0442XXXXXX',
        'address'=>[
            'address'=>'2 AV XXX',
            'postal_code'=>'55XXX',
            'city'=>'UKNOWN',
            'mail'=>'foo.bar@foobar.com'
        ]
    ],

    'default_contractor'=>'default',
    'contractors'=>[
        'default'=>[
            'COCLICO'=>'xxx',
            'corp_name'=>'default_contractor_corp_name',
            'billing'=>[
                'COCLICO'=>'billing_coclico_default_contractor',
                'corp_name'=>'xxx',
                'phone'=>'0442XXXXXX'
            ],
            'european_identifier'=>'european_CE_identifier',
            'postage_contract_number'=>'xxx',
            'postage_account_number'=>'ACCxxx',
            'phone'=>'0442XXXXXX',
            'address'=>[
                'address'=>'2 AV XXX',
                'postal_code'=>'55XXX',
                'city'=>'UKNOWN',
                'mail'=>'foo.bar@foobar.com'
            ]
        ],
        'special'=>[
            'COCLICO'=>'special_COCLICO',
            'corp_name'=>'special_contractor_corp_name',
            'european_identifier'=>'european_CE_identifier',
            'postage_contract_number'=>'xxx',
            'postage_account_number'=>'xxx',
            'phone'=>'0442XXXXXX',
            'address'=>[
                'address'=>'2 AV XXX',
                'postal_code'=>'55XXX',
                'city'=>'UKNOWN',
                'mail'=>'foo.bar@foobar.com'
            ]
        ]
    ]
];