<?php return [

    'name'          => [
        'Product name',
        '_' => 'Product name',
        '?' => 'Product name',
    ],

    'sku'           => [
        'SKU',
        '_' => 'SKU',
        '?' => 'Storage Keeping Unit',
    ],

    'type_id'       => [
        'Type',
        '_' => 'Select Type',
        '?' => 'Type',
    ],

    'brand_id'      => [
        'Brand',
        '_' => 'Brand',
        '?' => 'Brand',
        'optional'  => 'Without Brand',
    ],

    'model_id'      => [
        'Model',
        '_' => 'Model',
        '?' => 'Model',
        'optional'  => 'Without Model',
    ],

    'line_id'       => [
        'Line',
        '_' => 'Line',
        '?' => 'Line',
        'optional'  => 'Without Line',
    ],

    'gama_id'       => [
        'Gama',
        '_' => 'Gama',
        '?' => 'Gama',
        'optional'  => 'Without Gama',
    ],

    'family_id'     => [
        'Family',
        '_' => 'Family',
        '?' => 'Family',
        'optional'  => 'Without Family',
    ],

    'sub_family_id' => [
        'SubFamily',
        '_' => 'SubFamily',
        '?' => 'SubFamily',
        'optional'  => 'Without SubFamily',
    ],

    'categories'    => [
        'Categories',
        '_' => 'Categories',
        '?' => 'Categories',

        'category_id'   => [
            'Category',
            '_' => 'Select Category',
            '?' => 'Category',
            'optional'  => '(optional) Select Category',
        ],
    ],

    'brief'         => [
        'Brief',
        '_' => 'Brief',
        '?' => 'Brief',
    ],

    'description'   => [
        'Description',
        '_' => 'Description',
        '?' => 'Description',
    ],

    'prices'        => [
        'Prices',
        '_' => 'Prices',
        '?' => 'Prices',

        'currency_id'   => [
            'Currency',
            '_' => 'Currency',
            '?' => 'Currency',
        ],

        'cost'          => [
            'Cost',
            '_' => 'Cost',
            '?' => 'Cost',
        ],

        'price'         => [
            'Price',
            '_' => 'Price',
            '?' => 'Price',
        ],

        'limit'         => [
            'Limit',
            '_' => 'Limit',
            '?' => 'Limit',
        ],
    ],

    'tax'           => [
        'Tax',
        '_' => 'Tax',
        '?' => 'Tax',
    ],

    'weight'        => [
        'Weight',
        '_' => 'Weight',
        '?' => 'Weight',
        'optional' => '(optional) Weight',
    ],

    'sizes'         => [
        'Sizes',
        '_' => 'Sizes',
        '?' => 'Sizes',
        'optional' => '(optional) Sizes',
    ],

    'length'        => [
        'Length',
        '_' => 'Length',
        '?' => 'Length',
        'optional' => '(optional) Length',
    ],

    'width'         => [
        'Width',
        '_' => 'Width',
        '?' => 'Width',
        'optional' => '(optional) Width',
    ],

    'height'        => [
        'Height',
        '_' => 'Height',
        '?' => 'Height',
        'optional' => '(optional) Height',
    ],

    'giftcard'      => [
        'Giftcard',
        '_' => 'Yes, this products is a Giftcard',
        '?' => 'Giftcard',
    ],

    'image_id'        => [
        'Image',
        '_' => 'Image',
        '?' => 'Image',
    ],

    'images'        => [
        'Images',
        '_' => 'Images',
        '?' => 'Images',
        'optional' => '(optional) Images',
    ],

    'url'           => [
        'URL',
        '_' => 'Custom product URL',
        '?' => 'URL',
        'optional' => '(optional) URL',
    ],

    'tags'          => [
        'Tags',
        '_' => 'Tags',
        '?' => 'Tags',
    ] + include('tag.php'),

    'locators'      => [
        'Locators',
        '_' => 'Locators',
        '?' => 'Locators',
    ],

    'visible'       => [
        'Visible',
        '_' => 'Yes, show product on frontend',
        '?' => 'Visible',
    ],

    'priority'      => [
        'Priority',
        '_' => 'Priority',
        '?' => 'Priority',
        'optional' => '(optional) Priority',
    ],

];
