all: help
help:
	@echo "Usage: make [option]\n\tOptions:\n\trun: runs the service\n\tstop: halts the service\n\tclean: removes all the containers\n\tbuild: builds the containers\n\thelp: displays this help message"
run:
	docker-compose up -d
build:
	docker-compose build
stop:
	docker-compose stop
clean:
	docker-compose down -v
