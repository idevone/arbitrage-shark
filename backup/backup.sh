#!/bin/bash

DB_HOST=${DB_HOST:-postgres}
DB_PORT=${DB_PORT:-5432}
DB_NAME=${DB_NAME:-your_database_name}
DB_USER=${DB_USER:-your_database_user}
DB_PASSWORD=${DB_PASSWORD:-your_database_password}

BACKUP_DIR=/backups
DATE=$(date +"%Y%m%d_%H%M%S")
BACKUP_FILE="$BACKUP_DIR/db_backup_$DATE.sql"

PGPASSWORD=$DB_PASSWORD pg_dump -h $DB_HOST -p $DB_PORT -U $DB_USER $DB_NAME > $BACKUP_FILE

if [ $? -eq 0 ]; then
  echo "Бэкап завершен: $BACKUP_FILE"
else
  echo "Ошибка при создании бэкапа."
fi