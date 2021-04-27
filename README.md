# my-recurring-accountant
A personal finance manager application that allows users to track, manage, and plan for short and long-term recurring expenses

# Requirements
- [Docker](https://www.docker.com/)
- [Docker Compose](https://docs.docker.com/compose/install/)

**Make sure to clone the project using Git**, as opposed to downloading a .zip file. The project makes use of git submodules
in order to download dependencies; and submodule information can only be used inside a git folder.

After you clone the project, run this command to install dependencies:

```shell
git submodule update --init --recursive
```

# Startup
Before starting the program, copy `.env.example` to `.env`, then edit `.env`, filling in a stong password for the database.

To run the web server, run these commands from inside the project directory:

```shell
docker-compose up --build
```

This will run the web server on port `8000`. You may change this by altering the `web/ports` directive in `docker-compose.yml`
