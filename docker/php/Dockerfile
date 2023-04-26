ARG PHP_VER
ARG PHP_SAPI
FROM php:${PHP_VER}-${PHP_SAPI}-alpine3.16 AS basic

RUN docker-php-ext-install -j$(getconf _NPROCESSORS_ONLN) \
      opcache \
      pdo_mysql \
    && apk add --no-cache --virtual .build-deps \
      $PHPIZE_DEPS \
    && pecl install apcu \
    && docker-php-ext-enable apcu \
    && apk del .build-deps

ARG APP_TIMEZONE
RUN apk add tzdata \
        && cp /usr/share/zoneinfo/${APP_TIMEZONE} /etc/localtime \
        && echo ${APP_TIMEZONE} > /etc/timezone \
        && apk del tzdata

ADD ./docker/php/ini/*ini ${PHP_INI_DIR}/conf.d/
RUN sed -i "s#{{date.timezone}}#${APP_TIMEZONE}#g" ${PHP_INI_DIR}/conf.d/date.ini

ADD ./docker/php/*sh /var/tools/
RUN chmod u+x /var/tools/*.sh && /var/tools/install-composer.sh


# Add user and group for isolated run
ARG APP_USER
ENV USER ${APP_USER}
ARG APP_UID
ENV UID ${APP_UID}
ARG APP_GID
ENV GID ${APP_GID}

RUN addgroup -g ${GID} -S ${USER} && \
    adduser -u ${UID} -S ${USER} -G ${USER}

COPY ./docker/.ashrc "/home/${APP_USER}/.ashrc"
ENV ENV="/home/${APP_USER}/.ashrc"

USER ${APP_USER}
