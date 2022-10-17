<h1>Changelog</h1>

All notable changes to `mtech/module-helper` will be documented in this file

1.0.4
------------------------------------------
- update command hints for attachment
- fix standard contract namespace and service parameter

1.0.3
------------------------------------------
- updated **README.md** & **CHANGELOG.md** format
- added seeder template for metas

1.0.2
------------------------------------------
- fix path for README.md & CHANGELOG.md
- removed command to create module for now as it is still using `nwidart/laravel-modules` default stub
- updated attachment repository, `cp_attachment_type_id` to `$MODEL_LOWERCASE$_attachment_type_id` 

1.0.1
------------------------------------------
- Added **README.md** & **CHANGELOG.md**
- update composer.json to require `php` and `laravel`
- fix attachment migration file name
- added foreign key in attachment model
- added `belongsTo` relation in attachment model
- update command hints

1.0.0
------------------------------------------
- Initial Commit with feature to generate template for standard Model, Meta, and Attachment.
