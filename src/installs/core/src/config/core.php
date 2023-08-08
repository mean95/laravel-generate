<?php

return [
    'maxlength_field' => [
        'Currency', 'Decimal', 'Float', 'Integer',
    ],
    'min_max_field' => [
        'Address', 'Currency', 'Decimal', 'Email', 'Float', 'Integer', 'Mobile', 'Password', 'String', 'TagInput', 'URL',
    ],
    'not_max_field' => [
        'Editor', 'Textarea',
    ],
    'popup_field' => [
        'Checkbox', 'Dropdown', 'MultiSelect', 'Radio'
    ],
    'unique_field' => [
        'Date', 'DateTime', 'Email', 'Float', 'Integer', 'Mobile', 'String',
    ],
    'tag_input' => 'TagInput',
    'default_value_int' => [
       'Currency', 'Decimal', 'Float', 'Integer',
    ],
    'permission' => [
        'super_admin' => 'SUPER_ADMIN',
        'viewer' => 'VIEWER',
    ],
];