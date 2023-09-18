# How to Start a Local Web Server

Follow these steps to set up and run a local web server on your computer using Docker.

## Prerequisites
- Install Docker on your computer.

## Instructions

1. Create a directory that will serve as the parent directory for the 'HAMK-Edu' folder. Your directory structure should look like this:

your_directory
── Hamk-Edu

2. Copy the files from the following repository into the newly created folder:
- [Repository Link](https://github.com/gibanator/files-for-local-server)

3. To start the web server, run the following command from within the created folder:

```bash
docker-compose up -d
```

4. To access the `index.php` page, open your web browser and enter the following URL:
   - [http://localhost:81](http://localhost:81)

5. To access phpMyAdmin, open your web browser and enter the following URL:
   - [http://localhost:82](http://localhost:82)	
   	(username: root
	 password: password)