![gazpacho logo](http://f.cl.ly/items/0a2l3o231c2w1F0m0t3t/gazpacho_logo.png)

Gazpacho is a refreshing name for a refreshing new PHP [MVC framework](http://en.wikipedia.org/wiki/Model%E2%80%93view%E2%80%93controller).

> 0.8

## Install

For now, you only can download a bare project and start coding on it.

```bash
$ git clone https://github.com/Pixelito/gazpacho.git
```

## Configuration

The only config you must set up is in `config/app.php` file and `config/db.php`.
You have to set the apache document root to the __public__ folder too!

## Usage

#### generate tool

You may want to use the `script/generate` tool! It's a useful shell application
which helps you to create your project files.

__Generating a controller "home":__

```bash
$ script/generate controller post
```

__Generating a view "home":__

```bash
$ script/generate view post
```

__Generating a model "home":__

```bash
$ script/generate model post title=string date=datetime author=integer body=text
```

If you want to build a complete entity logic you can use this:

```bash
$ script/generate scaffold post title=string date=datetime author=integer body=text
```

And the generate tool will creates a controller, a view and a model for the post entity. :)

#### App flow

```php
Application::initialization(); // Loads the config files and creates a database instance

Application::processRequest(); // Calls the Router class
    Router::dispatch();        // Process the action
        Controller->action();  // Calls the action to be performed

Application::finalization();   // Close the database connection and release resources
```

Keep in mind that Gazpacho use __frendly URL__, so the URL `http://mysite.com/posts/new`
will call the `PostsController->new();` action.

The model class you generated will create the database tables once the class is reached __automatically__.
So you __don't__ need to create the tables on your mariaDB client.

## License 

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.