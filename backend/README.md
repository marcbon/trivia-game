## Backend - Full Stack Trivia API 

### Installing Dependencies

1. **PHP 7.4** - Follow instructions to install the required version of php for your platform in the [php manual](https://www.php.net/manual/en/image.installation.php).
2. **Installing requirements** - To install dependencies, navigate to the `/backend/api` directory and run:

```bash
composer install
```
This will install all of the required packages we selected within the `composer.json` file.

3. **Configure environment**

If you like to change the environment for the project, you can do that by editing the file `.env` in the root folder, but we suggest to keep the same set variables.

4. **Key Dependencies**

 - [Laravel](https://laravel.com/)
 - [Sail](https://laravel.com/docs/8.x/sail#introduction)
 - [Postgres](https://www.postgresql.org/)
 - [Docker](https://www.docker.com/)
 - [WSL2 base engine for Docker](https://docs.docker.com/docker-for-windows/wsl/) - Windows

### Docker Setup

Once your WSL distro (i.e. Ubuntu-16.04) is correctly installed and integrated with Docker, navigate to the `/backend/api` directory and run:

```bash
wsl
```

This command will open the terminal for the installed and enabled wsl distro.

Start docker engine (Docker Desktop for Windows).

From the terminal, run:

```bash
vendor/bin/sail up
```

This will initiate the sail engine and install all the requirements (this will take up to few minutes, just for the first time) to create and run the needed Docker containers specified in the file `docker-compose.yml` file.

This, will create two containers named `api_psql` and `api_laravel`. 

### Database Setup

`DB_DATABASE` is a variable found in the `.env` file previously configured, a database with this name will be created in the Docker image by the `vendor/bin/sail up` command.
You can now connect to the database with the `DB_USERNAME` and `DB_PASSWORD` credentials.

##### Import database dump

In order to have the database filled with data to run the application, you need to import the database dump placed in the `/backend` folder to the Docker container.

To do this, run:

```bash
docker ps
```

Get the **CONTAINER ID** for the `api_psql` container.

Use this id into the following command:

```bash
docker cp /host/local/path/file/api-export.psql <containerId>:/tmp
```

This way, you will copy the databse dump file into the Docker container. 

Access the `api_psql` Docker container bash, and run:

```bash
su postgres
```

Navigate to the /tmp folder, there you will find your copied database dump.

To import this dump into your database, run:

```
psql databasename < api-export.psql
```

Where `databasename` is the name specified in the `DB_DATABASE` variable in the `.env` file.

Now that your Docker containers are up, you are able to access the Laravel app from http://localhost.

## API endpoints

This section will describe all the API endpoints, with the structure of each request and all the data required and returned.

All the endpoints are served under: http://localhost/api/v1/.

```
Show all questions with pagination info and all categories
GET '/api/v1/questions?page=1'
- Description: Fetches all the questions, with pagination informations
- Request Arguments: page: which is the page number to paginate the results; if omitted, the page returned will be page=1
- Returns: An object with 'questions' key, which contains 'current_page' key which is a value for the current page and 'data' key which is an object containing all the questions, and 'categories' key which is an object containing all the categories
{
    "questions": {
        "current_page": 1,
        "data": [
            {
                "id": 1,
                "question": "What movie earned Tom Hanks his third straight Oscar nomination, in 1996?",
                "answer": "Apollo 13",
                "difficulty": 4,
                "category_id": 5,
                "created_at": "2021-04-21T21:18:16.000000Z",
                "updated_at": "2021-04-21T21:18:16.000000Z"
            },
            ...
        ],
        "first_page_url": "http://localhost/api/v1/questions?page=1",
        "from": 1,
        "last_page": 2,
        "last_page_url": "http://localhost/api/v1/questions?page=2",
        "links": [
            {
                "url": null,
                "label": "&laquo; Previous",
                "active": false
            },
            {
                "url": "http://localhost/api/v1/questions?page=1",
                "label": "1",
                "active": true
            },
            {
                "url": "http://localhost/api/v1/questions?page=2",
                "label": "2",
                "active": false
            },
            {
                "url": "http://localhost/api/v1/questions?page=2",
                "label": "Next &raquo;",
                "active": false
            }
        ],
        "next_page_url": "http://localhost/api/v1/questions?page=2",
        "path": "http://localhost/api/v1/questions",
        "per_page": 10,
        "prev_page_url": null,
        "to": 10,
        "total": 19
    },
    "categories": {
        "1": "Science",
        ...
    }
}

Show a question
GET '/api/v1/questions/{id}'
- Description: Fetches a question, with pagination informations
- Request Arguments: id: the id of the question to show
- Request data: None
- Returns: An object with 'questions' key, which contains 'current_page' value and 'data' which is an object containing all the questions, and 'categories' which contains all the categories
{
    "id": 3,
    "question": "What actor did author Anne Rice first denounce, then praise in the role of her beloved Lestat?",
    "answer": "Tom Cruise",
    "difficulty": 4,
    "category_id": 5,
    "created_at": "2021-04-21T22:59:31.000000Z",
    "updated_at": "2021-04-21T22:59:31.000000Z"
}

Create new question
POST '/api/v1/questions/
- Description: Create a new question with the given data
- Request Arguments: string 'question' (required), string 'answer' (required), int 'difficulty' (required), int 'category_id' (required)
- Returns: An object which represents the question created with the values above
{
    "id": 3,
    "question": "What actor did author Anne Rice first denounce, then praise in the role of her beloved Lestat?",
    "answer": "Tom Cruise",
    "difficulty": 4,
    "category_id": 5,
    "created_at": "2021-04-21T22:59:31.000000Z",
    "updated_at": "2021-04-21T22:59:31.000000Z"
}

Update a question
PUT '/api/v1/questions/{id}
- Description: Update a question with the given data
- Request Arguments: id: the id of the question to be updated
- Request Data: string 'question' (required), string 'answer' (required), int 'difficulty' (required), int 'category_id' (required)
- Returns: An object which represents the question updated with the values above
{
    "id": 3,
    "question": "What actor did author Anne Rice first denounce, then praise in the role of her beloved Lestat?",
    "answer": "Tom Cruise",
    "difficulty": 4,
    "category_id": 5,
    "created_at": "2021-04-21T22:59:31.000000Z",
    "updated_at": "2021-04-21T22:59:31.000000Z"
}

Delete a question
DELETE '/api/v1/questions/{id}
- Description: Delete a question with the given data
- Request Arguments: id: the id of the question to be deleted
- Request Data: None
- Returns: An object with the question deleted
{
    "id": 3,
    "question": "What actor did author Anne Rice first denounce, then praise in the role of her beloved Lestat?",
    "answer": "Tom Cruise",
    "difficulty": 4,
    "category_id": 5,
    "created_at": "2021-04-21T22:59:31.000000Z",
    "updated_at": "2021-04-21T22:59:31.000000Z"
}

Search questions
POST '/api/v1/search'
- Description: Fetches all the questions containing the searched string
- Request Arguments: None
- Request Data: search_term: which is the string to be searched within the questions
- Returns: An object containing two keys: questions: which contains all the questions, total: the total number of questions that match the research
{
    "questions": [
        {
            "id": 1,
            "question": "What movie earned Tom Hanks his third straight Oscar nomination, in 1996?",
            "answer": "Apollo 13",
            "difficulty": 4,
            "category_id": 5,
            "created_at": "2021-04-21 21:18:16",
            "updated_at": "2021-04-21 21:18:16"
        },
        ...
    ],
    "total": 8
}

Get questions from a specific category
GET '/api/v1/categories/{id}/questions'
- Description: Fetches all the questions from a specific category
- Request Arguments: id: the category id to retrieve the related questions
- Request Data: None
- Returns: An object with three keys: questions: all the question from the specific category, total: the total number of questions retrieved, category: the category id of the specified category
{
    "questions": [
        {
            "id": 14,
            "question": "Which Dutch graphic artist–initials M C was a creator of optical illusions?",
            "answer": "Escher",
            "difficulty": 1,
            "category_id": 2,
            "created_at": "2021-04-22 22:40:49",
            "updated_at": "2021-04-22 22:40:49"
        },
        ...
    ],
    "total": 4,
    "category": 2
}

Get all categories
GET '/api/v1/categories'
- Description: Fetches a dictionary of categories in which the keys are the ids and the value is the corresponding string of the category
- Request Arguments: None
- Request Data: None
- Returns: An object with two keys: id: which is the category id and type: which is the category name
{
    "categories": {
        "1": "Science",
        "2": "Art",
        "3": "Geography",
        "4": "History",
        "5": "Entertainment",
        "6": "Sports"
    }
}

Get the current question to play the quiz
POST '/api/v1/quiz'
- Description: Fetches the questions to play the quiz for a specific category
- Request Arguments: None
- Request Data: int quiz_category (required): which is the category id for the related questions, previous_questions which is an array of question ids already answered 
- Returns: An object with a single key: current_question: which is the question to be answered. The question returned by this endpoint are returned in random order
{
    "current_question": {
        "id": 20,
        "question": "Hematology is a branch of medicine involving the study of what?",
        "answer": "Blood",
        "difficulty": 4,
        "category_id": 1,
        "created_at": "2021-04-22 22:42:19",
        "updated_at": "2021-04-22 22:42:19"
    }
}

```