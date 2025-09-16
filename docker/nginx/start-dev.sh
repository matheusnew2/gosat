#!/bin/sh
cd /var/www/html/vue  && npm install &&  npm run build &
nginx -g 'daemon off;'