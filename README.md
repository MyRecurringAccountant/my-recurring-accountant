# my-recurring-accountant
A personal finance manager application that allows users to track, manage, and plan for short and long-term recurring expenses

# Requirements
- [Docker](https://www.docker.com/)
- [Docker Compose](https://docs.docker.com/compose/install/)

# Startup
Before starting the program, copy `.env.example` to `.env`, then edit `.env`, filling in a stong password for the database.

To run the web server, run these commands from inside the project directory:

```shell
docker-compose up --build
```

This will run the web server on port `8000`. You may change this by altering the `web/ports` directive in `docker-compose.yml`
