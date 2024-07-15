# Tasks Microservice

This guide provides detailed instructions on how to set up and run the application using Docker. It covers the installation of necessary software, setting up the Docker environment, and running the application.

## Prerequisites

Before you begin, ensure you have the following software installed on your system:

- Docker: Version 20.10.7 or higher
- Docker Compose: Version 1.29.2 or higher

## Software Versions

The application uses the following software versions:

- PHP: 8.3.3
- Nginx: 1.21
- Alpine Linux: 3.19
- Composer: 2.4
- MySQL: 5.7

## Setting Up the Environment

1. **Clone the Repository**

   Clone the project repository to your local machine using Git:

   ```bash
   git clone <repository-url>
   cd <project-directory>

2. **Environment Variables**

   Before running the application, you need to set up the necessary environment variables. Copy the `.env` file to `.env.local` and update the values according to your environment:

   ```bash
   cp .env .env.local
   Make sure to adjust the following variables according to your setup:  

3. **Environment Variables**

   Before running the application, you need to set up the necessary environment variables. Copy the `.env` file to `.env.local` and update the values according to your environment:

   ```bash
   cp .env .env.local

4. **Testing**

    To ensure your application is running correctly, you should run tests. Here's how you can execute tests within the Docker environment:  
    Enter the PHP Container  First, you need to access the shell of your PHP container. You can do this with the following command:  
    <pre>docker-compose exec php sh </pre>
   Ensure all static analysis check are pass ing to confirm that your application is set up correctly and functioning as expected.
