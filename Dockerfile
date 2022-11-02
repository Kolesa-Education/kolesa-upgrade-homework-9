FROM mysql

COPY ../../storage/init.sql /tmp

CMD ["mysqld", "--init-file=/tmp/init.sql"]