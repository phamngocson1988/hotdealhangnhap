<?php

return [
// Module quark
    'quark' => [
        /* 'site' => [
          'index' => [
          'js' => ['js/quarksearch.js']
          ]
          ], */
        'quark' => [
            'add' => [
                'css' => ['js/lib/select2/css/select2.min.css'],
                'js' => ['http://feather.aviary.com/imaging/v3/editor.js',
                	'https://sdk.amazonaws.com/js/aws-sdk-2.2.39.min.js',
                    'js/numeric.min.js',
                    'js/quark.js',
                    'js/upload.js',
                    'js/quark_validate.js',
                    'js/admin_slide.js',
                    'js/handlers.js',
                    'js/jdropdownPop.js',
                    'js/lib/select2/select2.min.js',
                    'js/add_valueband.js',
                    'js/hashtag_scroll.js',
                	'js/lib/autosize.js',
                	
                ]
            ],
            'edit' => [
                'css' => [],
                'js' => ['http://feather.aviary.com/imaging/v3/editor.js',
                	'https://sdk.amazonaws.com/js/aws-sdk-2.2.39.min.js',
                    'js/numeric.min.js',
                    'js/quark.js',
                    'js/upload.js',
                    'js/admin_slide.js',
                    'js/add_valueband.js',
                	'js/lib/autosize.js',
                ]
            ],
            'read' => [
                'css' => [''],
                'js' => [
                    'js/lib/jquery/jquery.bxslider.min.js',
                    'js/bxslider.js',
                    'js/subscribe_brand.js',
                    'js/like.js',
                    'js/bookmark.js',
                    'js/min/CWebChat.js',
                    'js/quark.js',
                    'js/ajax_paging.js',
                    'js/kakao/kakao.min.js',
                ]
            ],
            'list' => [
                'css' => [],
                'js' => ['js/handlers.js',
                    'js/jdropdownPop.js',
                    'js/quarklist.js',
                    'js/hashtag_scroll.js'
                    ]
            ],
            'subscribers' => [
                'css' => [],
                'js' => ['js/quark_subscribers.js'
                    ]
            ]
        ],
        'account' => [
            'index' => [
                'css' => ['js/lib/select2/css/select2.min.css'],
                'js' => [
                		'js/lib/jquery/jquery-migrate-1.2.1.min.js',
                		'http://feather.aviary.com/imaging/v3/editor.js',
                		'https://sdk.amazonaws.com/js/aws-sdk-2.2.39.min.js',
                    'js/ui.datepicker.js',
                    // 'js/lib/select2/select2.min.js',
                    'js/edit_user.js',
                    'js/add_valueband_user.js',
                    'js/upload.js',
                    'js/post.tag.js',
                    'js/account.js'
                    ]
            ],
            'withdrawal' => [
                'css' => [],
                'js' => [
                    'js/withdraw.js'
                    ]
            ]
        ],
        'discover' => [
            'index' => [
                'css' => [],
                'js' => [
                	'js/lib/jquery/jquery-ui.min.js',
                    'js/like.js',
                    'js/bookmark.js',
                    'js/subscribe_brand.js',
                    'js/masonry.pkgd.min.js',
                    'js/lib/jquery/jquery-scrolltofixed-min.js',
                    'js/top_slide.js',
                    'js/jTab.js',
                    'js/handlers.js',
                    'js/quarklayout.js',
                    'js/owl.carousel.min.js',
                    'js/hashtag_scroll.js',
                    //'js/brand_slide.js',
                ]
            ],
            'quark' => [
                'js' => [
                    'js/like.js',
                    'js/bookmark.js',
                    'js/masonry.pkgd.min.js',
                    'js/lib/jquery/jquery-scrolltofixed-min.js',
                    'js/top_slide.js',
                    'js/quarklayout.js',
                    'js/owl.carousel.min.js',
                    'js/hashtag_scroll.js'
                ]
            ],
            'value-band' => [
                'js' => [
                    'js/lib/jquery/jquery-scrolltofixed-min.js',
                    'js/top_slide.js',
                    'js/hashtag_scroll.js'
                ]
            ],
            'brand' => [
                'js' => [
                    'js/subscribe_brand.js',
                    'js/lib/jquery/jquery-scrolltofixed-min.js',
                    'js/top_slide.js',
                    'js/hashtag_scroll.js'
                ]
            ],
            'tip' => [
                'js' => [
                	'js/lib/jquery/jquery-ui.min.js',
                    'js/like.js',
                    'js/bookmark.js',
                    'js/masonry.pkgd.min.js',
                    'js/lib/jquery/jquery-scrolltofixed-min.js',
                    'js/top_slide.js',
                    'js/quarklayout.js',
                    'js/owl.carousel.min.js',
                    'js/hashtag_scroll.js'
                ]
            ],
        ],
        'brand' => [
            'register' => [
                'css' => [],
                'js' => [
                    'https://sdk.amazonaws.com/js/aws-sdk-2.2.39.min.js',
                    'http://feather.aviary.com/imaging/v3/editor.js',
                    'js/upload.js',
                    'js/brand_register.js',
                    'js/jNicescroll.js',
                    'js/add_area.js',
                    'js/hashtag_scroll.js',
                ]
            ],
            'register-out-site' => [
            'css' => [],
            'js' => [
            'https://sdk.amazonaws.com/js/aws-sdk-2.2.39.min.js',
            'http://feather.aviary.com/imaging/v3/editor.js',
            'js/upload.js',
            'js/brand_register.js',
            'js/jNicescroll.js',
            'js/add_area.js',
            'js/hashtag_scroll.js',
            ]
            ],
            'contact' => [
                'css' => [],
                'js' => ['js/brand.js',
                    'js/subscribe_brand.js',
                    'js/min/CWebChat.js',
                    'js/hashtag_scroll.js',
                ]
            ],
            'index' => [
                'css' => [],
                'js' => ['js/brand.js',
                    'js/like.js',
                    'js/bookmark.js',
                    'js/masonry.pkgd.min.js',
                    'js/quarklayout.js',
                    'js/subscribe_brand.js',
                    'js/min/CWebChat.js',
                    'js/owl.carousel.min.js',
                    'js/hashtag_scroll.js'
                ]
            ],
            'value-band' => [
                'css' => [],
                'js' => ['js/brand.js',
                    'js/subscribe_brand.js',
                    'js/min/CWebChat.js',
                    'js/hashtag_scroll.js'
                ]
            ],
            'setting-brand' => [
                'css' => [],
                'js' => ['js/brand.js',
                    'js/masonry.pkgd.min.js',
                    'js/quarklayout.js',
                    'js/min/CWebChat.js',
                    'js/hashtag_scroll.js',
                    'js/user.js',
                    'js/like.js',
                    'js/subscribe_brand.js',
                    'js/bookmark.js'
                ]
            ],
            'setting' => [
                'css' => [],
                'js' => [
                    'https://sdk.amazonaws.com/js/aws-sdk-2.2.39.min.js',
                    'http://feather.aviary.com/imaging/v3/editor.js',
                    'js/upload.js',
                    'js/brand.js',
                    'js/jNicescroll.js',
                    'js/add_area.js',
                    'js/brand_setting.js',
                    'js/hashtag_scroll.js',
                    'js/subscribe_brand.js',
                ]
            ],
            'management' => [
                'css' => [],
                'js' => [
                    'http://feather.aviary.com/imaging/v3/editor.js',
                    // 'js/chart/Chart.min.js',
                    // 'js/chart/chart_2016_08_29.js',
                    'js/chart/loader.js',
                    // 'js/chart/prefixfree.min.js',
                    'js/management.js',
                    'js/hashtag_scroll.js',
                    'js/handlers.js',
                    'js/jdropdownPop.js'
                ]
            ],
            'band-subscribed' => [
                'css' => [],
                'js' => [
                    'js/band_subscribed.js',
                    'js/hashtag_scroll.js'
                ]
            ],
            'chain-map' => [
                'css' => [],
                'js' => [
                    'js/cytoscape.js',
                    'js/bilkent.js',
                    'js/graph_brand.js',
                    // 'js/'
                ]
            ],
            'member' => [
                'css' => [],
                'js' => [
                    'js/member.js'
                ]
            ],
            'department' => [
                'css' => [],
                'js' => [
                    'js/brand.js'
                ]
            ],
            'administrator-setting' => [
                'css' => [],
                'js' => [
                    'js/brand_admin.js',
                    'js/hashtag_scroll.js'
                ]
            ],
            'update-member' => [
                'css' => [],
                'js' => [
                    'js/brand_member.js'
                ]
            ],
            
        ],
        'valueband' => [
            'myfeed' => [
                'css' => [],
                'js' => [
                    'js/function.js',
                    'js/ajax_paging.js',
                    'js/like.js',
                    'js/bookmark.js',
                    'js/masonry.pkgd.min.js',
                    'js/quarklayout.js',
                    'js/owl.carousel.min.js',
                    'js/hashtag_scroll.js'
                ]
            ],
            'band' => [
                'css' => [],
                'js' => [
                    'js/function.js',
                    'js/ajax_paging.js',
                    'js/handlers.js',
                    'js/jdropdownPop.js',
                    'js/hashtag_scroll.js'
                ]
            ],
            'search' => [
                'css' => [],
                'js' => [
                    'js/function.js',
                    'js/ajax_paging.js',
                    'js/hashtag_scroll.js'
//'js/quarksearch.js',
                ]
            ],
        ],
        'band' => [
            'index' => [
                'css' => [],
                'js' => [
                    'js/function.js',
                    'js/ajax_paging.js',
                    'js/band.js',
                    'js/like.js',
                    'js/bookmark.js',
                    'js/masonry.pkgd.min.js',
                    'js/quarklayout.js',
                    'js/owl.carousel.min.js',
                    'js/hashtag_scroll.js',
                ]
            ],
            'brand' => [
                'css' => [],
                'js' => [
                    'js/function.js',
                    'js/ajax_paging.js',
                    'js/subscribe_brand.js',
                    'js/band.js',
                    'js/hashtag_scroll.js',
                ]
            ],
            'chain-map' => [
                'css' => [],
                'js' => [
                    'js/function.js',
                    'js/ajax_paging.js',
                    'js/subscribe_brand.js',
                    'js/cytoscape.js',
                    'js/bilkent.js',
                    'js/band.js',
                    'js/graph_brand.js'
                ]
            ],
            'register' => [
                'css' => [],
                'js' => [
                    'js/function.js',
                    'js/ajax_paging.js',
                    'js/band.js',
                    'js/like.js',
                    'js/bookmark.js',
                    'js/masonry.pkgd.min.js',
                    'js/quarklayout.js',
                    'js/owl.carousel.min.js',
                    'js/hashtag_scroll.js',
                ]
            ],
            'subscribed-user' => [
                'css' => [],
                'js' => [
                    'js/function.js',
                    'js/ajax_paging.js',
                    'js/band.js',
                    'js/hashtag_scroll.js',
                    'js/band_user_subscribe.js'
                ],
            ],
        ],
        'dingdong' => [
            'setting' => [
                'css' => [
                    'css/colorpicker.css'
                ],
                'js' => [
                    'js/editor/CColorPicker.js',
                    'js/ding.js'
                ]
            ],
            'chatroom' => [
                'css' => [
                    'css/colorpicker.css'
                ],
                'js' => [
                    'js/min/CWebChat.js',
                    'js/min/chatRecentList.js'
                ]
            ],
        ],
        'search' => [
            'index' => [
                'js' => [
                    'js/ajax_paging.js',
                    'js/like.js',
                    'js/bookmark.js',
                    'js/subscribe_brand.js',
                    'js/tab.js',
                    'js/lib/jquery/jquery-scrolltofixed-min.js',
                    // 'js/quarksearch.js',
// 'js/quarksearch_top.js',
                    'js/masonry.pkgd.min.js',
                    'js/quarklayout.js',
                    'js/owl.carousel.min.js',
                    'js/hashtag_scroll.js',
                    'js/subscribe_user.js'
               //     'js/band_user_subscribe.js'
                ],
            ]
        ],
        'tutorial' => [
            'search-brand' => [
                'js' => [
                    'js/search-brand.js'
                ],
            ],
            'hashtags' => [
                'js' => [
                    'js/edit_user.js',
                    'js/add_valueband_user.js',
                ]
            ]
        ],
        'user' => [
        'setting' => [
                'css' => [],
                'js' => ['js/brand.js',
                    // 'js/masonry.pkgd.min.js',
                    // 'js/quarklayout.js',
                    'js/min/CWebChat.js',
                    'js/hashtag_scroll.js',
                    'js/user.js',
                    'js/like.js',
                    'js/subscribe_brand.js',
                    'js/bookmark.js',
                    'http://feather.aviary.com/imaging/v3/editor.js',
                    'https://sdk.amazonaws.com/js/aws-sdk-2.2.39.min.js',
                    'js/upload.js',
                    'js/update_cover_user.js'
                ]
            ],
        ],
    ],

// Module developers
    'developers' => [
        'site' => [
            'index' => [
                'js' => [
                    'js/masonry.pkgd.min.js',
                    'js/quarklayout.js',
                ],
            ]
        ],
    ]
];
