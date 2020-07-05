# Vendify

Community marketplace theme.

![Vendify](https://cldup.com/hhvrfg3yIe.png)

## Install

```
$ git clone git@github.com:Astoundify/vendify && cd vendify
$ npm run setup-theme
```


The command `npm run setup-theme` will try to bring all the theme's submodules, from the `vendor/astoundify` directory, 
so make sure you have access to those github submodules.
It will also go through each submodule and run their own build there, so the theme will be ready to work after this step

## Develop

```
$ npm run dev
```

This command will start a webpack watcher which will build CSS and JS assets when their files are edited.

Be aware that the files in `vendor/asoundify` should not be commited directly in the theme's repository.
Check the `.gitmodules` file for the linked submodules for more details or documentation, especially these ones:

* For style customization https://github.com/Astoundify/wp-theme-customizer
* For WooCommerce features and customisation https://github.com/Astoundify/wc-themes-framework
* For the Product editor https://github.com/Astoundify/wc-product-editor

## Build

```
$ npm run build
```

The command to create a production ready theme.

## Contributing

`master` branch is always what is currently published on Themeforest, which means nothing should be committed directly to this branch.

### Creating a Release

1. Create a `release/x.x.x` branch off of master.
2. Add features or fix bugs. See sections below.
3. Assign at least one reviewer other than yourself to the Pull Request.
4. Once reviewed the reviewer can merge the release in to the `master` branch.

### Fixing a Regression/Adding a Feature

1. Create a new issue branch. For example `fix/123`. Where `123` is the ID of the open issue.
2. Add your changes.
3. Open a Pull Request against the next minor or patch branch. For example `release/1.5.1`. If a patch branch does not exist create one.
4. Assign at least one reviewer other than yourself to the Pull Request.
5. Once reviewed the reviewer can merge the fix in to the `release/x.x.x` branch.

## Distribute

Each time a commit is made to any `release/*` branch, Github will trigger a CircleCI workflow which creates a production
ready release build with `npm run build`.

Also CircleCI will upload the release files on Github. Check the `.circleci` directory and the CircleCI documentation for
custom workflows.
