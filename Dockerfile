FROM webdevops/php-nginx:8.2-alpine
ENV COMPOSER_ALLOW_SUPERUSER=1
ENV WEB_DOCUMENT_ROOT=/app/public
ENV PHP_DISMOD=bz2,calendar,exiif,ffi,intl,gettext,ldap,mysqli,imap,soap,sockets,sysvmsg,sysvsm,sysvshm,shmop,xsl,zip,gd,apcu,vips,yaml,imagick,mongodb,amqp
WORKDIR /app
COPY . /app/
COPY ./docker/supervisord.conf /opt/docker/etc/supervisor.d/custom.conf
COPY ./docker/contatos_template.csv /app/storage/app/public/contatos_template.csv
RUN mkdir /app/storage/app/keys
RUN cd /app && composer install --no-interaction --optimize-autoloader --no-dev
# Ensure all of our files are owned by the same user and group.
EXPOSE 80
RUN mv /opt/docker/etc/supervisor.d/syslog.conf /opt/docker/etc/supervisor.d/syslog.conf.disabled
RUN chown -R application:application .
