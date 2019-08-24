# USDOE 50001 Ready Guidance


[![Latest Stable Version](https://poser.pugx.org/michaelbmuller/50001-ready-guidance-2018/v/stable)](https://packagist.org/packages/michaelbmuller/50001-ready-guidance-2018)
[![Total Downloads](https://poser.pugx.org/michaelbmuller/50001-ready-guidance-2018/downloads)](https://packagist.org/packages/michaelbmuller/50001-ready-guidance-2018)
[![Build Status](https://travis-ci.org/michaelbmuller/50001-ready-guidance-2018.svg?branch=master)](https://travis-ci.org/michaelbmuller/50001-ready-guidance-2018)
[![License](https://poser.pugx.org/michaelbmuller/50001-ready-guidance-2018/license)](https://packagist.org/packages/michaelbmuller/50001-ready-guidance-2018)
[![codecov](https://codecov.io/gh/michaelbmuller/50001-ready-guidance-2018/branch/master/graph/badge.svg)](https://codecov.io/gh/michaelbmuller/50001-ready-guidance-2018)
[![PHP-Eye](https://php-eye.com/badge/michaelbmuller/50001-ready-guidance-2018/tested.svg?style=flat)](https://php-eye.com/package/michaelbmuller/50001-ready-guidance-2018)

This support library includes all of the USDOE 50001 Ready Navigator guidance broken into 25 individual tasks.
The 50001 Ready Navigator provides step-by-step guidance for implementing and maintaining 
an energy management system in conformance with the ISO 50001 Energy Management System Standard.


## Installation

### With Composer

```
$ composer require michaelbmuller/50001-ready-guidance-2018
```

```json
{
    "require": {
        "michaelbmuller/50001-ready-guidance-2018": "dev-master"
    }
}
```

#### Loading Guidance

```php
<?php
require 'vendor/autoload.php';

use DOE_50001_2018_Ready\Guidance;

//Load guidance
$guidance = new Guidance();

//Load alternate language (example: español) 
$guidance = new Guidance('es'); 

//Set Custom Task Tips
$guidance->setCustomTips($customTips);

//Section Related Functions
$sections = $guidance->getSections();
$sectionName = $guidance->getSectionName($sectionCode);
$previousSectionCode = $guidance->previousSection($sectionCode, $dashboardCode = 'dashboard');
$nextSectionCode = $guidance->nextSection($sectionCode, $dashboardCode = 'dashboard');

//Get All Tasks
$tasks = $guidance->getTasks();

//Get Section Tasks
$tasks = $guidance->getTasks([sectionCode]);

//Get Task
$task = $guidance->getTask([taskId]);
$task = $guidance->getTaskByMenuName($menuName);

//Or load Task 1 directly
$task = Task::load(1,'en');
```

#### Accessing Task Details

```php
<?php
/** @var \DOE_50001_Ready\Task $task */
//Available Task Data 
$task->id();
$task->getMenuName();
$task->getTitle();
$task->language_requested;
$task->language_displayed;

/** ONLY AVAILABLE WHEN TASKS LOADED THROUGH GUIDANCE */
$task->sectionCode;
$task->section;
$task->relatedIsoSections;
$task->prerequisites;
$task->leadsTo;
$task->custom_tips;
//customTips Must be externally loaded with $guidance->setCustomTips($customTips);
$task->resources;

//With Processed Markup Text
$task->getGettingItDone();
$task->getTaskOverview();
$task->getFullDescription();
$task->getOtherIsoTips();
$task->getEnergyStarTips();
$task->getCustomTips();
```

#### Accessing Resource Details
   
```php
<?php
/** @var \DOE_50001_Ready\Resource $resource */
//Available Task Data 
$resource->id;
$resource->name;
$resource->file_type;
$resource->short_description;
$resource->file_name;
$resource->link;
```

## Guidance Markup
The DefaultMarkupProcessor flattens the task markup tags by replacing them with basic text.

How to set a new Markup Processor:
```php
//Create a new Markup Processor that implements the required interface
class NewMarkupProcessor implementes MarkupProcessorInterface

//Inject the new Markup Processor into the Guidance or Tasks
$guidance = new Guidance($language, NewMarkupProcessor::class);
$task = new Task::load($task_id, $language, NewMarkupProcessor::class);
```

### Types of Markup

#### Task Links
Embedded link to other Tasks 
```php
[task](Menu Name)
```

#### Resource Links
Embedded link to Resources
```php
[resource](Resource_Code_Name)
```
#### Accordions
_Requires opening and closing tags_

Allows content to be open and collapsed
```php
[Accordion](Title of Accordion Content)
**Accordion Content**
[Accordion End]
```

#### Learn More
_Requires opening and closing tags_

Allows content to be open and collapsed
```php
[Learn More](Title of Learn More Content)
**Learn More Content**
[Learn More End]
```


## Important Notes

* The English version of the guidance is both the default and primary version used as the basis for translated versions
* If a requested language is not available, the English version will be returned
* Non-English guidance content folders include a copy of the English version used for the translation to provide guidance on what needs to be updated when the English version is updated
 

## Contributors

Library Developer: Michael B Muller

50001 Ready Task Guidance Developed by the:
* US Department of Energy
* Lawrence Berkeley National Laboratory
* Georgia Institute of Technology