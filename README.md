<p align="center"><img src="https://res.cloudinary.com/dtfbvvkyp/image/upload/v1566331377/laravel-logolockup-cmyk-red.svg" width="400"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>
<hr>

- docker run --name mysql -p 3310:3306 -e MYSQL_ROOT_PASSWORD=senocak -d mysql:8.0.1
- docker run --name phpmyadmin2 -d --link mysql:db -p 3320:80 phpmyadmin/phpmyadmin
- docker exec -it mysql bash
- docker build -t senocak:1.0 .
	- docker rm -f senocak
- docker run -d -p 31:8181 --name senocak senocak:1.0
- docker exec -it senocak bash
	- ProxyServer
- docker pull nginx:alpine
- docker volume create volume-nginx
- docker run -d --restart always --name proxy -p 80:80 -p 443:443 -p 23:23 -v volume-nginx:/etc/nginx nginx:alpine
- cd /var/lib/docker/volumes/volume-nginx/_data/conf.d/
ls
<hr>

    server {
            server_name senocak.tk www.senocak.tk;
            location / {
                    #try_files $uri $uri/ =404;
                    proxy_pass http://157.230.22.123:31;
                    proxy_http_version 1.1;
                    proxy_set_header Upgrade $http_upgrade;
                    proxy_set_header Connection 'upgrade';
                    proxy_set_header Host $host;
                    proxy_cache_bypass $http_upgrade;
            } #location tag
		    ######################SSL#####################
		    # listen [::]:443 ssl; # managed by Certbot
		    #    listen 443 ssl; # managed by Certbot
		    #    ssl_certificate ssl/senocak.tk/fullchain1.pem; # managed by Certbot ssl_certificate_key /etc/nginx/ssl/senocak.tk/privkey1.pem; # managed by Certbot include options-ssl-nginx.conf;
		    #    # managed by Certbot
		    #    ssl_dhparam ssl-dhparams.pem; # managed by Certbot
		    ###################################################
    }
    server {
        if ($host = senocak.tk) {
            return 301 https://$host$request_uri;
        } # managed by Certbot
            server_name senocak.tk;
            listen 80 ;
            listen [::]:80 ;
        return 404; # managed by Certbot
    }

<hr>
