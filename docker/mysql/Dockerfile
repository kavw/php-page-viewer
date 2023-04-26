ARG MYSQL_VER

FROM mysql:${MYSQL_VER}-debian

ARG MYSQL_USER
ARG MYSQL_PASS
ARG MYSQL_DB
COPY docker/mysql/*.sql /docker-entrypoint-initdb.d
RUN sed -i "s#{{user}}#${MYSQL_USER}#g" /docker-entrypoint-initdb.d/02_grants.sql \
    && sed -i "s#{{pass}}#${MYSQL_PASS}#g" /docker-entrypoint-initdb.d/02_grants.sql \
    && sed -i "s#{{db}}#${MYSQL_DB}#g" /docker-entrypoint-initdb.d/02_grants.sql

ARG APP_USER
ENV USER ${APP_USER}
ARG APP_UID
ENV UID ${APP_UID}
ARG APP_GID
ENV GID ${APP_GID}

RUN addgroup --gid ${GID} ${USER} && \
    adduser --gid ${GID} --uid ${UID} --home "/home/${USER}"  ${USER}

ARG PS1
ENV PS1_EX $PS1

RUN echo 'export PS1="$PS1_EX"' >> "/home/${USER}/.bashrc" \
    && mkdir /home/${APP_CONTAINER_USER}/scripts


USER ${APP_USER}
