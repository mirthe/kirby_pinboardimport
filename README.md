# Kirby Plugin: Pinboard import

Imports weekly links from [Pinboard](https://pinboard.in) to a linklist in the form of Kirby pages.

## Git submodule

```
git submodule add https://github.com/mirthe/kirby_pinboardimport site/plugins/pinboard-import
```

## Usage

There are 2 routines available, one to import last weeks post and a second one to pick a specific week and import the links for that week. To run either routine, you need to be logged into the panel as an admin user to protect your site from some abuse.

### Get last weeks links

Add the following to your Kirby config where XX is your Pinboard API token (get this at https://pinboard.in/settings/password) and YYY your domain or sitename for identification:
    
    'pinboard.token' => 'XXX',
    'pinboard.useragent' => 'YYY',

I have this scheduled for early monday morning, but you can run this manually on monday in case you made changes in Pinboard and want to update the linklist. An existing folder for the week will be overwritten.

    https://yoursite.com/pinboard/import

### Choose a specific week

If for some reason you want to run a specific week, you can use the calendar function to pick the week and create the export. An existing folder for the week will be overwritten.

    https://yoursite.com/pinboard/calendar

## Example 

Check out the display on my site at
https://mirthe.org/linklist

## Todo

- Offer as an official Kirby plugin
- Add sample Kirby templates to this readme
- Add sample Kirby Blueprint to this readme
- Cleanup code, a lot, maybe stick to one language, sorry
- Lots..
