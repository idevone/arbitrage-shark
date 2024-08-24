FROM liquibase:latest

RUN liquibase init project

COPY ./changelog /liquibase/changelog
COPY ./liquibase.properties /liquibase/liquibase.properties

CMD ["liquibase", "--defaultsFile=/liquibase/liquibase.properties", "update"]