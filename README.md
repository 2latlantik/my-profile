# My Profile

Personal Symfony application used to manage and publish a professional profile.

## Current Stack

- Backend: Symfony 5.4, Doctrine ORM
- Frontend: Webpack Encore, Stimulus, Sass, Bootstrap
- Database: MySQL-compatible (configured through .env)

## PR Evolutions Included

This branch introduces a Doctrine model modernization:

- Migration of Doctrine entity mapping from annotations to PHP 8 attributes in src/Entity.
- Repository declaration normalized with repositoryClass: RepositoryName::class.
- Missing repositories added for consistency:
	- src/Repository/FileRepository.php
	- src/Repository/FileGroupRepository.php
	- src/Repository/LeisureRepository.php
- Entity properties progressively typed with modern PHP types (?int, ?string, bool, collections).
- Existing business logic and relations preserved (OneToMany, ManyToOne, OneToOne, ManyToMany, cascade, fetch, nullable, mappedBy, inversedBy).

## Requirements

- PHP 8.0+ (required by PHP attributes used in Doctrine entities)
- Composer
- Node.js + Yarn
- A configured database server

## Installation

1. Clone the repository.
2. Install PHP dependencies:

```bash
composer install
```

3. Configure environment variables in .env (database, mail, etc.).
4. Create and migrate the database:

```bash
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```

5. Install frontend dependencies:

```bash
yarn install
```

## Frontend Build

- Development build:

```bash
yarn dev
```

- Watch mode:

```bash
yarn watch
```

- Production build:

```bash
yarn build
```

Webpack configuration is available in webpack.config.js.

## Useful Commands

- Launch tests:

```bash
php bin/phpunit
```

- Clear cache:

```bash
php bin/console cache:clear
```

## License

This project is licensed under the MIT license. See license.md for details.