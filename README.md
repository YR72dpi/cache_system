# Cache_system

A simple class for manage your cache.
If you have a question or just want talk with me, you can come on [my Twitter](https://twitter.com/DevIl00110000).

## How to start ?
``` php
$cache = new cache(dirname(__FILE__), "name file", 1);
```
1st parameter : the path where will be the tempory path

2nd parameter : name file

3th : parameter : number of minute(s) of the tempory file 

### Write in the file
``` php
$cache->write("Hello word !");
```
"Hello word !" will be write in **your_path/tmp/name_file.tmp**

### Read the file
``` php
$cache->read();
```
Return **Hello word !**

### Delete the file
``` php
$cache->delete();
```
Return true if it's ok.

### Delete all files
``` php
$cache->clear_dir();
```
Delete all files in the tempory path

