# FrontendEdit

Extends [heimrichhannot/contao-formhybrid_list](https://github.com/heimrichhannot/contao-formhybrid_list) with crud functionality (create, update, delete).

-> Click [here](docs/formhybrid.png) for a diagram visualizing the interaction between the modules [formhybrid](https://github.com/heimrichhannot/contao-formhybrid), [formhybrid_list](https://github.com/heimrichhannot/contao-formhybrid_list), [frontendedit](https://github.com/heimrichhannot/contao-frontendedit) and [submissions](https://github.com/heimrichhannot/contao-submissions).

## Features

- adds a memberAuthor field to news and calendar events

### List module

- display e.g. all entities of a certain member
- contains links for editing, deleting and publishing the certain item

### Reader module
- edit an arbitrary entity

## Modules

Name | Description
---- | -----------
ModuleList | Extends formhybrid_list's ModuleList with crud funnctionality
ModuleMemberList | Encapsulates member specific changes overriding ModuleList
ModuleNewsList | Encapsulates news specific changes overriding ModuleList
ModuleReader | A generic editor module able to edit a specific entity (_doesn't_ inherit from formhybrid_list's ModuleReader)
ModuleFrontendUserReader | Encapsulates frontend user specific changes overriding ModuleReader
ModuleFormValidator | Validates a certain amount of entity's fields (useful e.g. as the last step of a multi step form)