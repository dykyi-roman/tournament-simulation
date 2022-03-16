FROM nginx:stable-alpine

RUN apk upgrade --update-cache --available && \
    apk add openssl && \
    rm -rf /var/cache/apk/*

RUN openssl req  -subj "/C=UA/ST=/L=/O=/OU= Department/CN=tournament-simulation.docker" -x509 -nodes -days 365 -newkey rsa:2048 -keyout /etc/ssl/private/nginx-selfsigned.key -out /etc/ssl/certs/nginx-selfsigned.crt