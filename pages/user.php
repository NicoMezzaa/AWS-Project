<?php
// Avvia la sessione all'inizio dello script
session_start();

// Include il file per la connessione al database
include '../includes/connect.php';?>
<!DOCTYPE html>
<html lang="it">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>AWS PROJECT</title>
	<link rel="stylesheet" href="/asset/css/style_user.css">
</head>

<body>
	<div class="container">
		<h1>AWS DON</h1>
		<?php
		if (isset($_SESSION['email'])) {
			echo '<p>Buona Lettura ' . $_SESSION['email'] . '</p>';
		}
		?>
		<h2>Premesse:</h2>
		<p>Per iniziare, installa Docker e Docker Compose utilizzando i seguenti comandi:</p>
		<code>sudo apt update</code>
		<code>sudo apt install -y docker.io</code>
		<code>sudo systemctl enable docker</code>
		<code>sudo curl -L "https://github.com/docker/compose/releases/latest/download/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose</code>
		<code>sudo chmod +x /usr/local/bin/docker-compose</code>

		<h2>Step:</h2>
		<h3>Configurazione di Nginx:</h3>
		<p>Crea una cartella chiamata <code>docker-project</code> e al suo interno crea un file <code>docker-compose.yml</code> con il seguente contenuto:</p>
		<pre><code>version: "3.9"
services:
  nginx:
    image: nginx:latest
    container_name: nginx-container
    ports:
      - 80:80</code></pre>

		<h3>Avvia Nginx:</h3>
		<p>Avvia il container Nginx con il comando:</p>
		<code>sudo docker-compose up -d</code>

		<h3>Generazione del Certificato SSL:</h3>
		<p>Crea una directory <code>ssl</code> nella tua home e genera un certificato SSL con i seguenti comandi:</p>
		<code>mkdir ~/ssl</code>
		<code>sudo openssl req -x509 -nodes -days 365 -newkey rsa:2048 -keyout ~/ssl/key.pem -out ~/ssl/cert.pem</code>

		<h3>Configurazione del Proxy SSL per Nginx:</h3>
		<p>Collega il certificato SSL al container Nginx utilizzando il comando:</p>
		<code>sudo docker run -d --name proxyapp --network docker-project_default -p 443:443 -e DOMAIN=*.compute-1.amazonaws.com -e TARGET_PORT=80 -e TARGET_HOST=docker-project-nginx-1 -e SSL_PORT=443 -v ~/ssl:/etc/nginx/certs --restart unless-stopped fsouza/docker-ssl-proxy</code>

		<h3>Configurazione del Codice PHP:</h3>
		<p>Crea una cartella <code>php_code</code> nella tua home e clona la tua repository GitHub al suo interno con il comando:</p>
		<code>mkdir ~/docker-project/php_code</code>
		<code>git clone https://github.com/dularagamagee/tech2go.git ~/docker-project/php_code/</code>

		<h3>Configurazione del Dockerfile per PHP:</h3>
		<p>All'interno della cartella <code>php_code</code>, crea un file <code>Dockerfile</code> con il seguente contenuto:</p>
		<pre><code>FROM php:7.0-fpm
RUN docker-php-ext-install mysqli pdo pdo_mysql
RUN docker-php-ext-enable mysqli</code></pre>

		<h3>Configurazione di Nginx per PHP:</h3>
		<p>Crea una cartella <code>nginx</code> nella cartella <code>docker-project</code> e al suo interno crea un file <code>default.conf</code> con la seguente configurazione per Nginx:</p>

		<h3>Aggiornamento di Docker Compose:</h3>
		<p>Modifica il file <code>docker-compose.yml</code> nella cartella <code>docker-project</code> come segue:</p>

		<h3>Avvia tutti i Container:</h3>
		<p>Avvia tutti i container utilizzando il comando:</p>
		<code>docker-compose up -d</code>

		<h3>Configurazione del Database MariaDB:</h3>
		<p>Modifica il file <code>docker-compose.yml</code> per includere il servizio di MariaDB:</p>

		<h3>Creazione del Database MariaDB:</h3>
		<p>Avvia nuovamente tutti i container con il comando <code>docker-compose up -d</code> e accedi al container MariaDB con il comando:</p>
		<code>sudo docker exec -it docker-project-db-1 /bin/sh</code>
		<p>Accedi a MariaDB con il comando:</p>
		<code>mariadb -u root -pmariadb</code>
		<p>Crea un nuovo utente per il database e assegna i privilegi necessari:</p>

		<h3>Push e Pull del Codice:</h3>
		<p>Pusha il codice dalla tua macchina locale al repository GitHub. Nell'istanza AWS, esegui il pull del codice nella cartella <code>php_code</code> con il comando:</p>
		<code>git pull</code>
	</div>
</body>

</html>