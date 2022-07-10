# Silverstripe Twig Template Engine

An experimental POC twig templating engine for Silverstripe CMS

The code in this repository requires breaking changes in framework to work correctly. It is an experiment primarily intended for my own learning - but if you want to play around with it as well you'll need to use the `experimental-view-refactor` branch in [my fork of silverstripe/framework](https://github.com/GuySartorelli/silverstripe-framework/tree/experimental-view-refactor).

## Doesn't work yet

- Anything other than a leaf include template
  - ThemeResourceTemplateLoader has no context for what _type_ of template it should be looking for
  - We aren't passing layout info through
  - We aren't passing any of Silverstripe's scope through
  - We aren't going back to SSViewer to render found templates (which means as soon as we hit one twig template, all flow-down templates must be twig)
- Call methods on DBField (looks like we just get the raw value instead)
- Global Template Variables
- {% require javascript('themes/some-theme/path/some-file.js') %} and the like
- {% base_tag %}
- Use Silverstripe's casting
- Have the context object be directly available instead of via an intermediate value
