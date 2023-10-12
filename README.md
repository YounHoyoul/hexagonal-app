<h1 align="center">
  Laravel 10 DDD / CQRS with Inertia.js & Sail
</h1>

##Base Project
`mguinea/laravel-ddd-example`

##First Step
```
make build
make up
make bash # run bash of laravel.test container
```
In the laravel.test container
```
composer install
php artisan test
```

##Folder Structure
```
src/
    BoundedContext/
        DomainName/
            Applicatoin/
                CommandFolder/
                    *Command.php
                    *CommandHandler.php
                *Reponse.php
            Domain/
                Actions/
                    *Action.php
                Events/
                Exceptions/
                Repositories/
                ValueObjects/
                Entity.php
            Infrastructure/
                Http/
                    Controllers/
                        *Controller.php
                    Resources/
                        *Resource.php
                Providers/
                    *ServiceProvider.php
                Repositories/
                    *Repository.php
                route/
                    api.php
                    web.php

```

##Validation
1. implement `ValidateInterface` on Command
2. add `rules` method
```
public function rules(): array
{
    return [
        'name' => UserName::rule(),
        'email' => UserEmail::rule(),
        'password' => UserPassword::rule(),
    ];
}
```
3. add `ValidateItemInterface` on ValueObject
4. add `rule` mothod
```
public static function rule() : array
{
    return [
        'required',
        'email',
    ];
}
```
5. When the command is dispatched, the validation is checked in `MessengerCommandBus`.
```
if ($command instanceof ValidateInterface) {
    $rules = $command->rules();
    if (! empty($rules)) {
        Validator::make((array) $command, $rules)->validate();
    }
}
```

* Using Laravel's Validation with Command following the rule of https://laravel.com/docs/10.x/validation

##PHP xDebug
In order to enable xDebug with Laravel Sail
1.add below in /docker/8.2/php.ini
```
[XDebug]
zend_extension = xdebug.so
xdebug.mode = debug
xdebug.start_with_request = yes
xdebug.discover_client_host = true
xdebug.idekey = VSC
xdebug.client_host = host.docker.internal
xdebug.client_port = 9003
```
2. update Docker file
```
...
ARG XDEBUG
...
RUN if [ ${XDEBUG}] ; then \
    apt-get install -y php-xdebug; \
fi;
...
```
3. rebuild docker with 
```
make build
```
4. add launch.json
```
{
    // Use IntelliSense to learn about possible attributes.
    // Hover to view descriptions of existing attributes.
    // For more information, visit: https://go.microsoft.com/fwlink/?linkid=830387
    "version": "0.2.0",
    "configurations": [
        {
            "name": "Listen for XDebug on Docker App",
            "type": "php",
            "request": "launch",
            "port": 9003,
            "pathMappings": {
                "/var/www/html": "${workspaceFolder}"
            },
            "hostname": "localhost",
            "xdebugSettings": {
                "max_data": 65535,
                "show_hidden": 1,
                "max_children": 100,
                "max_depth": 5
            }
        }
    ]
}
```
5. update .env
```
SAIL_XDEBUG_MODE=develop,debug
```
6. run docker
```
make up
```