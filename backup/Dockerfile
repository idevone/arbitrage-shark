FROM alpine:latest

# Установка необходимых пакетов
RUN apk add --no-cache postgresql-client bash

# Копирование скрипта бэкапа
COPY backup.sh /usr/local/bin/backup.sh
RUN chmod +x /usr/local/bin/backup.sh

# Установка cron
RUN apk add --no-cache openrc && \
    echo "0 * * * * /usr/local/bin/backup.sh" > /etc/crontabs/root

CMD ["crond", "-f"]
