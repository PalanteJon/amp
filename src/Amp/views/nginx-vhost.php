<?php
/* nginx Virtual Host Template
 *
 * @var string $root - the local path to the web root
 * @var string $host - the hostname to listen for
 * @var int $port - the port to listen for
 * @var string $include_vhost_file - the local path to a related config file
 */
?>
server {
  server_name <?php echo $host; ?>;
  listen <?php echo $port ?>;
  root <?php echo $root; ?>;

  <?php if (!empty($include_vhost_file)) { ?>

  include <?php echo $include_vhost_file ?>;

  <?php } else { ?>
  location ~ \..*/.*\.php$ {
    return 403;
  }

  location ~* (\.php~|\.php.bak|\.php.orig)$ {
    deny all;
  }

  location ~ \.php$ {
    fastcgi_split_path_info ^(.+\.php)(/.+)$;
    #NOTE: You should have "cgi.fix_pathinfo = 0;" in php.ini
    include fastcgi_params;
    fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    # fastcgi_pass unix:/var/run/php5-fpm.sock;
    fastcgi_pass 127.0.0.1:9000;
    fastcgi_intercept_errors on;
    fastcgi_read_timeout 60;
  }
  <?php } ?>

}