=== Finnish Weather WP Plugin ===
Tags: sää,weather,suomi,finland,map
License: GPL-3.0

 Finnish weather information map plugin that is very lightwheight. Donate if you like the plugin: https://gofund.me/0403326f

== Installation ==
  Setup database MySQL table:
     CREATE USER "exampleuser"@"%" identified by "example password";
     CREATE DATABASE databasename
     CREATE TABLE databasetable

     GRANT ALL PRIVILEGES ON databasename.* TO ""exampleuser""@"%";

                                    OR

     GRANT ALL PRIVILEGES ON databasename.databasetable TO ""exampleuser""@"%";

  run as www-data:
     mkdir -p ~/bin/
     cp download_to_sql_fi.py ~/bin/

  run as root:
     # setup cron to run every 20min the backend database update
     echo " 0,20 * * * *  sudo -u www-data -- python3 /var/www/bin/download_to_sql_fi.py" >> /etc/crontab



== Changelog ==
2.2
     Donation link set up.

2.1
     Documented better the installation process.

2.0
     Initial public version.
