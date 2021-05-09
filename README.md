# My-Profile

The goal of this project is to evolve at the same rate as my learning on **symfony4**

# Requirements

 - PHP 7.1.3 or higher 

# Installation 

 - git clone
 - composer install
 - Config bvatabase parameter in .env file 
 - php bin/console doctrine:database:create
 - php bin/console make:migration 
 - php bin/console doctrine:migrations:migrate
 
 - Install front dependencies
 
 npm install --global yarn
 yarn install

## I - Discovery of the new front end component

I relied on the documentation available on the symfony site called  [Managing CSS and Javascript](https://symfony.com/doc/current/frontend.html)

The main element for good frontend file management is called Webpack Encore.

The use of this bundle will also include the use of the dependency manager [Yarn](https://yarnpkg.com) and light knowledge of [webpack](https://webpack.js.org).

This bundle sign the end of assetic and it is from my point of view a good thing as this bundle is successful. It allows through wepack a very good management of CSS files, JS, Images ...

It is very useful to prepare these CSS files by writing them in SCSS and to install front end dependencies, like JQuery or Bootstrap, thanks to a dependency manager.

The configuration and addition of functionality on the front end is done through the file **webpack.config.js**. It will, in particular : 

 - define where the files will be compiled by webpack
 - define entry 0points, place where the original files are stored 
 - allow use and processing of Scss files
 - add plugins

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details