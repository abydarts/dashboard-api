<?php 

return [
    'LibUserPerm\\Model\\UserPerm' => [
        'data' => [
            'name' => [
                'manage_team'      => ['group'=>'Team','about'=>'Allow user to manage own teams'],
                'manage_team_all'  => ['group'=>'Team','about'=>'Allow user to manage all teams'],
                'remove_team'      => ['group'=>'Team','about'=>'Allow user to remove teams'],
                'publish_team'     => ['group'=>'Team','about'=>'Allow user to publish teams'],
            ]
        ]
    ]
];