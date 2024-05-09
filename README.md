<p align="center">
    <img width="300" alt="AWS Logo" src="https://upload.wikimedia.org/wikipedia/commons/9/93/Amazon_Web_Services_Logo.svg">
</p>

# AWS Setup with Docker for an Optimized Website

<div align="center">

<br>

![Docker](https://img.shields.io/badge/Docker-2496ED?style=for-the-badge&logo=docker&logoColor=white)
![AWS](https://img.shields.io/badge/AWS-232F3E?style=for-the-badge&logo=amazon-aws&logoColor=white)

[![Badge License]][License] 

<br>
Welcome to AWS Setup with Docker for an Optimized Website! Follow these steps to configure an AWS environment using Docker and deploy your website.

</div>

## Premises

Before starting, make sure to install Docker and Docker Compose using the following commands:

```bash
sudo apt update
sudo apt install -y docker.io
sudo systemctl enable docker

**Scaricare Docker Compose da GitHub:**

```bash
sudo curl -L "https://github.com/docker/compose/releases/latest/download/docker-compose-$(uname -s)-$(uname -m)" \
    -o /usr/local/bin/docker-compose
sudo chmod +x /usr/local/bin/docker-compose

## Instructions

## Step 1
1. **Creazione del file `docker-compose.yml` per avviare il container Nginx:**

```yaml
version: "3.9"
services:
  nginx:
    image: nginx:latest
    container_name: nginx-container
    ports:
      - 80:80

### Avvio dei container Docker in background

Per avviare i container Docker in background, utilizza il seguente comando:

```bash
sudo docker-compose up -d

## Step 2

### Creazione del Certificato SSL

Successivamente, crea il certificato SSL nella cartella `ssl` con i seguenti comandi:

```bash
mkdir ~/ssl
sudo openssl req -x509 -nodes -days 365 -newkey rsa:2048 -keyout ~/ssl/key.pem -out ~/ssl/cert.pem

sudo docker run -d --name proxyapp --network docker-project_default -p 443:443 \
    -e DOMAIN=*.compute-1.amazonaws.com -e TARGET_PORT=80 -e TARGET_HOST=docker-project-nginx-1 \
    -e SSL_PORT=443 -v ~/ssl:/etc/nginx/certs --restart unless-stopped fsouza/docker-ssl-proxy
	

### Creazione della Cartella e Clonazione del Repository GitHub

Dopo aver configurato il certificato SSL, creiamo una cartella dedicata per il nostro codice PHP. Utilizziamo il seguente comando per creare la cartella:

```bash
mkdir ~/docker-project/php_code
cd ~/docker-project/php_code
git clone https://NicoMezzaa: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@github.com/NicoMezzaa/AWS-Project.git ~/docker-project/php_code/


### Creazione del File Dockerfile per PHP

Successivamente, creiamo un file chiamato `Dockerfile` nella cartella `php_code` dove inseriremo le istruzioni per configurare l'ambiente PHP. Ecco il contenuto del file:

```Dockerfile
FROM php:7.0-fpm

RUN docker-php-ext-install mysqli pdo pdo_mysql
RUN docker-php-ext-enable mysqli


### Creazione della Configurazione Nginx

All'interno della cartella `docker-project`, creiamo una cartella chiamata `nginx` dove aggiungeremo la configurazione per Nginx.

Utilizziamo il seguente comando per creare e aprire il file `default.conf` utilizzando l'editor `nano`:

```bash
nano ~/docker-project/nginx/default.conf

server {  
    listen 80 default_server;  
    root /var/www/html;  
    index index.html index.php;  

    charset utf-8;  

    location / {  
        try_files $uri $uri/ /index.php?$query_string;  
    }  

    location = /favicon.ico { 
        access_log off; 
        log_not_found off; 
    }  

    location = /robots.txt { 
        access_log off; 
        log_not_found off; 
    }  

    access_log off;  
    error_log /var/log/nginx/error.log error;  

    sendfile off;  

    client_max_body_size 100m;  

    location ~ .php$ {  
        fastcgi_split_path_info ^(.+.php)(/.+)$;  
        fastcgi_pass php:9000;  
        fastcgi_index index.php;  
        include fastcgi_params;
        fastcgi_read_timeout 300;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;  
        fastcgi_intercept_errors off;  
        fastcgi_buffer_size 16k;  
        fastcgi_buffers 4 16k;  
    }  

    location ~ /.ht {  
        deny all;  
    }  
}


### Configurazione del Dockerfile per Nginx e Aggiornamento di docker-compose.yml

Successivamente, creiamo un altro file nella cartella `nginx` chiamato `Dockerfile`, dove aggiungiamo le regole per Nginx:

**Contenuto di `Dockerfile` per Nginx:**

```Dockerfile
FROM nginx
COPY ./default.conf /etc/nginx/conf.d/default.conf

**docker-compose.yml:**
version: "3.9"
services:
  nginx:
    build: ./nginx/
    ports:
      - 80:80
    volumes:
      - ./php_code/:/var/www/html/

  php:
    build: ./php_code/
    expose:
      - 9000
    volumes:
      - ./php_code/:/var/www/html/

### Configurazione del Container per MariaDB

L'ultimo passo consiste nell'impostare il container per il database MariaDB.

1. **Modifica del file `docker-compose.yml` per MariaDB:**

```yaml
version: "3.9"
services:
  nginx:
    build: ./nginx/
    ports:
      - 80:80
    volumes:
      - ./php_code/:/var/www/html/

  php:
    build: ./php_code/
    expose:
      - 9000
    volumes:
      - ./php_code/:/var/www/html/

  db:    
    image: mariadb  
    volumes: 
      - mysql-data:/var/lib/mysql
    environment:  
      MYSQL_ROOT_PASSWORD: mariadb
      MYSQL_DATABASE: ecomdb 

volumes:
  mysql-data:


### Creazione di una Sessione all'Interno del Container MariaDB

Per riavviare tutti i contenitori e creare una sessione all'interno del container MariaDB, utilizza i seguenti comandi:

```bash
docker-compose up -d
sudo docker exec -it docker-project-db-1 /bin/sh


### Configurazione del Database MariaDB

1. **Accedere come root al database MariaDB:**

```bash
mariadb -u root -pmariadb


CREATE USER 'esempio'@'%' IDENTIFIED BY "esempio";


GRANT ALL PRIVILEGES ON *.* TO 'esempio'@'%';
FLUSH PRIVILEGES;


CREATE DATABASE nomedb;


USE nomedb;


git pull