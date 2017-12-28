<?php

// on=>["table_1","table_2"]
// by default id= content_id
// join => ["table_name"=>"column_name"]
// link=> if needed add some on start

return [
    "news"=>[
        "columns"=>["title",
            "description",
            "alias"
        ],
        "join"=>["news_description"=>[
            "news_description.content_id",
            "news.id"
        ]
        ],
        "link"=>[
            "url_add"=>"/news/",
            "column"=>"alias"
        ]
    ],
    "publications"=>[
        "columns"=>[
            "title",
            "description",
            "id"
        ],
        "join"=>[
            "publications_description"=>[
                "publications_description.content_id",
                "publications.id"
            ]
        ],
        "link"=>[
            "url_add"=>"/publication/",
            "column"=>"id"
        ]
    ],
];