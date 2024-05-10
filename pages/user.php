<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AWS WEBSITE</title>
</head>
<body>
<div class="container" id="content">
    <!-- Il contenuto del README verrà aggiunto qui dinamicamente -->
    <div id="top"></div>

<p align="center">
    <img width="300" alt="AWS Logo" src="https://upload.wikimedia.org/wikipedia/commons/9/93/Amazon_Web_Services_Logo.svg">
</p>

<h1 align="center"># AWS Setup with Docker for an Optimized Website</h1>

<div align="center">

<br>

<img src="https://img.shields.io/badge/AWS-232F3E?style=for-the-badge&amp;logo=amazon-aws&amp;logoColor=white" alt="AWS">
<img src="https://img.shields.io/badge/Docker-2496ED?style=for-the-badge&amp;logo=docker&amp;logoColor=white" alt="Docker">
<img src="https://img.shields.io/badge/Nginx-009639?style=for-the-badge&amp;logo=nginx&amp;logoColor=white" alt="Nginx">
<img src="https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&amp;logo=php&amp;logoColor=white" alt="PHP">
<img src="https://img.shields.io/badge/MariaDB-003545?style=for-the-badge&amp;logo=mariadb&amp;logoColor=white" alt="MariaDB">

<a href="https://opensource.org/licenses/MIT"><img src="https://img.shields.io/badge/License-MIT-blue.svg" alt="MIT License"></a>

<h4 align="center">Welcome to the AWS Setup with Docker for an Optimized Website! In this guide, you&#39;ll embark on a journey to configure a robust AWS environment using Docker, Nginx, PHP, and MariaDB. Follow these comprehensive steps to deploy your stunning website and harness the power of cloud infrastructure.</h4>

</div>

<!-- TABLE OF CONTENTS -->
<details href="#index">
  <summary>Table of Contents</summary>
  <ol>
    <li><a href="#initial-configuration">Initial Configuration</a></li>
    <li><a href="#add-nginx-and-ssl">Add Nginx and SSL</a></li>
    <li><a href="#configure-php">Configure PHP</a></li>
    <li><a href="#container">Container</a></li>
    <li><a href="#last-step-configure-mariadb">Last Step: Configure MariaDB</a></li>
    <li><a href="#how-to-update-the-repo-on-aws">How to Update the Repo on AWS</a></li>
    <li><a href="#license">License</a></li>
    <li><a href="#contact">Contact</a></li>
  </ol>
</details>

<!-- START -->
<h2 id="initial-configuration">Initial configuration</h2>
<p>You need to install both docker and docker-compose.</p>
<p>Follow the following commands:</p>
<ol>
<li>Install Docker Engine<pre><code class="lang-bash">sudo apt <span class="hljs-keyword">install</span> -y docker.io
</code></pre>
</li>
<li>Enable docker correctly<pre><code class="lang-bash">sudo systemctl <span class="hljs-built_in">enable</span> docker
</code></pre>
</li>
<li>Install docker-compose (add the chmod command to grant execute permissions)<pre><code class="lang-bash">sudo curl -L <span class="hljs-string">"https://github.com/docker/compose/releases/latest/download/docker-compose-<span class="hljs-variable">$(uname -s)</span>-<span class="hljs-variable">$(uname -m)</span>"</span> -o /usr/<span class="hljs-built_in">local</span>/bin/docker-compose
</code></pre>
</li>
</ol>
<p>Then create the project folder:</p>
<ul>
<li><pre><code class="lang-bash"> <span class="hljs-built_in">mkdir</span> ~/docker-project
</code></pre>
</li>
<li><pre><code class="lang-bash"> <span class="hljs-built_in">cd</span> ~/docker-project
</code></pre>
</li>
</ul>
<p>You can of course call it whatever you want.</p>
<p align="right">(<a href="#top">back to top</a>)</p>


<!-- NGINX SSL -->
<h2 id="add-nginx-and-ssl">Add Nginx and SSL</h2>
<p>After creating the folder, we create the docker-compose.yml file inside, which will be used to initially launch the nginx container.</p>
<ul>
<li>Create the file<pre><code class="lang-bash"> <span class="hljs-selector-tag">nano</span> <span class="hljs-selector-tag">docker-compose</span><span class="hljs-selector-class">.yml</span>
</code></pre>
</li>
<li>Copy the code and put it in<pre><code class="lang-bash"> <span class="hljs-attribute">version</span>: <span class="hljs-string">"3.9"</span>
 <span class="hljs-attribute">services</span>:
      <span class="hljs-attribute">nginx</span>:
        <span class="hljs-attribute">image</span>: <span class="hljs-attribute">nginx</span>:latest
        <span class="hljs-attribute">container_name</span>: nginx-container
        <span class="hljs-attribute">ports</span>:
         - <span class="hljs-number">80</span>:<span class="hljs-number">80</span>
</code></pre>
</li>
</ul>
<p>Start the nginx container via the <code>docker-compose up -d</code> command, giving permissions with sudo.</p>
<ul>
<li>Create the certificate in the ssl folder with the command:<pre><code class="lang-bash"> mkdir ~/ssl 
 sudo openssl req -x509 -nodes -days <span class="hljs-number">365</span> -newkey <span class="hljs-string">rsa:</span><span class="hljs-number">2048</span> -keyout <span class="hljs-regexp">~/ssl/</span>key.pem -out <span class="hljs-regexp">~/ssl/</span>cert.pem
</code></pre>
</li>
<li>To connect it to the nginx container:<pre><code class="lang-bash"> sudo docker <span class="hljs-keyword">run</span><span class="bash"> <span class="hljs-_">-d</span> --name proxyapp --network docker-project_default -p 443:443 <span class="hljs-_">-e</span> DOMAIN=*.compute-1.amazonaws.com <span class="hljs-_">-e</span> TARGET_PORT=80 <span class="hljs-_">-e</span> TARGET_HOST=docker 
</span> project-nginx-<span class="hljs-number">1</span> -e SSL_PORT=<span class="hljs-number">443</span> -v ~/ssl:/etc/nginx/certs --restart unless-stopped fsouza/docker-ssl-proxy
</code></pre>
</li>
</ul>
<p align="right">(<a href="#top">back to top</a>)</p>


<!-- PHP -->
<h3 id="configure-php">Configure PHP</h3>
<ol>
<li>Create PHP folder (the repo is saved here):<pre><code class="lang-bash"><span class="hljs-built_in">mkdir</span> ~/docker-project/php_code
</code></pre>
</li>
<li>Clone the repo:<pre><code class="lang-sh">git clone https:<span class="hljs-regexp">//gi</span>thub.com<span class="hljs-regexp">/NicoMezzaa/</span>AWS-Project ~<span class="hljs-regexp">/docker-project/</span>php_code<span class="hljs-regexp">/</span>
</code></pre>
</li>
<li>Create a file called <em>Dockerfile</em> in the php_code folder:<pre><code class="lang-sh"> <span class="hljs-keyword">FROM</span> php:<span class="hljs-number">7.0</span>-fpm
 <span class="hljs-keyword">RUN</span><span class="bash"> docker-php-ext-install mysqli pdo pdo_mysql
</span> <span class="hljs-keyword">RUN</span><span class="bash"> docker-php-ext-enable mysqli</span>
</code></pre>
</li>
<li>Create a directory for Nginx inside your project directory:<pre><code class="lang-sh"> <span class="hljs-built_in">mkdir</span> ~/docker-project/nginx
</code></pre>
</li>
<li>Create an Nginx default configuration file to run your PHP application<pre><code class="lang-sh"> sudo nano <span class="hljs-regexp">~/docker-project/</span>nginx/<span class="hljs-keyword">default</span>.conf
</code></pre>
</li>
<li><p>Add the following Nginx configuration to the <em>default.conf</em> file:</p>
<pre><code class="lang-sh"> <span class="hljs-section">server</span> {  

  <span class="hljs-attribute">listen</span> <span class="hljs-number">80</span> default_server;  
  <span class="hljs-attribute">root</span> /var/www/html;  
  <span class="hljs-attribute">index</span> index.html index.php;  

  <span class="hljs-attribute">charset</span> utf-<span class="hljs-number">8</span>;  

  <span class="hljs-attribute">location</span> / {  
   <span class="hljs-attribute">try_files</span> <span class="hljs-variable">$uri</span> <span class="hljs-variable">$uri</span>/ /index.php?<span class="hljs-variable">$query_string</span>;  
  }  

  <span class="hljs-attribute">location</span> = /favicon.ico { <span class="hljs-attribute">access_log</span> <span class="hljs-literal">off</span>; <span class="hljs-attribute">log_not_found</span> <span class="hljs-literal">off</span>; }  
  <span class="hljs-attribute">location</span> = /robots.txt { <span class="hljs-attribute">access_log</span> <span class="hljs-literal">off</span>; <span class="hljs-attribute">log_not_found</span> <span class="hljs-literal">off</span>; }  

  <span class="hljs-attribute">access_log</span> <span class="hljs-literal">off</span>;  
  <span class="hljs-attribute">error_log</span> /var/log/nginx/error.log <span class="hljs-literal">error</span>;  

  <span class="hljs-attribute">sendfile</span> <span class="hljs-literal">off</span>;  

  <span class="hljs-attribute">client_max_body_size</span> <span class="hljs-number">100m</span>;  

  <span class="hljs-attribute">location</span> <span class="hljs-regexp">~ .php$</span> {  
   <span class="hljs-attribute">fastcgi_split_path_info</span><span class="hljs-regexp"> ^(.+.php)(/.+)$</span>;  
   <span class="hljs-attribute">fastcgi_pass</span> php:<span class="hljs-number">9000</span>;  
   <span class="hljs-attribute">fastcgi_index</span> index.php;  
   <span class="hljs-attribute">include</span> fastcgi_params;
   <span class="hljs-attribute">fastcgi_read_timeout</span> <span class="hljs-number">300</span>;
   <span class="hljs-attribute">fastcgi_param</span> SCRIPT_FILENAME <span class="hljs-variable">$document_root</span><span class="hljs-variable">$fastcgi_script_name</span>;  
   <span class="hljs-attribute">fastcgi_intercept_errors</span> <span class="hljs-literal">off</span>;  
   <span class="hljs-attribute">fastcgi_buffer_size</span> <span class="hljs-number">16k</span>;  
   <span class="hljs-attribute">fastcgi_buffers</span> <span class="hljs-number">4</span> <span class="hljs-number">16k</span>;  
 }  

  <span class="hljs-attribute">location</span> <span class="hljs-regexp">~ /.ht</span> {  
   <span class="hljs-attribute">deny</span> all;  
  }  
 }
</code></pre>
</li>
<li>Create a Dockerfile inside the nginx directory to copy the Nginx default config file:<pre><code class="lang-sh"> nano ~<span class="hljs-regexp">/docker-project/</span>nginx<span class="hljs-regexp">/Dockerfile</span>
</code></pre>
</li>
<li>Add the following lines to the Dockerfile:<pre><code class="lang-sh"> <span class="hljs-keyword">FROM</span> nginx
 <span class="hljs-keyword">COPY</span> .<span class="hljs-regexp">/default.conf /</span>etc<span class="hljs-regexp">/nginx/</span>conf.d<span class="hljs-regexp">/default.conf</span>
</code></pre>
</li>
<li><p>Update the <em>docker-compose.yml</em> file with the following contents:</p>
<pre><code class="lang-sh"> version: "3.9"
 services:
    nginx:
      build: ./nginx/
      ports:
        -<span class="ruby"> <span class="hljs-number">80</span><span class="hljs-symbol">:</span><span class="hljs-number">80</span>
</span>
      volumes:
          -<span class="ruby"> ./php_code/<span class="hljs-symbol">:/var/www/html/</span>
</span>
    php:
      build: ./php_code/
      expose:
        -<span class="ruby"> <span class="hljs-number">9000</span>
</span>      volumes:
         -<span class="ruby"> ./php_code/<span class="hljs-symbol">:/var/www/html/</span></span>
</code></pre>
</li>
<li>Then launch the containers:<pre><code class="lang-sh">sudo docker-compose up <span class="hljs-_">-d</span>
</code></pre>
</li>
<li>See the containers:<pre><code class="lang-sh"><span class="hljs-attribute">sudo docker ps</span>
</code></pre>
<p align="right">(<a href="#top">back to top</a>)</p>


</li>
</ol>
<!-- CONTAINER -->
<h2 id="container">Container</h2>
<p><img src="asset/img/containers.png" alt="Containers"></p>
<p align="right">(<a href="#top">back to top</a>)</p>


<!-- MARIADB -->
<h3 id="last-step-configure-mariadb">Last step: configure MariaDB</h3>
<p>The last step now is to set up the container for the database</p>
<ol>
<li><p>Update the <em>docker-compose.yml</em> with this:
```sh
 version: &quot;3.9&quot;
 services:</p>
<pre><code>nginx:
  build: ./nginx/
  ports:
    -<span class="ruby"> <span class="hljs-number">80</span><span class="hljs-symbol">:</span><span class="hljs-number">80</span>
</span>
  volumes:
      -<span class="ruby"> ./php_code/<span class="hljs-symbol">:/var/www/html/</span>
</span>
php:
  build: ./php_code/
  expose:
    -<span class="ruby"> <span class="hljs-number">9000</span>
</span>  volumes:
     -<span class="ruby"> ./php_code/<span class="hljs-symbol">:/var/www/html/</span></span>
</code></pre></li>
</ol>
<pre><code>   <span class="hljs-symbol">db:</span>    
      <span class="hljs-symbol">image:</span> mariadb  
      <span class="hljs-symbol">volumes:</span> 
        -    mysql-<span class="hljs-symbol">data:</span>/var/<span class="hljs-class"><span class="hljs-keyword">lib</span>/<span class="hljs-title">mysql</span></span>
      <span class="hljs-symbol">environment:</span>  
       <span class="hljs-symbol">MYSQL_ROOT_PASSWORD:</span> mariadb
       <span class="hljs-symbol">MYSQL_DATABASE:</span> AWS


<span class="hljs-symbol">volumes:</span>
    mysql-<span class="hljs-symbol">data:</span>
</code></pre><pre><code><span class="hljs-number">2.</span> Then launch the containers:
    ```sh
    sudo docker-compose up -d
</code></pre><ol>
<li>Create the CLI inside MariaDB:<pre><code class="lang-sh">sudo docker exec -it docker-<span class="hljs-keyword">project</span>-db-<span class="hljs-number">1</span> <span class="hljs-regexp">/bin/</span>sh
</code></pre>
</li>
<li>Access MariaDB as the root user:<pre><code class="lang-sh"><span class="hljs-keyword">mariadb </span>-u root -pmariadb
</code></pre>
</li>
<li>Create a user for the db:<pre><code class="lang-sh"><span class="hljs-keyword">CREATE</span> <span class="hljs-keyword">USER</span> <span class="hljs-string">'username'</span>@<span class="hljs-string">'%'</span> <span class="hljs-keyword">IDENTIFIED</span> <span class="hljs-keyword">BY</span> <span class="hljs-string">"password"</span>;
</code></pre>
</li>
<li>Grant him privileges:<pre><code class="lang-sh"><span class="hljs-keyword">GRANT</span> ALL <span class="hljs-keyword">PRIVILEGES</span> <span class="hljs-keyword">ON</span> . <span class="hljs-keyword">TO</span> <span class="hljs-string">'esempio'</span>@<span class="hljs-string">'%'</span>;
<span class="hljs-keyword">FLUSH</span> <span class="hljs-keyword">PRIVILEGES</span>;
</code></pre>
</li>
<li>To create a new db first repeat steps 3 and 4, then:<pre><code class="lang-sh"><span class="hljs-attribute">CREATE</span> DATABASE site;
<span class="hljs-attribute">MariaDB</span> [site]&gt;
</code></pre>
</li>
<li>You can now run SQL commands to create tables:<pre><code class="lang-sh"><span class="hljs-keyword">CREATE</span> <span class="hljs-keyword">TABLE</span> example_table (column1 <span class="hljs-built_in">INT</span>, column2 <span class="hljs-built_in">VARCHAR</span>(<span class="hljs-number">50</span>), column3 <span class="hljs-built_in">DATE</span>);
</code></pre>
<p align="right">(<a href="#top">back to top</a>)</p>


</li>
</ol>
<!-- GIT PULL -->
<h2 id="how-to-update-the-repo-on-aws">How to update the repo on AWS</h2>
<ol>
<li>Move to the folder where the repo is located:<pre><code class="lang-sh"> cd docker-<span class="hljs-keyword">project</span><span class="hljs-regexp">/php_code/</span>
</code></pre>
</li>
<li><p>Do the <em>git pull</em>:</p>
<pre><code class="lang-sh"><span class="hljs-attribute"> git pull</span>
</code></pre>
<p>Now, after setting everything up, check if it works and now you can focus on developing the site on AWS using the main development techniques:</p>
</li>
<li><p><a href="https://developer.mozilla.org/en-US/docs/Web/HTML">HTML</a></p>
</li>
<li><a href="https://developer.mozilla.org/en-US/docs/Web/CSS">CSS</a></li>
<li><a href="https://developer.mozilla.org/en-US/docs/Web/JavaScript">JavaScript</a></li>
<li><a href="https://getbootstrap.com/">Bootstrap</a></li>
</ol>
<p align="right">(<a href="#top">back to top</a>)</p>


<!-- LICENSE -->
<h2 id="license">License</h2>
<p>Distributed under the MIT License. See <code>LICENSE</code> for more information.</p>
<p align="right">(<a href="#top">back to top</a>)</p>


<!-- CONTACT -->
<h2 id="contact">Contact</h2>
<p>Nicolò Mezzanzanica - <a href="https://instagram.com/nicomezzaa"><img src="https://img.icons8.com/fluency/48/000000/instagram-new.png" alt="Instagram" width="20"/></a> - nico.mezza7@gmail.com</p>
<p>Project Link (GitHub):    <a href="https://github.com/NicoMezzaa/AWS-Project"><img src="https://img.icons8.com/fluency/48/000000/github.png" alt="GitHub" width="20"/></a></p>
<p align="right">(<a href="#top">back to top</a>)</p>


<!-- MARKDOWN LINKS & IMAGES -->
<!-- https://www.markdownguide.org/basic-syntax/#reference-style-links -->

</body>
</html>