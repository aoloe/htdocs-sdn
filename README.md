# Sortir du nucléaire

Website de l'association Suisse Sortir du nucléaire

# Notes

- cross reference anchors in markdownk:
  - <http://stackoverflow.com/questions/5319754/cross-reference-named-anchor-in-markdown>
  - <https://michelf.ca/projects/php-markdown/extra/>
- facebook feed:
    - eventually, for composer:
        "simplepie/simplepie": "1.3.1",
        "facebook/php-sdk": "3.2.3",
    - http://callmenick.com/2013/03/14/displaying-a-custom-facebook-page-feed/
    - https://gist.github.com/banago/3864515
    - https://github.com/facebook/facebook-php-sdk
- line below the page title: http://www.impressivewebs.com/centered-heading-horizontal-line/

# Reference

- rename the lightSlider's image and modify `lightSlider.css` according to it.
- upload manager:
  - https://github.com/daverogers/jQueryFileTree/
  - http://toopay.github.io/bootstrap-markdown/ (with custom buttons...)

# Todo

- catch wrong urls (404)
- check what to do with neuchatel (and the other "small sites")
- add a module for the most recent update
- find out how to show items of a module (news entries)
- create a 303 redirect for each old id=
- add the tests for the Markdown local url replacements
      test

      <ici> et <http://labas.com>

      [test ici](ici) [test ici 2](ici_2)

      ![test ici](ici)

      [test la](http://labas.com)

      [tests la](https://labas.com)

      [test@test.com](mailto:test@test.com)

      ![tests la](https://labas.com)
 

## Content

- add the way to get the magazine on the magazine's page sidebar.
- when getting into a section always show the first subsection (i could create a module showing a sidebar with the list of subsections, too)
