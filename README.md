# Manual de instalación de PANTALLAS
## Versión 3.0
____


## Requisitos

* **Linux**
* PHP > 5.2.8
* Apache 2.2
* MySQL 5.5
* mod_rewrite ACTIVADO
* php5-curl INSTALADO

____


## Instrucciones para la instalación en Ubuntu

## Clonar repositorio
  * Lo vamos a hacer en **/var/www/**, entonces ingresamos en la **terminal**:

    ```
    cd /var/www/
    ```
  * Elegimos el método por el cual vamos a clonar el desarrollo:
    + **SSH**
      ```
      git clone git@github.com:gcba/pantallas.git pantallas
      ```
    + **HTTP**
      ```
      git clone https://github.com/gcba/pantallas.git pantallas
      ```
  * Y luego ingresamos el siguiente comando para darle permisos a la carpeta:

    ```
    sudo chmod 755 pantallas
    ```

____
## Importar base de datos
  * Una vez clonado el repositorio, necesitamos importar la base de datos, para eso vamos a buscar la estructura.:

    ```
    cd /var/www/pantallas/app/Config/Schema/
    ```
  * Y luego ingresamos los siguientes comandos en la **terminal**:

    ```
    mysql -h localhost -u root -p
    ```
  + Importante: ingresar contraseña de MySQL.

    ```
    create database pantallas;
    exit;
    ```
  * Y ahora hacemos el import y esperamos a que termine:

    ```
    mysql -h localhost -u root -p pantallas < structure.sql
    ```
  + Importante: ingresar contraseña de MySQL nuevamente.
  * Esperamos a que termine de importar y salimos:

    ```
    exit;
    ```

____
## Configuración del entorno
  * Ahora vamos a proceder a configurar el entorno. Ingresar los siguientes comandos en la **terminal**:

    ```
    cd /var/www/pantallas/app/Config
    sudo cp core.php.default core.php
    ```
  * Y por último, vamos a:

    ```
    cd /var/www/pantallas/app/
    ```
  * En el caso de que NO exista la carpeta **tmp**, ingresamos también los siguiente comandos:

    ```
    sudo mkdir tmp
    sudo mkdir tmp/cache
    sudo mkdir tmp/cache/models
    sudo mkdir tmp/cache/persistent
    sudo mkdir tmp/logs
    ```
  * Y el comando para darle permisos:

    ```
    sudo chmod -R 777 tmp/
    ```

____
## Configuración de la base de datos
  * Ahora vamos a proceder a configurar la base de datos. Ingresar los siguientes comandos en la **terminal**:

    ```
    cd /var/www/pantallas/app/Config
    sudo cp database.php.default database.php
    sudo gedit database.php
    ```
  * Ir a la **línea 56** y **editar la variable $default con la configuración de la base de datos con la que corresponda**. Una vez listo, guardar y salir.

____
## Configuracion de emails
  * Para configurar el servicio de emails. Ingresar los siguientes comandos en la **terminal**:

    ```
    cd /var/www/pantallas/app/Config
    sudo cp email.php.default email.php
    sudo gedit email.php
    ```
  * Ir a la **línea 38** seleccionamos todo hasta el fondo y pegamos lo siguiente:

    ```
    class EmailConfig {

      public $smtp = array(
		    'transport' => 'Smtp',
		    'from' => 'noreply@smtp.ar',
		    'host' => 'smtp.com.ar',
		    'port' => 25,
		    'timeout' => 30,
		    'username' => 'smtp',
		    'password' => 'smtp',
		    'client' => null,
		    'log' => false,
		    //'charset' => 'utf-8',
		    //'headerCharset' => 'utf-8',
      );

    }
    ```

____
## Configuración del VirtualHost
  * Puede ser medio tedioso, pero es simple siguiendo las instrucciones correctamente, comencemos:

    ```
    cd /etc/apache2/sites-available
    sudo gedit pantallas.conf
    ```
  * Dentro del archivo **pantallas.conf** vamos a copiar y pegar lo siguiente:

    ```
    <VirtualHost *:80>

      ServerName pantallas
      ServerAlias pantallas
      ServerAdmin dev@localhost
    
      DirectoryIndex index.php
      DocumentRoot "/var/www/pantallas/"
      <Directory "/var/www/pantallas/">
        AllowOverride All
        Allow from All
        Require all granted
      </Directory>
    
      ErrorLog ${APACHE_LOG_DIR}/error.log
      CustomLog ${APACHE_LOG_DIR}/access.log combined
    
    </VirtualHost>
    ```
  * Guardamos y salimos. Ahora vamos a activar el **mod rewrite**, el **virtualhost** y reiniciamos el apache:

    ```
    sudo a2enmod rewrite
    sudo a2ensite pantallas.conf
    sudo service apache2 restart
    ```
  * Ahora nos resta configurar el archivos **hosts**, lo abrimos con el siguiente comando:

    ```
    sudo gedit /etc/hosts
    ```
  * Vamos abajo de todo e ingresamos

    ```
    127.0.0.1   pantallas
    ```

____
## Configuración del Ambiente
  * Para determinar el ambiente en el cual se va a utilizar el entorno, necesitamos configurar el archivo **core.php** y editar el **debug** _(toma valores de 0 a 2)_, entonces ingresamos lo siguiente en la **terminal**:

    ```
    cd /var/www/pantallas/app/Config
    sudo gedit core.php
    ```
  * Y determinamos según el ambiente en la **línea 36**:
    + **PRD** _(sin mensajes)_:
      ```
      Configure::write('debug', 0)
      ```
    + **HML** _(advertencias, errores de código)_:
      ```
      Configure::write('debug', 1)
      ```
    + **DEV** _(advertencias, errores de código y base de datos)_:
      ```
      Configure::write('debug', 2)
      ```
  * Una vez definido el ambiente, guardamos y salimos.

____
## Ingreso al sitio
  * Listo! Ya podemos cerrar la terminal, ir al explorador e ingresar la siguiente dirección en el navegador:

    ```
    http://pantallas/
    ```
  * **IMPORTANTE** Por ser el primer ingreso, pide que se cree un nuevo usuario

____
## Verificación de la configuración
  * En la siguiente dirección aparecerá la página de CakePHP con toda la información necesaria del framework _(requiere debug en 2)_:

    ```
    http://pantallas/pages/home/
    ```

____
## Fin