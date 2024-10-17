## Getting Started

1. If not already done, [install Docker Compose](https://docs.docker.com/compose/install/) (v2.10+)
2. Run `docker compose build --no-cache` to build fresh images
3. Run `docker compose up -d` to start the containers
4. Run `docker compose exec php composer install` to install the composer dependencies
5. See below instructions to use the project
6. When finished, run `docker compose down --remove-orphans` to stop the Docker containers.

Credits for docker setup: [symfony-docker](https://github.com/dunglas/symfony-docker)

## Instructions

1. Send a request to end point `https://localhost/message/create` with a json body including the message content and recipient. 
Example: 
```
curl --location 'https://localhost/message/create' \
--header 'Content-Type: application/json' \
--data '{
    "content": "HEY HALLO DIT IS GEHEIM EN WIL IK VERSTUREN NAAR IEMAND ANDERS",
    "recipient": "henk"
}'
```

As a response you will receive something like this:
```
{
    "url": "/message/view/37344242-8c9c-11ef-b7ed-4b19947c085b",
    "secret": "860024"
}
```

2. Use the response to create url: `https://localhost/message/view/37344242-8c9c-11ef-b7ed-4b19947c085b` and send this to the recipient.
3. Send the secret from the response also to the recipient, use a different communication channel for this in case the recipient is compromised on one of them
4. The recipient needs to send a request to the given endpoint `https://localhost/message/view/37344242-8c9c-11ef-b7ed-4b19947c085b` and add a json body including the secret.
Example:
```
curl --location 'https://localhost/message/view/37344242-8c9c-11ef-b7ed-4b19947c085b' \
--header 'Content-Type: application/json' \
--data '{
    "secret":"860024"
}'
```

5. The response that the recipient will receive will be one of the following
Success:
```
{
    "content": "HEY HALLO DIT IS GEHEIM EN WIL IK VERSTUREN NAAR IEMAND ANDERS",
    "recipient": "henk"
}
```
Wrong secret given:
```
{
    "content": "Wrong secret passed, message deleted. sorry :("
}
```
Message not found:
```
A generic 404 response
```

6. After a request is done to retrieve a message (success or fail) the message is deleted.
7. A command is present to remove messages from 'yesterday'. This can be set up to run with for example a cronjob.

## Testing

1. Using the command `docker compose exec php bin/phpunit` will run the unit tests (currently one test)
