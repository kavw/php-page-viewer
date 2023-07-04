ARG PHP_VER
ARG PHP_SAPI
FROM php:${PHP_VER}-${PHP_SAPI}-alpine3.16 AS basic


RUN docker-php-ext-install -j$(getconf _NPROCESSORS_ONLN) \
      pdo_mysql \
    && apk add --no-cache --virtual .build-deps \
      $PHPIZE_DEPS \
    && pecl install apcu \
    && docker-php-ext-enable apcu \
    && apk del .build-deps

ADD ./ini/*ini ${PHP_INI_DIR}/conf.d/

ADD ./*sh /var/tools/
RUN chmod u+x /var/tools/*.sh && /var/tools/install-composer.sh

ARG APP_CONTAINER_VAR_DIR
ARG APP_CONTAINER_CACHE_DIR
RUN mkdir -p ${APP_CONTAINER_VAR_DIR} && mkdir -p ${APP_CONTAINER_CACHE_DIR}

# Add user and group for isolated run
ARG APP_CONTAINER_USER
ENV USER ${APP_CONTAINER_USER}
ARG APP_CONTAINER_UID
ENV UID ${APP_CONTAINER_UID}
ARG APP_CONTAINER_GID
ENV GID ${APP_CONTAINER_GID}

RUN addgroup -g ${GID} -S ${USER} && \
    adduser -u ${UID} -S ${USER} -G ${USER} && \
    chmod -R 0755 ${APP_CONTAINER_VAR_DIR} && \
    chown -R ${USER}:${USER} ${APP_CONTAINER_VAR_DIR}

USER ${APP_CONTAINER_USER}








