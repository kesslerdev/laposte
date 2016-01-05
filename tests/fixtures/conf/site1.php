<?php
return [

    'establishment'=>[
        'code'=>'S3C',
        'label'=>'xxx',
        'postage_label'=>'xxx',
        'postal_code'=>'13700'
    ],
    'depositor'=>[
        'COCLICO'=>'depositor_coclico',
        'corp_name'=>'depositor_corpname'
    ],

    'default_contractor'=>'default',
    'contractors'=>[
        'default'=>[
            'COCLICO'=>'xxx',
            'corp_name'=>'default_contractor_corp_name',
            'billing'=>[
                'COCLICO'=>'billing_coclico_default_contractor',
                'corp_name'=>'xxx',
            ],
            'european_identifier'=>'european_CE_identifier',
            'postage_contract_number'=>'xxx'
        ],
        'special'=>[
            'COCLICO'=>'special_COCLICO',
            'corp_name'=>'special_contractor_corp_name',
            'european_identifier'=>'european_CE_identifier',
            'postage_contract_number'=>'xxx'
        ]
    ]
];