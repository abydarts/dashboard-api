<?php 

return [
    'LibUserPerm\\Model\\UserPerm' => [
        'data' => [
            'name' => [
                'manage_league'      => ['group'=>'League','about'=>'Allow user to manage own leagues'],
                'manage_league_all'  => ['group'=>'League','about'=>'Allow user to manage all leagues'],
                'remove_league'      => ['group'=>'League','about'=>'Allow user to remove leagues'],
                'publish_league'     => ['group'=>'League','about'=>'Allow user to publish leagues'],
            ]
        ]
    ]
];