# Chronolabs Cooperative Presents

#Internet Strata + Fallout Services API

## http://strata.snails.email

### Author: Simon Antony Roberts (simon@snails.email) - (c) 2016 - 2026

The ISF API Provides a drill down list of all the Internet Realms, TLD, gTLD that are currently available to the network strata you are in. It also provides country or place fallout which is associated with going on the end of the nodes in the strata.

A TLD, gTLD is not fortified until it has a fallout domain associated with it takeup; otherwise it is floating flambount in the marketplace with no nation or fallout channelling in it physicality.

## Mod Rewrite .htaccess on root path

The following mod rewrite module extension which you have to enable in apache2 with: $ sudo a2enmod rewrite after doing so the following .htaccess goes in the root if it isn't there already

    RewriteEngine On
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule ^v2/(strata|fallout)/(.*?).api index.php?mode=$1&output=$2 [L,NC,QSA]
    RewriteRule ^v2/(strata)/([0-9]+)/(.*?).api index.php?mode=$1&length=$2&output=$3 [L,NC,QSA]
    RewriteRule ^v2/(strata)/([a-z]+)/(.*?).api index.php?mode=$1&start=$2&output=$3 [L,NC,QSA]
    RewriteRule ^v2/(strata)/([0-9]+)/([a-z]+)/(.*?).api index.php?mode=$1&length=$2&start=$3&output=$4 [L,NC,QSA]
    RewriteRule ^v1/(strata|fallout)/(.*?).api index.php?mode=$1&output=$2 [L,NC,QSA]
    RewriteRule ^v1/(strata)/([0-9]+)/(.*?).api index.php?mode=$1&length=$2&output=$3 [L,NC,QSA]
    RewriteRule ^v1/(strata)/([a-z]+)/(.*?).api index.php?mode=$1&start=$2&output=$3 [L,NC,QSA]
    RewriteRule ^v1/(strata)/([0-9]+)/([a-z]+)/(.*?).api index.php?mode=$1&length=$2&start=$3&output=$4 [L,NC,QSA]


## Scheduled Cron Job Details.,
    
There is one or more cron jobs that is scheduled task that need to be added to your system kernel when installing this API, the following command is before you install the chronological jobs with crontab in debain/ubuntu
    
    Execute:-
    $ sudo crontab -e

### CronTab Entry:
    
    * */12 * * * /usr/bin/php -q /path/to/cronjobs/align-strata.php

##Licensing

 * This is released under General Public License 3 - GPL3 - Only!