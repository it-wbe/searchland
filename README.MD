Laravel Live Search
=============

### Install in Laravel 5.5

add to config/app.php
```php
 'providers' => [
        Wbe\Searchland\SearchlandServiceProvider::class,
```
		
DO

```php
php artisan vendor:publish --provider="Wbe\Searchland\SearchlandServiceProvider"
```

add to blade in script section
```php
@include('titleSearch')
```

add to search input class "searchGlobal"

after input add it's opened list  
```html
<div class="dropdown dropdown-lg">
    <div class="dropdown-menu dropdown-menu-right resultlist" role="menu" id="searchbox">
    </div>
</div>
```


if you whant customize opened list 
create in views folder search with blade template.blade.php

config/search

count - max count row in popup search
urlname - fild where is link on page
datacol - default data column

config/search_table

Example
```php
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
```
```php
"table_name"=>[
    "columns"=>["first_column","second_column","thread_column","link_column"],
    "join"=>["table_what_need_to_join"=>["what","to_what"]], - if needed
    "link"=>["url_add"=>"if need echo on start link","column"=>"what_column_is_link"]
```

if you have two or more tables and columns did'n have the same count search columns will result be used name where is max count of columns
for example 
````
"table_1"=>["1","2","3"]
"table_2"=>["a","b","c","d"]
````
result has been 
```html
<table>
<tr>
<th></th><th>"a"</th><th>"b"</th><th>"c"</th><th>"d"</th>
</tr>
<tr>
<td>table 1 row result</td><td>"a"</td><td>"b"</td><td>"c"</td><td>null</td>
</tr>
<tr>
<td>table 2 row result</td><td>"a"</td><td>"b"</td><td>"c"</td><td>"d"</td>
</tr>
</table>
```
need install bootstrap
```
	composer require twbs/bootstrap
```

---------