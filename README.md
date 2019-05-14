# TODO list
Garald : separate SCSS files by page, card system for pokemon grid
Prime : consistent entities and real fixture (9 first pkmns), joins for correct data set in each page

Find DELETE strategy for table rows

Manage enums with Doctrine : https://www.doctrine-project.org/projects/doctrine-orm/en/2.6/cookbook/mysql-enums.html

* Write unit tests to check enums
* Compatible CT / CS for each pokemon

next week :
- Determine JQuery sorts for each page, with controls
- Feed sprite folder
- User space with custom team with custom attacks
- Backoffice page to CRUD pokemons and attacks
- Make REST API layer with API Platform
- Dockerize with fast controls in a make file

# sf-pokedex

Pokedex example using Symfony 4.2, Bootstrap 4, PHP 7.2.
Frontend uses twig templates.

## Paths

/
home page : something fancy

/pokemon
pokemon grid

/pokemon/{id}
Features of a pokemon (infos filter in jquery, check)

/attack

/attack/{id}
Features of an attack

/create
Form page to create a new Pokemon or attack

Common template :
- Navigation panel
- Login / Logout (FOSUserBundle)

## Images management

We manage images loading with Webpack.
See https://github.com/symfony/webpack-encore/issues/24

## Frontend setup

This project embeds both backend and frontend, like a classic website and not a independent webservice.<br/>

### Step 1 : Install Encore, yarn and webpack components<br/>
```
composer require encore
curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | sudo apt-key add -
echo "deb https://dl.yarnpkg.com/debian/ stable main" | sudo tee /etc/apt/sources.list.d/yarn.list
sudo apt-get update && sudo apt-get install yarn
```
Install node_module dependencies at project root by running :
```
yarn install
```
WebpackEncoreBundle is now enabled, and webpack.config.js created at root to manage dependencies. .gitignore was auto updated. A new assets/ folders appears with assets/js/app.js and assets/css/app.css as common JavaScript/CSS.

### Step 2 : Configure Encore, SASS, jQuery and Bootstrap

First enable CSS preprocessor. We use SASS (<a href="https://sass-lang.com/">see website</a>). Install it with yarn :

```
yarn add sass-loader@^7.0.1 node-sass --dev
```

Load it in app.js :
```
// assets/js/app.js
// ...

require('../css/app.scss');
```

Enable in webpack.config.js :

```
// webpack.config.js
// ...

Encore
    // ...

    // enable just the one you want

    // processes files ending in .scss or .sass
    .enableSassLoader()
;
```
**Note that any webpack.config.js needs Encore restart to take effect.**

base.html.twig will include common CSS and JavaScript like that :
```
{# templates/base.html.twig #}
<!DOCTYPE html>
<html>
    <head>
        <!-- ... -->

        {% block stylesheets %}
            {# 'app' must match the first argument to addEntry() in webpack.config.js #}
            {{ encore_entry_link_tags('app') }}

            <!-- Renders a link tag (if your module requires any CSS)
                 <link rel="stylesheet" href="/build/app.css"> -->
        {% endblock %}
    </head>
    <body>
        <!-- ... -->

        {% block javascripts %}
            {{ encore_entry_script_tags('app') }}

            <!-- Renders app.js & a webpack runtime.js file
                <script src="/build/runtime.js"></script>
                <script src="/build/app.js"></script> -->
        {% endblock %}
    </body>
</html>
```

Install bootstrap with yarn :
```
yarn add bootstrap --dev
```
Then import Bootstrap in our main stylesheet :
```
// assets/css/global.scss

// the ~ allows you to reference things in node_modules
@import "~bootstrap/scss/bootstrap";
```

Now install jQuery and its dependency :
```
yarn add jquery popper.js --dev
```
Load it in app.js :
```
// assets/app.js

const $ = require('jquery');
// this "modifies" the jquery module: adding behavior to it
// the bootstrap module doesn't export/return anything
require('bootstrap');
```

After any config change, to launch frontend auto watch :
```
yarn encore dev --watch
```

See https://symfony.com/doc/current/frontend.html for more details.
