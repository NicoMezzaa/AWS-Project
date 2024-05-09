<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AWS PROJECT</title>
    <link rel="stylesheet" href="/asset/css/style_user.css">
</head>
<body>
    <header>
        <div class="container">
            <img src="//assets//img//aws_logo.png" alt="AWS Logo" class="logo">
            <h1>AWS WEB SITE</h1>
            <?php
            if (isset($_SESSION['email'])) {
                echo '<p>Welcome, ' . $_SESSION['username'] . '</p>';
            }
            ?>
        </div>
    </header>
    <main>
        <div class="container">
            <section id="premises">
                <h2>Premises:</h2>
                <p>To get started, follow these steps to install Docker and Docker Compose:</p>
                <ol>
                    <li>Update packages:
                        <code>sudo apt update</code>
                    </li>
                    <li>Install Docker:
                        <code>sudo apt install -y docker.io</code>
                    </li>
                    <li>Enable Docker service:
                        <code>sudo systemctl enable docker</code>
                    </li>
                    <li>Download Docker Compose:
                        <code>sudo curl -L "https://github.com/docker/compose/releases/latest/download/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose</code>
                    </li>
                    <li>Give executable permissions:
                        <code>sudo chmod +x /usr/local/bin/docker-compose</code>
                    </li>
                </ol>
            </section>
            <section id="steps">
                <h2>Steps:</h2>
                <h3>Nginx Configuration:</h3>
                <p>Create a directory named <code>docker-project</code> and inside it, create a file <code>docker-compose.yml</code> with the following content:</p>
                <pre><code>version: "3.9"
services:
  nginx:
    image: nginx:latest
    container_name: nginx-container
    ports:
      - 80:80</code></pre>
                <h3>Start Nginx:</h3>
                <p>Launch the Nginx container using the command:</p>
                <code>sudo docker-compose up -d</code>
                <h3>Generate SSL Certificate:</h3>
                <p>Create a directory named <code>ssl</code> in your home directory and generate an SSL certificate with the following commands:</p>
                <code>mkdir ~/ssl</code>
                <code>sudo openssl req -x509 -nodes -days 365 -newkey rsa:2048 -keyout ~/ssl/key.pem -out ~/ssl/cert.pem</code>
                <h3>Configure SSL Proxy for Nginx:</h3>
                <p>Link the SSL certificate to the Nginx container using the command:</p>
                <code>sudo docker run -d --name proxyapp --network docker-project_default -p 443:443 -e DOMAIN=*.compute-1.amazonaws.com -e TARGET_PORT=80 -e TARGET_HOST=docker-project-nginx-1 -e SSL_PORT=443 -v ~/ssl:/etc/nginx/certs --restart unless-stopped fsouza/docker-ssl-proxy</code>
                <h3>PHP Code Configuration:</h3>
                <p>Create a directory named <code>php_code</code> in your home directory and clone your GitHub repository inside it with the command:</p>
                <code>mkdir ~/docker-project/php_code</code>
                <code>git clone https://github.com/dularagamagee/tech2go.git ~/docker-project/php_code/</code>
                <h3>Configure Dockerfile for PHP:</h3>
                <p>Inside the <code>php_code</code> directory, create a <code>Dockerfile</code> with the following content:</p>
                <pre><code>FROM php:7.0-fpm
RUN docker-php-ext-install mysqli pdo pdo_mysql
RUN docker-php-ext-enable mysqli</code></pre>
                <h3>Nginx Configuration for PHP:</h3>
                <p>Create a directory named <code>nginx</code> inside the <code>docker-project</code> directory and inside it, create a <code>default.conf</code> file with the following Nginx configuration:</p>
                <pre><code>server {
    listen 80 default_server;
    root /var/www/html;
    index index.html index.php;
    charset utf-8;
    
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt { access_log off; log_not_found off; }

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
}</code></pre>
                <h3>Update Docker Compose:</h3>
                <p>Modify the <code>docker-compose.yml</code> file in the <code>docker-project</code> directory as follows:</p>
                <pre><code>version: "3.9"
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
       - ./php_code/:/var/www/html/</code></pre>
                <h3>Start All Containers:</h3>
                <p>Launch all containers using the command:</p>
                <code>docker-compose up -d</code>
                <h3>MariaDB Database Configuration:</h3>
                <p>Modify the <code>docker-compose.yml</code> file to include the MariaDB service:</p>
                <pre><code>version: "3.9"
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
        -    mysql-data:/var/lib/mysql
      environment:  
       MYSQL_ROOT_PASSWORD: mariadb
       MYSQL_DATABASE: ecomdb 

volumes:
    mysql-data:</code></pre>
                <h3>Create MariaDB Database:</h3>
                <p>Launch all containers again with the command <code>docker-compose up -d</code> and access the MariaDB container with the command:</p>
                <code>sudo docker exec -it docker-project-db-1 /bin/sh</code>
                <p>Access MariaDB with the command:</p>
                <code>mariadb -u root -pmariadb</code>
                <p>Create a new user for the database and assign necessary privileges:</p>
                <pre><code>MariaDB [(none)]> CREATE USER 'example'@'%' IDENTIFIED BY "example";
MariaDB [(none)]> GRANT ALL PRIVILEGES ON . TO 'example'@'%';
MariaDB [(none)]> FLUSH PRIVILEGES;</code></pre>
                <h3>Push and Pull Code:</h3>
                <p>Push code from your local machine to the GitHub repository. On the AWS instance, pull the code into the <code>php_code</code> directory with the command:</p>
                <code>git pull</code>
            </section>
        </div>
    </main>
    <footer>
        <div class="container">
            <p>&copy; <?php echo date("Y"); ?> AWS Project. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
