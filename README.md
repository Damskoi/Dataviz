Lien du site: http://vps730707.ovh.net/

__Les tests de lib sont dans le dossier private/ sur le site.__ 
Ne pas oublier de [mettre a jour le tableur du drive.](https://docs.google.com/spreadsheets/d/1BmaGsoMMQVTREYDd74d80dhl63-IGTdGSH7caSQm5O4/edit?usp=drive_web&ouid=115761483079445534524)

# Installation en localhost (linux)

Installer les paquets:

    sudo apt install php mariadb-client mariadb-server php-mysql

Télécharger db.sql sur le drive et le mettre dans /var/www/html.

Lancer mysql. Dans le prompt:

    CREATE USER 'php'@'localhost' IDENTIFIED BY 'jesuistresencolere';
    CREATE DATABASE anticipation;
    GRANT ALL PRIVILEGES ON *.* TO 'php'@'localhost';

Dans le terminal, importer db.sql:

    mysql -u root -p anticipation < /home/xy/db.sql 

Cloner le projet dans /var/www/html/ ( le point est important ) :

    git clone https://gitlab.com/xy2_/projet-arp .

C'est bon!