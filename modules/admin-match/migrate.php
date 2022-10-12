<?php 

return [
    'LibUserPerm\\Model\\UserPerm' => [
        'data' => [
            'name' => [
                'manage_match'      => ['group'=>'Match','about'=>'Allow user to manage own matchs'],
                'manage_match_all'  => ['group'=>'Match','about'=>'Allow user to manage all matchs'],
                'remove_match'      => ['group'=>'Match','about'=>'Allow user to remove matchs'],
                'publish_match'     => ['group'=>'Match','about'=>'Allow user to publish matchs'],
            ]
        ]
    ]
];