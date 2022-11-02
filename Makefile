build:
	docker build -t my_db .

run:
	docker run --rm -e MYSQL_ROOT_PASSWORD=my-secret-pw -p 3306:3306 -d my_db