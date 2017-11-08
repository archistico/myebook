MY EBOOK
========
Il mio vecchio downloader di ebook  

INFO
----
git clone https://www.github.com/archistico/myebook.git  
sudo chown -R emilie:users myebook  
  
cd /etc/apache2/sites-available/  
sudo cp 000-default.conf 001-myebook.conf  
...Cambia il server name e la directory  
sudo a2ensite 001-myebook.conf  
sudo service apache2 reload  
  
mysql -u root -p'toor'  
create database myebook;  
quit  
  
mysql -u root -p'toor' myebook <ebookDB.sql  
  
git add .
git commit -m''
git config credential.helper store