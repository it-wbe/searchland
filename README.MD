Laravel popup login form with service google facebook integration
=============

### Install in Laravel 5.5

add to config/app.php
```
 'providers' => [
        Wbe\Searchland\SearchlandServiceProvider::class,
```
		
DO

```
php artisan vendor:publish --provider="Wbe\Searchland\SearchlandServiceProvider"
```

in 
config/search

count - max count row in popup search
urlname - fild where is link on page
datacol - default data column

config/search_table
```
'table'=>['first_column','second_column']
```
if you have two or more tables and columns did'n have 

SETTINGS

in	
	
	need install bootstrap
	
	composer require twbs/bootstrap


---------