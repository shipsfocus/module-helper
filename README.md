<h1>Mtech Module helper</h1>

Create Template for Migration, Model, Contract, and Repository in Modules with one command

<h3>Installation</h3>

`composer require mtech/module-helper --dev`

<h3>How to use</h3>

````
php artisan mtech:make-model {module} {table} {model} --meta
php artisan mtech:make-attachment {module} {table} {model}
````

Example:

- Model:
  ````
  php artisan mtech:make-model Voyage voyage_details VoyageDetail
  ````

- Meta:
  Please note that to create metas, include the option `--meta` in the command:
  ````
  php artisan mtech:make-model Voyage voyage_types VoyageType --meta
  ````
  - Attachment:
    Please note that third variable is the Model that this attachment belongs to. In this example, we want to create voyage attachment, so the third variable should be **Voyage**:
  ````
  php artisan mtech:make-attachment Voyage voyage_attachments Voyage
  ````

<h2>Important Notes</h2>

You still need to bind contract and repository in the Config/config.php
